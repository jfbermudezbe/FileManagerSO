<?php session_start(); ?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explorador de archivos - Sistemas Operativos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="content">
        <h1 class="welcomeTitle">Bienvenido al explorador de archivos construido en el curso Sistemas Operativos - Universidad Nacional de Colombia - Medellín 2020-2</h1>

        <div class="mx-auto" style="width: 80%;">
            <button id="crearCarpeta" class="btn btn-success">Crear carpeta</button>
            <button class="btn btn-warning">Crear archivo</button>
        </div>
    
    
    </div>
    
<script>
$('#crearCarpeta').on('click',function() {
    Swal.fire({
    title:"Ingrese el nombre de la carpeta que desea crear",
    html: "<form action='crearCarpeta.php' method='GET'><div class='form-group'><input type='text' class='form-control' name='nombreCarpeta'></div><small id='crearCarpetaComment' class='form-text text-muted'>Evita usar puntos o caracteres especiales.</small><br><input type='submit' class='btn btn-primary' value='CREAR'></form>",
    showCancelButton: false,
    showConfirmButton: false
})})
</script>


<?php 
if(isset($_SESSION['error'])){?>
    <script>
        Swal.fire("Oops...", "<?php echo $_SESSION['error'] ?>", "error")
    </script>
<?php 
    unset($_SESSION['error']);
}else if(isset($_SESSION['success'])) {?>
    <script>
        Swal.fire("Muy bien!", "<?php echo $_SESSION['success']; ?>", "success")
    </script>
<?php 
unset($_SESSION['success']);
} ?>


</body>
</html>