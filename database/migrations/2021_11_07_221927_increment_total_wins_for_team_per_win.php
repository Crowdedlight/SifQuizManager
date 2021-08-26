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
        $allRounds = DB::table('rounds')->get();

        foreach ($allRounds as $round) {
            // get winning team
            $winningTeamID = DB::table('roundteams')->where('FK_round', $round->id)->where('position', 1)->first()->id;
            DB::table('teams')->find($winningTeamID)->increment('TotalWins');
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
