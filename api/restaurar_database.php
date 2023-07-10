<?php
include_once "funciones.php";
include_once "encabezado.php";

// Obtener el contenido del archivo JSON de respaldo
$jsonRespaldo = file_get_contents($_FILES['file']['tmp_name']);

// Decodificar el JSON en un array de objetos
$respaldo = json_decode($jsonRespaldo, true);

// Recorrer el array de objetos y aplicar las inserciones y actualizaciones
foreach ($respaldo as $tabla => $registros) {
    foreach ($registros as $registro) {
        // Verificar si el registro con ese ID ya existe en la base de datos
        $existe = verificarExistencia($tabla, $registro['id']);

        if ($existe) {
            // Realizar consulta UPDATE para actualizar el registro
            actualizarRegistro($tabla, $registro);
        } else {
            // Realizar consulta INSERT para insertar un nuevo registro
            insertarRegistro($tabla, $registro);
        }
    }
}

// Mostrar un mensaje de éxito
echo "El respaldo se ha aplicado correctamente.";

// Función para verificar si un registro con el ID dado ya existe en la tabla
function verificarExistencia($tabla, $id)
{
    $bd = conectarBaseDatos();
    $sentencia = $bd->prepare("SELECT COUNT(*) FROM $tabla WHERE id = ?");
    $sentencia->execute([$id]);
    $count = $sentencia->fetchColumn();

    return $count > 0;
}

// Función para realizar la consulta UPDATE y actualizar un registro en la tabla
function actualizarRegistro($tabla, $registro)
{
    $bd = conectarBaseDatos();

    // Obtener los campos y los valores del registro
    $campos = array_keys($registro);
    $valores = array_values($registro);

    // Construir la parte de la consulta para actualizar los campos
    $actualizaciones = [];
    foreach ($campos as $campo) {
        $actualizaciones[] = "$campo = ?";
    }
    $actualizacionesStr = implode(", ", $actualizaciones);

    // Construir la consulta SQL para actualizar el registro
    $sql = "UPDATE $tabla SET $actualizacionesStr WHERE id = ?";
    $sentencia = $bd->prepare($sql);

    // Agregar el valor del ID al final de los valores
    $id = $registro['id'];

    // Ejecutar la consulta con los valores actualizados
    $sentencia->execute([...$valores, $id]);

    // Verificar si se realizó la actualización correctamente
    return $sentencia->rowCount() > 0;
}

// Función para realizar la consulta INSERT e insertar un nuevo registro en la tabla
function insertarRegistro($tabla, $registro)
{
    $bd = conectarBaseDatos();

    // Obtener el valor del ID del registro
    $id = $registro['id'];

    // Verificar si el registro con ese ID ya existe en la base de datos
    $existe = verificarExistencia($tabla, $id);

    if (!$existe) {
        // Obtener los campos y los valores del registro
        $campos = array_keys($registro);
        $valores = array_values($registro);

        // Construir la parte de la consulta para los campos y los valores
        $camposStr = implode(", ", $campos);
        $valoresStr = rtrim(str_repeat("?, ", count($valores)), ", ");

        // Construir la consulta SQL para insertar el registro
        $sql = "INSERT INTO $tabla ($camposStr) VALUES ($valoresStr)";
        $sentencia = $bd->prepare($sql);

        // Ejecutar la consulta con los valores del registro
        $sentencia->execute($valores);

        // Verificar si se realizó la inserción correctamente
        return $sentencia->rowCount() > 0;
    }

    // El registro ya existe, no se realiza la inserción
    return false;
}
?>
