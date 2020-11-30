<?php
session_start();
//session_destroy();
$currentPath = "./projectFolder";
$fakePath = [];
if (isset($_SESSION['path'])) {
    foreach ($_SESSION['path'] as $key) {
        $currentPath = $currentPath . '/' . $key;
        array_push($fakePath, $key);
    }
} else {
    $_SESSION['path'] = [];
}

function sortedDir($dir)
{
    $sortedData = array();
    foreach (scandir($dir) as $file) {
        if (is_file($dir . '/' . $file))
            array_push($sortedData, $file);
        else
            array_unshift($sortedData, $file);
    }
    return $sortedData;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" id="favicon" href="img/favicon.png" />
    <title>Explorador de archivos - Sistemas Operativos</title>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/styles.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fuentes -->
    <link href="https://fonts.googleapis.com/css?family=Poppins|Fredoka+One|Patua+One|Play|Righteous&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Menu click derecho -->
    <div id="menu" class="menu row m-0">
        <input type="hidden" value="" class="col-12">
        <div class="col-12" id="copiar">
            <i class="fas fa-copy fa-fw"></i> Copiar
        </div>
        <div class="col-12" id="cortar">
            <i class="fas fa-cut fa-fw"></i> Cortar
        </div>
        <hr>
        <div class="col-12" id="renombrar">
            <i class="fas fa-pencil fa-fw"></i> Renombrar
        </div>
        <div class="col-12" id="eliminar">
            <i class="fas fa-trash fa-fw"></i> Eliminar
        </div>
    </div>

    <div id="menu2" class="menu row m-0">
        <div class="col-12 disabled" id="pegar">
            <i class="fas fa-clipboard fa-fw"></i> Pegar
        </div>
        <hr>
        <div class="col-12" id="crearCarpetaMenu">
            <i class="fas fa-folder-plus fa-fw"></i> Crear carpeta
        </div>
        <div class="col-12" id="crearArchivoMenu">
            <i class="fas fa-file-medical fa-fw"></i> Crear archivo
        </div>
    </div>

    <!-- Navbar -->
    <nav class="navbar nav-color">
        <a class="navbar-brand r-font" href="/">
            FileExSO
        </a>
        <img src="img/favicon.png" width="40" height="40" class="d-inline-block align-top" alt="">
        <div class="row m-0">
            <button class="btn nav-btn" id="crearCarpeta">
                <i class="fas fa-folder-plus fa-fw fa-2x"></i>
            </button>
            <button class="btn nav-btn" id="crearArchivo">
                <i class="fas fa-file-medical fa-fw fa-2x"></i>
            </button>
        </div>
    </nav>

    <!-- Navegacion entre directorios -->
    <div class="mt-3 row m-0">
        <?php if (!empty($fakePath)) { ?>
            <button class="btn nav-btn" id="irAtras" style="border-radius: 50px;">
                <i class="fas fa-arrow-circle-left fa-fw fa-2x"></i>
            </button>
            <div class="total-path row m-0">
                <div class="current-path r-font">
                    Home
                </div>
                <?php foreach ($fakePath as $key) {
                    echo '
            <div class="divider r-font">/</div>
            <div class="current-path r-font">
                ' . $key . '
            </div>';
                }; ?>
            </div>
        <?php } else { ?>
            <div class="current-path r-font text-center mx-auto">
                Home
            </div>
        <?php
        } ?>

    </div>

    <!-- Navegador de archivos-->
    <div class="content row m-0 mt-3 align-content-start flex-wrap" id="explorer">
        <?php
        $directory = $currentPath;
        $row = array_diff(sortedDir($directory), array('..', '.'));
        if (count($row) > 0) {
            foreach ($row as $i) {
                if (is_file($directory . '/' . $i)) {
        ?>
                    <div class="object object-file col-6 col-sm-3 col-lg-2 row m-0" id="<?php echo $i ?>">
                        <i class="fas fa-file fa-fw col-12"></i>
                        <p class="col-12 text-center"><?php echo $i ?></p>
                        <input type="hidden" name="nameFile" value="<?php echo $i ?>">
                    </div>
                <?php
                } else {
                ?>
                    <div class="object object-folder col-6 col-sm-3 col-lg-2 row m-0" id="<?php echo $i ?>">
                        <i class="fas fa-folder fa-fw col-12"></i>
                        <p class="col-12 text-center"><?php echo $i ?></p>
                        <input type="hidden" name="nameFolder" value="<?php echo $i ?>">
                    </div>
            <?php
                }
            }
        } else {
            ?>
            <div class="col-12">
                <i class="fas fa-folder-open fa-fw fa-3x text-muted text-center w-100"></i>
                <p class="r-font text-muted text-center">Carpeta vacía.</p>
            </div>
        <?php
        }

        ?>
    </div>

    <script src="./js/scripts.js"></script>

    <script>
        $('#crearCarpeta').on('click', function() {
            Swal.fire({
                title: "Ingrese el nombre de la carpeta que desea crear",
                html: `
                <form action='crearCarpeta.php' method='GET'>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='nombreCarpeta'>
                    </div>
                    <small id='crearCarpetaComment' class='form-text text-muted'>
                        Evita usar puntos o caracteres especiales.
                    </small>
                    <br>
                    <input type='submit' class='btn btn-primary' value='CREAR'>
                </form>`,
                showCancelButton: false,
                showConfirmButton: false
            })
        })

        $('#crearArchivo').on('click', function() {
            var currentUrl = "<?php echo $currentPath ?>";
            Swal.fire({
                title: "Ingrese el nombre del archivo que desea crear",
                html: `
                <form action='crearArchivo.php' method='GET'>
                    <div class='form-group'>
                        <input type='hidden' name='carpetaActual' value='${currentUrl}'>
                        <input type='text' class='form-control' name='nombreArchivo'>
                    </div>
                    <small id='crearCarpetaComment' class='form-text text-muted'>
                        Evita usar puntos o caracteres especiales.
                    </small>
                    <br>
                    <input type='submit' class='btn btn-primary' value='CREAR'>
                </form>`,
                showCancelButton: false,
                showConfirmButton: false
            })
        })

        $('#crearCarpetaMenu').on('click', function() {
            Swal.fire({
                title: "Ingrese el nombre de la carpeta que desea crear",
                html: `
                <form action='crearCarpeta.php' method='GET'>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='nombreCarpeta'>
                    </div>
                    <small id='crearCarpetaComment' class='form-text text-muted'>
                        Evita usar puntos o caracteres especiales.
                    </small>
                    <br>
                    <input type='submit' class='btn btn-primary' value='CREAR'>
                </form>`,
                showCancelButton: false,
                showConfirmButton: false
            })
        })

        $('#crearArchivoMenu').on('click', function() {
            var currentUrl = "<?php echo $currentPath ?>";
            Swal.fire({
                title: "Ingrese el nombre del archivo que desea crear",
                html: `
                <form action='crearArchivo.php' method='GET'>
                    <div class='form-group'>
                        <input type='hidden' name='carpetaActual' value='${currentUrl}'>
                        <input type='text' class='form-control' name='nombreArchivo'>
                    </div>
                    <small id='crearCarpetaComment' class='form-text text-muted'>
                        Evita usar puntos o caracteres especiales.
                    </small>
                    <br>
                    <input type='submit' class='btn btn-primary' value='CREAR'>
                </form>`,
                showCancelButton: false,
                showConfirmButton: false
            })
        })

        $(document).ready(() => {
            console.log("<?php echo $currentPath; ?>")
        })
    </script>


    <?php
    if (isset($_SESSION['error'])) { ?>
        <script>
            Swal.fire("Oops...", "<?php echo $_SESSION['error'] ?>", "error")
        </script>
    <?php
        unset($_SESSION['error']);
    } else if (isset($_SESSION['success'])) { ?>
        <script>
            Swal.fire("Muy bien!", "<?php echo $_SESSION['success']; ?>", "success")
        </script>
    <?php
        unset($_SESSION['success']);
    } ?>
</body>

</html>