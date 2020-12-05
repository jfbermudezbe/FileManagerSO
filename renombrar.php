<?php

session_start();

$newName = $_POST['newName'];
$oldName = $_POST['oldName'];

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}

$oldPath = './projectFolder' . $path . '/' . $oldName;
$newPath = './projectFolder' . $path . '/' . $newName;

exec('mv ' . $oldPath . ' ' . $newPath, $result, $error);

if ($error) {
    echo json_encode(false);  
} else {
    echo json_encode(true);
} 
?>