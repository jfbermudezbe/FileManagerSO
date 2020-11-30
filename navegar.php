<?php

session_start();

if (!isset($_GET['nameFolder'])) {
    $_SESSION['error'] = "Ha ocurrido un error al navegar.";
    header("Location: index.php");
    return;
}

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$result = chdir('./projectFolder' . $path . '/' . $_GET['nameFolder']);

if ($result) {
    array_push($_SESSION['path'], $_GET['nameFolder']);
} /* else {
    $_SESSION['error'] = "Ocurrió un error abriendo el directorio";
} */

header("Location: index.php");
return;
?>