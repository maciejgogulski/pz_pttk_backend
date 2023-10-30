<?php

namespace App\Http\Controllers;

use App\Models\BadgeAward;
use Illuminate\Http\Request;

class BadgeAwardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $badgeAwards = BadgeAward::all();
        return response()->json($badgeAwards);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'badge_id' => 'required|exists:badges,id',
            'grant_date' => 'required|date',
            'badge_award_status' => 'required|string',
            'points_from_previous_badge' => 'integer|nullable',
        ]);

        $badgeAward = new BadgeAward();
        $badgeAward->user_id = $validatedData['user_id'];
        $badgeAward->badge_id = $validatedData['badge_id'];
        $badgeAward->grant_date = $validatedData['grant_date'];
        $badgeAward->badge_award_status = $validatedData['badge_award_status'];
        $badgeAward->points_from_previous_badge = $validatedData['points_from_previous_badge'];
        $badgeAward->save();

        return response()->json($badgeAward);
    }

    /**
     * Display the specified resource.
     */
    public function show(BadgeAward $badgeAward)
    {
        return response()->json($badgeAward);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BadgeAward $badgeAward)
    {
        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'badge_id' => 'exists:badges,id',
            'grant_date' => 'date',
            'badge_award_status' => 'string',
            'points_from_previous_badge' => 'integer|nullable',
        ]);

        $badgeAward->fill($validatedData);
        $badgeAward->save();

        return response()->json($badgeAward);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BadgeAward $badgeAward)
    {
        $badgeAward->delete();
        return response()->json(['message' => 'Badge award deleted']);
    }
}
