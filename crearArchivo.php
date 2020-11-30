<?php 

session_start();

if( !isset($_GET['nombreArchivo'])){
    $_SESSION['error'] = "Ingrese un nombre de archivo correcto.";
    header( "Location: index.php");
    return;
}

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}

$result = touch("./projectFolder" . $path . '/' . $_GET['nombreArchivo']);

if($result){
    $_SESSION['success'] = "El archivo se ha creado correctamente.";
}else{
    $_SESSION['error'] = "Ocurrió un error creando el archivo.";
}

header( "Location: index.php" );
return;

?>
