@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">API Key Details</h1>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" value="{{ $apiKey->username }}" readonly>
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="apiKey" value="{{ $apiKey->api_key }}" readonly>
                        <label for="apiKey">API Key</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="status" value="{{ $apiKey->status ? 'Active' : 'Inactive' }}" readonly>
                        <label for="status">Status</label>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="endDate" value="{{ $apiKey->end_date }}" readonly>
                        <label for="endDate">End Date</label>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="createdAt"  value="{{ $apiKey->created_at }}" readonly>
                        <label for="createdAt">Created At</label>
                    </div>
                </div>
                <div class="col-md-4">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="daysRemaining"
               value="@if($apiKey->end_date && $apiKey->created_at)
                        @php
                            $endDate = \Carbon\Carbon::parse($apiKey->end_date);
                            $createdAt = \Carbon\Carbon::parse($apiKey->created_at);
                            $today = \Carbon\Carbon::now()->startOfDay(); // Consider only the date part
                            $daysRemaining = $endDate->diffInDays($today, false);
                        @endphp
                        @if($endDate->isPast())
                            Expired
                        @else
                            {{ $daysRemaining }} days
                        @endif
                    @else
                        N/A
                    @endif"
               readonly>
        <label for="daysRemaining">Days Remaining</label>
    </div>
</div>
            </div>

            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="phone" value="{{ $apiKey->phone_number ?? 'N/A' }}" readonly>
                        <label for="phone">Phone</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="email" value="{{ $apiKey->email ?? 'N/A' }}" readonly>
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
             <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-floating mb-3">
                         <input type="text" class="form-control" id="lastUsed" value="{{ $apiKey->last_used ? $apiKey->last_used->diffForHumans() : 'Never' }}" readonly>
                        <label for="lastUsed">Last Used</label>
                    </div>
                </div>
                 <div class="col-md-4">
                    <div class="form-floating mb-3">
                         <input type="text" class="form-control" id="requests" value="{{  $apiKey->number_of_requests }}" readonly>
                        <label for="requests"># Requests</label>
                    </div>
                </div>
            </div>

            <h6 class="mt-4 mb-3">Access History</h6>
            <div class="table-responsive">
                <table class="table table-sm table-striped table-hover"id="table"> {{-- Added table-hover for better UX --}}
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
