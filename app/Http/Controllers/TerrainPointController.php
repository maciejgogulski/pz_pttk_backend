<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\TerrainPoint;
use Illuminate\Http\Request;
use App\Models\MountainGroup;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TerrainPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terrainPoints = TerrainPoint::all();
        return response()->json($terrainPoints);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/',
            'sea_level_height' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $terrainPoint = new TerrainPoint();
        $terrainPoint->name = $validatedData['name'];
        $terrainPoint->description = $request->input('description');
        $terrainPoint->sea_level_height = $validatedData['sea_level_height'];
        $terrainPoint->latitude = $validatedData['latitude'];
        $terrainPoint->longitude = $validatedData['longitude'];
        $terrainPoint->save();
        return response()->json($terrainPoint);
    }

    /**
     * Display the specified resource.
     */
    public function show(TerrainPoint $terrainPoint)
    {
        return response()->json($terrainPoint);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TerrainPoint $terrainPoint)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/',
            'sea_level_height' => 'required|numeric',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        $terrainPoint->name = $validatedData['name'];
        $terrainPoint->description = $request->input('description');
        $terrainPoint->sea_level_height = $validatedData['sea_level_height'];
        $terrainPoint->latitude = $validatedData['latitude'];
        $terrainPoint->longitude = $validatedData['longitude'];
        $terrainPoint->save();
        return response()->json($terrainPoint);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TerrainPoint $terrainPoint)
    {
        // Sprawdzamy, czy któryś z punktów terenu A lub B sekcji odcinka zawiera punkt o danym ID
        $sections = $terrainPoint->terrainPointAs->merge($terrainPoint->terrainPointBs);
        $containsPoint = $sections->contains(function ($section) use ($terrainPoint) {
            return $section->terrainPointAs && $section->terrainPointBs && ($section->terrainPointAs->contains($terrainPoint) || $section->terrainPointBs->contains($terrainPoint));
        });
        
        if ($containsPoint) 
        {
            $this->deleteTerrainPointAndSection($terrainPoint->id);
        } 
        else 
        {
            $terrainPoint->delete();
        }
        return response()->json(['message' => 'Terrain point deleted successfully']);
    }

    private function deleteTerrainPointAndSection(int $terrainPointId)
    {
        DB::transaction(function () use ($terrainPointId) 
        {
            $terrainPoint = TerrainPoint::findOrFail($terrainPointId);
            $sections = $terrainPoint->terrainPointAs->merge($terrainPoint->terrainPointBs)->map(fn ($section) => $section->id)->toArray();
            Section::whereIn('id', $sections)->delete();
            $terrainPoint->delete();
        });
    }
}

