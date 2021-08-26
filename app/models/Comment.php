<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    public function round()
    {
        return $this->BelongsTo('App\Models\Round', 'id', 'FK_round');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'FK_user')->withTrashed();
    }
}
