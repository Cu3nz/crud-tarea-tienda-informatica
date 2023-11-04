<?php 
namespace App\Utils;


const MAY=0;
const MIN=1;


use App\Db\ArticulosTienda;

class Errores{

    //todo Validaciones: 
    
    //* El nombre no puede estar repetido.
    //* El nombre tiene que tener como minimo 5 caracteres.
    //* El precio tiene que tener un rango entre 1 y 1000€
    
    
    //todo Validaciones para nombre: 
    //* El nombre tiene que tener como minimo 5 caracteres.
    
    public static function definirLongitud($nombre , $valor , $logitud):bool{ //? Si la longitud del valor es menor a la longitud definida nos creamos una sesion con el nombre que le pasemos en este caso nombre y mostrara este mensaje  y devolvemos true
        if (strlen($valor) < $logitud){
            $_SESSION[$nombre] = "**** Error el campo $nombre debe tener al menos $logitud caracteres ";
            return true;
        } else {
            return false;
        }
    }
    
    //todo este metodo tambien lo utilizamos a la hora de  actualizar un articulo. 
    //* El nombre no puede estar repetido.
    
    public static function comprobarNombreArticuloRepetido( string $nombreArticulo, int|null $codigo=null):bool{ //* Se le pasa el nombre del articulo que quiero comprobar si esta almacenado en la base de datos. 

        if (ArticulosTienda::existeNombre($nombreArticulo, $codigo)){ //* Si Articulos::existeNombre($nombreArticulo) devuelve 1, es porque hay un registro en la base de datos con ese nombre de articulo, por lo tanto comprobarNombreArticuloRepetido devuelve FALSE porque un nombre de articulo que ya existe no puede ser almacenado de nuevo 

            return false; //? Devuelvo false porque no se puede almacenar un nombre de articulo que ya esta almacenado en la base de datos

        } else { //! Si Articulos::existeNombre($nombreArticulo) devuelve 0, es porque no hay ninguna fila con ese nombre de articulo, por lo tanto se puede almacenar en la base de datos
            return true; //? Devuelvo true porque si se puede almacenar, no esta el nombre del articulo almacenado en la base de datos aun.
        }

    }
    
    //* El precio tiene que tener un rango entre 1 y 1000€

    public static function validarPrecio($nombre , $precio , $minPrecio , $maxPrecio ){
        if ($precio < $minPrecio || $precio > $maxPrecio){
            $_SESSION[$nombre] = "****Error el precio introducido es inferior o superior al límite, tienes que introducir un valor entre 1-1000€";
            return false;
        }
        return true;
    }


    public static function pintarErrores($nombreSesionError){
        if (isset($_SESSION[$nombreSesionError])){
            echo "<p class = 'test-sm text-red-700 italic mt-2'>{$_SESSION[$nombreSesionError]}</p>";
            unset($_SESSION[$nombreSesionError]);
        }
    }

    public static function sanearCampos(string $campo , int $mode=MAY): string {
        //? si mode = 0 paso a mayusculas, si no solo saneo.

        return ($mode == 0) ? ucfirst(htmlspecialchars(trim($campo))) : htmlspecialchars(trim($campo)); //* si mode vale 0, ponemos la primera letra en mayuscula, si mode no vale 0, solo saneamos.
    }

}


?>