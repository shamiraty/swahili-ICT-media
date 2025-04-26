@extends('layouts.app')

@section('content')
    <div class="container mt-5">
 {{-- New Feature: Quick Actions --}}
 <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm rounded-2 border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Quick Actions</h5>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                            <a href="{{ route('documents.create') }}" class="btn btn-primary rounded-pill btn-sm"><i class="fas fa-upload me-2"></i> Upload Document</a>
                            <a href="{{ route('posts.create') }}" class="btn btn-success rounded-pill btn-sm"><i class="fas fa-plus-circle me-2"></i> Create Post</a>
                            <a href="{{ route('videos.create') }}" class="btn btn-info rounded-pill btn-sm"><i class="fas fa-plus-square me-2"></i> Add Video</a>
                            <a href="{{ route('categories.create') }}" class="btn btn-warning rounded-pill btn-sm"><i class="fas fa-tag me-2"></i> Create Category</a>
                            <a href="{{ route('playlists.create') }}" class="btn btn-secondary rounded-pill btn-sm"><i class="fas fa-plus me-2"></i> Create Playlist</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-4">
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                        <h5 class="card-title fw-bold">Documents</h5>
                        <h2 class="card-text fw-bold text-danger">{{ $totalDocuments }}</h2>
                        <p class="card-text text-muted">Total Documents</p>
                        <a href="{{ route('documents.index') }}" class="btn btn-outline-danger rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-file-alt fa-3x text-success mb-3"></i>
                        <h5 class="card-title fw-bold">Posts</h5>
                        <h2 class="card-text fw-bold text-success">{{ $totalPosts }}</h2>
                        <p class="card-text text-muted">Total Posts</p>
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-success rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-video fa-3x text-info mb-3"></i>
                        <h5 class="card-title fw-bold">Videos</h5>
                        <h2 class="card-text fw-bold text-info">{{ $totalVideos }}</h2>
                        <p class="card-text text-muted">Total Videos</p>
                        <a href="{{ route('videos.index') }}" class="btn btn-outline-info rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                        <h5 class="card-title fw-bold">Categories</h5>
                        <h2 class="card-text fw-bold text-warning">{{ $documentCategories->count() + $postCategories->count() + $videoCategories->count() }}</h2>
                        <p class="card-text text-muted">Total Categories</p>
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-warning rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-key fa-3x text-secondary mb-3"></i>
                        <h5 class="card-title fw-bold">API Users</h5>
                        <h2 class="card-text fw-bold text-secondary">{{ $totalApiKeys ?? 0 }}</h2>
                        <p class="card-text text-muted">Total API Keys</p>
                        <a href="{{ route('api-keys.index') }}" class="btn btn-outline-secondary rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body text-center">
                        <i class="fas fa-list-ul fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Playlists</h5>
                        <h2 class="card-text fw-bold text-primary">{{ $totalPlaylists ?? 0 }}</h2>
                        <p class="card-text text-muted">Total Playlists</p>
                        <a href="{{ route('playlists.index') }}" class="btn btn-outline-primary rounded-pill btn-sm">
                            <i class="fas fa-eye me-1"></i> View
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm rounded-2 border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Documents by Category</h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($documentCategories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $category->name }}
                                    <span class="badge bg-danger rounded-pill">{{ $category->documents_count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No categories found for documents.</li>
                            @endforelse
                        </ul>
                        @if ($documentCategories->isNotEmpty())
                            <div class="d-grid mt-3">
                                <a href="{{ route('categories.index') }}?type=document" class="btn btn-outline-secondary btn-sm rounded-pill">View All Document Categories</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm rounded-2 border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Posts by Category</h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($postCategories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $category->name }}
                                    <span class="badge bg-success rounded-pill">{{ $category->posts_count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No categories found for posts.</li>
                            @endforelse
                        </ul>
                        @if ($postCategories->isNotEmpty())
                            <div class="d-grid mt-3">
                                <a href="{{ route('categories.index') }}?type=post" class="btn btn-outline-secondary btn-sm rounded-pill">View All Post Categories</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm rounded-2 border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-3">Videos by Category</h5>
                        <ul class="list-group list-group-flush">
                            @forelse ($videoCategories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $category->name }}
                                    <span class="badge bg-info rounded-pill">{{ $category->videos_count }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No categories found for videos.</li>
                            @endforelse
                        </ul>
                        @if ($videoCategories->isNotEmpty())
                            <div class="d-grid mt-3">
                                <a href="{{ route('categories.index') }}?type=video" class="btn btn-outline-secondary btn-sm rounded-pill">View All Video Categories</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- New Feature: Recent Uploads --}}
            
        

       
@endsection