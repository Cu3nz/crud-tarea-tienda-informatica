<?php 

namespace App\Db;

use PDO;

class Articulos extends Conexion{

    private int $codigo; //* llave primaria
    private string $nombre;
    private float $precio;


    public function __construct()
    {
        parent::setConexion(); //* Llamamos al constructor padre de la clase conexion.
    }


    //todo vienen los metodos.

    //? metodo create, el cual se encarga de insertar las filas.

    public  function create(){
        parent::setConexion();

        $q = "insert into producto (nombre , precio) values ( :n , :pre)"; //! Aqui no se pone la llave primaria en este caso codigo.

        $stmt = parent::$conexion -> prepare($q);

        try {
            $stmt -> execute([
                ':n' =>  $this -> nombre,
                ':pre' => $this -> precio 
            ]);
        } catch (\PDOException $ex) {
            die("Error no se han podido insertar los registros , mensaje = " . $ex -> getMessage());
        }
        
        parent::$conexion = null;
    }


    public static function read(){ //* devuelve todos los registros que haya en la base de datos 

        parent::setConexion();

        $q = "select * from producto order by id desc"; //? Mostramos todos los registro de la tabla en orden descendente

        $stmt =  parent::$conexion -> prepare($q);

        try {
            $stmt -> execute();
        } catch (\PDOException $ex) {
            die("Error no se ha podido recuperar los registros que hay almacenados en la base de datos error en el metodo read , mensaje = " .$ex -> getMessage());
        }

        parent::$conexion = null;

        return $stmt -> fetchAll(PDO::FETCH_OBJ); //* Te devuelve todas las filas.



    }


}



?>