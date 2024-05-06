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
use Illuminate\Support\Facades\DB;

class MedicController extends Controller
{
    public function index()
    {
        $ordenes = [];
    
        if (Auth::user()->hasRole('user')) {
            return view('dashboard.userdash');
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
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

    public function store(Request $request){
        //validacion de los datos del formulario
        $request->validate([
            'Rut' => 'required|string|between:8,9',
            'detalle.*' => 'required|string|max:100',
        ]);

        //obtener el id del usuario medico autenticado
        $medic_id = Auth::id();

        //insertar la orden medica
        $orden_id = DB::table('ordenes')->insertGetId([
            'patient_id' => $request->input('Rut'),
            'medic_id' => $medic_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //insertar los detalles
        foreach ($request->input('detalle') as $detalle) {
            DB::table('detalles')->insert([
                'order_id' => $orden_id,
                'detalle' => $detalle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect(route('dashboard', absolute: false));
    }
}
