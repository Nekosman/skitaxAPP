@extends('layouts.admin.sidebar')

@section('title', 'Detail Product')

@section('contents')
<div class="container mt-4">
    <div class="card shadow-sm" style="border-radius: 15px; overflow: hidden;">
        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 400px; object-fit: cover;">
        <div class="card-body">
            <h5 class="card-title">{{ $product->name }}</h5>
            <p class="card-text">Stock: {{ $product->stock }}</p>
            <p class="card-text">{{ $product->description }}</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
    </div>
</div>
@endsection
