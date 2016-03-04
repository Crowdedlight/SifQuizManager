<?php
echo BootForm::open(['route' => ['round.add_team', $round->id]]);
echo BootForm::hidden('_action', 'add_team');
echo BootForm::text('TeamName', 'Team Name');
echo BootForm::number('numPersons', 'Number of Persons in Team');
?> <small class="text-muted">Enter Team Name and number of persons in the team</small> <?php
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();