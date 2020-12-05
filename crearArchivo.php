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
$query = "touch ./projectFolder" . $path . '/' . $_GET['nombreArchivo'];

if(is_file("./projectFolder" . $path . '/' . $_GET['nombreArchivo'])){
    $_SESSION['error'] = "Ya existe un archivo con este nombre y extensión.";
    header( "Location: index.php" );
    return;
}

exec($query);

$_SESSION['success'] ="El archivo se ha creado correctamente.";

header( "Location: index.php" );
return;

?>
