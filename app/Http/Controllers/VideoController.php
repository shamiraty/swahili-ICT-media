<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Video;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::with('category')->get();
        return view('videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $playlists = Playlist::all(); // Fetch all playlists
        return view('videos.create', compact('categories','playlists'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'headingTitle' => 'nullable|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4,video/mpeg,video/quicktime|max:204800', // Max 200MB
            'targetAudience' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'Author' => 'nullable|string|max:255',
            'References' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'playlists' => 'nullable|array|exists:playlists,id', // Validate playlist IDs
        ]);
    
        $videoPath = $request->file('video')->store('videos', 'public');
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }
    
        $video = Video::create([
            'category_id' => $request->category_id,
            'headingTitle' => $request->headingTitle,
            'video' => $videoPath,
            'targetAudience' => $request->targetAudience,
            'comment' => $request->comment,
            'Author' => $request->Author,
            'References' => $request->References,
            'thumbnail' => $thumbnailPath,
            'size' => $request->file('video')->getSize(),
        ]);
    
        // Attach playlists if selected
        if ($request->has('playlists')) {
            $video->playlists()->attach($request->playlists);
        }
    
        return redirect()->route('videos.index')->with('success', 'Video imepakiwa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        $playlists = $video->playlists;
        $playlistVideos = collect();
    
        foreach ($playlists as $playlist) {
            $playlistVideos = $playlistVideos->merge($playlist->videos()->where('videos.id', '!=', $video->id)->get());
        }
    
        $playlistVideos = $playlistVideos->unique('id');
    
        // Fetch related videos based on the current video's category
        $relatedVideos = Video::where('category_id', $video->category_id)
            ->where('id', '!=', $video->id)
            ->latest()
            ->take(10) // You can adjust the number of related videos to show
            ->get();
    
        return view('videos.show', compact('video', 'playlistVideos', 'relatedVideos'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        $categories = Category::all();
        $playlists = Playlist::all(); // Fetch all playlists
        return view('videos.edit', compact('video', 'categories', 'playlists'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'headingTitle' => 'nullable|string|max:255',
        'video' => 'nullable|file|mimetypes:video/mp4,video/mpeg,video/avi,video/quicktime|max:204800', // Max 200MB
        'targetAudience' => 'nullable|string|max:255',
        'comment' => 'nullable|string',
        'Author' => 'nullable|string|max:255',
        'References' => 'nullable|string|max:255',
        'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        'playlists' => 'nullable|array|exists:playlists,id', // Validate playlist IDs
    ]);

    // Handle video update
    if ($request->hasFile('video')) {
        // Delete the old video if it exists
        if ($video->video) {
            Storage::disk('public')->delete($video->video);
        }
        // Store the new video
        $video->video = $request->file('video')->store('videos', 'public');
        $video->size = $request->file('video')->getSize();
    }

    // Handle thumbnail update
    if ($request->hasFile('thumbnail')) {
        // Delete the old thumbnail if it exists
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        // Store the new thumbnail
        $video->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
    }

    // Update other video details
    $video->update($request->except(['video', 'thumbnail', 'playlists']));

    // Sync playlists
    if ($request->has('playlists')) {
        $video->playlists()->sync($request->playlists);
    } else {
        $video->playlists()->detach(); // Remove all playlists if none are selected
    }

    return redirect()->route('videos.index')->with('success', 'Video imebadilishwa.');
}

    /*** Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        Storage::disk('public')->delete($video->video);
        Storage::disk('public')->delete($video->thumbnail);
        $video->delete();
        return redirect()->route('videos.index')->with('success', 'Video imefutwa.');
    }
}