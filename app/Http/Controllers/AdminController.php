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
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\examen;
use App\Rules\ValidRut;


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

    public function checkOrden($id)
    {
    $orderExists = DB::table('ordenes')->where('id', $id)->exists();

    return response()->json(['found' => $orderExists]);
    }


    public function search(Request $request)
    {
        $orden = DB::table('ordenes')
            ->where('id', 'LIKE', "%{$request->search}%")
            ->first();

        $detalles = DB::table('detalles')->where('order_id', 'LIKE', "%{$request->search}%")->get();

        $documentos = DB::table('examens')->where('order_id', 'LIKE', "%{$request->search}%")->get();
        return view('admin_views.modificarorden_id', compact('orden', 'detalles', 'documentos'));
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
            'Rut' => ['required', new ValidRut, 'string','between:8,9'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'id' => $request->Rut,
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

    public function ordenInfo(Request $request)
    {
        $this->getOrdenes();
        $this->search($request);
    }

    public function updateOrden(Request $request)
    {
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
            ->update(['patient_id' => $patientId]);

        DB::table('detalles')->where('order_id', $orderId)->delete();

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