@extends('layouts.admin.sidebar')

@section('contents')
<div class="d-flex justify-content-between mb-3">
    <h2>PETUGAS LIST</h2>
    <a href="{{ route('create.account') }}" class="btn btn-success">Create Petugas</a>
</div>

<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <input id="searchInput" class="form-control" type="search" placeholder="Search by name" aria-label="Search" style="max-width: 300px;">
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Kondisi</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody id="userTable">
            @forelse($users->filter(fn($user) => $user->type == 'petugas') as $petugas)
                <tr>
                    <td class="name">{{ $petugas->name }}</td>
                    <td>{{ $petugas->email }}</td>
                    <td>
                        @if($petugas->is_approved)
                            <span style="color: green;">Aktif</span>
                        @else
                            <span style="color: red;">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?');"
                                  action="{{ route('admin.userlist.destroy', $petugas->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger mr-2">Hapus</button>
                            </form>
                            <form action="{{ route('toggle.approval', $petugas->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $petugas->is_approved ? 'btn-warning' : 'btn-success' }}">
                                    {{ $petugas->is_approved ? 'Nonaktifkan' : 'Aktifkan' }}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No petugas found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('#userTable tr').filter(function() {
                $(this).toggle($(this).find('.name').text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection
