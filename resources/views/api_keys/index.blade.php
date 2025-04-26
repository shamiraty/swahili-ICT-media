@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>API Keys</h1>
        <a href="{{ route('api-keys.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New API Key
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover mb-0" id="apiKeysTable">
            <thead class="table-primary">
                <tr>
                    <th>Username</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($apiKeys as $apiKey)
                    <tr>
                        <td>{{ $apiKey->username }}</td>
                        <td><span class="badge bg-{{ $apiKey->status ? 'success' : 'danger' }}">{{ $apiKey->status ? 'Active' : 'Inactive' }}</span></td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('api-keys.show', $apiKey) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                <a href="{{ route('api-keys.edit', $apiKey) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-pencil-square me-1"></i> Edit
                                </a>
                                <form action="{{ route('api-keys.destroy', $apiKey) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this API Key?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">No API keys found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#apiKeysTable').DataTable(); // If you are using DataTables
    });
</script>
@endsection