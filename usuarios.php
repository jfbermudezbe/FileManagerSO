<?php

session_start();

if ($_POST['action'] == 'propietarios') {

    $path = '';
    if (isset($_SESSION['path'])) {
        foreach ($_SESSION['path'] as $key) {
            $path = $path . '/' . $key;
        }
    }
    $path = './projectFolder' . $path . '/' . $_POST['fileID'];

    exec('stat -c "%U" ' . $path, $owner, $errorOwner);
    exec('stat -c "%s" ' . $path, $size, $errorSize);
    exec('stat -c "%x" ' . $path, $date, $errorDate);

    exec("cut -d: -f1,3 /etc/passwd | egrep ':[0-9]{4}$' | cut -d: -f1", $users, $error);

    echo json_encode(['users' => $users, 'owner' => $owner, 'fileSize' => $size, 'date' => $date]);
} else if ($_POST['action'] == 'todos') {
    exec("cut -d: -f1,3 /etc/passwd | egrep ':[0-9]{4}$' | cut -d: -f1", $users, $error);

    echo json_encode($users);
} else {
    echo json_encode(false);
}

?>