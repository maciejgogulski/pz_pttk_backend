<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'tatra_podtatrze',
        'tatra_slowackie',
        'beskidy_zachodnie',
        'beskidy_wschodnie',
        'gory_swietokrzyskie',
        'sudety',
        'słowacja',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}