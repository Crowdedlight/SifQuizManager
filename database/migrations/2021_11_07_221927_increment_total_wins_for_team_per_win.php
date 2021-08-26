<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
        $allRounds = DB::table('rounds')->whereNull('deleted_at')->get();

        foreach ($allRounds as $round) {
            // get winning team
            $winningTeamID = DB::table('roundteams')->where('FK_round', $round->id)->orderBy('points', 'DESC')->first()->id;
            $winTeam = DB::table('teams')->where('id', $winningTeamID)->first();

            if (is_null($winTeam)) {
                continue;
            }

            $wins = $winTeam->TotalWins + 1;
            DB::table('teams')->where('id', $winningTeamID)->update(['TotalWins' => $wins]);
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
