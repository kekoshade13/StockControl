<?php
include '../assets/php/userClass.php';
include '../assets/php/inventoryClass.php';
$admin = $_SESSION['uid'];
$connectAdmin =  userClass::obtenerDatosUnUsuario($admin); 
    $listaUsuarios = userClass::obtenerUsuarios();
    $obtenerEquipos = inventoryClass::obtenerEquipos();
if(!$connectAdmin->class == "Admin") {
    header("Location:../index.php");
} else {
    $listaUsuarios = userClass::obtenerUsuarios();
    $obtenerEquipos = inventoryClass::obtenerEquipos();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de administracion</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="../assets/img/logos/logoprin.png">
    <link href="../assets/css/toastr.css" rel="stylesheet"/>
    <script type="text/javascript" src="../assets/js/toastr.min.js"></script>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
            <div class="nav-MenuVert">
                <nav class="navbar navbar-expand d-flex flex-column align-items-start" id="sidebar">
                <img src="../assets/img/logos/logoprin.png" alt="" width="200" height="150">
                    <a href="index.php" class="navbar-brand text-light d-block mx-auto">
                        <div class="display-6" style="font-size: 30px;">StockControl
                        </div>
                        <p class="text-center" style="font-size: 15px;">Administrador</p>
                    </a>
                    <ul class="navbar-nav d-flex flex-column mt-5 w-100">
                        <li class="nav-item w-100 mt-3">
                            <a href="gestiones.php" class="nav-link text-light pl-4">Gestiones</a>
                        </li>
                        <li class="nav-item w-100 mt-3">
                            <a href="movimientos.php" class="nav-link text-light pl-4">Movimientos Generales</a>
                        </li>
                                
                        <li class="nav-item w-100 mt-3">
                            <a href="../admin/reportes.php" class="nav-link text-light pl-4">Reportes</a>
                        </li>
                        <li class="nav-item w-100" style="margin-top: 30%;">
                            <a href="../index.php" class="nav-link text-light pl-4">Volver</a>
                        </li>
                    </ul>
                </nav>  
            </div>
        </div>

        <div class="col-10">  
            <nav class="navbar navbar-expand-lg mb-5">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                                <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="../assets/img/img_perfil/<?php echo $connectAdmin->nombre_u; ?>/<?php echo $connectAdmin->nombre_u?>.jpeg" alt="" width="35" style="width: 40px; height: 40px;border-radius: 100px;">     
                                <?php echo $connectAdmin->nombre." ".$connectAdmin->apellido ?>
                                </a>
                                <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="../logout.php">Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="bg"></div>
            <div class="bg bg2"></div>
            <div class="bg bg3"></div>
            <div class="content">
            <h1>Panel de administración</h1>
            </div>
        </div>
    </div>
</div>

<style>
.bg {
  animation:slide 3s ease-in-out infinite alternate;
  background-image: linear-gradient(-40deg, rgb(4,161,156)50%, black 50%); /*-40deg is the angle of the cut and 50% is how much of the color takes up the screen*/
  bottom:0;
  top:0;
  left:-50%;
  opacity:.8;
  position:fixed;
  right:-50%;
  z-index:-1;
}
.bg2 {
  animation-direction:alternate-reverse;
  animation-duration:4s;
  background-image: linear-gradient(-40deg, rgb(29,99,237) 50%, grey 50%);
}
.bg3 {
  animation-duration:5s;
}
.content {
  background-color:rgba(255,255,255,.8);
  border-radius:.25em;
  box-shadow:0 0 .25em rgba(0,0,0,.25);
  box-sizing:border-box;
  left:55%;
  padding:10vmin;
  position:fixed;
  text-align:center;
  top:50%;
  transform:translate(-50%, -50%);
}
@keyframes slide {
  0% {
    transform:translateX(-25%);
  }
  100% {
    transform:translateX(25%);
  }
}
</style>

<!-- All of JavaScript -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/popper.min.js"></script>
</body>
</html>