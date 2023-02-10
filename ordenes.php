<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';
include_once('assets/php/inventoryClass.php');
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $db = getDB();
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    $obtenerEquipos = inventoryClass::obtenerEquipos();
    $obtenerTipoStock = inventoryClass::obtenerTiposStock();

    $lastMonthRepairs = inventoryClass::obtenerTotalReparadasMesActualPorUsuario($dataUser->id_user);
    $productividad = inventoryClass::calcularProductividadMensual($dataUser->id_user);
}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <title>OT Reparaciones</title>
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-2" style="padding-left: 0;">
        <?php
            include 'assets/php/menu/menu.php';
        ?>
        </div>
        <div class="col-10 h-50">   
            <nav class="navbar navbar-expand-lg mb-5">
                <div class="container">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav" style="position: absolute; left: 80%; top: 5%;">
                            <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/img/img_perfil/<?php echo $dataUser->nombre_u; ?>/<?php echo $dataUser->nombre_u?>.jpeg" alt="" width="35" style="width: 40px; height: 40px;border-radius: 100px;">     
                            <?php echo $dataUser->nombre." ".$dataUser->apellido ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                             </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="col-8">
                    <div id="tablaOrdenTotal" style="height: 500px; overflow-y: scroll;">
                        
                    </div>
                </div>
                <div class="col-4" style="z-index:1;">
                    <button class="btn btn-outline-primary mb-1 btnCrearOrden" style=""><svg xmlns="http:/www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter"viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 01h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>Alta Orden</button>

                    <button class="btn btn-outline-primary mb-1 btnFiltros" style=""><svg xmlns="http:/www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter"viewBox="0 0 16 16">
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 01h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>Filtros</button>

                    <button class="btn btn-outline-primary mb-1 btnTarget" type="button" style=""><svg xmlns="http:/www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter"viewBox="0 0 16 16" >
                    <path d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 01h-11a.5.5 0 0 1-.5-.5z"/>
                    </svg>Target</button>
                        <div class="card d-none row" id="btnCrearOrden">
                            <h5 class="card-header">Crear Orden</h5>
                            <div class="row">
                                <div class="col-4 mt-1">
                                    <label for="nSerie" style="margin-top: 10px">Serie</label>
                                </div>
                                <div class="col-8 mt-1">
                                    <input type="text" class="form-control w-100 d-inline-block mb-3 nSerie" id="nSerie" placeholder="N° Serie" />
                                </div>

                                <div class="col-4">
                                    <label for="nEscuela" style="margin-top: 10px">Escuela</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" class="form-control w-100 d-inline-block mb-3 nEscuela" id="nEscuela" placeholder="N° Escuela" />
                                </div>

                                <div class="col-4">
                                    <label for="tModelo" style="margin-top: 10px">Modelo</label>
                                </div>
                                <div class="col-8 mb-3">
                                    <select class="form-select" id="selectModelo" aria-label="Default select example">
                                        <option value="" selected>Selecciona el modelo</option>
                                        <?php foreach($obtenerEquipos as $equipo) { ?>
                                            <option value="<?php echo $equipo->id_equipo; ?>"><?php echo $equipo->nameEq; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <button class="btn btn-outline-primary btnCrearOrdenes mb-2" style="margin-left: 10px;">Crear</button>
                            </div>
                            
                        </div>

                        <div class="card d-none row" id="btnFiltros">
                            <h5 class="card-header mt-2">Filtrar</h5>
                            <div class="row mt-1 mb-2">
                                <div class="col-4">
                                    <label for="tModelo" style="margin-top: 10px">Modelo</label>
                                </div>
                                <div class="col-8 mb-2">
                                    <select class="form-select" id="selectModeloF">
                                        <option value="" selected>Modelos</option>
                                        <?php foreach($obtenerEquipos as $equipo) { ?>
                                            <option value="<?php echo $equipo->id_equipo; ?>"><?php echo $equipo->nameEq; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-4">
                                    <label for="nSerie1" style="margin-top: 10px">Serie</label>
                                </div>
                                <div class="col-8 mb-2">
                                    <input type="text" class="form-control w-100 d-inline-block nSerie1" id="nSerie1" placeholder="N° Serie" />
                                </div>

                                <div class="col-4">
                                    <label for="nEscuela1" style="margin-top: 10px">Escuela</label>
                                </div>
                                <div class="col-8 mb-2">
                                    <input type="text" class="form-control w-100 d-inline-block mb-3 nEscuela1" id="nEscuela1" placeholder="N° Escuela" />
                                </div>
                                <div class="col-12" style="margin-left: 8px;">
                                    <button class="btn btn-outline-primary btnFiltrarOrdenes col-7" style="margin-left: 10px;">Buscar</button>
                                    <button class="btn btn-outline-danger btnLimpiarOrdenes col-4" style="margin-left: 10px;">Limpiar</button>
                                </div>
                                
                            </div>
                        </div>

                        <div class="card d-none row" id="filtroTarget">
                            <h5 class="card-header mt-2">Actualiza tu Target</h5>
                            <div class="row mt-1 mb-2">
                                <div class="col-4">
                                    <label for="newTarget" style="margin-top: 10px">Target</label>
                                </div>
                                <div class="col-8 mb-2">
                                    <input type="text" class="form-control" name="" id="newTarget" placeholder="Ingresa tu nuevo target">
                                </div>
                                <div class="col-12" style="margin-left: 8px;">
                                    <button class="btn btn-outline-primary btnActualizarTarget col-12" style="margin-left: 10px;">Actualizar Target</button>
                                </div>
                                
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                        <div class="progress mb-3" style="height: 1px;">
                            <div class="progress-bar bg-secondary" id="barraProgreso" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-secondary" id="barraProgreso1" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><?php echo intval($productividad['totalPorcentaje']) ?>%</div>
                        </div>
                            <div class="col-12">
                                <p style="font-size: 25px;">Objetivo hasta la fecha: <?php echo $productividad['objetivoMensual'] ?></p>
                            </div>
                            <div class="col-12">
                                <p style="font-size:20px;">Total Reparadas: <?php echo $lastMonthRepairs ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
            <div class="logosCompany" style="position:absolute; bottom: 0px; right: 0px; opacity: 0.9;">
                <img src="assets/img/logos/logoceibal.png" alt="" width="150">
                <img src="assets/img/logos/logosonda.png" alt="" width="150">
            </div>
        </div>
    </div>        
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
<script>
    jQuery(document).ready(function(){
        // Listen for the input event.
        jQuery(".nSerie").on('input', function (evt) {
            // Allow only numbers.
            jQuery(this).val(jQuery(this).val().replace(/[^0-9A-Za-z]/g, ''));
        });
    });
    jQuery(document).ready(function(){
        // Listen for the input event.
        jQuery(".nEscuela").on('input', function (evt) {
            // Allow only numbers.
            jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
        });
    });

    var user = '<?php echo $dataUser->nombre_u; ?>';
    var idUser = '<?php echo $dataUser->id_user; ?>';    

    $(document).ready(function() {
        toastr.options = {
			'closeButton': true,
			'debug': false,
			'newestOnTop': true,
			'progressBar': false,
			'positionClass': 'toast-top-right',
			'preventDuplicates': false,
			'showDuration': '500',
			'hideDuration': '1000',
			'timeOut': '5000',
			'extendedTimeOut': '1000',
			'showEasing': 'swing',
			'hideEasing': 'linear',
			'showMethod': 'fadeIn',
			'hideMethod': 'fadeOut',
		}
        $.ajax({
            url: 'assets/php/inventoryClass.php',
            data: { usuario: user, funcion: 'obtenerOrdenesTotales' },
            type: 'POST',
            success: function(e) {
                $('#tablaOrdenTotal').html(e);
            },
            error: function(e) {
                $('#tablaOrdenTotal').html(e);
            }
        });


        var porcentHastaElMomento = <?php echo $productividad['totalPorcentaje'] ?>;
        var barraProgreso = document.getElementById('barraProgreso');
        var barraProgreso1 = document.getElementById('barraProgreso1');
        setInterval(function() {
            barraProgreso.style.width = porcentHastaElMomento + "%";
            barraProgreso1.style.width = porcentHastaElMomento + "%";
            if(porcentHastaElMomento < 24) {
                barraProgreso.classList.add('bg-secondary');
                barraProgreso1.classList.add('bg-secondary');
            } 
            if(porcentHastaElMomento > 24) {
                barraProgreso.classList.remove('bg-secondary');
                barraProgreso1.classList.remove('bg-secondary');
                barraProgreso.classList.add('bg-danger');
                barraProgreso1.classList.add('bg-danger');
            }
            if(porcentHastaElMomento > 49) {
                barraProgreso.classList.remove('bg-danger');
                barraProgreso1.classList.remove('bg-danger');
                barraProgreso.classList.add('bg-warning');
                barraProgreso1.classList.add('bg-warning');
            }
            if(porcentHastaElMomento > 74) {
                barraProgreso.classList.remove('bg-warning');
                barraProgreso1.classList.remove('bg-warning');
                barraProgreso.classList.add('bg-success');
                barraProgreso1.classList.add('bg-success');
            }
        }, 100);
    });

    $(document).on('click', '.btnFiltros', function(e) {
        e.preventDefault();
        var filtros = document.getElementById('btnFiltros');
        var btnCrearOrden = document.getElementById('btnCrearOrden');
        var newTarget = document.getElementById('filtroTarget');

        if(filtros.classList.contains('d-none')) {
            filtros.classList.remove('d-none');
            btnCrearOrden.classList.add('d-none');
            newTarget.classList.add('d-none');
        } else {
            filtros.classList.add('d-none');
        }
    });

    $(document).on('click', '.btnTarget', function(e) {
        var filtros = document.getElementById('btnCrearOrden');
        var filtrosA = document.getElementById('btnFiltros');
        var newTarget = document.getElementById('filtroTarget');

        if(newTarget.classList.contains('d-none')) {
            filtros.classList.add('d-none');
            filtrosA.classList.add('d-none');
            newTarget.classList.remove('d-none');
        } else {
            newTarget.classList.add('d-none');
        }

        $(document).on('click', '.btnActualizarTarget', function(e) {
            var valNewTarget = document.getElementById('newTarget').value;

            if(valNewTarget.trim() != "") {
                $.ajax({
                    url: 'assets/php/userClass.php',
                    data: { usuario: idUser, target: valNewTarget, funcion: 'actualizarTarget' },
                    type: 'post',
                    dataType: 'json',
                    success: function(e) {
                        var mess = JSON.parse(e);

                        if(mess == 1) {
                            toastr.success("Tu target fue actualizado con exito", "Exito");
                            setTimeout(function() {
                                location.reload();
                            }, 1100);
                        } else {
                            toastr.error("No se pudo actualizar tu target.", "Error");
                        }
                    }
                });
            }
        });
    });

    $(document).on('click', '.btnCrearOrden', function(e) {
        e.preventDefault();
        var filtros = document.getElementById('btnCrearOrden');
        var filtrosA = document.getElementById('btnFiltros');
        var mewTarget = document.getElementById('filtroTarget'); 

        if(filtros.classList.contains('d-none')) {
            filtros.classList.remove('d-none');
            filtrosA.classList.add('d-none');
            mewTarget.classList.add('d-none');
        } else {
            mewTarget.classList.add('d-none');
            filtros.classList.add('d-none');
            filtrosA.classList.add('d-none');
        }

        $(document).on('click', '.btnCrearOrdenes', function(e) {
            var serie = document.getElementById('nSerie').value;
            var escuela = document.getElementById('nEscuela').value;
            var modelo = document.getElementById('selectModelo').value;

            if(serie.trim() != "") {
                if(escuela.trim() != "") {
                    if(modelo.trim() != "") {
                        $.ajax({
                            url: 'assets/php/inventoryClass.php',
                            data: { usuario: user, nSerie: serie, nEscuela: escuela, tModelo: modelo, funcion: 'addNewOrder' },
                            type: 'post',
                            success: function(e) {
                                var mess = JSON.parse(e);
                                if(mess == 1) {
                                    toastr.success("Se creo la orden correctamente. Actualiza la página, por favor.","¡Exito!");
                                    location.reload();
                                } else if(mess == 0) {
                                    toastr.error("   existe esa orden");
                                } else if(mess == 2) {
                                    toastr.error("No se pudo obtener la ID de la orden");
                                } else if(mess == 3) {
                                    toastr.error("No puedes crear una orden sin definir tu target personal");
                                } else if(mess == 4) {
                                    toastr.error("No puedes crear una orden con un equipo que no tiene repuestos asignados.");
                                }else {
                                    toastr.error("Algo paso");
                                }
                            },
                            error: function(e) {
                                toastr.error("Error imprevisto");
                            }
                        });
                    } else {
                        toastr.error("No puedes crear una orden sin ingresar el modelo del equipo", "Error");
                    }
                    
                } else {
                    toastr.error("No puedes crear una orden sin ingresar la escuela.", "Error");
                }
            } else {
                toastr.error("No puedes crear una orden sin ingresar la serie del equipo.", "Error");
            }
        });
    });

    $(document).on('click', '.btnFiltrarOrdenes', function(e) {
        var tModelo1 = document.getElementById('selectModeloF').value;
        var nSerie1 = document.getElementById('nSerie1').value;
        var nEscuela1 = document.getElementById('nEscuela1').value;

        $.ajax({
            url: 'assets/php/inventoryClass.php',
            data: { usuario: user, modelo: tModelo1, serie: nSerie1, escuela: nEscuela1, funcion: 'filtrarOrdenesUsuario' },
            type: 'post',
            success: function(e) {
                $('#tablaOrdenTotal').html(e);
            },
            error: function(e) {
                alert("Error");
            }
        });
    });

    $(document).on('click', '.btnLimpiarOrdenes', function(e) {
        document.getElementById('selectModeloF').value = '';
        document.getElementById('nSerie1').value = '';
        document.getElementById('nEscuela1').value = '';

        $.ajax({
            url: 'assets/php/inventoryClass.php',
            data: { usuario: user, funcion: 'obtenerOrdenesTotales' },
            type: 'POST',
            success: function(e) {
                $('#tablaOrdenTotal').html(e);
            },
            error: function(e) {
                $('#tablaOrdenTotal').html(e);
            }
        });
    });
</script>

<style>
    .listaRepConsumidos ul li {
        list-style: none;
    }
    .listaRepConsumidos ul li::before {
    content: "- ";
    }
</style>
</body>
</html>