<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        if(!Auth::check()){
            return $this->view('home.login');
        }

        return $this->view('home.index');
    }
}
