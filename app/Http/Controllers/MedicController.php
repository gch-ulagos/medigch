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
use App\Models\File;

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

    public function ordenStore(Request $request){
        //validacion de los datos del formulario
        $request->validate([
            'Rut' => 'required|numeric|digits_between:8,9|exists:users,id',
            'detalle.*' => 'nullable|string|max:100',
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
        $detalles = $request->input('detalle');
        if ($detalles && is_array($detalles)) {
            foreach ($detalles as $detalle) {
                if (!empty($detalle)) {
                    DB::table('detalles')->insert([
                        'order_id' => $orden_id,
                        'detalle' => $detalle,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect(route('dashboard', absolute: false));
    }

    public function search(Request $request)
    {
        $medic_id = Auth::id();

        $orden = DB::table('ordenes')
            ->where('id', 'LIKE', "%{$request->search}%")
            ->where('medic_id', $medic_id)
            ->first();

        $detalles = DB::table('detalles')->where('order_id', 'LIKE', "%{$request->search}%")->get();

        $documentos = DB::table('examens')->where('order_id', 'LIKE', "%{$request->search}%")->get();
        return view('medic_views.modificarorden_id', compact('orden', 'detalles', 'documentos'));
    }
    
    public function checkOrden($id)
    {
        $medic_id = Auth::id();

        $orderExists = DB::table('ordenes')
            ->where('id', $id)
            ->where('medic_id', $medic_id)
            ->exists();
        
        if (!$orderExists) {
            return response()->json(['message' => 'Orden no encontrada'], 404);
        }
    
        return response()->json(['found' => true]);
    }

    public function getOrdenes()
    {
        $medic_id = Auth::id();

        if (Auth::user()->hasRole('user')) {
            return view('dashboard.userdash');
        } elseif (Auth::user()->hasRole('admin')) {
            return view('dashboard.admindash');
        } elseif (Auth::user()->hasRole('medic')) {
            $ordenes = DB::table('ordenes')
                ->orderBy('created_at', 'desc')
                ->where('medic_id', $medic_id)
                ->take(5)
                ->get();
            return view(('medic_views.modificarordenes'), compact('ordenes'));
        }
    }

    public function updateOrden(Request $request)
    {
        $medic_id = Auth::id();

        $request->validate([
            'Rut' => 'required|numeric|digits_between:8,9',
            'detalle.*' => 'nullable|string|max:100',
            'remove_document_ids' => 'array',
            'remove_document_ids.*' => 'integer|exists:examens,id',
            'archivo' => 'array',
            'archivo.*' => 'file',
            'order_id' => 'required|exists:ordenes,id'
        ]);

        $patientId = $request->input('Rut');
        $orderId = $request->input('order_id');

        DB::table('ordenes')
            ->where('id', $orderId)
            ->where('medic_id', $medic_id)
            ->update(['patient_id' => $patientId]);

        DB::table('detalles')
        ->where('order_id', $orderId)
        ->delete();

        $detalles = $request->input('detalle');
        if ($detalles && is_array($detalles)) {
            foreach ($detalles as $detalle) {
                if (!empty($detalle)) {
                    DB::table('detalles')->insert([
                        'order_id' => $orderId,
                        'detalle' => $detalle,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        if ($request->hasFile('archivo')) {
            foreach ($request->file('archivo') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('pdfs', $fileName);
    
                $examen = new examen([
                    'archivo' => $fileName,
                ]);
    
                $examen->order_id = $request->order_id;
                $examen->save();
            }
        }

        $removeDocumentIds = $request->input('remove_document_ids');
        if ($removeDocumentIds && is_array($removeDocumentIds)) {
            $documents = DB::table('examens')
                ->whereIn('id', $removeDocumentIds)
                ->get();

            foreach ($documents as $document) {
                Storage::delete('pdfs/' . $document->archivo);
                DB::table('examens')->where('id', $document->id)->delete();
            }
        }

        return redirect()->route('dashboard')->with('success', 'Orden actualizada exitosamente.');
    }

}
