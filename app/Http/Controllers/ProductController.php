<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('categories')->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'required|image|mimes:jpeg,jpg,png|max:10000',
            'stock' => 'required|integer',
            'price' => 'required',
            'categories' => 'required|array',
        ]);

        $number = mt_rand(1000000000, 9999999999);

        if ($this->productCodExist($number)) {
            $number = mt_rand(1000000000, 9999999999);
        }

        $request['barcode'] = $number;

        $price = str_replace('.', '', $request->price);
        $imagePath = $request->file('image')->store('public/img');

        // Simpan produk tanpa barcode terlebih dahulu
        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => str_replace('public/', '', $imagePath),
            'stock' => $request->stock,
            'price' => $price,
            'barcode' => $request->barcode,
        ]);

        $product->categories()->sync($request->categories);

        return redirect()->route('sales.index')->with('success', 'Product created successfully.');
    }

    public function productCodExist($number)
    {
        return Product::whereBarcode($number)->exists();
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.create', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'stock' => 'required|integer',
            'price' => 'required',
            'categories' => 'required|array',
        ]);

        $productData = $request->all();

        // Menghapus titik dari input harga sebelum disimpan
        $productData['price'] = str_replace('.', '', $request->price);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imagePath = $request->file('image')->store('img/imgproduct', 'public');
            $productData['image'] = $imagePath;
        }

        $product->update($productData);
        $product->categories()->sync($request->categories);

        return redirect()->route('sales.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete the associated image file from storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Detach the product from any associated categories
        $product->categories()->detach();

        // Delete the product
        $product->delete();

        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); // Mengambil data produk berdasarkan ID
        return view('products.detail', compact('product'));
    }

    public function downloadBarcode($id)
    {
        $product = Product::findOrFail($id);

        // Buat instance dari DNS1D
        $barcodeGenerator = new DNS2D();

        // Generate barcode sebagai gambar PNG
        $barcode = $barcodeGenerator->getBarcodePNG($product->barcode, 'QRCODE', 20, 20); // Sesuaikan ukuran jika diperlukan
        $fileName = 'barcode_' . $product->barcode . '.png';
        $filePath = storage_path('app/public/barcodes/' . $fileName);

        // Simpan barcode dalam file PNG
        if (!file_exists(storage_path('app/public/barcodes'))) {
            mkdir(storage_path('app/public/barcodes'), 0755, true);
        }

        file_put_contents($filePath, base64_decode($barcode));

        // Download file barcode
        return response()->download($filePath);
    }
}
