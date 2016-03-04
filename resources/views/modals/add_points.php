<?php
echo BootForm::open(['route' => ['round.add_points', 'id' => $id, 'FK_round' => $FK_round, 'FK_team' => $FK_team]]);
echo BootForm::hidden('_action', 'add_points');
echo BootForm::number('points', 'Add Points');
?><small class="text-muted">The entered points gets added to the existing points</small><?php
echo Button::submit()->withValue('Submit')->block();
echo BootForm::close();