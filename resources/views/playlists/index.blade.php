@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Playlists</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('playlists.create') }}" class="btn btn-primary mb-3">Add New Playlist</a>
    <table class="table table-bordered table-striped table-hover" id="table">
        <thead class="table-primary">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($playlists as $playlist)
                <tr>
                    <td>{{ $playlist->id }}</td>
                    <td>{{ $playlist->name }}</td>
                    <td>{{ $playlist->description ?? 'N/A' }}</td>
                    <td>{{ $playlist->created_at }}</td>
                    <td>
                        <a href="{{ route('playlists.edit', $playlist) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('playlists.destroy', $playlist) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5">No playlists found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#playlistsTable').DataTable();
        });
    </script>
@endpush