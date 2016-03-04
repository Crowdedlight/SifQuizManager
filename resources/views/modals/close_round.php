<?php
echo BootForm::open(['route' => ['round.close', $round->id]]);
echo BootForm::hidden('_action', 'close');
echo BootForm::textarea('comment');
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();