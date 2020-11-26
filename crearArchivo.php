<?php 

session_start();

if( !isset( $_GET['carpetaActual'] ) || !isset($_GET['nombreArchivo'])){
    $_SESSION['error'] = "Ingrese un nombre de archivo correcto.";
    header( "Location: index.php");
    return;
}

$path = "./projectFolder/" . $_GET['carpetaActual'] . "/" . $_GET['nombreArchivo'];
$result = touch("$path");

if($result){
    $_SESSION['success'] = "El archivo se ha creado correctamente.";
}else{
    $_SESSION['error'] = "Ocurrió un error creando el archivo.";
}

header( "Location: index.php" );
return;

?>
