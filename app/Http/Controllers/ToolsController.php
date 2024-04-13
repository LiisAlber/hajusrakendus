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
            'description' => 'required',
            'brand' => 'required|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|url' 
        ]);

        Tools::create($validatedData);
        return redirect()->route('tools.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Tools $tool)
    {
        return view('tools.show', compact('tools'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tools $tool)
    {
        return view('tools.edit', compact('tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tools $tool)
{
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'brand' => 'required|max:255',
        'price' => 'required|numeric',
        'image' => 'nullable|url'
    ]);

    // Update the tool with validated data.
    $tool->update($validatedData);

    return redirect()->route('tools.index')->with('success', 'Tool updated successfully');

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tools $tool)
    {
        $tool->delete();
        return redirect()->route('tools.index');
    }
}
