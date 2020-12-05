<?php

session_start();

$path = '';
$copyPath = [];
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
        array_push($copyPath, $key);
    }
}
array_push($copyPath, $_POST['fileID']);

$_SESSION['hasCuted'] = $_POST['hasCuted'];
$_SESSION['copyPath'] = $copyPath;

echo json_encode($_SESSION['hasCuted']);

?>
