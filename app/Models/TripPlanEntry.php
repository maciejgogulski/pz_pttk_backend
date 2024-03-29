<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class TripPlanEntry extends Model
{
    use HasFactory;

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function tripPlan(): HasOne {
        return $this->hasOne(TripPlan::class);
    }

    public function gotBookEntry(): HasOne
    {
        return $this->hasOne(GotBookEntry::class);
    }
}
