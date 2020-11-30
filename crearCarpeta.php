<?php 

session_start();

if(isset($_GET['nombreCarpeta'])){

    if( strlen($_GET['nombreCarpeta']) == 0 ){
        $_SESSION['error'] = "Por favor ingrese un nombre para la carpeta";
        header( "Location: index.php" );
        return;
    }

    $path = '';
    if (isset($_SESSION['path'])) {
        foreach ($_SESSION['path'] as $key) {
            $path = $path . '/' . $key;
        }
    }

    if(!file_exists("./projectFolder" . $path . '/' . $_GET['nombreCarpeta'])){
        mkdir("./projectFolder" . $path . '/' . $_GET['nombreCarpeta'], 0777, true);
        $_SESSION['success'] = "La carpeta se ha creado correctamente.";
        header('Location: index.php');
        return;
    }else{
        $_SESSION['error'] = "Ya existe una carpeta con este nombre";
        header('Location: index.php');
        return;
    }

}else {
    $_SESSION['error'] = "Por favor ingrese un nombre para la carpeta";
    header( "Location: index.php" );
    return;
}
