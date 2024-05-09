<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\files;

class filesController extends Controller
{
    public function crear_orden()
    {

        return view('subir_archivos');
    }

    public function store(Request $request){


        $file = $request->file('archivo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $archivodir = new files();

        $archivodir->archivo = $file->storeAs('pdfs', $fileName);


        $archivodir->save();


        return view('subir_archivos');
    }
}
