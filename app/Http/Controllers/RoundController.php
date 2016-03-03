<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use App\Models\round;
use App\Http\Requests;

class RoundController extends Controller
{
    public function create(Requests\CreateRoundRequest $request)
    {
        $round = new Round();
        $round->name        = $request->input('round_name');
        $round->numTeams    = 0;
        $round->active      = true;
        $round->status      = 'running';
        $round->FK_userID  = Auth::user()->id;
        $round->save();

        return redirect()->route('home');
    }

    public function single()
    {


    }
}
