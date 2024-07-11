@extends('dashboard.medicdash')

@section('display')

<div class="container mt-3">
    <h1>Ingresar orden médica</h1>
    <form method="POST" action="{{ route('medic/panel/adjuntar_doc/store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
    @csrf

    <!-- archivos-->
    <div class="mb-3 mt-3">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="archivo">Archivos</label>
        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
        id="archivo" name="archivo[]" type="file" multiple required>
    </div>
    <div class="mb-3">
        <label for="order_id">Buscar y seleccionar una orden:</label>
        <input list="ordenes" name="order_id" id="order_id" class="form-control" placeholder="Selecciona una orden..." required>
        <datalist id="ordenes">
            @foreach($ordenes as $orden)
                <option value="{{ $orden->id }}">
            @endforeach
        </datalist>
    </div>
    <div class="flex items-center justify-end mt-3 mb-3">
        <button type="submit">Subir archivos</button>
    </div>
    <br>
</form>
</div>

@method('PUT')

<script>
function validateForm() {
    //obtener el valor ingresado en el campo de busqueda de la orden
    var ordenId = document.getElementById('order_id').value;
    //obtener todas las opciones de la lista de ordenes
    var opcionesOrdenes = document.getElementById('ordenes').getElementsByTagName('option');
    //variable para verificar si se encuentra la orden
    var ordenEncontrada = false;
    //iterar sobre las opciones de la lista
    for (var i = 0; i < opcionesOrdenes.length; i++) {
        //verificar si el valor ingresado coincide con alguna orden
        if (opcionesOrdenes[i].value == ordenId) {
            ordenEncontrada = true;
            break;
        }
    }
    //si no se encuentra la orden, mostrar una alerta y detener el envio del formulario
    if (!ordenEncontrada) {
        alert("Orden no encontrada. Por favor, seleccione una orden válida.");
        return false;
    }
    //si se encuentra la orden, continuar con el envio del formulario
    alert("Orden seleccionada. Subiendo los archivos...");
    return true;
}
</script>

@endsection
