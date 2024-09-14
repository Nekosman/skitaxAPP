@extends('layouts.admin.sidebar')

@section('title', 'History Penjualan')

@section('contents')
<div class="container-fluid">
    <h1>History Penjualan</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Waktu Penjualan</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>Rp{{ number_format($sale->total, 0, ',', '.') }}</td>
                    <td>{{ $sale->sold_at }}</td>
                    <td>
                        <a href="{{ route('sales.invoice', $sale->id) }}" class="btn btn-primary">Lihat Invoice</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
