@extends('layouts.admin.sidebar')

@section('contents')
    <div class="d-flex justify-content-between mb-3">
        <h2>Daftar Produk</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Tambah Produk</a>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Gambar</th>
            <th>Stok</th>
            <th>QRCode</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th width="280px">Aksi</th>
        </tr>
        @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    @else
                        <span>No Image</span>
                    @endif
                </td>
                <td>{{ $product->stock }}</td>
                <td>
                    {!! DNS2D::getBarcodeHTML($product->barcode, 'QRCODE') !!}
                    p - {{ $product->barcode }}
                </td>

                <td>{{ $product->price }}</td>
                <td>
                    @foreach ($product->categories as $category)
                        <span class="badge bg-secondary">{{ $category->name }}</span>
                    @endforeach
                </td>
                <td>
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                        <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>

                        <a href="{{ route('products.downloadBarcode', $product->id) }}" class="btn btn-secondary">Download
                            Barcode</a>

                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>

            </tr>
        @endforeach
    </table>
@endsection
