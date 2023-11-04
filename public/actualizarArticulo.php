<?php 

session_start();
//todo comprobamos que si no se pasa un id de articulo por get, se vaya a la pantalla de inicio
if (!isset($_GET['codigoArticulo'])){
    header("Location:inicio.php");
    die();
}

use App\Db\ArticulosTienda;
use App\Utils\Errores;
require_once __DIR__."/../vendor/autoload.php";

use const App\Utils\MAY;


//todo recogemos el idArticulo que se pasa por get mediante la url.
$codigo = htmlspecialchars(trim($_GET['codigoArticulo']));
//echo "$codigo"; 
$miArticulo = ArticulosTienda::findArticulo($codigo);//* Metodo que busca el articulo pasado el codigo de articulo por parametro y se almacena en la variable $miArticulo 
print_r($miArticulo); 

//todo Una vez que hecho hecho lo anterior nos toca validar y recoger los datos que se introduce por los inputs, porque en el caso de cambiar el nombre a ese nuevo nombre le tenemos que pasar la validacion para el nomnbre.



if (isset($_POST['btn'])){
    $nombreArticulo = Errores::sanearCampos($_POST['nombreArticulo'] , MAY);
     $precioArticulo = (float) htmlspecialchars(($_POST['precioArticulo']));  
    $precioFormateado = number_format($precioArticulo, 2, ',', '.');



    $errores = false;

    //todo comprobamos la logitud del input nombre de articulo 

    if (Errores::definirLongitud("Nombre" , $nombreArticulo , 5)){ //* El nombre que le vamos a pasar a pintar va a ser nombre, contiene el valor que introduce el usuario 

        //* "Nombre" va a ser el nombre de la sesion que le vamos a pasar a pintarErrores
        //*  valor --> Va a ser lo que contenga la variable $nombreArticulo, la cual almacena el texto que meta el usuario por el input de nombre
        //* longitud --> Va a ser de 5, por lo tanto si la cadena de $nombreArticulo < 5 mostrara un error.

        $errores = true;
    }

    //todo Comprobamos el nombre repetido 

    if (!Errores::comprobarNombreArticuloRepetido($nombreArticulo, $codigo)){ //*Esta estructura condicional comprueba si el nombre del articulo está en la base de datos. Si el método comprobarNombreArticuloRepetido devuelve false es porque ya hay un nombre de articulo igual almcaneado en la base de datos, el cuerpo del if se ejecutará .
        $errores = true;
        $_SESSION['errorNombreArticuloRepetido'] = "Error: el nombre del articulo esta repetido";
    }


    //todo Validamos el precio 

    if (!Errores::validarPrecio("Precio" , $precioArticulo, 1 ,1000)){ //? si validarPrecio no se cumple (es decir, si devuelve false), enviamos el mensaje de error
        //* "Nombre" va a ser el nombre de la sesion que le vamos a pasar a pintarErrores
        //* precio --> va a ser lo que almacene la variale $precioArticulo, la cual almacena la cantidad que se introduce por el input de precio
        //* minPrecio --> Va a ser de 1 euros
        //* maxPrecio --> Va a ser de 1000 euros
         $errores= true;
    }

    if ($errores){ //* si hay errores
        header("Location:{$_SERVER['PHP_SELF']}?codigoArticulo=$codigo"); //! Cuidado con esto, si hay un error tiene que vovlver a cargar la pagina, pero con el articulo que estoy actualizando y eso se consigue gracias al codigo del artiulo que se pasa con get 
        die();
    }

    //todo si llegamos hasta aqui es porque hemos pasado todas las validaciones 

    (new ArticulosTienda) -> setNombre($nombreArticulo)
    -> setPrecio($precioArticulo)
    -> update($codigo); //? Llamamos al metodo el cual actualiza el articulo segun el id que se le haya pasado al metodo.
    $_SESSION['mensaje'] = "Artículo actualizado con éxito.";
    header("Location:inicio.php");


    } else {


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
          integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Crear</title>
</head>

<body style="background-color:blanchedalmond">
<h3 class="text-2xl text-center mt-4">Actualizar Artículo</h3>
<div class="container p-8 mx-auto">
    <div class="w-1/2 mx-auto p-6 rounded-xl bg-gray-400">
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']."?codigoArticulo={$codigo}"?>"> 
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del articulo</label>
                <input type="text" value="<?php echo "{$miArticulo -> nombre}" ?>"  name="nombreArticulo" required id="nombre" placeholder="Nombre del articulo..."
                       class=" mb-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                
                       <?php 
                        Errores::pintarErrores("Nombre"); //? Error de la longitud del campo 
                        Errores::pintarErrores("errorNombreArticuloRepetido") //? Cuando el nombre que queremos introducir ya esta almacenado en la base de datos.
                       ?>
               
            <div class="mb-6">
                <label for="precioArticulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Precio del producto</label>
                    <!--//! gracias a step puedo meter numero decimales y con min para que pueda introducir como minimo 0-->
                <input  id="precioArticulo" value="<?php echo "{$miArticulo -> precio}" ?>" type="number" id="stockArticulo" step="0.01" name="precioArticulo"
                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                       placeholder="Introduce el precio del producto, pero tiene que estar entre el rango de 1-1000€"  required>
                         <!--//todo Pintamos los errores-->
                 <?php 
               Errores::pintarErrores("Precio");
                ?>
                                   </div>
            
            <div class="flex flex-row-reverse">
            <button type="submit" name="btn"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <i class="fas fa-save mr-2"></i>Actualizar Articulo
            </button>
            <button type="reset"
                    class="mr-2 text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-blue-800">
                <i class="fas fa-paintbrush mr-2"></i>LIMPIAR
            </button>
            <a href="inicio.php"
                    class="mr-2 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-blue-800">
                <i class="fas fa-backward mr-2"></i>VOLVER
            </a>
            </div>

        </form>
    </div>
</div>
</body>
</html>
<?php 
}
?>
