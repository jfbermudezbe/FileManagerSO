<?php

session_start();

$path = '';
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $path = $path . '/' . $key;
    }
}
$path = './projectFolder' . $path . '/' . $_POST['fileID'];

if ($_POST['action'] == "get") {
    if (is_dir($path)) {
        $query = "ls -ld " . $path . "";
        exec($query, $result, $error);

        $pos1 = $result[0][1] . $result[0][2] . $result[0][3];
        $num1 = 0;
        if($pos1[0] == "r"){
            $num1 += 4;
        }
        if($pos1[1] == "w"){
            $num1 += 2;
        }
        if($pos1[2] == "x"){
            $num1 += 1;
        }
        $pos2 = $result[0][4] . $result[0][5] . $result[0][6];
        $num2 = 0;
        if($pos2[0] == "r"){
            $num2 += 4;
        }
        if($pos2[1] == "w"){
            $num2 += 2;
        }
        if($pos2[2] == "x"){
            $num2 += 1;
        }
        $pos3 = $result[0][7] . $result[0][8] . $result[0][9];
        $num3 = 0;
        if($pos3[0] == "r"){
            $num3 += 4;
        }
        if($pos3[1] == "w"){
            $num3 += 2;
        }
        if($pos3[2] == "x"){
            $num3 += 1;
        }

        $all = $num1 . $num2 . $num3;

        echo json_encode($all);
    } else {
        $query = "ls -l " . $path . "";
        exec($query, $result, $error);

        $pos1 = $result[0][1] . $result[0][2] . $result[0][3];
        $num1 = 0;
        if($pos1[0] == "r"){
            $num1 += 4;
        }
        if($pos1[1] == "w"){
            $num1 += 2;
        }
        if($pos1[2] == "x"){
            $num1 += 1;
        }
        $pos2 = $result[0][4] . $result[0][5] . $result[0][6];
        $num2 = 0;
        if($pos2[0] == "r"){
            $num2 += 4;
        }
        if($pos2[1] == "w"){
            $num2 += 2;
        }
        if($pos2[2] == "x"){
            $num2 += 1;
        }
        $pos3 = $result[0][7] . $result[0][8] . $result[0][9];
        $num3 = 0;
        if($pos3[0] == "r"){
            $num3 += 4;
        }
        if($pos3[1] == "w"){
            $num3 += 2;
        }
        if($pos3[2] == "x"){
            $num3 += 1;
        }

        $all = $num1 . $num2 . $num3;

        echo json_encode($all);
    }
} 
else if ($_POST['action'] == "set") {
    $query = 'sudo chmod ' . intval($_POST['nuevoP']) . ' ' . $path;
    exec($query, $result, $error);

    json_encode($error);
}
?>