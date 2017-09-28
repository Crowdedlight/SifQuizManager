<?php

namespace App\Http\Controllers;

use App\Models\Round;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return $this->view('auth.login');
        }

        $rounds = Round::where('active', true)->get();
        View()->share('rounds', $rounds);

        return $this->view('home.index');
    }
}
