@extends('layouts.petugas.sidebar')

@section('title', 'Home')

@section('contents')
<div class="container">
    <h1>Admin dashboard</h1>
    <div class="row">
        <div class="col-md-auto col-lg-auto ">
            <div class="card h-400 bg-transparent">
                @include('widget.widgetTotal', [
                    'color' => 'bg-secondary',
                    'title' => 'Total Products',
                    'icons' => 'lni lni-airtable',
                    'data' => $totalProducts
                ])
            </div>
        </div>
       
    </div>
</div>
@endsection