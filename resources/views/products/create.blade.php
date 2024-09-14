@extends('layouts.admin.sidebar')

@section('contents')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ isset($product) ? 'Edit' : 'Tambah' }} Produk</h2>
        </div>
    </div>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @isset($product)
        @method('PUT')
    @endisset

    <!-- Name -->
    <div class="form-group">
        <strong>Nama:</strong>
        <input type="text" name="name" value="{{ isset($product) ? $product->name : old('name') }}" class="form-control" placeholder="Nama">
    </div>

    <!-- Description -->
    <div class="form-group">
        <strong>Deskripsi:</strong>
        <textarea class="form-control" style="height:150px" name="description" placeholder="Deskripsi">{{ isset($product) ? $product->description : old('description') }}</textarea>
    </div>

    <!-- Image -->
    <div class="form-group">
        <strong>Gambar:</strong>
        <input type="file" name="image" class="form-control" accept="image/*">
        @isset($product)
            @if($product->image)
                <img src="{{ asset('storage/img/' . $product->image) }}" alt="{{ $product->name }}" width="100">
            @endif
        @endisset
    </div>

    <!-- Stock -->
    <div class="form-group">
        <strong>Stok:</strong>
        <input type="number" name="stock" value="{{ isset($product) ? $product->stock : old('stock') }}" class="form-control" placeholder="Stok">
    </div>

    <!-- Price -->
    <div class="form-group">
        <strong>Harga:</strong>
        <input type="text" name="price" id="priceInput" value="{{ old('price', isset($product) ? number_format($product->price, 0, ',', '.') : '') }}" class="form-control" placeholder="Harga">
    </div>

    <!-- Categories -->
    <div class="form-group">
        <strong>Kategori:</strong>
        <select name="categories[]" class="form-control" multiple>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ isset($product) && $product->categories->contains($category->id) ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Submit Button -->
    <div class="text-center">
        <button type="submit" class="btn btn-primary">{{ isset($product) ? 'Update' : 'Submit' }}</button>
    </div>
</form>

<script>
    document.getElementById('priceInput').addEventListener('input', function (e) {
        let value = e.target.value;
        value = value.replace(/\D/g, ""); // Menghapus semua karakter kecuali angka
        value = new Intl.NumberFormat('id-ID').format(value);
        e.target.value = value;
    });
</script>
@endsection
