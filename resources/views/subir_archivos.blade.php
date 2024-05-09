

        <div class="container mt-3">
            <h1>Ingresar Orden Medica</h1>
            <form method="POST" action="{{ route('/subirarchivo/store') }}" enctype="multipart/form-data">
            @csrf

            <!-- archivo-->
            <div class="mb-3 mt-3">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">archivo</label>
                <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                id="archivo" name="archivo" type="file">

            </div>

            <div class="flex items-center justify-end mt-3 mb-3">

                <button type="submit">Upload PDF</button>
            </div>
            <br>
        </form>
    </div>

    @method('PUT')

<script>
    function alertaUsuario(){
        alert("Orden! Volviendo al dashboard.");
    }

</script>

