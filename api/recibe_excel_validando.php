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
        
if( !empty($id) ){
    $checkemail_duplicidad = ("SELECT codigo FROM insumos WHERE codigo='".($codigo)."' ");
            $ca_dupli = mysqli_query($con, $checkemail_duplicidad);
            $cant_duplicidad = mysqli_num_rows($ca_dupli);
        }   

//No existe Registros Duplicados
if ( $cant_duplicidad == 0 ) { 

$insertarData = "INSERT INTO insumos( 
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
mysqli_query($con, $insertarData);
        
} 
/**Caso Contrario actualizo el o los Registros ya existentes*/
else{
    $updateData =  ("UPDATE insumos SET 
        id='" .$id. "',
        tipo='" .$tipo. "',
        codigo='" .$codigo. "',
        nombre='" .$nombre. "',
		descripcion='" .$descripcion. "',
        categoria='" .$categoria. "'
        precio='" .$precio. "', 
        
        WHERE codigo='".$codigo."'
    ");
    $result_update = mysqli_query($con, $updateData);
    } 
  }

 $i++;
}

?>
