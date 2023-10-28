<?php

namespace App\Http\Controllers;

use App\Enums\GotBookEntryStatus;
use App\Models\GotBook;
use App\Models\GotBookEntry;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GotBookController extends Controller
{
    public function createGotBook(Request $request)
    {
        $gotBook = new GotBook();
        $gotBook->got_book_id = $request->got_book_id;
        $gotBook->user_id = Auth::user()->id;
        $gotBook->save();
        return response()->json($gotBook);
    }

    public function mapTripPlanEntryToGotBookEntry(Request $request) {
        $tripPlanEntry = $request->trip_plan_entry;
        $gotBookEntry = new GotBookEntry();
        $gotBookEntry->got_book_id = $tripPlanEntry->got_book_id;
        $gotBookEntry->section_id = $tripPlanEntry->section_id;
        $gotBookEntry->trip_date = $tripPlanEntry->trip_date;
        $gotBookEntry->badge_award_id = $tripPlanEntry->badge_award_id;
        $gotBookEntry->status = GotBookEntryStatus::WAITING_FOR_LEADER_VERIFICATION;
        $gotBookEntry->b_to_a = $tripPlanEntry->b_to_a;
        $gotBookEntry->trip_plan_entry_id = $tripPlanEntry->id;

        $gotBookEntry->save();
        return response()->json($gotBookEntry);
    }

    public function getAllEntriesForGotBook(GotBook $gotBook) {
        return GotBookEntry::where('got_book_id', $gotBook->id);
    }
}
