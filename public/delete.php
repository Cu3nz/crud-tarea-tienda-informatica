<?php 

//todo Comprobacion que si no se manda nada por post nos salimos de aqui. 

require_once __DIR__."/../vendor/autoload.php";
use App\Db\ArticulosTienda;

if (!isset($_POST['idArticulo'])){
    header("Location:inicio.php");
    die();
}

session_start();


$id = $_POST['idArticulo']; //* Guardamos en la variable id, el id del articulo el cual queremos borrar y hemos pulsado en la papelera
ArticulosTienda::delete($id); //* Borra el articulo 
$_SESSION['mensaje'] = "El articulo se ha eliminado exitosamente";
header("Location:inicio.php");
die();

?>