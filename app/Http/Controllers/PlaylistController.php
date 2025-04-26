<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the playlists.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $playlists = Playlist::all();
        return view('playlists.index', compact('playlists'));
    }

    /**
     * Show the form for creating a new playlist.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('playlists.create');
    }

    /**
     * Store a newly created playlist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        Playlist::create($request->all());

        return redirect()->route('playlists.index')->with('success', 'Playlist created successfully.');
    }

    /**
     * Show the form for editing the specified playlist.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\View\View
     */
    public function edit(Playlist $playlist)
    {
        return view('playlists.edit', compact('playlist'));
    }

    /**
     * Update the specified playlist in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Playlist $playlist)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|string',
        ]);

        $playlist->update($request->all());

        return redirect()->route('playlists.index')->with('success', 'Playlist updated successfully.');
    }

    /**
     * Remove the specified playlist from storage.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->delete();
        return redirect()->route('playlists.index')->with('success', 'Playlist deleted successfully.');
    }
}