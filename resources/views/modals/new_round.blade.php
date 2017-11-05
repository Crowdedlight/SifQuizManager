<?php
echo BootForm::open(['route' => 'round.create']);
echo BootForm::text('round_name', 'Name', null,
['placeholder' => 'eksemple: 2016 forår - Runde 1', 'rows' => 1]);
echo BootForm::submit('Save', ['class' => 'btn-block btn-primary btn']);
echo BootForm::close();
