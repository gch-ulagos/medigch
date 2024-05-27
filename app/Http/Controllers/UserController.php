<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $ordenes = [];
        
        if(Auth::user()->hasRole('user')){
            return view('dashboard.userdash');

        }elseif(Auth::user()->hasRole('admin')){
            return view('dashboard.admindash');
            
        }elseif(Auth::user()->hasRole('medic')){
            return view('dashboard.medicdash');
        }
    }
}
