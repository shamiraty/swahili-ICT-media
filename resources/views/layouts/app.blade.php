<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Stream</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min21.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/date_range.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/toastfy.css') }}">

    <style>
        .progress-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 5px;
            z-index: 1000;
            display: none;
        }
        body {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem; /* Adjusted base font size for better responsiveness */
            padding-top: 56px; /* Adjust padding to prevent navbar overlap (for a standard navbar height) */
        }
        .select2-container--default .select2-selection--single {
            padding: 0.5rem 0.75rem;
            height: auto;
            line-height: 1.5;
            font-size: 1rem;
            border-radius: 0.25rem;
            border: 1px solid #ced4da;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: inherit;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: auto;
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
        }
        .select2-container--default .select2-results__options {
            padding: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-film me-2"></i>My Stream
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="mediaDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-folder-open me-2"></i>Media
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="mediaDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('videos.index') }}">
                                    <i class="fas fa-video me-2"></i>Videos
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('posts.index') }}">
                                    <i class="fas fa-file-alt me-2"></i>Posts
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('documents.index') }}">
                                    <i class="fas fa-file-pdf me-2"></i>Documents
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="fas fa-tags me-2"></i>Categories
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('api-keys.index') }}">
                            <i class="fas fa-key me-2"></i>API Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('playlists.index') }}">
                            <i class="fas fa-list-ul me-2"></i>Playlists
                        </a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-2"></i>User
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4"> <div id="progress-dialog" class="progress-dialog">
            Tafadhali subiri...
            <div class="spinner-border text-light mt-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        @yield('content')
    </div>

    <script src="{{ asset('assets/css/jquery.js') }}"></script>
    <script src="{{ asset('assets/css/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/css/datatable.js') }}"></script>
    <script src="{{ asset('assets/css/datatable5.js') }}"></script>
    <script src="{{ asset('assets/css/select2.js') }}"></script>
    <script src="{{ asset('assets/css/date_range.js') }}"></script>
    <script src="{{ asset('assets/css/toastfy.js') }}"></script>
    <script src="{{ asset('assets/css/select2.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            $('#table').DataTable({
                "lengthChange": false,   // Hides "Show X entries"
                "searching": false,     // Hides the search bar
                "info": false ,          // Hides "Showing 1 of X"
                "pageLength": 12
            });

            // Initialize Toastr notifications
            @if(session('success'))
                toastr.success('{{ session('success') }}');
            @endif

            @if(session('error'))
                toastr.error('{{ session('error') }}');
            @endif

            // Show progress dialog on form submit
            $('form').submit(function() {
                $('#progress-dialog').show();
            });

            // Confirm before delete action
            $('a[data-confirm="true"]').click(function(e) {
                e.preventDefault();
                var link = $(this).attr('href');
                if (confirm('Una uhakika unataka kufuta?')) {
                    window.location.href = link;
                }
            });

            // Initialize Select2
            $('.select2').select2({
                width: '100%' // Make Select2 responsive
            });
        });

        // Function to hide progress dialog
        function hideProgressDialog() {
            $('#progress-dialog').hide();
        }
    </script>
    
</body>
</html>