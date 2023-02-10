<?php
include_once('assets/php/connection.php');
include 'assets/php/userClass.php';
include_once('assets/php/inventoryClass.php');
if($_SESSION['sesion_exito'] != 1) {
    header('Location: login.php');
} else {
    $dataUser = userClass::obtenerDatosUnUsuario($_SESSION['uid']);
    $obtenerEquipos = inventoryClass::obtenerEquipos();
    $obtenerTipoStock = inventoryClass::obtenerTiposStock();
}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" />
    <script src="assets/js/jquery-3.6.1.min.js"></script>
    <link rel="shortcut icon" href="assets/img/logos/logoprin.png">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <title>Inicio</title>
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
        <div class="col-10 h-100">   
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
            <div class="row mx-auto" style="margin-top: 80px;">
                <div class="col-12">
                    <div id="tablaOrdenTotal">
                        <div class="col-sm-12 datosOrden row">
                            
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
    jQuery(".nCodigo").on('input', function (evt) {
    jQuery(this).val(jQuery(this).val().replace(/[^0-9]/g, ''));
    });
});
if($('#flasheoId').is(':checked')) {
    console.log("asd");
}
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
        });
    var id_ordenRep = <?php echo $_GET['id_orden']; ?>;
    var usuario = '<?php echo $dataUser->nombre_u; ?>';

    $(document).ready(function(e) {
        $.ajax({
            url: 'assets/php/inventoryClass.php',
            data: { user: usuario, orden: id_ordenRep, funcion: 'seeRepConsumed' },
            type: 'post',
            success: function(e) {
                $('.datosOrden').html(e);
            },
            error: function(e) {
                $('.datosOrden').html(e);
            }
        });
    });

    function descheckFlashCap() {
        document.getElementById('flasheoCapId').checked = false;
    }
    function descheckFlash() {
        document.getElementById('flasheoId').checked = false;
    }

    var arrRepuestos = [];
    $(document).on('click', '.addCodeRep', function(e) {
        var codigo = document.getElementById('codigoRep').value;
        var tipoStock = document.getElementById('selectTipoStock').value;

        if(codigo.trim() != "") {
            if(tipoStock.trim() != "") {
                if(codigo.length < 6 || codigo.length > 6) {
                    toastr.error("Tienes que ingresar un repuesto con una longitud de 6 dígitos.", "Consumir Repuesto");
                } else {
                    arrRepuestos.push(codigo);

                    $.ajax({
                        url: 'assets/php/inventoryClass.php',
                        data: { user: usuario, orden: id_ordenRep, tipoEstado: tipoStock, repuestos: JSON.stringify(arrRepuestos), funcion: 'addRepToOrder' },
                        type: "post",
                        success: function(e) {
                            $('.repConsumidos').html(e);
                            arrRepuestos = [];
                        },
                        error: function(e) {
                            alert("No funca");
                        }
                    });
                }
            } else {
                toastr.error("No puedes consumir un repuesto sin conocer su tipo de stock.", "Consumir Repuesto");
            }
        } else {
            toastr.error("Tienes que ingresar un repuesto compatible.", "Consumir Repuesto");
        }
        
    });

    $(document).on('click', '.quitCodeRep', function(e) {
        var codigo1 = document.getElementById('codigoRep').value;
        var tipoStock1 = document.getElementById('selectTipoStock').value;

        if(codigo1.trim() != "") {
            if(tipoStock1.trim() != "") {
                $.ajax({
                    url: 'assets/php/inventoryClass.php',
                    data: { user: usuario, orden: id_ordenRep, tipoEstado: tipoStock1, repuestos: codigo1, funcion: 'quitRepToOrder' },
                    type: "post",
                    success: function(e) {
                        $('.repConsumidos').html(e);
                    },
                    error: function(e) {
                        alert("No funca");
                    }
                });
            } else {
                toastr.error("No puedes devolver un repuesto sin conocer su tipo de stock.", "Devolver Repuesto");
            }
        } else {
            toastr.error("Tienes que ingresar un repuesto compatible", "Devolver Repuesto");
        }
    });

    $(document).on('click', '.btnConfirmarReparacion', function(e) {
        const confirmReparacion = confirm("¿Has finalizado la reparación?");

        let activoFijo = $('input[name="flash"]:checked').val();
        if(confirmReparacion) {
            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: { user: usuario, orden: id_ordenRep, tipoFlasheo: activoFijo, funcion: 'confirmarReparacion' },
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    var messConf = JSON.parse(e);

                    if(messConf == 1) {
                        setTimeout(function(){
                            location.reload();
                        }, 2000);

                        toastr.success("Se guardo la reparación en tu planilla.", "Reparación Finalizada.");
                    } else if(messConf == 2) {
                        toastr.error("Para cerrar la orden debes determinar si se consumieron repuestos, si el equipo fue flasheado o si se fue enviado pendiente o a destrucción total.", "¡Intenta nuevamente!");
                    } else if(messConf == 0) {
                        toastr.error("Ocurrió un error al finalizar la orden.", "Error");
                    } else if(messConf == 3) {
                        toastr.error("No se pudo insertar la reparación en la planilla. Anotate el registro como texto.");
                    } else if(messConf == 4) {
                        toastr.error("No se ha encontrado la orden.", "Error");
                    } else if(messConf == 5) {
                        toastr.error("No se ha podido finalizar la orden.", "Error");
                    } else if(messConf == 6) {
                        toastr.error("No se ha encontrado la orden.", "Error");
                    }
                },
                error: function(e) {
                    alert(e);
                }
            });
        }  
    });

    $(document).on('click', '.btnEliminarOrden', function(e) {
        const confirmacion = confirm("¿Estás seguro de eliminar la orden?");

        if(confirmacion) {
            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: { user: usuario, idOrden: id_ordenRep, funcion: 'eliminarOrden' },
                type: 'post',
                dataType: 'json',
                success: function(e) {

                    var messagElim = JSON.parse(e);

                    if(messagElim == 1) {
                        setTimeout(function(){
                            location.href="ordenes.php";
                    }, 1000);
                    toastr.success("Se ha eliminado la orden correctamente.", "Eliminar Orden");
                    } else if(messagElim == 2) {
                        toastr.error("No puedes eliminar una orden con repuestos consumidos.", "Eliminar Orden");
                    } else {
                        toastr.error("Ha ocurrido un error.");
                    }
                    
                },
                error: function(e) {
                    alert("No funciona");
                }
            });
        } else {
            toastr.success("Has cancelado la eliminación de la orden.", "Eliminar Orden");
        }
    });

    $(document).on('click', '.btnEditarOrden', function(e) {
        $(document).on('click', '.btnEditarOrGuardar', function(e) {
            var newSerie1 = document.getElementById('newSerie').value;
            var newEscuela1 = document.getElementById('newEscuela').value;
            var newModelo1 = document.getElementById('selectNewEquipo').value;

            const confEdit = confirm("¿Estás seguro de editar la orden?");

            if(confEdit) {
                $.ajax({
                    url: 'assets/php/inventoryClass.php',
                    data: { user: usuario, idOrden: id_ordenRep, newSerie: newSerie1, newEscuela: newEscuela1, newModelo: newModelo1, funcion: 'actualizarDatosOrden' },
                    type: 'post',
                    success: function(e) {
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                        toastr.success(e, "Editar Orden");
                    },
                    error: function(e) {
                        alert("No funciona");
                    }
                });
            }
        });
    });

    $(document).on('click', '.btnEnviarPendiente', function(e) {
        const enviarPend = confirm("¿Estás seguro de enviar este equipo pendiente?");

        if(enviarPend) {
            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: { user: usuario, idOrden: id_ordenRep, funcion: "enviarOrdenPendiente" },
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    var messagePend = JSON.parse(e);

                    if(messagePend == 1) {
                        setTimeout(function(){
                            window.open('https://docs.google.com/spreadsheets/d/1Sm_6Z05SuRX1zq1Qu2mmL2EvPFKK1fikO4xcyVSyYGM/edit#gid=0', '_blank');
                            location.href = "ordenes.php";
                        }, 1500);
                        toastr.success("La orden se envió pendiente exitosamente.", "Orden Pendiente.");
                    } else if(messagePend == 2) {
                        toastr.error("No se puede enviar pendiente una orden con repuestos consumidos.", "Error");
                    } else {
                        toastr.error("Ocurrió un error al enviar la orden pendiente.", "Error");
                    }
                }
            });
        }
    });

    $(document).on('click', '.btnDestruccionTotal', function(e) {
        const enviarDestrucTot = confirm("¿Estás seguro de enviar este equipo a destrucción total?");

        if(enviarDestrucTot) {
            $.ajax({
                url: 'assets/php/inventoryClass.php',
                data: { user: usuario, idOrden: id_ordenRep, funcion: "enviarADestruccionTotal" },
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    var messageDestru = JSON.parse(e);

                    if(messageDestru == 1) {
                        setTimeout(function(){
                            window.open('assets/DestruccionTotal.pdf', '_blank');
                            location.href = "ordenes.php";
                        }, 1500);
                        toastr.success("La orden se envio a destrucción total.", "Exito");
                    } else if(messageDestru == 2) {
                        toastr.error("Tienes que devolver los repuestos para hacer esto.", "Error");
                    } else {
                        toastr.error("Ocurrió un error.", "Error");
                    }
                }
            });
        }
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
