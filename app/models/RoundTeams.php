<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoundTeams extends Model
{
    protected $table = 'roundteams';
    protected $fillable = array('FK_round', 'FK_team', 'numPersons', 'position', 'points');

    public function team()
    {
        return $this->hasOne('App\Models\Team', 'id', 'FK_team');
    }

    public function round()
    {
        return $this->belongsTo('App\Models\Round', 'FK_round');
    }
}
