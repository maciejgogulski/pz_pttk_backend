<?php

namespace App\Http\Controllers;

use App\Enums\BadgeAwardStatus;
use App\Enums\GotBookEntryStatus;
use App\Models\BadgeAward;
use App\Models\GotBook;
use App\Models\GotBookEntry;
use App\Models\TripPlanEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GotBookController extends Controller
{
    public function getGotBook() {
        return GotBook::where("user_id", Auth::user()->id)->first();
    }

    public function createGotBook()
    {
        $gotBook = GotBook::where("user_id", Auth::user()->id)->first();

        if ($gotBook) {
           return response()->json(['message' => 'User already has GOT book'], 400);
        }

        $gotBook = new GotBook();
        $gotBook->got_book_id = date('Y');
        $gotBook->user_id = Auth::user()->id;
        $gotBook->save();
        $gotBook->got_book_id = $gotBook->id . '/' . $gotBook->got_book_id;
        $gotBook->save();

        $badgeAward = new BadgeAward();
        $badgeAward->user_id = Auth::user()->id;
        $badgeAward->badge_id = 1;
        $badgeAward->badge_award_status = BadgeAwardStatus::COLLECTING_POINTS->name;
        $badgeAward->points_from_previous_badge = 0;
        $badgeAward->save();

        return response()->json($gotBook);
    }

    public function mapTripPlanEntryToGotBookEntry(Request $request) {
        $gotBookEntry = new GotBookEntry();
        $gotBookEntry->got_book_id = $request->got_book_id;
        $gotBookEntry->section_id = $request->section_id;
        $gotBookEntry->trip_date = $request->trip_date;
        $gotBookEntry->badge_award_id = $request->badge_award_id;
        $gotBookEntry->status = GotBookEntryStatus::WAITING_FOR_LEADER_VERIFICATION->name;
        $gotBookEntry->b_to_a = $request->b_to_a;
        $gotBookEntry->trip_plan_entry_id = $request->trip_plan_entry_id;

        $gotBookEntry->save();
        return response()->json($gotBookEntry);
    }

    public function getAllEntriesForGotBook(GotBook $gotBook) {
        return GotBookEntry::where('got_book_id', $gotBook->id);
    }

    public function getLatestBadgeAward() {
        return BadgeAward::where('user_id', Auth::user()->id)
            ->where('badge_award_status', BadgeAwardStatus::COLLECTING_POINTS->name)
            ->where('grant_date', null)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
