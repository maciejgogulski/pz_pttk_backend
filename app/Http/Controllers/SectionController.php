<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();
        return response()->json($sections);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $section = new Section();
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->mountain_range = $request->input('mountain_range');
        $section->terrain_point_a = $request->input('terrain_point_a');
        $section->terrain_point_b = $request->input('terrain_point_b');
        $section->badge_points_a_to_b = $request->input('badge_points_a_to_b');
        $section->badge_points_b_to_a = $request->input('badge_points_b_to_a');
        $section->save();
        return response()->json($section);
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        return response()->json($section);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Section $section)
    {
        $section->name = $request->input('name');
        $section->description = $request->input('description');
        $section->mountain_range = $request->input('mountain_range');
        $section->terrain_point_a = $request->input('terrain_point_a');
        $section->terrain_point_b = $request->input('terrain_point_b');
        $section->badge_points_a_to_b = $request->input('badge_points_a_to_b');
        $section->badge_points_b_to_a = $request->input('badge_points_b_to_a');
        $section->save();
        return response()->json($section);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return response()->json(['message' => 'Section deleted']);
    }
}
