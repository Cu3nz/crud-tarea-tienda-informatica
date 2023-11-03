<?php

use App\Db\ArticulosTienda;

require_once __DIR__ . "/../vendor/autoload.php";
session_start();
$mostrarArticulo = ArticulosTienda::read(); //* En la variable, esta almacenados todos los registros que hay en la base de datos.

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas de Articulos</title>
    <script src="https://cdn.tailwindcss.com"></script> <!--CDN tailwind-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" /><!--CDN font awoesome-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!--CDN sweetalert2-->

</head>

<body>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4 mx-auto" style="max-width: 90%;">
        <h3 class="text-center text-xl">Lista de articulos</h3>
        <div class="flex flex-row-reverse mb-3">
            <a href="crearArticulo.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> <i class="fas fa-add mr-2"></i>Crear un nuevo articulo</a>
        </div>
        <table class="w-full text-sm  text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center text-center">
                            Precio
                            <a href="#"><svg class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                </svg></a>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex items-center">
                            Edit

                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <!--//todo Aqui haremos el foreach para recorrer todos los registros de la base de datos, que estan almacenados en la variables mostrarArticulos-->
                <?php
                foreach ($mostrarArticulo as $articulo) {
                    echo <<<TXT
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {$articulo->nombre}
                    </th>
                    <td class="px-6 py-4 text-left">
                    {$articulo->precio}€
                    </td>
                    <td class="px-6 py-4 text-left">
                    <form action = "borrarBotonPapelera.php" method='POST' onsubmit="return confirmarBorrado('{$articulo -> nombre}');"> <!--//todo onsumbit lo que hace es ejecutar la funcion confirmarBorrado de js antes de enviar el formulario , es imporatente poner el return ya que determina si se envia o no el formulario, si la funcion devuelve true (ha pulsado el boton de aceptar) se envia, si devuelve false (ha pulsado el boton de cancelar) no se envia -->
                    <input name='idArticulo' hidden value='{$articulo->codigo}' />
                    <a target="_blank" href="actualizarArticulo.php?idArticulo={$articulo -> codigo}"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button name='btnBorrar' type='submit'>
                    <i class = 'fas fa-trash text-red-600'></i>
                    </button>
                    </form>
                </td>
                TXT;
                }
                ?> <!--Lo cierro aqui para que se pueda crear todos los demaas tr.-->
            </tbody>
        </table>
    </div>

    <?php
    //todo cuando creo un articulo
    if (isset($_SESSION['mensaje'])) { //? Si existe la sesion mensaje mostramos el mensaje
        echo <<<TXT

        <script>

    Swal.fire({
    icon: 'success',
    title: '{$_SESSION['mensaje']}',
    showConfirmButton: false,
    timer: 1500
    })

</script>

TXT;

        unset($_SESSION['mensaje']); //? Destruimos el mensaje
    }

    ?>
    <!--//todo Funcion para mostrar un alert que diga si queremos borrar el articulo con su nombre. Si pulsamos aceptar borrara el articulo, si le da a cancelar no hara nada -->
    <script>
        function borrarArticulo(nombreArticulo) {
            return confirm("¿Estas seguro de que quieres eliminar el articulo " + nombreArticulo + "?");
        }
    </script>



</body>

</html>