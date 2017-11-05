@extends('layout.master')

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="jumbotron">
            <h1>Login</h1>

            <?php
            echo BootForm::open(['route' => 'auth.login']);
            echo BootForm::text('username', 'Username', null,
                ['placeholder' => 'Enter your Username', 'rows' => 1]);
            echo BootForm::password('password', null,
                ['placeholder' => 'Enter your Password', 'rows' => 1]);
            echo BootForm::checkbox('remember', null, 1, true);
            echo BootForm::submit('Login', ['class' => 'btn-block btn-primary btn']);
            echo BootForm::close();
            ?>

            @if (count($errors->all()) > 0)
                <div class="alert alert-danger" role="alert" style="margin-top:50px">{{ $errors->first() }}</div>
            @endif
        </div>
    </div>
</div>

@endsection