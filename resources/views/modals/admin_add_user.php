<?php
echo BootForm::open(['route' => ['admin.add_user']]);
echo BootForm::hidden('_action', 'add_user');
echo BootForm::text('UserName', 'User Name');
echo BootForm::text('name', 'Name');
echo BootForm::email('Email');
echo BootForm::password();
echo Button::submit()->withValue('Save')->block();
echo BootForm::close();