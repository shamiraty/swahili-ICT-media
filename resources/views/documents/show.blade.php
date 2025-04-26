@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row mt-5">
        <div class="col-md-10 offset-md-1">
            <h1 class="mb-4 fw-bold">{{ $document->headingTitle }}</h1>

            <div class="card shadow-lg rounded-4 mb-4 border-0">
                <div class="row g-0">
                    {{-- Left: Details --}}
                    <div class="col-md-7">
                        <div class="card-body p-4">
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-folder-open text-info me-3 fa-lg"></i>
                                    <strong class="me-1">Category:</strong> {{ $document->category->name }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-calendar-alt text-success me-3 fa-lg"></i>
                                    <strong class="me-1">Uploaded:</strong> {{ $document->created_at->diffForHumans() }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-users text-warning me-3 fa-lg"></i>
                                    <strong class="me-1">Target Audience:</strong> {{ $document->targetAudience ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-comment-dots text-secondary me-3 fa-lg"></i>
                                    <strong class="me-1">Comments:</strong> {{ $document->comment ?? 'No comments' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-user-circle text-primary me-3 fa-lg"></i>
                                    <strong class="me-1">Author:</strong> {{ $document->Author ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-link text-danger me-3 fa-lg"></i>
                                    <strong class="me-1">References:</strong> {{ $document->References ?? 'Not provided' }}
                                </li>
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-file-alt text-muted me-3 fa-lg"></i>
                                    <strong class="me-1">File Size:</strong> {{ formatSizeUnits($document->document_size) }}
                                </li>
                                <li class="list-group-item">
                                    <strong class="me-1">Open Document:</strong>
                                    <a href="{{ asset('storage/' . $document->document) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2 rounded-pill">
                                        <i class="fas fa-eye me-1"></i> View PDF
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Right: PDF Preview --}}
                    <div class="col-md-5 d-flex align-items-center justify-content-center p-3 bg-light rounded-end">
                        @if ($document->thumbnail)
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $document->thumbnail) }}"
                                     alt="PDF Thumbnail"
                                     class="img-fluid rounded shadow-sm mb-3"
                                     style="max-height: 300px; object-fit: contain;">
                                <p class="text-muted small">
                                    <i class="fas fa-file-pdf text-danger me-1"></i> PDF Thumbnail
                                </p>
                            </div>
                        @else
                            <p class="text-muted text-center">
                                <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i><br>
                                No PDF Thumbnail
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="card-footer text-end border-0 p-3">
                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-warning rounded-pill me-2">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('documents.index') }}" class="btn btn-info rounded-pill">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@php
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } elseif ($bytes == 1) {
            return $bytes . ' byte';
        } else {
            return '0 bytes';
        }
    }
@endphp