<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\examen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class filesController extends Controller
{
    public function adjuntar_doc()
    {
        if (Auth::user()->hasRole('user')) {
            return view('dashboard.userdash');
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
            $medic_id = Auth::id();

            $ordenes = DB::table('ordenes')
            ->where('medic_id', $medic_id)
            ->paginate(5);
            return view(('medic_views.subir_archivo'), compact('ordenes'));
        }
    }

    public function documentStore(Request $request)
    {
        $request->validate([
            'archivo' => 'required|array',
            'archivo.*' => 'file',
            'order_id' => 'required|exists:ordenes,id',
        ]);
    
        $order_id = $request->input('order_id');

        foreach ($request->file('archivo') as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            $file->storeAs('pdfs', $fileName);
    
            $examen = new examen([
                'archivo' => $fileName,
            ]);
    
            $examen->order_id = $request->order_id;
    
            $examen->save();
        }
    
        return redirect()->route('dashboard');
    }

    public function downloadFile(Request $request, $nombreArchivo)
    {
        $filePath = 'app/pdfs/' . $nombreArchivo;
            
        return response()->download(storage_path($filePath), $nombreArchivo)->deleteFileAfterSend(false);
    }
}
