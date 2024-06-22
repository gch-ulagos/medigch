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

    public function verificarRut(Request $request)
    {
        $rut = $request->input('Rut');

        $exists = DB::table('users')->where('id', $rut)->exists();

        return response()->json(['exists' => $exists]);
    }   

    public function showAllDocuments()
    {
        $user_id = Auth::id();

        if (Auth::user()->hasRole('user')) {
            $ordenes = DB::table('ordenes')
                ->orderBy('created_at', 'desc')
                ->where('user', $user_id)
                ->take(5)
                ->get();
            return view(('user_views.historial_documentos'), compact('ordenes'));
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
            return view('dashboard.medicdash');
        }
    }
}
