<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    protected $table = 'rounds';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'FK_userID');
    }

    public function roundTeams()
    {
        return $this->hasMany('App\Models\RoundTeams', 'FK_round', 'id');
    }

    public function comment()
    {
        return $this->hasMany('App\Models\Comment', 'FK_round', 'id');
    }

}
