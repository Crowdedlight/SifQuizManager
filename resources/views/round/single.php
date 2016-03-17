<?php if (count($errors->all()) > 0): ?>
    <div class="alert alert-danger" role="alert"><?php echo $errors->first(); ?></div>
<?php endif;
if ($round->status == "Finished"):?>
    <div class="alert alert-success" role="alert" style="">This round is complete. Nothing do to here. Move along.</div>
<?php endif; ?>

<div class="row">
    <div class="col-md-9">
        <div class="jumbotron">
            <span class=""><strong><?= $round->name; ?> </strong></span>
            <br/>

            <span class="pull-left">Created by: <?= $round->user->name; ?></span>
            <br/>

            <span class="pull-left">Created at: <?= $round->created_at; ?></span>
            <br/>

            <span class="pull-left">Last Updated: <?= $round->updated_at; ?></span>
            <span class="pull-right"> Total Teams: <?= $round->numTeams ?> </span>
            <br/>

            <span class="pull-right"> Total Persons: <?= $round->roundTeams->sum('numPersons'); ?></span>
        </div>

        <div class="jumbotron">
            <h3>Teams</h3>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Position</th>
                    <th>Name</th>
                    <th>Number of Persons</th>
                    <th class="text-right">Points</th>
                    <?php if ($round->status != 'Finished'): ?>
                        <th class="text-right">Update Points</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($round->roundTeams()->orderBy('points', 'DESC')->get() as $roundTeam):
                    ?>
                    <tr>
                        <td><?= $roundTeam->position ?></td>
                        <td><?= $roundTeam->team->name; ?></td>
                        <td><?= $roundTeam->numPersons; ?></td>
                        <td class="text-right"><?= $roundTeam->points; ?></td>

                        <?php if ($round->status != 'Finished'): ?>
                            <td class="pull-right">
                                <?php echo Modal::named('add_points' . $roundTeam->FK_team)
                                    ->withTitle('Add points')
                                    ->withButton(Button::success('Add Points')->setSize('btn-xs'))
                                    ->withBody(view('modals.add_points')
                                        ->with('id', $round->id)
                                        ->with('FK_team', $roundTeam->FK_team)
                                        ->render());
                                ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (count($round->comment) > 0): ?>
        <?php foreach ($round->comment->reverse() as $comment): ?>
        <?php if ($comment->type == 'round_info'): ?>
        <div class="alert alert-info" role="alert">
            <?php elseif ($comment->type == 'round_log'): ?>
            <div class="alert alert-success" role="alert">
                <?php elseif ($comment->type == 'round_important'): ?>
                <div class="alert alert-danger" role="alert">
                    <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        <?php endif; ?>
                        <p><?= $comment->comment; ?></p>
                        <span class="text-muted"><?= $comment->created_at . ' by ' . $comment->user->name ?></span>
                    </div>
                    <?php endforeach;
                    endif; ?>
                </div>

                <div class="col-md-3">
                    <?php if (!($round->status == 'Finished') && $round->active): ?>
                        <div class="jumbotron">

                            <?php
                                echo Modal::named('add_team')
                                    ->withTitle('Add Team')
                                    ->withButton(Button::withValue('Add Team')->block())
                                    ->withBody(view('modals.add_team')->with('id', $round->id)->render());
                            ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!($round->status == 'Finished') && $round->roundTeams->count() > 0): ?>
                        <div class="jumbotron">
                            <?php echo Modal::named('close')
                                ->withTitle('Close Round')
                                ->withButton(Button::danger('Close Round')->block())
                                ->withBody(view('modals.close_round')->with('id', $round->id)->render());
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="jumbotron">
                        <?php echo Modal::named('add_comment')
                            ->withTitle('Add Comment')
                            ->withButton(Button::info('Add Comment')->block())
                            ->withBody(view('modals.add_comment')->with('id', $round->id)->render());
                        ?>
                    </div>
                </div>
            </div>