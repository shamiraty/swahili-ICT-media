@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">API Key Details</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3 align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title"><i class="fas fa-key me-2"></i> {{ $apiKey->username }}</h5>
                    <p class="card-subtitle text-muted">Created on {{ \Carbon\Carbon::parse($apiKey->created_at)->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <span class="badge rounded-pill bg-{{ $apiKey->status ? 'success' : 'danger' }}"><i class="fas fa-circle me-1"></i> {{ $apiKey->status ? 'Active' : 'Inactive' }}</span>
                </div>
            </div>
            <hr class="mb-4">

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <div class="input-group">
                            <input type="password" class="form-control" id="apiKeyMasked" value="{{ Str::mask($apiKey->api_key, '*', 8, -4) }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" id="revealKey">Show</button>
                            <button class="btn btn-outline-secondary" type="button" id="copyKey" data-clipboard-text="{{ $apiKey->api_key }}"><i class="fas fa-copy"></i></button>
                        </div>
                        <label for="apiKeyMasked">API Key</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control {{ $apiKey->end_date && \Carbon\Carbon::parse($apiKey->end_date)->isPast() ? 'border-danger' : '' }}" id="endDate" value="{{ $apiKey->end_date ?? 'N/A' }}" readonly>
                        <label for="endDate">End Date</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="daysRemaining"
                               value="@if($apiKey->end_date && $apiKey->created_at) ... @endif"
                               readonly>
                        <label for="daysRemaining">Days Remaining</label>
                        @if($apiKey->end_date && $apiKey->created_at && !\Carbon\Carbon::parse($apiKey->end_date)->isPast())
                            @php
                                $endDate = \Carbon\Carbon::parse($apiKey->end_date);
                                $createdAt = \Carbon\Carbon::parse($apiKey->created_at);
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $totalDays = $createdAt->diffInDays($endDate);
                                $remainingDays = $endDate->diffInDays($today, false);
                                $progress = $totalDays > 0 ? min(100, max(0, ($totalDays - $remainingDays) / $totalDays * 100)) : 0;
                            @endphp
                            <div class="progress mt-2" style="height: 5px;">
                                <div class="progress-bar bg-{{ $remainingDays < 7 ? ($remainingDays < 3 ? 'danger' : 'warning') : 'success' }}" role="progressbar" style="width: {{ $progress }}%" aria-valuenow="{{ $remainingDays }}" aria-valuemin="0" aria-valuemax="{{ $totalDays }}"></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="phone" value="{{ $apiKey->phone_number ?? 'Not provided' }}" readonly>
                        <label for="phone">Phone</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" value="{{ $apiKey->email ?? 'Not provided' }}" readonly>
                        <label for="email">Email</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="category" value="{{ $apiKey->category ?? 'N/A' }}" readonly>
                        <label for="category">Category</label>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lastUsed" value="{{ $apiKey->last_used ? $apiKey->last_used->diffForHumans() : 'Never' }}" readonly>
                        <label for="lastUsed">Last Used</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="requests" value="{{ $apiKey->number_of_requests }}" readonly>
                        <label for="requests"># Requests</label>
                    </div>
                </div>
            </div>

            <h6 class="mt-4 mb-3">Access History</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover" id="table">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Accessed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($apiKey->access_history)
                            @foreach($apiKey->access_history as $index => $access)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ \Carbon\Carbon::parse($access['accessed_at'])->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="2" class="text-center">No access history available.</td></tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <a href="{{ route('api-keys.index') }}" class="btn btn-secondary mt-4"><i class="fas fa-arrow-left me-2"></i> Back to List</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const revealButton = document.getElementById('revealKey');
            const apiKeyInputMasked = document.getElementById('apiKeyMasked');
            const apiKeyInputValue = "{{ $apiKey->api_key }}";
            let isMasked = true;

            revealButton.addEventListener('click', function() {
                if (isMasked) {
                    apiKeyInputMasked.type = 'text';
                    apiKeyInputMasked.value = apiKeyInputValue;
                    revealButton.textContent = 'Hide';
                } else {
                    apiKeyInputMasked.type = 'password';
                    apiKeyInputMasked.value = "{{ Str::mask($apiKey->api_key, '*', 8, -4) }}";
                    revealButton.textContent = 'Show';
                }
                isMasked = !isMasked;
            });

            new ClipboardJS('#copyKey');
        });
    </script>
@endpush