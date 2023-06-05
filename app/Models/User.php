<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function mountainGroups(): BelongsToMany
    {
        return $this->belongsToMany(MountainGroup::class, 'users_mountain_groups');
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

    public function usersMountainGroups()
    {
        return $this->hasMany(UserMountainGroup::class);
    }

    // Role użytkowników (relacje)

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function assignRole(Role $role)
    {
        $this->roles()->attach($role);
    }

    public function revokeRole(Role $role)
    {
        $this->roles()->detach($role);
    }

    public function hasRole(string $roleName): bool
    {
        return $this->roles()->where('name', $roleName)->exists();
    }
}
