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
            $ordenes = DB::table('ordenes')->paginate(5);
            return view(('medic_views.subir_archivo'), compact('ordenes'));
        }
    }

    public function documentStore(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'archivo' => 'required|array',
            'archivo.*' => 'file', // No hay restricciones de tamaño
            'order_id' => 'required|exists:ordenes,id',
        ]);
    
        // Obtener el ID de la orden seleccionada
        $order_id = $request->input('order_id');
    
        // Procesar cada archivo recibido
        foreach ($request->file('archivo') as $file) {
            // Generar un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();
    
            // Guardar el archivo en el almacenamiento
            $file->storeAs('pdfs', $fileName);
    
            // Crear un nuevo registro de examen
            $examen = new examen([
                'archivo' => $fileName,
            ]);
    
            // Asociar el examen a la orden
            $examen->order_id = $request->order_id;
    
            // Guardar el examen en la base de datos
            $examen->save();
        }
    
        // Redirigir de vuelta al dashboard
        return redirect()->route('dashboard');
    }

    public function downloadFile(Request $request, $nombreArchivo)
    {
        // Ruta del archivo dentro de la carpeta 'storage/app/archivos'
        $filePath = 'app/pdfs/' . $nombreArchivo;
            // Obtén el nombre del archivo
            
        // Devuelve el archivo como una respuesta de descarga
        return response()->download(storage_path($filePath), $nombreArchivo)->deleteFileAfterSend(false);
    }
}
