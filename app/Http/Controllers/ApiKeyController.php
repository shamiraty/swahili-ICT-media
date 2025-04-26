<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View; 

class ApiKeyController extends Controller
{
    /**
     * Display a listing of the API keys.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $apiKeys = ApiKey::all();
        return view('api_keys.index', compact('apiKeys'));
    }

    /**
     * Show the form for creating a new API key.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('api_keys.create');
    }

    /**
     * Store a newly created API key in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:api_keys|max:255',
            'password' => 'required|min:6',
            'end_date' => 'required|date|after_or_equal:today',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|in:web_system,app',
        ]);

        ApiKey::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'api_key' => Str::random(40), // Generate a random API key
            'end_date' => $request->end_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'category' => $request->category,
        ]);

        return redirect()->route('api-keys.index')->with('success', 'API key created successfully.');
    }

    /**
     * Show the form for editing the specified API key.
     *
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\View\View
     */
    public function edit(ApiKey $apiKey)
    {
        return view('api_keys.edit', compact('apiKey'));
    }

    /**
     * Update the specified API key in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, ApiKey $apiKey)
    {
        $rules = [
            'username' => 'required|max:255|unique:api_keys,username,' . $apiKey->id,
            'end_date' => 'required|date|after_or_equal:today',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'category' => 'nullable|in:web_system,app',
        ];

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:6';
        }

        $request->validate($rules);

        $apiKey->update([
            'username' => $request->username,
            'end_date' => $request->end_date,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'category' => $request->category,
        ]);

        if ($request->filled('password')) {
            $apiKey->password = Hash::make($request->password);
            $apiKey->save();
        }

        return redirect()->route('api-keys.index')->with('success', 'API key updated successfully.');
    }

    /**
     * Remove the specified API key from storage.
     *
     * @param  \App\Models\ApiKey  $apiKey
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ApiKey $apiKey)
    {
        $apiKey->delete();
        return redirect()->route('api-keys.index')->with('success', 'API key deleted successfully.');
    }


    public function show(ApiKey $apiKey): View
    {
        return view('api_keys.show', compact('apiKey'));
    }

}