<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MountainGroup extends Model
{
    use HasFactory;

    public function leaders(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function mountainRanges(): HasMany
    {
        return $this->hasMany(MountainRange::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_mountain_groups');
    }
}
