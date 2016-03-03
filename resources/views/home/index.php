<div class="row">
    <div class="col-md-12">
        <div class="jumbotron">
            <h1>Welcome to SIF Quiz Manager</h1>

            <p>Here's a text with some explanations how to use this app.</p>

            <?php
            echo Modal::named('new_round')
                ->withTitle('Add New Round')
                ->withButton(Button::success('Add New Round')->setSize('btn-md'))
                ->withBody(view('modals.new_round')->render());
            ?>
        </div>
    </div>
</div>

<div class="panel panel-default">
    <!-- Default panel contents -->
    <div class="panel-heading">Active Rounds</div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Round Name</th>
            <th>Number of Teams</th>
            <th>Last updated</th>
            <th>Created By</th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rounds as $round): ?>
            <tr>
                <th><a href="<?= route('round.single', [$round->id]); ?>"><?= $round->name; ?></a></th>
                <td><?= $round->numTeams ?></td>
                <td>
                        <span data-toggle="tooltip" data-placement="top" title="<?=$round->updated_at ?>">
                            <?= Carbon\Carbon::parse($round->updated_at)->diffForHumans() ?>
                        </span>
                </td>
                <td><?= $round->user->name ?></td>
                <td>
                        <span data-toggle="tooltip" data-placement="top" title="<?=$round->created_at ?>">
                            <?= Carbon\Carbon::parse($round->created_at)->diffForHumans() ?>
                        </span>
                </td>
                <td>
                    <?php if ($round->where('active', true)): ?>
                        <span class="label label-info" data-toggle="tooltip" data-placement="top" title="active">Active</span>
                    <?php endif; ?>

                    <?php if ($round->where('status', 'running')->count() == 1): ?>
                        <span class="label label-success" data-toggle="tooltip" data-placement="top" title="Finished">Running</span>
                    <?php endif; ?>

                    <?php if ($round->where('status', 'finished')->count() == 1): ?>
                        <span class="label label-danger" data-toggle="tooltip" data-placement="top" title="Finished">Finished</span>
                    <?php endif; ?>

                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>