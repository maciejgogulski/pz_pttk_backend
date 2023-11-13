<?php

namespace App\Http\Controllers;

use App\Models\TripPlan;
use App\Models\TripPlanEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TripPlan::query()
            ->with(['tripPlanEntries', 'tripPlanEntries.section'])
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/'
        ]);

        $tripPlan = new TripPlan();
        $tripPlan->name = $validatedData['name'];
        $tripPlan->description = $request->description;
        $tripPlan->user_id = Auth::user()->id;
        $tripPlan->save();
        return response()->json($tripPlan);
    }

    /**
     * Display the specified resource.
     */
    public function show(TripPlan $tripPlan)
    {
        return TripPlan::query()
            ->with(['tripPlanEntries', 'tripPlanEntries.section'])
            ->where('id' ,'=', $tripPlan->id)
            ->get()->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TripPlan $tripPlan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/'
        ]);

        $tripPlan->name = $validatedData['name'];
        $tripPlan->description = $request->description;
        $tripPlan->user_id = Auth::user()->id;
        $tripPlan->save();
        return response()->json($tripPlan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TripPlan $tripPlan)
    {
        $tripPlan->delete();
        return response()->json(['message' => 'Trip plan deleted']);
    }

    public function putEntry(Request $request) {
        $tripPlanEntry = new TripPlanEntry();
        $tripPlanEntry->trip_plan_id = $request->input('trip_plan_id');
        $tripPlanEntry->section_id = $request->input('section_id');
        $tripPlanEntry->trip_date = $request->input('trip_date');
        $tripPlanEntry->b_to_a = $request->input('b_to_a');

        $tripPlanEntry->save();

        return response()->json($tripPlanEntry);
    }

    public function deleteEntry(TripPlanEntry $tripPlanEntry) {
        $tripPlanEntry->delete();

        return response()->json(['message' => 'Entry deleted']);
    }

    public function storeWithEntries(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/'
        ]);

        $tripPlan = new TripPlan();
        $tripPlan->name = $validatedData['name'];
        $tripPlan->description = $request->description;
        $tripPlan->user_id = Auth::user()->id;

        $tripPlan->save();

        $tripPlanEntries = $request->trip_plan_entries;

        foreach($tripPlanEntries as $entry) {
            $savedEntryModel = new TripPlanEntry();
            $savedEntryModel->trip_plan_id = $tripPlan->id;
            $savedEntryModel->section_id = $entry['section_id'];
            $savedEntryModel->trip_date = $entry['trip_date'];
            $savedEntryModel->status = 'PLANNED';
            $savedEntryModel->b_to_a = $entry['b_to_a'];

            $tripPlan->tripPlanEntries()->save($savedEntryModel);
        }

        // Return JSON response with TripPlan and its TripPlanEntries
        $tripPlan->load('tripPlanEntries');
        return response()->json($tripPlan);
    }

    public function updateWithEntries(Request $request, TripPlan $tripPlan)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-Z]+/',
            'trip_plan_entries' => 'required|array',
            'trip_plan_entries.*.section_id' => 'required',
            'trip_plan_entries.*.trip_date' => 'required',
            'trip_plan_entries.*.b_to_a' => 'required',
        ]);

        $tripPlan->name = $validatedData['name'];
        $tripPlan->description = $request->description;
        $tripPlan->user_id = Auth::user()->id;

        $tripPlan->save();

        // Delete previously existing TripPlanEntry models
        $tripPlan->tripPlanEntries()->delete();

        // Create and save new TripPlanEntry models
        $tripPlanEntries = $validatedData['trip_plan_entries'];

        foreach ($tripPlanEntries as $entry) {
            $savedEntryModel = new TripPlanEntry();

            $savedEntryModel->section_id = $entry['section_id'];
            $savedEntryModel->trip_date = $entry['trip_date'];
            $savedEntryModel->b_to_a = $entry['b_to_a'];

            $tripPlan->tripPlanEntries()->save($savedEntryModel);
        }

        // Return JSON response with TripPlan and its TripPlanEntries
        $tripPlan->load('tripPlanEntries');
        return response()->json($tripPlan);
    }

    public function getAllMappedEntriesForTrip(TripPlan $tripPlan) {
        return TripPlanEntry::where('trip_plan_id', $tripPlan->id)
            ->with('section')
            ->has('gotBookEntry')->get();
    }

    public function getAllUnmappedEntriesForTrip(TripPlan $tripPlan) {
        return TripPlanEntry::where('trip_plan_id', $tripPlan->id)
            ->with('section')
            ->doesntHave('gotBookEntry')->get();
    }
}
