<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'headingTitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'description' => 'nullable|string',
            'targetAudience' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'Author' => 'nullable|string|max:255',
            'References' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Post::create([
            'category_id' => $request->category_id,
            'headingTitle' => $request->headingTitle,
            'image' => $imagePath,
            'description' => $request->description,
            'targetAudience' => $request->targetAudience,
            'comment' => $request->comment,
            'Author' => $request->Author,
            'References' => $request->References,
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('posts.index')->with('success', 'Post imechapishwa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'headingTitle' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
            'description' => 'nullable|string',
            'targetAudience' => 'nullable|string|max:255',
            'comment' => 'nullable|string',
            'Author' => 'nullable|string|max:255',
            'References' => 'nullable|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($post->image);
            $post->image = $request->file('image')->store('images', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($post->thumbnail);
            $post->thumbnail = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $post->update($request->except(['image', 'thumbnail']));

        return redirect()->route('posts.index')->with('success', 'Post imebadilishwa.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Storage::disk('public')->delete($post->image);
        Storage::disk('public')->delete($post->thumbnail);
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post imefutwa.');
    }
}