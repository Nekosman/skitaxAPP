@if(session('cart'))
    <div class="list-group">
        @foreach(session('cart') as $id => $details)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $details['name'] }}</strong> <br>
                    <span>Kuantitas: {{ $details['quantity'] }}</span> <br>
                    <span>Harga: Rp{{ number_format($details['price'], 0, ',', '.') }}</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-danger remove-from-cart" data-id="{{ $id }}">Hapus</button>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        <strong>Total:</strong> Rp{{ number_format(array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, session('cart'))), 0, ',', '.') }}
    </div>
@else
    <p>Keranjang kosong.</p>
@endif
