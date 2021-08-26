<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Round extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'rounds';

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'FK_userID')->withTrashed();
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
