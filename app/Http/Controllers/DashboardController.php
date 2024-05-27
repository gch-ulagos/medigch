<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
    
        if (Auth::user()->hasRole('user')) {
            $patient_id = Auth::id();
            $ordenes = DB::table('ordenes')
                ->where('patient_id', $patient_id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            return view(('dashboard.userordenes'), compact('ordenes'));
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
            $medico_id = Auth::id();
            $ordenes = DB::table('ordenes')
                ->where('medic_id', $medico_id)
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            return view('medic_views.medicordenes', compact('ordenes'));
        }
    }
}