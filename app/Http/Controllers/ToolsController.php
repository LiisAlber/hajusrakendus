<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tools::all();
        return view('tools.index', compact('tools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'brand' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048', 
        ]);

    
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/tools');
            $validatedData['image'] = $path;
        }

        $tool = Tools::create($validatedData);

    
        return redirect()->route('tools.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tools $tools)
    {
        return view('tools.show', compact('tools'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tools $tools)
    {
        return view('tools.edit', compact('tools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tools $tools)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'brand' => 'required|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('image')) {
        // Delete the old image if it exists and it's not a default image
        if ($tools->image && !str_contains($tools->image, 'default-image.png')) {
            Storage::delete($tools->image);
        }

        $path = $request->file('image')->store('public/tools');
        $validatedData['image'] = $path;
    }

    $tools->update($validatedData);

    return redirect()->route('tools.index');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tools $tools)
    {
        $tools->delete();
        return redirect()->route('tools.index');
    }
}
