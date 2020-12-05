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

/* $result =  */
exec('mv ' . $oldPath . ' ' .$newPath);
echo json_encode(true);
/* if ($result) {
    
} else {
    echo json_encode(false);
} */
?>