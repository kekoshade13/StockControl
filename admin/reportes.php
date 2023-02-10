<?php
include_once '../assets/php/connection.php';
include '../assets/php/userClass.php';
$admin = $_SESSION['uid'];
$connectAdmin =  userClass::obtenerDatosUnUsuario($admin);
if($connectAdmin->class != "Admin") {
    header("Location:../admin/index.php");
} else {
    $listaUsuarios = userClass::obtenerUsuarios();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../assets/img/logos/logoprin.png">
</head>
<body>
    <div class="container-fluid">
            <div class="row">
                <!-- -------------------------------------------------------------- Menu -------------------------------------------------------------- -->
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
                <!-- -------------------------------------------------------------- Fin Menu -------------------------------------------------------------- -->
                
                <!-- -------------------------------------------------------------- Contenedor Principal -------------------------------------------------------------- -->
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
                    <div class="lista-tareas col-8">
                        <div class="dropdown btn-group col-4" id="admGest0" style="position:relative; left: 50px;">
                            <a class="btn border-success dropdown-toggle btn-lg" href="#" id="resultGestionP" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                Seleccionar acción
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <li><button class="btn dropdown-item btn-lg" id="gestionUsuarios" type="button" onclick="admGestiones('dPromedio')">Reporte Promedios</button></li>
                                <li><button class="btn dropdown-item btn-lg" id="gestionRepuestos" type="button" onclick="admGestiones('dPlanilla')">Reporte Planillas</button></li>
                            </ul>
                        </div>
                    </div>

                    <center>
                    <div class="col-8 d-none" id="dReporte" style="margin-top: 50px; margin-right: 30px;">
                        <form action="../assets/php/reportes.php" method="POST" class="col-10">
                            <div class="form-group col-md-12 mb-3">
                                <h1 class="display-5">Reporte</h1>
                            </div>

                            <div class="form-group col-md-6 mb-4">
                                <label for="selectUser">Selecciona el usuario</label>
                                <select name="select_usuario" id="selectUser" class="form-select form-select-lg mb-3">
                                <?php foreach($listaUsuarios as $usu): ?>
                                    <option value="<?php echo $usu->nombre_u ?>"><?php echo $usu->nombre_u ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>  

                            <div class="form row">
                                <div class="form-group col-md-6">
                                    <label for="start">Fecha Inicial:</label>
                                    <input type="date" class="form-control" name="fechaIn" placeholder="Fecha Inicial" id="start"> <br>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end">Fecha Final:</label>
                                    <input type="date" class="form-control" name="fechaFn" placeholder="Fecha Final" id="end">
                                    <br>
                                </div>
                            </div>                        

                            <input type="submit" value="Descargar Reporte" name="btnDownload" class="btn btn-outline-info text-dark">
                            <a href="../assets/planillaReporteStock.xlsx" class="btn btn-outline-info text-dark">Descargar Planilla Base</a>
                        </form>
                    </div>

                    <div class="col-8 d-none h-100" id="dPlanilla">
                        <form action="../assets/php/planillas.php" method="GET">
                            <div class="fosrm-group col-md-12">
                                <h1 class="display-5">Planillas</h1>
                            </div>
                            <div class="form row">
                                <div class="form-group col-md-6">
                                    <label for="start">Fecha Inicial:</label>
                                    <input type="date" class="form-control" name="fechaI" id="fechaIn" placeholder="Fecha Inicial" id="start"> <br>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="end">Fecha Final:</label>
                                    <input type="date" class="form-control" name="fechaF" id="fechaFn" placeholder="Fecha Final" id="end">
                                    <br>
                                </div>
                            </div>  
                            <div class="form-group">
                                <label for="selectUser">Selecciona el usuario</label>
                                <select name="usuario" id="selectUser" class="form-select form-select-lg mb-3">
                                <?php foreach($listaUsuarios as $usu): ?>
                                    <option value="<?php echo $usu->nombre_u ?>"><?php echo $usu->nombre_u ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>                          
                            <button class="btn btn-outline-info text-dark w-100 btnDownloadPlanilla">Descargar Planilla</button>
                        </form>
                    </div>
                    </center>
                        
                        <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                            <img src="../assets/img/logos/logoceibal.png" alt="" width="150">
                            <img src="../assets/img/logos/logosonda.png" alt="" width="150">
                        </div>
                    </div>
                    </center>
                </div>
            </div>
    </div>



    <!-- All of JavaScript -->
    <script src="../assets/js/jquery-3.6.1.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>

    <script>
        var user = document.getElementById('selectUser').value;
        function admGestiones(admGest) {
            var planilla = document.getElementById('dPlanilla');
            var reporte = document.getElementById('dReporte');

            if(admGest == "dPromedio") {
                document.getElementById('resultGestionP').innerHTML = "Reporte Promedios";

                planilla.classList.add('d-none');
                reporte.classList.remove('d-none');
            } else if(admGest == "dPlanilla") {
                document.getElementById('resultGestionP').innerHTML = "Reporte Planilla";
                
                planilla.classList.remove('d-none');
                reporte.classList.add('d-none');
            }
        }
    </script>
</body>
</html>