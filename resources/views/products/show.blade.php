@extends('layouts.admin.sidebar')

@section('title', 'Products')

@section('contents')
    <link rel="stylesheet" href="{{ asset('styling/app.css') }}">
    <div class="container-fluid">
        <h1>Product List</h1>
        <div class="row justify-content-start">
            @foreach ($products as $product)
            
            <div class="card ms-2 mb-2" style="width: 14rem;">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                    alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="row">
                            <div class="col-10">
                                <h5 class="card-title"> {{ $product->name }}</h5>
                                <h6>stock : {{ $product->stock }}</h6>
                            </div>
                            <div class="col-2">
                                <a href="{{ route('products.show', $product->id) }}" class="badge rounded-pill text-bg-warning">
                                    <i class="lni lni-information"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <h6 class="mb-0">Rp{{ number_format($product->price, 0, ',', '.') }}</h6>
                        <a href="#" class="btn btn-dark text-warning p-2 w-50 ">
                            <i class="lni lni-cart"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    
@endsection
