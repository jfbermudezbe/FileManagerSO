<?php 

session_start();

if (isset($_SESSION['path'])) {
    if (count($_SESSION['path']) > 0) {
        array_pop($_SESSION['path']);
        echo json_encode(true);
    }
    else{
        echo json_encode(false);    
    }
}
else{
    echo json_encode(false);
}
