<?php
require('config.php');
$tipo       = $_FILES['dataCliente']['type'];
$tamanio    = $_FILES['dataCliente']['size'];
$archivotmp = $_FILES['dataCliente']['tmp_name'];
$lineas     = file($archivotmp);

$i = 0;

foreach ($lineas as $linea) {
    $cantidad_registros = count($lineas);
    $cantidad_regist_agregados =  ($cantidad_registros - 1);

    if ($i != 0) {

        $datos = explode(";", $linea);
       
        $id               = !empty($datos[0])  ? ($datos[0]) : ''; 
        $tipo                = !empty($datos[0])  ? ($datos[0]) : '';
		$codigo                = !empty($datos[1])  ? ($datos[1]) : '';
        $nombre               = !empty($datos[2])  ? ($datos[2]) : '';
        $descripcion                = !empty($datos[0])  ? ($datos[0]) : '';
        $categoria                = !empty($datos[1])  ? ($datos[1]) : '';
        $precio               = !empty($datos[2])  ? ($datos[2]) : '';
       
    $insertar = "INSERT INTO insumos(
            id,
            tipo,
            codigo, 
            nombre,
			descripcion,
            categoria,
            precio,
        ) VALUES(
            '$id',
            '$tipo',
            '$codigo',
            '$nombre',
			'$descripcion',
            '$categoria',
            '$precio',
           
        )";
        mysqli_query($con, $insertar);
    }

      echo '<div>'. $i. "). " .$linea.'</div>';
    $i++;
}


  echo '<p style="text-aling:center; color:#333;">Total de Registros: '. $cantidad_regist_agregados .'</p>';

?>
