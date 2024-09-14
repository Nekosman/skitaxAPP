<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\File;
use \PDF;

class SaleController extends Controller
{
    /**
     * Menampilkan halaman penjualan (daftar produk dan keranjang belanja).
     */
    public function index()
    {
        // Ambil semua produk
        $products = Product::all();

        // Tampilkan halaman penjualan
        return view('sales.index', compact('products'));
    }

    /**
     * Tambahkan produk ke keranjang.
     */
    public function addToCart($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response('Produk tidak ditemukan', 404);
        }

        // Check if the product is out of stock
        if ($product->stock <= 0) {
            return redirect()->route('sales.index')->with('success', 'Product created successfully.');
        }

        $cart = session()->get('cart', []);

        // If the product is already in the cart, increase the quantity
        if (isset($cart[$id])) {
            // Check if adding another unit exceeds stock
            if ($cart[$id]['quantity'] + 1 > $product->stock) {
                return response('Jumlah produk melebihi stok yang tersedia', 400);
            }
            $cart[$id]['quantity']++;
        } else {
            // Add the new product to the cart
            $cart[$id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        // Save the cart to the session
        session()->put('cart', $cart);

        return response('Produk ditambahkan ke keranjang');
    }

    /**
     * Hapus produk dari keranjang.
     */
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json(['success' => 'Produk dihapus dari keranjang']);
    }

    /**
     * Menampilkan isi keranjang belanja.
     */
    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('sales.cart', compact('cart'));
    }

    /**
     * Checkout, menyimpan penjualan dan membuat invoice PDF.
     */
    public function checkout(Request $request)
    {
        // Ambil keranjang dari session
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Keranjang kosong.'], 400);
        }

        // Simpan data penjualan ke database
        $sale = new Sale();
        $sale->total = array_sum(
            array_map(function ($item) {
                return $item['price'] * $item['quantity'];
            }, $cart),
        );
        $sale->sold_at = now();
        $sale->save();

        // Simpan item penjualan
        foreach ($cart as $id => $details) {
            $saleItem = new SaleItem();
            $saleItem->sale_id = $sale->id;
            $saleItem->product_id = $id;
            $saleItem->quantity = $details['quantity'];
            $saleItem->price = $details['price'];
            $saleItem->save();

            // Update stok produk
            $product = Product::find($id);
            if ($product) {
                $product->stock -= $details['quantity'];
                $product->save();
            }
        }

        // Kosongkan keranjang
        session()->forget('cart');

        // Buat direktori jika belum ada
        $invoicePath = storage_path('app/public/invoices');
        if (!File::exists($invoicePath)) {
            File::makeDirectory($invoicePath, 0755, true);
        }

        // Buat PDF invoice
        try {
            $pdf = PDF::loadView('sales.invoice', ['sale' => $sale]);
            $filePath = $invoicePath . '/invoice_' . $sale->id . '.pdf';
            $pdf->save($filePath);

            // Kembalikan URL untuk mengunduh PDF
            return response()->json(['download_url' => asset('storage/invoices/invoice_' . $sale->id . '.pdf')]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate PDF: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Menampilkan invoice dalam bentuk PDF.
     */
    public function invoice($saleId)
    {
        // Ambil data penjualan beserta item penjualannya
        $sale = Sale::with('saleItems.product')->findOrFail($saleId);

        // Buat PDF dari view invoice
        $pdf = PDF::loadView('sales.invoice', ['sale' => $sale]);

        // Download file PDF dengan nama file yang unik berdasarkan ID penjualan
        return $pdf->download('invoice_' . $sale->id . '.pdf');
    }

    /**
     * Menampilkan riwayat penjualan.
     */
    public function history()
    {
        // Ambil semua data penjualan
        $sales = Sale::all();

        // Tampilkan halaman riwayat penjualan
        return view('sales.history', compact('sales'));
    }

    public function addToCartByBarcode(Request $request)
    {
        $barcode = $request->barcode;

        // Temukan produk berdasarkan barcode
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        // Cek jika produk kehabisan stok
        if ($product->stock <= 0) {
            return response()->json(['message' => 'Stok produk habis'], 400);
        }

        $cart = session()->get('cart', []);

        // Jika produk sudah ada di keranjang, tambahkan kuantitasnya
        if (isset($cart[$product->id])) {
            // Cek jika menambah kuantitas akan melebihi stok
            if ($cart[$product->id]['quantity'] + 1 > $product->stock) {
                return response()->json(['message' => 'Jumlah produk melebihi stok yang tersedia'], 400);
            }
            $cart[$product->id]['quantity']++;
        } else {
            // Tambahkan produk baru ke keranjang
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => 1,
                'price' => $product->price,
                'image' => $product->image,
            ];
        }

        //  Simpan keranjang ke session
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
}
