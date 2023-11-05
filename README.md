# crud-tarea-tienda-informatica
tarea crud tienda informatica 
# Documentación del Proyecto

## Clases

### `App\Db\ArticulosTienda`

`ArticulosTienda` es una clase que gestiona las operaciones de la base de datos relacionadas con los artículos de una tienda. Extiende de la clase `Conexion` para interactuar con la base de datos.

#### Métodos

- `create()`: Inserta un nuevo artículo en la base de datos.
- `read()`: Recupera todos los artículos de la base de datos.
- `update($codigoArticulo)`: Actualiza la información de un artículo existente.
- `delete($codigoArticulo)`: Elimina un artículo de la base de datos.
- `existeNombre($nombre, $codigo)`: Verifica si ya existe un artículo con el mismo nombre en la base de datos.
- `findArticulo($codigoArticulo)`: Busca un artículo específico por su código.

#### Propiedades

- `$codigo`: Clave primaria del artículo.
- `$nombre`: Nombre del artículo.
- `$precio`: Precio del artículo.

### `App\Db\Conexion`

`Conexion` es una clase que maneja la conexión a la base de datos utilizando el patrón singleton para asegurar una única instancia activa.

#### Métodos

- `__construct()`: Constructor que inicializa la conexión a la base de datos.
- `setConexion()`: Establece la conexión a la base de datos si aún no existe.

#### Propiedades

- `$conexion`: Instancia de la conexión a la base de datos (PDO).

### `App\Utils\Errores`

`Errores` es una clase de utilidades que proporciona métodos estáticos para la validación de entradas y el manejo de errores.

#### Métodos

- `definirLongitud($nombre, $valor, $longitud)`: Valida la longitud de una cadena de texto.
- `comprobarNombreArticuloRepetido($nombreArticulo, $codigo)`: Comprueba si un nombre de artículo ya está registrado en la base de datos.
- `validarPrecio($nombre, $precio, $minPrecio, $maxPrecio)`: Valida que el precio de un artículo esté dentro de un rango específico.
- `pintarErrores($nombreSesionError)`: Muestra errores de validación al usuario y limpia la sesión.
- `sanearCampos($campo, $mode)`: Limpia y sanitiza los campos de entrada, opcionalmente convirtiendo a mayúsculas.

#### Constantes

- `MAY`: Modo para convertir el primer carácter de un campo a mayúscula.
- `MIN`: Modo para sanitizar campos sin cambiar la capitalización.

## Uso

Esta documentación está destinada a desarrolladores que trabajan en el proyecto. Cada clase y método tiene su propósito específico dentro del flujo de trabajo de la aplicación, y deben ser utilizados de acuerdo a las necesidades de las operaciones de la tienda.

Para más detalles sobre la implementación y ejemplos de uso, se recomienda revisar el código fuente y los comentarios incluidos en cada archivo de clase.

