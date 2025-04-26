<?php

namespace App\Http\Controllers;

use App\Models\ApiKey; // Import the ApiKey model
use App\Models\Document;
use App\Models\Post;
use App\Models\Video;
use App\Models\Category;
use App\Models\Playlist; // Import the Playlist model
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Get counts for all records
        $totalDocuments = Document::count();
        $totalPosts = Post::count();
        $totalVideos = Video::count();
        $totalApiKeys = ApiKey::count(); // Get the total number of API keys
        $totalPlaylists = Playlist::count(); // Get the total number of playlists

        // Get counts for each category for documents, posts, and videos
        $documentCategories = Category::withCount('documents')->get();
        $postCategories = Category::withCount('posts')->get();
        $videoCategories = Category::withCount('videos')->get();

        return view('dashboard', compact(
            'totalDocuments',
            'totalPosts',
            'totalVideos',
            'documentCategories',
            'postCategories',
            'videoCategories',
            'totalApiKeys', // Pass the total API key count to the view
            'totalPlaylists', // Pass the total playlist count to the view
        ));
    }
}