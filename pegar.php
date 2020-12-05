<?php

session_start();

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$path = './projectFolder' . $path;

$copyPath = '';
$popedElement = null;
$arrayCopyPath = $_SESSION['copyPath'];
if (isset($arrayCopyPath)) {
    $popedElement = array_pop($arrayCopyPath);
    foreach ($arrayCopyPath as $key) {
        $copyPath = $copyPath . '/' . $key;
    }
}
$copyPath = './projectFolder' . $copyPath;

if (file_exists($path . '/' . $popedElement)) {
    echo json_encode(false);
    $_SESSION['hasPasted'] = false;
    return;
}

$cuted = $_SESSION['hasCuted'] == "true" ? true : false;

if ($cuted) {
    $query = 'mv ' . $copyPath . '/' . $popedElement . ' ' . $path;
    exec($query);
    unset($_SESSION['copyPath']);
    echo json_encode('cortado');
} else {
    $query = 'cp -dPr ' . $copyPath . '/' . $popedElement . ' ' . $path;
    exec($query);
    echo json_encode('copiado');
}

echo json_encode($cuted);

$_SESSION['hasPasted'] = true;
//echo json_encode(true);

?>