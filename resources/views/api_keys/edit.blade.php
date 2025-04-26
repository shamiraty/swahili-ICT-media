@extends('layouts.app')

@section('content')
<div class="container mt-5">
<h1 class="mb-0"><i class="fas fa-edit me-2"></i> Edit API Key</h1>
            <form action="{{ route('api-keys.update', $apiKey) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="username" class="form-label"><i class="fas fa-user me-2"></i> Username</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username', $apiKey->username) }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-2"></i> New Password (Optional)</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    <small class="form-text text-muted"><i class="fas fa-info-circle me-1"></i> Leave blank to keep the current password.</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label"><i class="fas fa-calendar-alt me-2"></i> End Date</label>
                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $apiKey->end_date) }}" required>
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label"><i class="fas fa-phone me-2"></i> Phone Number (Optional)</label>
                    <input type="text" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number', $apiKey->phone_number) }}">
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i> Email (Optional)</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $apiKey->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label"><i class="fas fa-tag me-2"></i> Category (Optional)</label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                        <option value="">Select Category</option>
                        <option value="web_system" {{ old('category', $apiKey->category) == 'web_system' ? 'selected' : '' }}>Web System</option>
                        <option value="app" {{ old('category', $apiKey->category) == 'app' ? 'selected' : '' }}>App</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i> Update API Key</button>
                    <a href="{{ route('api-keys.index') }}" class="btn btn-secondary ms-2"><i class="fas fa-times me-2"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection