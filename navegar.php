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
$result = chdir('./projectFolder' . $path . '/' . $_POST['nameFolder']);

if ($result) {
    array_push($_SESSION['path'], $_POST['nameFolder']);
    echo json_encode(true);
} else {
    echo json_encode(false);
}

?>
