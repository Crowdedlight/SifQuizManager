<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Round;
use App\Models\RoundTeams;
use App\Models\Comment;
use App\Models\Team;
use App\Http\Requests;

class RoundController extends Controller
{

    public function index()
    {
        $rounds = Round::orderBy('created_at', 'DESC')->paginate(10);

        view()->share('rounds', $rounds);

        return $this->view('round.index');
    }

    public function create(Requests\CreateRoundRequest $request)
    {
        $round = new Round();
        $round->name        = $request->input('round_name');
        $round->numTeams    = 0;
        $round->active      = true;
        $round->status      = 'running';
        $round->FK_userID   = Auth::user()->id;
        $round->save();

        $comment            = new Comment();
        $comment->FK_user   = Auth::user()->id;
        $comment->type      = 'round_info';
        $comment->comment   = 'Round Opened';
        $comment->FK_round  = $round->id;
        $comment->save();

        return redirect()->route('home');
    }

    public function single(Request $request, $id)
    {
        if (!is_numeric($id)) {
            return redirect()->route('home');
        }

        $round = Round::find($id);
        //Eager Loading
        $round->load('roundTeams');

        if (is_null($round)) {
            return redirect()->route('rounds.all');
        }

        view()->share('round', $round);

        return $this->view('round.single');

    }


    public function addTeam(Requests\AddTeamRequest $request, $id)
    {
        $round = Round::find($id);
        if (is_null($round))
            return redirect()->route('round.single', ['id' => $id]);

        //Get input
        $teamname = $request->input('TeamName');
        $numPerson = $request->input('numPersons');

        //if a team already exists for this sheet, retrive the record and update it, else create a new record
        $Team = Team::firstOrNew(
            [
                'name' => $teamname
            ]
        );

        $Team->save();

        //Check if Team is already on current round, else add it
        $currentRound = RoundTeams::firstOrNew(
            [
                'FK_round' => $id,
                'FK_team'  => $Team->id
            ]
        );

        $currentRound->numPersons = $numPerson;
        $currentRound->points = 0;
        $currentRound->save();

        //Update round with new team
        $round = Round::find($id);
        $round->numTeams = $round->roundTeams->count();
        $round->save();

        return redirect()->route('round.single', ['id' => $id]);
    }

    public function addPoints(Request $request, $id, $FK_team)
    {
        //Find entry in roundteams
        $round = Round::find($id);
        $roundTeams = $round->roundTeams()->where('FK_team', $FK_team)->first();

        if (is_null($roundTeams))
            return redirect()->route('round.single', ['id' => $id]);

        $addpoints = $request::input('points');
        $currentPoints = $roundTeams->points;
        $newPoints = $addpoints + $currentPoints;

        $roundTeams->points = $newPoints;

        $roundTeams->save();

        //Update Position
        $position = 1;
        foreach ($round->roundTeams()->orderBy('points', 'DESC')->get() as $roundTeam)
        {
            $roundTeam->position = $position;
            $roundTeam->save();

            $position++;
        }


        return redirect()->route('round.single', ['id' => $id]);

    }

    public function AddComment(Request $request, $id)
    {
        $round = Round::find($id);

        if (is_null($round))
            return redirect()->route('round.single', ['id' => $id]);

        $comment            = new Comment();
        $comment->FK_user   = Auth::user()->id;
        $comment->type      = 'round_info';
        $comment->comment   = $request::input('comment');
        $comment->FK_round  = $round->id;
        $comment->save();

        return redirect()->route('round.single', ['id' => $id]);
    }


    public function close(Requests\CloseSheetRequest $request, $id)
    {
        $round = Round::find($id);

        if (is_null($round))
            return redirect()->route('round.single', ['id' => $id]);

        $round->status = 'Finished';
        $round->active   = false;
        $round->save();
        $comment            = new Comment();
        $comment->FK_user   = Auth::user()->id;
        $comment->type      = 'round_important';
        $comment->comment   = 'Closed with comment: ' . $request->input('comment');
        $comment->FK_round  = $round->id;
        $comment->save();
        return redirect()->route('round.single', ['id' => $id]);
    }
}
