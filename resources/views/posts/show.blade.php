@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row mt-4">
        <div class="col-md-10 offset-md-1">
            <h1 class="mb-4"><i class="fas fa-newspaper me-2"></i> {{ $post->headingTitle }}</h1>

            <div class="card mb-4 shadow rounded-4 border-0">
                <div class="row g-0">
                    {{-- Left: Details --}}
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-folder-open text-primary me-3 fa-lg"></i>
                                    <strong>Category:</strong> {{ $post->category->name }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-clock text-info me-3 fa-lg"></i>
                                    <strong>Uploaded:</strong> {{ $post->created_at->diffForHumans() }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-file-alt text-secondary me-3 fa-lg"></i>
                                    <strong>Description:</strong> {{ $post->description ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-users text-warning me-3 fa-lg"></i>
                                    <strong>Target Audience:</strong> {{ $post->targetAudience ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item">
                                    <i class="fas fa-comment-dots text-success me-3 fa-lg"></i>
                                    <strong>Comments:</strong> {{ $post->comment ?? 'No comments' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-user-pen text-danger me-3 fa-lg"></i>
                                    <strong>Author:</strong> {{ $post->Author ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-link text-muted me-3 fa-lg"></i>
                                    <strong>References:</strong> {{ $post->References ?? 'Not provided' }}
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Right: Image --}}
                    <div class="col-md-5 d-flex align-items-center justify-content-center p-3 bg-light">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}"
                                 alt="{{ $post->headingTitle }}"
                                 class="img-fluid rounded-3 shadow-sm"
                                 style="max-height: 350px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 350px;">
                                <i class="fas fa-image fa-4x text-secondary"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="card-footer text-end border-top">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning rounded-pill me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-info rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection