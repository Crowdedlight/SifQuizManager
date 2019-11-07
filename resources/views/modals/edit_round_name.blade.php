<?php
echo BootForm::open(['route' => ['round.editname', 'id' => $id]]);
echo BootForm::text('round_name', 'Name', $name,
['rows' => 1]);
echo BootForm::submit('Save', ['class' => 'btn-block btn-primary btn']);
echo BootForm::close();
