<?php

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);

        foreach ($objects as $object) {
            if ($object != '.' && $object != '..') {
                if (filetype($dir . '/' . $object) == 'dir') {
                    rrmdir($dir . '/' . $object);
                } else {
                    unlink($dir . '/' . $object);
                }
            }
        }

        reset($objects);
        rmdir($dir);
    }
}

session_start();

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$path = './projectFolder' . $path . '/' . $_POST['fileID'];

if (is_file($path)) {
    $result = unlink($path);

    if ($result) {
        echo json_encode(true);
    } else {
        echo json_encode(false);
    }
} else {
    rrmdir($path);
    echo json_encode(true);
}
?>
