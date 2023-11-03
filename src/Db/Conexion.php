<?php 
namespace App\Db;

use PDO;

class Conexion{

    protected static $conexion;

    public function __construct()
    {
        //* aqui llamaremos al metodo setConexion;
        self::setConexion();

    }



    public function setConexion(){

        //todo comprobamos que si hay conexion nos salimos de aqui, si no la creamos.

        if (self::$conexion != null) return;

        //todo si no 

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__."/../../"); //* Para que cargue el .env 
        $dotenv->load();
        $user = $_ENV['USER'];
        $pass = $_ENV['PASS'];
        $host = $_ENV['HOST'];
        $db = $_ENV['DB'];

        $dns = "mysql:dbname=$db;host=$host;charset=utf8mb4";

        $options = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

        try {
        // Creamos una instancia de la clase PDO para establecer una conexión a la base de datos.
        // Utilizamos los siguientes parámetros:
        // - $dns: Define la información de la base de datos, incluyendo el tipo, nombre de la base de datos, host y codificación de caracteres.
        // - $user: Es el nombre de usuario para la autenticación en la base de datos.
        // - $pass: Es la contraseña para la autenticación en la base de datos.
        // - $options: Un array de opciones, donde configuramos PDO::ATTR_ERRMODE para que lance excepciones en caso de errores.
            self::$conexion = new PDO ($dns , $user , $pass , $options);
        } catch (\Throwable $ex) {
            die("Error en la conexion con la base de datos mensaje = " . $ex -> getMessage());
        }
    }


}

?>
