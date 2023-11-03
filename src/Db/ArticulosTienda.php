<?php

namespace App\Db;

use PDO;

class ArticulosTienda extends Conexion
{

    private int $codigo; //* llave primaria
    private string $nombre;
    private float $precio;


    public function __construct()
    {
        parent::setConexion(); //* Llamamos al constructor padre de la clase conexion.
    }


    //todo vienen los metodos.

    //? metodo create, el cual se encarga de insertar las filas.

    public  function create()
    {
        parent::setConexion();

        $q = "insert into producto (nombre , precio) values ( :n , :pre)"; //! Aqui no se pone la llave primaria en este caso codigo.

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([
                ':n' =>  $this->nombre,
                ':pre' => $this->precio
            ]);
        } catch (\PDOException $ex) {
            die("Error no se han podido insertar los registros , mensaje = " . $ex->getMessage());
        }

        parent::$conexion = null;
    }


    public static function read()
    { //* devuelve todos los registros que haya en la base de datos 

        parent::setConexion();

        $q = "select * from producto order by codigo desc"; //? Mostramos todos los registro de la tabla en orden descendente

        $stmt =  parent::$conexion->prepare($q);

        try {
            $stmt->execute();
        } catch (\PDOException $ex) {
            die("Error no se ha podido recuperar los registros que hay almacenados en la base de datos error en el metodo read , mensaje = " . $ex->getMessage());
        }

        parent::$conexion = null;

        return $stmt->fetchAll(PDO::FETCH_OBJ); //* Te devuelve todas las filas.
    }

    public static function delete($codigoArticulo)
    {
        parent::setConexion();

        $q = "delete from producto where codigo=:c";

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute([':c' => $codigoArticulo]);
        } catch (\PDOException $ex) {
            die("Error no se ha podido borrar el producto, mensaje = " . $ex->getMessage());
        }

        parent::$conexion = null;
    }

    //! Tenemos una restriccion, no puede haber un producto con mismo nombre, por lo tanto creamos el siguiente metodo.

    //todo Metodo que comprueba si existe ese nombre en la base de datos, si devuelve (1)  es porque existe una fila en la base de datos con ese nombre, si  devuelve (0)  es porque no existe ninguna fila con ese nombre de articulo
    public static function existeNombre(string $nombre, int|null $codigo = null)
    {

        parent::setConexion();

        //todo Esto basicamente lo hacemos para la hora de actualizar, para que cuando actualicemos al tener el mismo nombre no nos diga que ese nombre esta repetido

        //* Si el codigo es nulo, ejecutamos la  primera consulta que comprueba si existe ya el nombre en la base de datos (Primera consulta que se utiliza para crear el articulo)

        //? Si no es nulo ejecutamos la segunda consulta, la cual busca un codigo de articulo en la base de datos segun un nombre pasado y un codigo el cual tiene que ser distinto al que se le pasa por parametro. Esta consulta la utilizamos para la hora de actualizar el articulo, porque al actualizar se manda el codigo del articulo mediante get, a la hora de actualizar si no ejecutamos la segunda consulta (y ejecutamos la primera) va a mostrar un error de que el nombre esta repetido porque esta buscando por el nombre el cual ya existe en la base de datos.

        //? Por lo tanto con la segunda consulta estamos buscando por toda la base de datos si existe el nuevo nombre que le vamos a poner articulo y si tiene distinto codigo de articulo que el codigo de articulo que quiero actualizar, si lo encuentra y tiene distinto codigo de articulo que el codigo de articulo que estoy actualizando dara un error, porque devovlera 1 (porque ya existe el nombre). 

        $q = ($codigo == null) ? "select codigo from producto where nombre=:n" : "select codigo from producto where nombre=:n AND codigo != :c";

        $options = ($codigo == null) ? [':n' => $nombre] : [':n' => $nombre, ':c' => $codigo];

        $stmt = parent::$conexion->prepare($q);

        try {
            $stmt->execute($options);
        } catch (\PDOException $ex) {
            die("error, no se ha podido comprobar si existe el nombre repetido, error en el metodo comprobarExisteNombre , mensaje = " . $ex->getMessage());
        }

       return $stmt->rowCount(); //* Devuelve 1 si existe el nombre, devuelve 0 si no existe el nombre
    } 

  


    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Set the value of codigo
     */
    public function setCodigo(int $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }
}
