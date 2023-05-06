<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TerrainPoint extends Model
{
    use HasFactory;

    public function terrainPointAs(): HasMany
    {
        return $this->hasMany(Section::class, "terrain_point_a_id", "id");
    }

    public function terrainPointBs(): HasMany
    {
        return $this->hasMany(Section::class, "terrain_point_b_id", "id");
    }
}
