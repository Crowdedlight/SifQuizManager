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

}
