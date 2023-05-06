<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'first_name',
        'last_name',
        'legitimation_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mountainGroups(): HasMany
    {
        return $this->hasMany(MountainGroup::class);
    }

    public function gotBook(): HasOne
    {
        return $this->hasOne(GotBook::class);
    }

    public function sectionReport(): HasMany
    {
        return $this->hasMany(SectionReport::class);
    }

    public function tripPlans(): HasMany
    {
        return $this->hasMany(TripPlan::class);
    }

    public function badges(): HasMany
    {
        return $this->hasMany(Badge::class);
    }


}
