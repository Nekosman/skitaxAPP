@extends('layouts.admin.sidebar')

@section('contents')
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('create.account') }}" class="btn btn-md btn-success">Create Petugas</a>
        <input id="searchInput" class="form-control me-2" type="search" placeholder="Search by name" aria-label="Search">
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="userTable">
            @forelse($users->filter(fn($user) => $user->type == 'petugas') as $petugas)
                <tr>
                    <td class="name">{{ $petugas->name }}</td>
                    <td>{{ $petugas->email }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <form onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?');"
                                action="{{ route('admin.userlist.destroy', $petugas->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No petugas found.</td>
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
