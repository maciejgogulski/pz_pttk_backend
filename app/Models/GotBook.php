<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GotBook extends Model
{
    use HasFactory;

    protected $fillable = ['got_book_id'];

    public function tourist(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function entries(): HasMany
    {
        return $this->hasMany(GotBookEntry::class);
    }
}
