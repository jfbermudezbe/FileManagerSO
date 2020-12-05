<?php

session_start();

if (!isset($_POST['nameFolder'])) {
    echo json_encode(false);
    return;
}

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }    
}

$query = 'cd ./projectFolder' . $path . '/' . $_POST['nameFolder'];
exec($query, $result, $error);

if ($error == 0) {
    array_push($_SESSION['path'], $_POST['nameFolder']);
    echo json_encode(true);
} else {
    echo json_encode(false);
}

?>
