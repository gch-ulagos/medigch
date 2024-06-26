<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                ->where('patient_id', $user_id)
                ->take(5)
                ->get();
            return view(('user_views.historial_documentos'), compact('ordenes'));
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
            return view('dashboard.medicdash');
        }
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $user_id = Auth::id();

        $orders = DB::table('ordenes')
            ->where('patient_id', $user_id)
            ->where(function($queryBuilder) use ($query) {
                $queryBuilder->where('id', 'LIKE', "%{$query}%");
            })
            ->get();

        foreach ($orders as $order) {
            $order->examens = DB::table('examens')->where('order_id', $order->id)->get();
        }

        return response()->json($orders);
    }
}
