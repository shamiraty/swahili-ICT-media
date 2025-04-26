@extends('layouts.app')

@section('content')
<div class="container-fluid mt-1">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow-lg rounded-4 border-0 mb-4">
                        <div class="card-body p-4">
                            {{-- Video Section --}}
                            <div class="position-relative rounded-3 overflow-hidden mb-3" style="aspect-ratio: 16/9;">
                                @if ($video->video)
                                    @if ($video->thumbnail)
                                        <div id="thumbnail-container"
                                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                                                    background-image: url('{{ asset('storage/' . $video->thumbnail) }}');
                                                    background-size: cover; background-position: center; cursor: pointer;
                                                    display: flex; justify-content: center; align-items: center;
                                                    transition: opacity 0.3s ease-in-out;"
                                             onclick="playVideo(this)">
                                            <button class="btn btn-danger btn-lg rounded-circle shadow">
                                                <i class="fas fa-play fa-2x"></i>
                                            </button>
                                        </div>
                                        <video id="myVideo"
                                               src="{{ asset('storage/' . $video->video) }}"
                                               style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: none;"
                                               controls muted class="w-100 h-100" autoplay></video>
                                    @else
                                        <video src="{{ asset('storage/' . $video->video) }}" class="w-100 h-100 rounded-3" controls muted autoplay></video>
                                    @endif
                                @else
                                    <div class="alert alert-warning mt-3">Video not available.</div>
                                @endif
                            </div>
                            <h4 class="mb-4 text-uppercase fw-bold">{{ $video->headingTitle }}</h4>
                            {{-- Description Section --}}
                            <div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-folder-open text-primary me-3 fa-lg"></i>
                                        <strong class="me-1">Category:</strong> {{ $video->category->name }}
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-calendar-alt text-success me-3 fa-lg"></i>
                                        <strong class="me-1">Published:</strong> {{ $video->created_at->diffForHumans() }}
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-user text-info me-3 fa-lg"></i>
                                        <strong class="me-1">Author:</strong> {{ $video->Author ?? 'Not provided' }}
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-link text-warning me-3 fa-lg"></i>
                                        <strong class="me-1">References:</strong> {{ $video->References ?? 'Not provided' }}
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-users text-danger me-3 fa-lg"></i>
                                        <strong class="me-1">Target Audience:</strong> {{ $video->targetAudience ?? 'Not provided' }}
                                    </li>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-envelope text-secondary me-3 fa-lg"></i>
                                        {{ $video->comment ?? 'No comments' }}
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fas fa-list text-info me-3 fa-lg"></i>
                                        <strong class="me-1">Playlists:</strong>
                                        @if ($video->playlists->count() > 0)
                                            @foreach ($video->playlists as $playlist)
                                                <span class="badge bg-danger ms-2">{{ $playlist->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted ms-2">This video is not in any playlist.</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer py-3 d-flex justify-content-between align-items-center">
                            <small class="text-muted">Published {{ $video->created_at->diffForHumans() }}</small>
                            <div>
                                <a href="{{ route('videos.edit', $video->id) }}" class="btn btn-sm btn-outline-success rounded-pill me-2">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="{{ route('videos.index') }}" class="btn btn-sm btn-outline-info rounded-pill">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    {{-- Playlist Videos --}}
                    @if ($playlistVideos->count() > 0)
                        <div class="mt-0">
                            <h4 class="mb-3 fw-semibold">Playlist </h4>
                            <div class="row row-cols-1 g-3 mb-3" style="height: 700px; overflow-y: auto;">
                                @foreach ($playlistVideos as $pVideo)
                                    <div class="col">
                                        <a href="{{ route('videos.show', $pVideo->id) }}" class="text-decoration-none text-dark playlist-item"
                                           title="{{ $pVideo->headingTitle }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <div class="card shadow-sm rounded-3 h-100 border-1 playlist-card">
                                                <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                                                    @if ($pVideo->thumbnail)
                                                        <img src="{{ asset('storage/' . $pVideo->thumbnail) }}" class="card-img-top playlist-thumbnail" alt="{{ $pVideo->headingTitle }}" style="object-fit: cover; height: 100%;">
                                                    @else
                                                        <div class="bg-light d-flex justify-content-center align-items-center h-100 playlist-thumbnail">
                                                            <i class="fas fa-film fa-2x text-secondary"></i>
                                                        </div>
                                                    @endif
                                                    <div class="position-absolute top-50 start-50 translate-middle" style="opacity: 0.5;">
                                                        <i class="fas fa-play fa-4x text-danger"></i>
                                                    </div>
                                                    <video src="{{ asset('storage/' . $pVideo->video) }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; display: none;" muted></video>
                                                </div>
                                                <div class="card-body p-2">
                                                    <h6 class="card-title fw-bold mb-0 small">{{ Str::limit($pVideo->headingTitle, 40) }}</h6>
                                                    <p class="card-text"><small class="text-muted">{{ Str::limit($pVideo->category->name, 30) }} - {{ $pVideo->created_at->diffForHumans() }}</small></p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Related Videos Section (Full Width, Below Everything) --}}
            @if ($relatedVideos->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h4 class="mb-3 fw-semibold">Related Videos</h4>
                        <div class="overflow-auto horizontal-scroll">
                            <div class="d-flex gap-3">
                                @foreach ($relatedVideos as $rVideo)
                                    <a href="{{ route('videos.show', $rVideo->id) }}" class="text-decoration-none text-dark related-video-item"
                                       title="{{ $rVideo->headingTitle }}" data-bs-toggle="tooltip" data-bs-placement="top">
                                        <div class="card shadow-sm rounded-3 border-1 related-video-card" style="width: 200px;">
                                            <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                                                @if ($rVideo->thumbnail)
                                                    <img src="{{ asset('storage/' . $rVideo->thumbnail) }}" class="card-img-top related-video-thumbnail" alt="{{ $rVideo->headingTitle }}" style="object-fit: cover; height: 100%;">
                                                @else
                                                    <div class="bg-light d-flex justify-content-center align-items-center h-100 related-video-thumbnail">
                                                        <i class="fas fa-film fa-2x text-secondary"></i>
                                                    </div>
                                                @endif
                                                <div class="position-absolute top-50 start-50 translate-middle" style="opacity: 0.5;">
                                                    <i class="fas fa-play fa-3x text-danger"></i>
                                                </div>
                                            </div>
                                            <div class="card-body p-2">
                                                <h6 class="card-title fw-bold mb-0 small">{{ Str::limit($rVideo->headingTitle, 30) }}</h6>
                                                <p class="card-text"><small class="text-muted">{{ $rVideo->created_at->diffForHumans() }}</small></p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</div>

{{-- Style --}}
<style>
    .playlist-card {
        border-radius: 0.5rem !important; /* Make cards more rounded */
    }

    .playlist-item {
        transition: transform 0.2s ease-in-out;
    }

    .playlist-item:hover {
        transform: scale(1.02);
    }

    .playlist-thumbnail {
        transition: opacity 0.2s ease-in-out;
    }

    .playlist-item:hover .playlist-thumbnail {
        opacity: 0.9;
    }

    .playlist-card .position-absolute {
        pointer-events: none; /* Make the play icon non-interactive */
    }

    .playlist-card:hover .position-absolute {
        opacity: 1 !important; /* Show play icon on hover */
    }

    /* Styles for related videos */
    .horizontal-scroll {
        overflow-x: auto;
        white-space: nowrap;
        padding-bottom: 15px; /* To accommodate scrollbar */
        margin-bottom: 1rem;
    }

    .related-video-card {
        min-width: 200px; /* Adjust as needed */
        border-radius: 0.5rem;
    }

    .related-video-item {
        transition: transform 0.2s ease-in-out;
        display: inline-block; /* Ensure horizontal layout */
    }

    .related-video-item:hover {
        transform: scale(1.05);
    }

    .related-video-thumbnail {
        object-fit: cover;
        height: 100%;
    }

    .related-video-card .position-absolute {
        opacity: 0.5;
        pointer-events: none;
    }

    .related-video-card:hover .position-absolute {
        opacity: 1 !important;
    }
</style>

{{-- Script --}}
<script>
    const videoElement = document.getElementById('myVideo');
    const thumbnailContainer = document.getElementById('thumbnail-container');

    if (videoElement && thumbnailContainer) {
        thumbnailContainer.style.display = 'none';
        videoElement.style.display = 'block';
        videoElement.play().catch(error => {
            console.error("Video could not be played automatically:", error);
            thumbnailContainer.style.display = 'flex';
            videoElement.style.display = 'none';
        });
    } else if (videoElement && !thumbnailContainer) {
        videoElement.autoplay = true;
        videoElement.play().catch(error => {
            console.error("Video could not be played automatically:", error);
        });
    }

    // Initialize tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // Autoplay on hover for playlist videos
    const playlistItems = document.querySelectorAll('.playlist-card');
    playlistItems.forEach(item => {
        const video = item.querySelector('video');
        if (video) {
            item.addEventListener('mouseenter', () => {
                video.style.display = 'block';
                video.play().catch(error => {
                    console.error("Could not play video on hover:", error);
                    video.style.display = 'none';
                });
            });

            item.addEventListener('mouseleave', () => {
                video.pause();
                video.currentTime = 0;
                video.style.display = 'none';
            });
        }
    });
</script>

{{-- Font Awesome --}}
@endsection