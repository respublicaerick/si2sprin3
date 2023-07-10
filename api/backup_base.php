<?php
include_once "funciones.php";
include_once "encabezado.php";

// Obtener los datos de las tablas en formato JSON
$insumos = obtenerInsumosR();
$categorias = obtenerCategoriaR();
$usuarios = obtenerUsuariosR();
$ventas = obtenerVentasR();

// Crear un array para almacenar los datos de todas las tablas
$respaldo = array(
    "insumos" => $insumos,
    "categorias" => $categorias,
    "usuarios" => $usuarios,
    "ventas" => $ventas
);

// Convertir el array en formato JSON
$jsonRespaldo = json_encode($respaldo);

// Guardar el JSON en un archivo
$fechaHora = date("Ymd-His");
$archivoRespaldo = "respaldo_" . $fechaHora . ".json";
file_put_contents($archivoRespaldo, $jsonRespaldo);

// Mostrar un mensaje de éxito
echo "El respaldo de las tablas se ha creado correctamente.";

?>