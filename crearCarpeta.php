<?php 

session_start();

if(isset($_GET['nombreCarpeta'])){
    //shell_exec("mkdir D:/xampp/htdocs/FileManagerSO/projectFolder/" . $_GET['nombreCarpeta']);
    if(! file_exists($_GET['nombreCarpeta'])){
        mkdir("D:/xampp/htdocs/FileManagerSO/projectFolder/" . $_GET['nombreCarpeta'], 0777, true);
        $_SESSION['success'] = "La carpeta se ha creado correctamente.";
        header('Location: index.php');
        return;
    }else{
        $_SESSION['error'] = "Ya existe una carpeta con este nombre";
        header('Location: index.php');
        return;
    }
}
?>
