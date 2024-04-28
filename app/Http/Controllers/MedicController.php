<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\ordenes;

class MedicController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('user')){
            return view('dashboard.userdash');

        }elseif(Auth::user()->hasRole('admin')){
            return view('dashboard.admindash');

        }elseif(Auth::user()->hasRole('medic')){
            return view('dashboard.medicdash');
        }
    }

    public function crear_orden()
    {
        if(Auth::user()->hasRole('user')){
            return view('dashboard.userdash');

        }elseif(Auth::user()->hasRole('admin')){
            return view('dashboard.admindash');

        }elseif(Auth::user()->hasRole('medic')){
            return view('medic_views.crear_ordenes');
        }
    }

    public function store(){
        $ordennueva = new ordenes();

        $ordennueva->Nombre = request('Nombre');
        $ordennueva->Rut = request('Rut');
        $ordennueva->Genero = request('Genero');
        $ordennueva->Indicaciones_Medicas = request('Indicaciones');

        $ordennueva->save();


        return view('medic_views.crear_ordenes');

    }
}
