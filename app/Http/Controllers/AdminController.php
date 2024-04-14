<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\User;
use App\Http\Controllers\Controller;




class AdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('user')){
            return view('dashboard.userdash');
        } elseif(Auth::user()->hasRole('admin')){
            return view('dashboard.admindash');
        } elseif(Auth::user()->hasRole('medic')){
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
        ])->addRole($request->Roles);

        event(new Registered($user));

        return redirect(route('dashboard', absolute: false));
    }
}
