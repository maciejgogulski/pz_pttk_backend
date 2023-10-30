<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $badges = Badge::all();
        return response()->json($badges);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Wersja podstawowa
        /*$validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);

        $badge = new Badge;
        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];
        $badge->next_badge = $validatedData['next_badge'];
        $badge->previous_badge = $validatedData['previous_badge'];
        $badge->save();

        return response()->json($badge);

        //Wersja ulepszona

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);
    
        $badge = new Badge;
        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];
        $badge->previous_badge = $validatedData['previous_badge'];
        
        // Sprawdź, czy podano identyfikator „next_badge”.
        if ($validatedData['next_badge']) {
            $temporaryNextBadge = new Badge;
            $temporaryNextBadge->save();
            $badge->next_badge = $temporaryNextBadge->id;
        }
    
        $badge->save();
    
        return response()->json($badge);*/

        //Wersja ostateczna
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);
    
        // Sprawdź, czy istnieje już odznaka o nazwie "Nowa odznaka"
        $existingBadge = Badge::where('name', 'Nowa odznaka')->first();

        if ($existingBadge) {
            // Edytuj istniejącą odznakę zamiast tworzyć nową
            $existingBadge->name = $validatedData['name'];
            $existingBadge->point_threshold = $validatedData['point_threshold'];
            
            $temporaryNextBadge = null;
        $temporaryPreviousBadge = null;
    
        if ($validatedData['next_badge']) {
            if ($validatedData['next_badge'] !== $existingBadge->id) {
                $nextBadge = Badge::find($validatedData['next_badge']);
                if ($nextBadge) {
                    $existingBadge->next_badge = $nextBadge->id;
                } else {
                    $temporaryNextBadge = new Badge;
                    $temporaryNextBadge->id = $validatedData['next_badge'];
                    $temporaryNextBadge->point_threshold = 0; // Możesz ustawić point_threshold na 0 dla tymczasowej odznaki
                    $temporaryNextBadge->save();
                    $existingBadge->next_badge = $temporaryNextBadge->id;
                }
            } else {
                $existingBadge->next_badge = null;
            }
        } else {
            $existingBadge->next_badge = null;
        }
    
        if ($validatedData['previous_badge']) {
            if ($validatedData['previous_badge'] !== $existingBadge->id) {
                $previousBadge = Badge::find($validatedData['previous_badge']);
                if ($previousBadge) {
                    $existingBadge->previous_badge = $previousBadge->id;
                } else {
                    $temporaryPreviousBadge = new Badge;
                    $temporaryPreviousBadge->id = $validatedData['previous_badge'];
                    $temporaryPreviousBadge->point_threshold = 0; // Możesz ustawić point_threshold na 0 dla tymczasowej odznaki
                    $temporaryPreviousBadge->save();
                    $existingBadge->previous_badge = $temporaryPreviousBadge->id;
                }
            } else {
                $existingBadge->previous_badge = null;
            }
        } else {
            $existingBadge->previous_badge = null;
        }
    
        $existingBadge->save();

        if ($temporaryNextBadge) {
            $temporaryNextBadge->previous_badge = $existingBadge->id;
            $temporaryNextBadge->save();
            $existingBadge->next_badge = $temporaryNextBadge->id;
        }
        
        if ($temporaryPreviousBadge) {
            $temporaryPreviousBadge->next_badge = $existingBadge->id;
            $temporaryPreviousBadge->save();
            $existingBadge->previous_badge = $temporaryPreviousBadge->id;
        }

            return response()->json($existingBadge);
        } else {

        $badge = new Badge;
        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];

        $temporaryNextBadge = null;
        $temporaryPreviousBadge = null;
    
        if ($validatedData['next_badge']) {
            if ($validatedData['next_badge'] !== $badge->id) {
                $nextBadge = Badge::find($validatedData['next_badge']);
                if ($nextBadge) {
                    $badge->next_badge = $nextBadge->id;
                } else {
                    $temporaryNextBadge = new Badge;
                    $temporaryNextBadge->id = $validatedData['next_badge'];
                    $temporaryNextBadge->point_threshold = 0; // Możesz ustawić point_threshold na 0 dla tymczasowej odznaki
                    $temporaryNextBadge->save();
                    $badge->next_badge = $temporaryNextBadge->id;
                }
            } else {
                $badge->next_badge = null;
            }
        } else {
            $badge->next_badge = null;
        }
    
        if ($validatedData['previous_badge']) {
            if ($validatedData['previous_badge'] !== $badge->id) {
                $previousBadge = Badge::find($validatedData['previous_badge']);
                if ($previousBadge) {
                    $badge->previous_badge = $previousBadge->id;
                } else {
                    $temporaryPreviousBadge = new Badge;
                    $temporaryPreviousBadge->id = $validatedData['previous_badge'];
                    $temporaryPreviousBadge->point_threshold = 0; // Możesz ustawić point_threshold na 0 dla tymczasowej odznaki
                    $temporaryPreviousBadge->save();
                    $badge->previous_badge = $temporaryPreviousBadge->id;
                }
            } else {
                $badge->previous_badge = null;
            }
        } else {
            $badge->previous_badge = null;
        }
    
        $badge->save();

        if ($temporaryNextBadge) {
            $temporaryNextBadge->previous_badge = $badge->id;
            $temporaryNextBadge->save();
            $badge->next_badge = $temporaryNextBadge->id;
        }
        
        if ($temporaryPreviousBadge) {
            $temporaryPreviousBadge->next_badge = $badge->id;
            $temporaryPreviousBadge->save();
            $badge->previous_badge = $temporaryPreviousBadge->id;
        }
    
        return response()->json($badge);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
            return response()->json($badge);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        //Wersja podstawowa
        /*$validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);

        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];
        $badge->next_badge = $validatedData['next_badge'];
        $badge->previous_badge = $validatedData['previous_badge'];
        $badge->save();

        return response()->json($badge);

        //Wersja ulepszona

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);
    
        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];
        $badge->previous_badge = $validatedData['previous_badge'];
    
        // Sprawdź, czy podano identyfikator „next_badge”.
        if ($validatedData['next_badge']) {
            // Spróbuj znaleźć „next_badge” w bazie danych
            $nextBadge = Badge::find($validatedData['next_badge']);
    
            if ($nextBadge) {
                // Jeśli istnieje, zaktualizuj „next_badge”
                $badge->next_badge = $nextBadge->id;
            } else {
                // Jeśli nie istnieje, utwórz odznakę tymczasową o identyfikatorze większym o 1
                $temporaryNextBadge = new Badge;
                $temporaryNextBadge->id = $validatedData['next_badge'];
                $temporaryNextBadge->point_threshold = 0; // Możesz ustawić point_threshold na 0 dla tymczasowej plakietki
                $temporaryNextBadge->save();
                $badge->next_badge = $temporaryNextBadge->id;
            }
        } else {
            // Jeśli nie podano „next_badge”, ustaw istniejące „next_badge” na null
            $badge->next_badge = null;
        }
    
        $badge->save();
    
        return response()->json($badge);*/

        //Wersja ostateczna
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'point_threshold' => 'required|integer',
            'next_badge' => 'integer|nullable',
            'previous_badge' => 'integer|nullable',
        ]);
    
        $badge->name = $validatedData['name'];
        $badge->point_threshold = $validatedData['point_threshold'];

        $temporaryNextBadge = null;
        $temporaryPreviousBadge = null;
    
        if ($validatedData['next_badge'] && $validatedData['next_badge'] !== $badge->id) {
            $nextBadge = Badge::find($validatedData['next_badge']);
    
            if ($nextBadge) {
                $badge->next_badge = $nextBadge->id;
            } else {
                $temporaryNextBadge = new Badge;
                $temporaryNextBadge->id = $validatedData['next_badge'];
                $temporaryNextBadge->point_threshold = 0;
                $temporaryNextBadge->save();
                $badge->next_badge = $temporaryNextBadge->id;
            }
        } else {
            $badge->next_badge = null;
        }
    
        if ($validatedData['previous_badge'] && $validatedData['previous_badge'] !== $badge->id) {
            $previousBadge = Badge::find($validatedData['previous_badge']);
    
            if ($previousBadge) {
                $badge->previous_badge = $previousBadge->id;
            } else {
                $temporaryPreviousBadge = new Badge;
                $temporaryPreviousBadge->id = $validatedData['previous_badge'];
                $temporaryPreviousBadge->point_threshold = 0;
                $temporaryPreviousBadge->save();
                $badge->previous_badge = $temporaryPreviousBadge->id;
            }
        } else {
            $badge->previous_badge = null;
        }
    
        $badge->save();

        if ($temporaryNextBadge) {
            $temporaryNextBadge->previous_badge = $badge->id;
            $temporaryNextBadge->save();
            $badge->next_badge = $temporaryNextBadge->id;
        }
        
        if ($temporaryPreviousBadge) {
            $temporaryPreviousBadge->next_badge = $badge->id;
            $temporaryPreviousBadge->save();
            $badge->previous_badge = $temporaryPreviousBadge->id;
        }
    
        return response()->json($badge);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        if ($badge) {
            $badge->delete();
            return response()->json(['message' => 'Badge deleted']);
        } else {
            return response()->json(['message' => 'Badge not found']);
        }
    }
}
