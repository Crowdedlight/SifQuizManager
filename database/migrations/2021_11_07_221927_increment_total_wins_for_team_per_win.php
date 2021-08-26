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
        Round::all()->each(function ($item, $key) {
            // get winning team
            $winningTeam = RoundTeams::where('FK_round', $item->id)->where('position', 1)->first();
            $winningTeam->TotalWins = $winningTeam->TotalWins + 1;
            $winningTeam->save();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // just set all totalWins to 0 for all teams, as we haven't counted them so far.
        Team::all()->each(function ($item, $key) {
            // get winning team
            $item->TotalWins = 0;
            $item->save();
        });
    }
}
