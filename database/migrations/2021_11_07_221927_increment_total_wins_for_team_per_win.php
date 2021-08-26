<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Round;
use App\Models\RoundTeams;
use App\Models\Team;

class IncrementTotalWinsForTeamPerWin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // get all rounds
        $allRounds = Round::all();

        foreach ($allRounds as $round) {
            // get winning team
            $winningTeam = RoundTeams::where('FK_round', $round->id)->where('position', 1)->first()->team();
            $winningTeam->TotalWins = $winningTeam->TotalWins + 1;
            $winningTeam->save();
        };
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // nothing
    }
}
