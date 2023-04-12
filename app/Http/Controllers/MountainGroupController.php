<?php

namespace App\Http\Controllers;

use App\Models\MountainGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MountainGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mountainGroups = MountainGroup::all();
        return response()->json($mountainGroups);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mountainGroup = new MountainGroup();
        $mountainGroup->name = $request->input('name');
        $mountainGroup->save();
        return response()->json($mountainGroup);
    }

    /**
     * Display the specified resource.
     */
    public function show(MountainGroup $mountainGroup)
    {
        return response()->json($mountainGroup);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MountainGroup $mountainGroup)
    {
        $mountainGroup->name = $request->input('name');
        $mountainGroup->save();
        return response()->json($mountainGroup);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MountainGroup $mountainGroup)
    {
        $mountainGroup->delete();
        return response()->json(['message' => 'Mountain group deleted']);
    }
}
