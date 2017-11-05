@extends('layout.master')

@section('content')

@if (count($errors->all()) > 0)
    <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
@endif
@if ($round->status == "Finished")
    <div class="alert alert-success" role="alert" style="">This round is complete. Nothing do to here. Move along.</div>
@endif

<div class="row">
    <div class="col-md-9">
        <div class="jumbotron">
            <span class=""><strong>{{ $round->name }} </strong></span>
            <br/>

            <span class="pull-left">Created by: {{ $round->user->name }}</span>
            <br/>

            <span class="pull-left">Created at: {{ $round->created_at }}</span>
            <br/>

            <span class="pull-left">Last Updated: {{ $round->updated_at }}</span>
            <span class="pull-right"> Total Teams: {{ $round->numTeams }} </span>
            <br/>

            <span class="pull-right"> Total Persons: {{ $round->roundTeams->sum('numPersons') }}</span>
            <br/>

            <?php
                $position1 = $round->roundTeams->contains('position', 1);
                $position2 = $round->roundTeams->contains('position', 2);
                $position3 = $round->roundTeams->contains('position', 3);

                if ($position1)
                {
                    $position1 = 30;
                } else
                {
                    $position1 = 0;
                }

                if ($position2)
                {
                    $position2 = $round->roundTeams()->where('position', 2)->first()->numPersons;
                } else
                {
                    $position2 = 0;
                }

                if ($position3)
                {
                    $position3 = $round->roundTeams()->where('position', 3)->first()->numPersons;
                } else
                {
                    $position3 = 0;
                }

                $beerPrize = $position1 + $position2 + $position3;
                $beerTotal = $round->roundTeams()->sum('numPersons') + $beerPrize;
            ?>

            <span class="pull-right"> Number of Beers (Prizes): {{ $beerPrize  }}   </span>
            <br/>

            <span class="pull-right"> Total Beers: {{ $beerTotal  }}   </span>
        </div>

        <div class="jumbotron">
            <h3>Teams</h3>

            <table class="table table-striped vertical-align">
                <thead>
                <tr>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Number of Persons</th>
                    <th class="text-right">Points</th>

                    @if ($round->status != 'Finished')
                        <th class="text-right">Update Points</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($round->roundTeams()->orderBy('points', 'DESC')->get() as $roundTeam)
                    <tr>
                        <td>{{ $roundTeam->position }}</td>
                        <td>{{ $roundTeam->team->name }}</td>
                        <td>
                            <div class="center-block">
                                <button type="button" class="btn btn-link changeNumPersons" data-action="decrement" data-id="{{ $roundTeam->id }}"><span class="glyphicon glyphicon-minus"></span> </button>
                                <span class="textPersons" data-id="{{ $roundTeam->id }}">{{ $roundTeam->numPersons }}</span>
                                <button type="button" class="btn btn-link changeNumPersons" data-action="increment" data-id="{{ $roundTeam->id }}"><span class="glyphicon glyphicon-plus"></span> </button>
                            </div>
                        </td>
                        <td class="text-right">{{ $roundTeam->points }}</td>

                        @if ($round->status != 'Finished')
                            <td class="pull-right">
                                <?php echo Modal::named('add_points' . $roundTeam->FK_team)
                                    ->withTitle('Add points')
                                    ->withButton(Button::success('Add Points')->setSize('btn-xs'))
                                    ->withBody(view('modals.add_points')
                                        ->with('id', $round->id)
                                        ->with('FK_team', $roundTeam->FK_team)
                                        ->render())
                                ?>
                            </td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if (count($round->comment) > 0)
            @foreach ($round->comment->reverse() as $comment)
                @if ($comment->type == 'round_info')
                    <div class="alert alert-info" role="alert">
                @elseif ($comment->type == 'round_log')
                    <div class="alert alert-success" role="alert">
                @elseif ($comment->type == 'round_important')
                    <div class="alert alert-danger" role="alert">
                @else
                    <div class="alert alert-warning" role="alert">
                @endif

                <p>{{$comment->comment }}</p>
                <span class="text-muted">{{ $comment->created_at . ' by ' . $comment->user->name }}</span>
                </div>
            @endforeach
        @endif
    </div>
    <div class="col-md-3">
        @if (!($round->status == 'Finished') && $round->active)
            <div class="jumbotron">
            <?php echo Modal::named('add_team')
                ->withTitle('Add Team')
                ->withAttributes(['data-backdrop' => 'static', 'data-keyboard' => 'true'])
                ->withButton(Button::withValue('Add Team')->block())
                ->withBody(view('modals.add_team')->with('id', $round->id)->render())
            ?>
            </div>
        @endif

        @if (!($round->status == 'Finished') && $round->roundTeams->count() > 0)
            <div class="jumbotron">
            <?php echo Modal::named('close')
                    ->withTitle('Close Round')
                    ->withButton(Button::danger('Close Round')->block())
                    ->withBody(view('modals.close_round')->with('id', $round->id)->render())
            ?>
            </div>
        @endif

        <div class="jumbotron">
            <?php echo Modal::named('add_comment')
                ->withTitle('Add Comment')
                ->withButton(Button::info('Add Comment')->block())
                ->withBody(view('modals.add_comment')->with('id', $round->id)->render())
            ?>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        //Price per group member
        var personPrice = 15;

        //Auto update admission based on groupmembers
        $(document).on("keyup", "#numPersons", function () {
            var num = $("#numPersons").val();
            var admission = num * personPrice;

            $(".admissionUpdate").text(admission + ' kr.');
        });

        $(document).on("click", ".changeNumPersons", function (e) {
            var target = $(e.target).closest('button').first();

            var roundTeamID = target.data().id;
            var action = target.data().action;
            var textPersons = $('span[data-id='+roundTeamID+ ']');
            //console.log("action: " + action + ", id: " + id);

            $.ajax({
                type: "POST",
                url: "{{ route('round.update.numPersons') }}",
                data: {'roundteamID': roundTeamID, 'action': action},
                success: function( msg ) {
                    textPersons.text(msg.numPersons);
                },
                error: function (msg) {
                    //do nothing atm
                }
            });
        });
    });
</script>
@endpush

