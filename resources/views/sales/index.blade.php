@extends('layouts.admin.sidebar')

@section('title', 'Sales')

@section('contents')

    <head>
        <link rel="stylesheet" href="{{ asset('styling/app.css') }}">
    </head>
    <div class="container-fluid">
        <h1>Sales</h1>

        <div class="d-flex justify-content-between mb-3">
            <input id="searchInput" class="form-control" type="search" placeholder="Search by name" aria-label="Search"
                style="max-width: 300px;">
        </div>

        <div class="row">
            <!-- Bagian Produk -->
            <div class="col-md-8">
                <div class="row justify-content-start g-3">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="card h-100" style="width: 14rem;">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <div class="row">
                                            <div class="col-10">
                                                <h5 class="card-title"> {{ $product->name }}</h5>
                                                <h6>stock : {{ $product->stock }}</h6>
                                            </div>
                                            <div class="col-1">
                                                <a href="{{ route('products.show', $product->id) }}"
                                                    class="badge rounded-pill text-bg-warning">
                                                    <i class="lni lni-information"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <h6 class="mb-0">Rp{{ number_format($product->price, 0, ',', '.') }}</h6>
                                        <button class="btn btn-dark text-warning p-2 w-50 add-to-cart"
                                            data-id="{{ $product->id }}">
                                            <i class="lni lni-cart"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

          

            <!-- Bagian Keranjang -->
            <div class="col-md-2">
                <h3>Cart</h3>
                <div id="cart"></div>
                <button class="btn btn-success mt-3" id="checkout">Bayar</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk memuat keranjang belanja
            function loadCart() {
                $.get('{{ route('sales.cart') }}', function(data) {
                    $('#cart').html(data);
                });
            }

            // Tambah ke keranjang
            $('.add-to-cart').on('click', function() {
                var id = $(this).data('id');
                $.post("/sales/add-to-cart/" + id, {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    loadCart();
                });
            });

            // Hapus dari keranjang
            $(document).on('click', '.remove-from-cart', function() {
                var id = $(this).data('id');
                $.post("/sales/remove-from-cart/" + id, {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    loadCart();
                });
            });

            // Checkout
            $('#checkout').on('click', function() {
                $.post("{{ route('sales.checkout') }}", {
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    if (data.download_url) {
                        // Redirect ke URL PDF dan muat ulang keranjang
                        window.location.href = data.download_url;
                        loadCart();
                    } else if (data.error) {
                        alert(data.error);
                    }
                }).fail(function(xhr) {
                    alert('Checkout failed: ' + xhr.responseJSON.error);
                });
            });

            // Muat keranjang pada saat halaman pertama kali dimuat
            loadCart();
        });



        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var value = $(this).val().toLowerCase();
                $('.card').filter(function() {
                    $(this).parent().toggle($(this).find('.card-title').text().toLowerCase()
                        .indexOf(value) > -1)
                });
            });
        });


        // $(document).ready(function() {
        //     // Fungsi untuk memuat keranjang belanja
        //     function loadCart() {
        //         $.get('{{ route('sales.cart') }}', function(data) {
        //             $('#cart').html(data);
        //         });
        //     }

        //     // Tambah ke keranjang
        //     $('.add-to-cart').on('click', function() {
        //         var id = $(this).data('id');
        //         $.post("/sales/add-to-cart/" + id, {
        //             _token: '{{ csrf_token() }}'
        //         }, function(data) {
        //             loadCart();
        //         });
        //     });

        //     // Hapus dari keranjang
        //     $(document).on('click', '.remove-from-cart', function() {
        //         var id = $(this).data('id');
        //         $.post("/sales/remove-from-cart/" + id, {
        //             _token: '{{ csrf_token() }}'
        //         }, function(data) {
        //             loadCart();
        //         });
        //     });

        //     // Checkout
        //     $('#checkout').on('click', function() {
        //         $.post("{{ route('sales.checkout') }}", {
        //             _token: '{{ csrf_token() }}'
        //         }, function(data) {
        //             if (data.download_url) {
        //                 // Redirect ke URL PDF dan muat ulang keranjang
        //                 window.location.href = data.download_url;
        //                 loadCart();
        //             } else if (data.error) {
        //                 alert(data.error);
        //             }
        //         }).fail(function(xhr) {
        //             alert('Checkout failed: ' + xhr.responseJSON.error);
        //         });
        //     });

        //     // Muat keranjang pada saat halaman pertama kali dimuat
        //     loadCart();
        // });
    </script>

@endsection
