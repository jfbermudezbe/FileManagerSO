<?php

session_start();

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$path = './projectFolder' . $path . '/' . $_POST['fileID'];

exec('sudo chown ' . $_POST['propietario'] . ' ' . $path . ' -R', $output, $error);

echo json_encode($error);

?>
