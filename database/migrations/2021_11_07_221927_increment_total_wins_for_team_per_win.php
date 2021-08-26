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
        print(count($allRounds));

        foreach ($allRounds as $round) {
            // get winning team
            $winningTeamID = DB::table('roundteams')->where('FK_round', $round->id)->where('position', 1)->limit(1)->id;
            $winTeam = DB::table('teams')->where('id', $winningTeamID)->first();

            if (is_null($winTeam)) {
                print($round);
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
