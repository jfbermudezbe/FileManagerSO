<?php

session_start();

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$path = './projectFolder' . $path . '/' . $_POST['fileID'];

exec('chown ' . $_POST['propietario'] . ' ' . $path, $output, $error);

echo json_encode($error);

?>
