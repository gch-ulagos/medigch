<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Controllers\Controller;

class AdminController extends Controller
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
    
    public function crear_personal()
    {
        if(Auth::user()->hasRole('admin')){
            return view('admin_views.crear_personal');
        } 
        elseif(Auth::user()->hasRole('user')){
            return view('dashboard.userdash');
        } 
        elseif(Auth::user()->hasRole('medic')){
            return view('dashboard.medicdash');
        }
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->addRole('medic');

        event(new Registered($user));

        return redirect(route('dashboard', absolute: false));
    }

    public function getOrdenes()
    {
        if (Auth::user()->hasRole('user')) {
            return view('dashboard.userdash');
        } elseif (Auth::user()->hasRole('admin')) {
            $ordenes = DB::table('ordenes')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            return view(('admin_views.modificarordenes'), compact('ordenes'));
        } elseif (Auth::user()->hasRole('medic')) {
            return view('dashboard.medicdash');
        }
    }

    public function ordenInfo($id)
    {
    $orden = DB::table('ordenes')->where('id', $id)->first();
    $detalles = DB::table('detalles')->where('order_id', $id)->get();

    return response()->json([
        'patient_id' => $orden->patient_id,
        'detalles' => $detalles
    ]);
    }

    public function updateOrden(Request $request, $id)
    {
        $request->validate([
            'Rut' => 'required|string|between:8,9',
            'detalle.*' => 'required|string|max:100'
        ]);

        DB::table('ordenes')->where('id', $id)->update([
            'patient_id' => $request->input('Rut')
        ]);

        DB::table('detalles')->where('order_id', $id)->delete();
        foreach ($request->input('detalle') as $detalle) {
            DB::table('detalles')->insert([
                'order_id' => $id,
                'detalle' => $detalle,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Orden actualizada correctamente.');
    }
}