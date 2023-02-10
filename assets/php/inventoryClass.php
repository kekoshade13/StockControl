<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(E_ALL);
include_once('connection.php');

if(!empty($_POST['funcion'])) {

    switch($_POST['funcion']) {
        case 'addNewRepuest':
            if(!empty($_POST['newCode']) && !empty($_POST['newNombre']) && !empty($_POST['newRepEquipo'])) {
                $newCodigo = $_POST['newCode'];
                $newNameCode = $_POST['newNombre'];
                $newRepEquipo = $_POST['newRepEquipo'];
        
                inventoryClass::addNewRepuesto($newCodigo, $newNameCode, $newRepEquipo);
            }
            break;
        case 'reduceStock':
            if(!empty($_POST['deleteCode']) && !empty($_POST['cantDelete']) && !empty($_POST['tipoStock'])) {
                $codeDelete = $_POST['deleteCode'];
                $cantDelete = $_POST['cantDelete'];
                $tipoStock = $_POST['tipoStock'];

                inventoryClass::reducirStock($codeDelete, $cantDelete, $tipoStock);
            }
            break;
        case 'aumentStock':
            if(!empty($_POST['codeAument']) && !empty($_POST['cantidad']) && !empty($_POST['tipoEstado'])) {
                $codeAument = $_POST['codeAument'];
                $cantidad = $_POST['cantidad'];
                $tipoStock = $_POST['tipoEstado'];
                inventoryClass::aumentarStock($codeAument, $cantidad, $tipoStock);
            }
            break;
        case 'filtrarMovimientos':
            if(!empty($_POST['nombre_u'])) {
                $nombre = $_POST['nombre_u'];
            } else {
                $nombre = '';
            }
            if(!empty($_POST['dateIni'])) {
                $fechaI = $_POST['dateIni'];
            } else {
                $fechaI = '';
            }
            if(!empty($_POST['dateFin'])) {
                $fechaF = $_POST['dateFin'];
            } else {
                $fechaF = '';
            }
            if(!empty($_POST['code'])) {
                $code = $_POST['code'];
            } else {
                $code = '';
            }
            if(!empty($_POST['tipoMovi'])) {
                $tipoMov = $_POST['tipoMovi'];
            } else {
                $tipoMov = '';
            }
            if(!empty($_POST['tipoStoc'])) {
                $tipoStoc = $_POST['tipoStoc'];
            } else {
                $tipoStoc = '';
            }
            inventoryClass::obtenerMovimientos($nombre, $fechaI, $fechaF, $code, $tipoMov, $tipoStoc);
            break;
        case 'filtrarMovimientosGenerales':
            if(!empty($_POST['nombre_u'])) {
                $nombre1 = $_POST['nombre_u'];
            } else {
                $nombre1 = '';
            }
            if(!empty($_POST['dateIni'])) {
                $fechaI1 = $_POST['dateIni'];
            } else {
                $fechaI1 = '';
            }
            if(!empty($_POST['dateFin'])) {
                $fechaF1 = $_POST['dateFin'];
            } else {
                $fechaF1 = '';
            }
            if(!empty($_POST['code'])) {
                $code1 = $_POST['code'];
            } else {
                $code1 = '';
            }
            if(!empty($_POST['tipoMovi'])) {
                $tipoMov1 = $_POST['tipoMovi'];
            } else {
                $tipoMov1 = '';
            }
            if(!empty($_POST['tipoStoc'])) {
                $tipoStoc1 = $_POST['tipoStoc'];
            } else {
                $tipoStoc1 = '';
            }
            if(!empty($_POST['tableD'])) {
                $downloadTable = 1;
            } else {
                $downloadTable = "";
            }
            inventoryClass::obtenerMovimientosGenerales($nombre1, $fechaI1, $fechaF1, $code1, $tipoMov1, $tipoStoc1, $downloadTable);
            break;
        case 'filtrarInventario':
            if(!empty($_POST['code'])) {
                $codigo = $_POST['code'];
            } else {
                $codigo = "";
            }
            if(!empty($_POST['modelo'])) {
                $modelo = $_POST['modelo'];
            } else {
                $modelo = "";
            }

            if(!empty($_POST['compatible'])) {
                $compatible = $_POST['compatible'];
            } else {
                $compatible = "";
            }
            if(!empty($_POST['tipoEstado'])) {
                $tipoStock = $_POST['tipoEstado'];
            } else {
                $tipoStock = "";
            }
            inventoryClass::obtenerInventario($codigo, $modelo, $compatible, $tipoStock);
            break;
        case 'obtenerRepEqComp':
            if(!empty($_POST['code'])) {
                $codeEqComp1 = $_POST['code'];
            } else {
                $codeEqComp1 = '';
            }
            inventoryClass::obtenerRepuestosCompatibles($codeEqComp1);
            break;
        case 'anadirRepEqComp':
            if(!empty($_POST['code'])) {
                $codeEqComp2 = $_POST['code'];
            } else {
                $codeEqComp2 = '';
            }
            if(!empty($_POST['newEqComp'])) {
                $newEqComp = $_POST['newEqComp'];
            } else {
                $newEqComp = '';
            }
            inventoryClass::addRepCompatible($codeEqComp2, $newEqComp);
            break;
        case 'removeRepEqComp':
            if(!empty($_POST['code'])) {
                $codeEqComp2 = $_POST['code'];
            } else {
                $codeEqComp2 = '';
            }
            if(!empty($_POST['quitEqComp'])) {
                $quitEqComp = $_POST['quitEqComp'];
            } else {
                $quitEqComp = '';
            }
            inventoryClass::removeRepCompatible($codeEqComp2, $quitEqComp);
            break;
        case 'obtenerOrdenesTotales':
            if(!empty($_POST['usuario'])) {
                $user = $_POST['usuario'];
            } else {
                $user = '';
            }
            inventoryClass::obtenerOrdenesDelUltimoMes($user);
            break;
        case 'addRepToOrder':
            if(!empty($_POST['user'])) {
                $user1 = $_POST['user'];
            } else  {
                $user1 = '';
            }
            if(!empty($_POST['orden'])) {
                $orden = $_POST['orden'];
            } else {
                $orden = '';
            }
            if(!empty($_POST['repuestos'])) {
                $repuestos = json_decode($_POST['repuestos']);
            } else {
                $repuestos = '';
            }
            if(!empty($_POST['tipoEstado'])) {
                $tStock3 = $_POST['tipoEstado'];
            } else {
                $tStock3 = '';
            }

            inventoryClass::addRepToOrder($user1,$orden, $tStock3, $repuestos);
            break;
        case 'quitRepToOrder':
            if(!empty($_POST['user'])) {
                $user3 = $_POST['user'];
            } else {
                $user3 = '';
            }
            if(!empty($_POST['orden'])) {
                $orden3 = $_POST['orden'];
            } else {
                $orden3 = '';
            }
            if(!empty($_POST['repuestos'])) {
                $repuestos1 = $_POST['repuestos'];
            } else {
                $repuestos1 = '';
            }
            if(!empty($_POST['tipoEstado'])) {
                $tStock5 = $_POST['tipoEstado'];
            } else {
                $tStock5 = '';
            }
            inventoryClass::quitRepToOrder($user3, $orden3, $repuestos1, $tStock5);
            break;
        case 'seeRepConsumed':
            if(!empty($_POST)) {
                $user2 = $_POST['user'];
            } else {
                $user2 = '';
            }
            if(!empty($_POST['orden'])) {
                $orden1 = $_POST['orden'];
            } else {
                $orden1 = '';
            }

            inventoryClass::seeRepConsumed($user2, $orden1);
            break;
        case 'addNewOrder':
            if(!empty($_POST['usuario'])) {
                $user4 = $_POST['usuario'];
            } else {
                $user4 = '';
            }
            if(!empty($_POST['nSerie'])) {
                $nSerie1 = $_POST['nSerie'];
            } else {
                $nSerie1 = '';
            }
            if(!empty($_POST['nEscuela'])) {
                $nEscuela1 = $_POST['nEscuela'];
            } else {
                $nEscuela1 = '';
            }
            if(!empty($_POST['tModelo'])) {
                $tModelo = $_POST['tModelo'];
            } else {
                $tModelo = '';
            }

            inventoryClass::addNewOrder($user4, $nEscuela1, $nSerie1, $tModelo);
            break;
        case 'confirmarReparacion':
            if(!empty($_POST['user'])) {
                $usuario2 = $_POST['user'];
            } else {
                $usuario2 = '';
            }
            if(!empty($_POST['orden'])) {
                $nOrden = $_POST['orden'];
            } else {
                $nOrden = '';
            }
            if(!empty($_POST['tipoFlasheo'])) {
                $tipoFlasheo = $_POST['tipoFlasheo'];
            } else {
                $tipoFlasheo = '';
            }
            inventoryClass::confirmarReparacion($usuario2, $nOrden, $tipoFlasheo);
            break;
        case 'filtrarOrdenesUsuario':
            if(!empty($_POST['usuario'])) {
                $user6 = $_POST['usuario'];
            } else {
                $user6 = '';
            }
            if(!empty($_POST['modelo'])) {
                $modelo1 = $_POST['modelo'];
            } else {
                $modelo1 = '';
            }
            if(!empty($_POST['serie'])) {
                $serie1 = $_POST['serie'];
            } else {
                $serie1 = '';
            }
            if(!empty($_POST['escuela'])) {
                $escuela1 = $_POST['escuela'];
            } else {
                $escuela1 = '';
            }

            inventoryClass::filtrarOrdenesUsuario($user6, $modelo1, $escuela1, $serie1);
            break;
        case 'eliminarOrden':
            $userOD = '';
            $ordenOD = '';
            if(!empty($_POST['user'])) {
                $userOD = $_POST['user'];
            }
            if(!empty($_POST['idOrden'])) {
                $ordenOD = $_POST['idOrden'];
            }

            inventoryClass::eliminarOrden($ordenOD, $userOD);
            break;
        case 'actualizarDatosOrden':
            $newSerie = '';
            $newEscuela = '';
            $newModelo = '';
            $idOrden1 = '';
            $userAD = '';

            if(!empty($_POST['newSerie'])) {
                $newSerie = $_POST['newSerie'];
            }
            if(!empty($_POST['newEscuela'])) {
                $newEscuela = $_POST['newEscuela'];
            }
            if(!empty($_POST['newModelo'])) {
                $newModelo = $_POST['newModelo'];
            }
            if(!empty($_POST['user'])) {
                $userAD = $_POST['user'];
            }
            if(!empty($_POST['idOrden'])) {
                $idOrden1 = $_POST['idOrden'];
            }

            inventoryClass::actualizarDatosOrden($userAD, $idOrden1, $newSerie, $newEscuela, $newModelo);
            break;
        case 'enviarOrdenPendiente':
            if(!empty($_POST['user'])) {
                $userOrdePendiente = $_POST['user'];
            } else {
                $userOrdePendiente = "";
            }
            if(!empty($_POST['idOrden'])) {
                $idOrdenPend = $_POST['idOrden'];
            } else {
                $idOrdenPend = "";
            }

            inventoryClass::enviarOrdenPendiente($userOrdePendiente, $idOrdenPend);
            break;
        case 'enviarADestruccionTotal':
            if(!empty($_POST['user'])) {
                $userOrdenDestru = $_POST['user'];
            } else {
                $userOrdenDestru = "";
            }
            if(!empty($_POST['idOrden'])) {
                $idOrdenDestru = $_POST['idOrden'];
            } else {
                $idOrdenDestru = "";
            }

            inventoryClass::enviarADestruccionTotal($userOrdenDestru, $idOrdenDestru);
            break;
        case 'addNewEquipo':
            if(!empty($_POST['newEquipo'])) {
                $newEquipo = $_POST['newEquipo'];
            } else {
                $newEquipo = '';
            }

            inventoryClass::addNewEquipo($newEquipo);
            break;
    }
}

class inventoryClass {

    public function __construct() {
    }
    
    public static function obtenerInventario($codigo, $modelo, $compatible, $tipoStock) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM SpareParts";
            $registroComp = "select * from spareparts";

            //Obtener id de un codigo especifico.
            if(!empty($codigo)) {
                $codeRepInv = $db->prepare("SELECT * FROM SpareParts where code = $codigo");
                $codeRepInv->execute([$codigo]);

                $countCode = $codeRepInv->rowCount();
                if($countCode > 0) {
                    $codeRepInv = $codeRepInv->fetch();
                    $idCodigo = $codeRepInv['id_code'];
                } else {
                    $codigo = '';
                }
            }
            if(empty($compatible)) {
                $registros .= " as sp inner join repuestos_estados as repE inner join tipoStock as ts on repE.id_repuesto=sp.id_code and repE.id_estado=ts.id_stock";
                //Filtros funcionales de a uno.
                if(!empty($codigo) && !empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where repE.id_repuesto = $idCodigo and sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($codigo) && !empty($modelo)) {
                    $registros .= " where repE.id_repuesto like $idCodigo and sp.id_equip = $modelo";
                } else if(!empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($codigo) && !empty($tipoStock)) {
                    $registros .= " where ts.id_stock = $tipoStock and repE.id_repuesto = $idCodigo";
                } else if(!empty($codigo)) {
                    $registros .= " where repE.id_repuesto like $idCodigo";
                } else if(!empty($tipoStock)) {
                    $registros .= " where ts.id_Stock = $tipoStock";
                } else if(!empty($modelo) && !empty($tipoStock)) {
                    $registros .= " where sp.id_equip = $modelo and ts.id_stock = $tipoStock";
                } else if(!empty($modelo)) {
                    $registros .= " where sp.id_equip = $modelo";
                }
                // Fin filtros   
                
                $registros = $db->prepare($registros);
    
                $registros->execute();
    
                $registros = $registros->fetchAll();
            }
            if(!empty($compatible)) {
                $registroComp = "select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq  on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo";
            
                if(!empty($codigo) && !empty($modelo)) {
                    $registroComp .= " where eqR.repuesto_id = $idCodigo and eqR.equipo_id = $modelo";
                } else if(!empty($codigo)) {
                    $registroComp .= " where eqR.repuesto_id = $idCodigo";
                } else if(!empty($modelo)) {
                    $registroComp .= " where eqR.equipo_id = $modelo";
                }
                $registroComp = $db->prepare($registroComp);
                $registroComp->execute();
                $registroComp = $registroComp->fetchAll();
            }
            $tabla = '<table class="table table-striped">
            <thead>
            <th>Código</th>
            <th>Nombre</th>';
            if(!empty($compatible)) {
                $tabla .= '<th>Compatible con</th>';
            } else {
                $tabla .= '
                <th>Cantidad</th>
                <th>Tipo de Stock</th>
                </thead><tbody>';
            }

            if(!empty($compatible)) {
                foreach($registroComp as $regComp) {
                    $tabla .= "<tr><td>".$regComp['code']."</td>
                    <td>".$regComp['name']."</td>
                    <td>".$regComp['nameEq']."</td>";
                }

                
                $tabla .= "</tr>";
            }

            if(empty($compatible)) {
                foreach($registros as $reg) {
                    $tabla .= "<tr><td>" . $reg['code'] . "</td>
                    <td>".$reg['name']."</td>
                    <td>".$reg['qty']."</td>
                    <td>".$reg['nameTipoStock']."</td></tr>";
                }
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientos($nombre_u, $fechaI, $fechaF, $codigo, $tipoMov, $tipoStoc) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM Movements WHERE nombre = ?";

            if(!empty($fechaI)) {
                $registros .= " AND date >= '".$fechaI."'";
            }
            if(!empty($fechaF)) {
                $registros .= " AND date <= '".$fechaF."'";
            }
            if(!empty($codigo)) {
                $registros .= " AND code LIKE ".$codigo;
            }
            if(!empty($tipoMov)) {
                $registros .= " AND move = '$tipoMov'";
            }
            if(!empty($tipoStoc)) {
                $registros .= " AND tipoStock = '$tipoStoc'";
            }

            $registros .= " order by fechaTotal desc";

            $registros = $db->prepare($registros);

            $registros->execute([$nombre_u]);

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Código</th>
            <th>Tipo de Stock</th>
            <th>Movimiento</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Hora</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr><td>'.$reg['code'].'</td>';
                $obtenerTipoStock = inventoryClass::obtenerUnTipoStock($reg['tipoStock']);
                foreach($obtenerTipoStock as $tipoStock) {
                    $tabla .= '<td>'.$tipoStock->nameTipoStock.'</td>';
                }
                $tabla .= '<td>'.$reg['move'].'</td>
                    <td>'.$reg['qty'].'</td>
                    <td>'.$reg['date'].'</td>
                    <td>'.$reg['hora'].'</td>
                    </tr>';
            }

            $tabla .= '</tbody></table>';
            echo $tabla;
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerMovimientosGenerales($nombre_u, $fechaI, $fechaF, $codigo, $tipoMov, $tipoStoc, $downloadTable) {
        try {
            $db = getDB();

            $registros = "SELECT * FROM Movements";

            if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u' and date <= '$fechaF'";
            } else if(!empty($fechaI) && !empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u' and date >= '$fechaI'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoMov) && !empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF) && !empty($fechaI) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and date >= '$fechaI'";
            } else if(!empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) && !empty($fechaF) && !empty($tipoStoc) && !empty(($nombre_u))) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($nombre_u) && !empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where nombre = '$nombre_u' and code like $codigo and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($tipoMov) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and move = '$tipoMov' and date >= '$fechaI'";
            } else if(!empty($codigo) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and code like $codigo";
            } else if(!empty($fechaI) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and date >= '$fechaI'";
            } else if(!empty($tipoMov) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and move = '$tipoMov'";
            } else if(!empty($tipoStoc) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and tipoStock = '$tipoStoc'";
            } else if(!empty($codigo) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " WHERE code LIKE $codigo and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($nombre_u) && !empty($fechaF) && !empty($fechaI)) {
                $registros .= " where date >= '".$fechaI."' and date <= '$fechaF' and nombre = '$nombre_u'";
            } else if(!empty($nombre_u) && !empty($tipoMov) && !empty($codigo)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and nombre = '$nombre_u'";
            } else if(!empty($fechaF) && !empty($codigo) && !empty($tipoMov)) {
                $registros .= " where code like $codigo and move = '$tipoMov' and date <= '$fechaF'";
            } else if(!empty($nombre_u) && !empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " WHERE nombre = '$nombre_u' and move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($nombre_u) && !empty($fechaI) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI) && !empty($fechaF)) {
                $registros .= " where date >= '$fechaI' and date <= '$fechaF'";
            } else if(!empty($tipoMov) && !empty($tipoStoc)) {
                $registros .= " where move = '$tipoMov' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) and !empty($codigo)) {
                $registros .= " where date >= '$fechaI' and code like $codigo";
            } else if (!empty($fechaI) && !empty($tipoMov)) {
                $registros .= " where date >= '$fechaI' and move = '$tipoMov'";
            } else if(!empty($fechaI) && !empty($tipoStoc)) {
                $registros .= " where date >= '$fechaI' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaI) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and date >= '$fechaI'";
            } else if (!empty($fechaF) && !empty($codigo)) {
                $registros .= " where date <= '$fechaF' and code like $codigo";
            } else if(!empty($fechaF) && !empty($tipoMov)) {
                $registros .= " where date <= '$fechaF' and move = '$tipoMov'";
            } else if(!empty($fechaF) && !empty($tipoStoc)) {
                $registros .= " where date <= '$fechaF' and tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF) && !empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u' and date <= '$fechaF'";
            } else if(!empty($codigo) && !empty($nombre_u)) {
                $registros .= " where code like $codigo and nombre = '$nombre_u'";
            } else if(!empty($tipoMov) && !empty($nombre_u)) {
                $registros .= " where move = '$tipoMov' and nombre = '$nombre_u'";
            } else if(!empty($tipoStoc) && !empty($nombre_u)) {
                $registros .= " where tipoStock = '$tipoStoc' and nombre = '$nombre_u'";
            } else if(!empty($fechaI)) {
                $registros .= " WHERE date >= '".$fechaI."'";
            } else if(!empty($codigo)) {
                $registros .= " WHERE code LIKE ".$codigo;
            } else if(!empty($tipoMov)) {
                $registros .= " WHERE move = '$tipoMov'";
            } else if(!empty($tipoStoc)) {
                $registros .= " WHERE tipoStock = '$tipoStoc'";
            } else if(!empty($fechaF)) {
                $registros .= " where date <= '$fechaF'";
            } else if(!empty($nombre_u)) {
                $registros .= " where nombre = '$nombre_u'";
            }

            $registros .= " order by fechaTotal desc";

            $registros = $db->prepare($registros);

            $registros->execute();

            $registros = $registros->fetchAll();

            $tabla = '<table class="table table-striped">
            <thead>
            <th>Usuario</th>
            <th>Código</th>
            <th>Tipo de Stock</th>
            <th>Movimiento</th>
            <th>Cantidad</th>
            <th>Fecha</th>
            <th>Hora</th>
            </thead><tbody>';
            foreach($registros as $reg) {
                $tabla .= '<tr><td>'.$reg['nombre'].'</td>
                <td>'.$reg['code'].'</td>';
                $obtenerTipoStock = inventoryClass::obtenerUnTipoStock($reg['tipoStock']);
                foreach($obtenerTipoStock as $tipoStock) {
                    $tabla .= '<td>'.$tipoStock->nameTipoStock.'</td>';
                }
                $tabla .= '<td>'.$reg['move'].'</td>
                    <td>'.$reg['qty'].'</td>
                    <td>'.$reg['date'].'</td>
                    <td>'.$reg['hora'].'</td>
                    </tr>';
            }

            $tabla .= '</tbody></table>';
            echo $tabla;

            if($downloadTable == 1) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
                $spreadsheet = $reader->loadFromString($tabla);
                
                $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
                $writer->save('write.xls'); 
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function obtenerRepuestosCompatibles($code) {
        $db = getDB();
        try {
            $idCode = inventoryClass::obtenerDatosCodigos($code);
            $dataGen = inventoryClass::obtenerDataCode($code);

            $stmt = $db->prepare("select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq  on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo where eqR.repuesto_id = ?");
            $stmt->execute([$idCode]);

            $obtenerEquipos = inventoryClass::obtenerEquipos();

            $obtenerEqCompNoAnadidos = inventoryClass::obtenerEquiposCompatiblesNoAnadidos($code);

            $count = $stmt->rowCount();
            if($count > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $datos = '<div class="row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <div class="row mb-5">
                        <div class="col-6 mb-3">
                            <label for="equipCompGest">Nombre del repuesto:</label>
                        </div>
                        <div class="col-6" id="eqRepComp">
                            <input type="text" class="form-control" value="'.$dataGen['name'].'" disabled/>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-6 mb-3">
                            <label for="listaEqComp">Equipos Compatibles:</label>
                        </div>
                        <div class="col-6 listaEqCompatibles" id="listaEqComp">
                            <div style="width: 200px; height: 200px; overflow-y: scroll;">
                                <ul>';
                                    foreach($data as $repComp) {
                                    $datos .= '<li>'.$repComp['nameEq'].'</li>';
                                    }

                                    $datos .= '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row col-9">
                        <div class="col-6 row mb-5" style="margin-left: 35px;">
                            <div class="col-12 mb-3">
                                <label for="equipCompGest" class="w-100 text-center" style="border-bottom: solid 1px green">Agregar</label>
                            </div>
                            <div class="col-12">
                                <div class="w-100" style="height: 150px;">
                                    <select name="" id="selectAddEqComp" size="4" class="w-100" style="border-radius: 10px;">
                                    <option disabled selected value="">Añadir</option>';
                                    foreach($obtenerEqCompNoAnadidos as $equiposs) {
                                        $datos .= '<option value="' . $equiposs->id_equipo . '">' . $equiposs->nameEq. '</option>';
                                    }
                                    $datos .= '</select>
                                </div>
                                <button type="button" class="btn btn-outline-success w-100 btnAddRepComp">Añadir</button>
                            </div>
                        </div>
                        <div class="col-6 row mb-5">
                            <div class="col-12 mb-3">
                                <label for="equipCompGest" class="w-100 text-center" style="border-bottom: solid 1px red">Quitar</label>
                            </div>
                            <div class="col-12">
                                <div class="w-100" style="height: 150px;">
                                    <select name="" id="selectRemoveEqComp" size="4" class="w-100" style="border-radius: 10px;">
                                    <option disabled selected value="">Quitar</option>';
                                    foreach($data as $repComp) {
                                        $datos .= '<option value="'.$repComp['id_equipo'].'">'.$repComp['nameEq'].'</option>';
                                    }
                                    $datos .= '</select>
                                </div>
                                <button type="button" class="btn btn-outline-danger w-100 btnQuitRepComp">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
                echo $datos;
            } else {
                echo json_encode(0);
            }
        } catch(PDOException $e) {
            echo '"error":{"text:"'. $e->getMessage().'}}';
        }
    }

    public static function addRepCompatible($code, $newEqComp) {
        $db = getDB();

        try {
            $idCode = inventoryClass::obtenerDatosCodigos($code);

            $consultIfExtists = $db->prepare("select * from equipos_repuestos where repuesto_id = ? and equipo_id = ?");

            $consultIfExtists->execute([$idCode, $newEqComp]);

            $countExists = $consultIfExtists->rowCount();

            if(!($countExists > 0)) {
                $stmt = $db->prepare("insert into equipos_repuestos (repuesto_id, equipo_id) values (?, ?)");

                $stmt->execute([$idCode, $newEqComp]);
    
    
                if($stmt) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
            } else {
                echo json_encode(2);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function removeRepCompatible($code, $newEqComp) {
        $db = getDB();

        try {
            $idCode = inventoryClass::obtenerDatosCodigos($code);

            $consultIfExtists = $db->prepare("select * from equipos_repuestos where repuesto_id = ? and equipo_id = ?");

            $consultIfExtists->execute([$idCode, $newEqComp]);

            $countExists = $consultIfExtists->rowCount();

            if (!($countExists > 0)) {
                echo json_encode(2);
            } else {
                $stmt = $db->prepare("delete from equipos_repuestos where repuesto_id = ? and equipo_id = ?");

                $stmt->execute([$idCode, $newEqComp]);

                if ($stmt) {
                    echo json_encode(1);
                } else {
                    echo json_encode(0);
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function filtrarOrdenesUsuario($user, $modelo, $nEscuela, $nSerie) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos where user_id = ?");
            $stmt->execute([$idUser]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $sql = "select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = $idUser";

                if(!empty($nEscuela) && !empty($nSerie) && !empty($modelo)) {
                    $sql .= " and oT.escuela = '$nEscuela' and oT.nOrden = '$nSerie' and odR.equipo_id = '$modelo'";
                } else if(!empty($nEscuela) && !empty($nSerie)) {
                    $sql .= " and oT.escuela = '$nEscuela' and oT.nOrden = '$nSerie'";
                } else if(!empty($nEscuela) && !empty($modelo)) {
                    $sql .= " and oT.escuela = '$nEscuela' and odR.equipo_id = '$modelo'";
                } else if(!empty($nSerie) && !empty($modelo)) {
                    $sql .= " and oT.nOrden = '$nSerie' and odR.equipo_id = '$modelo'";
                } else if(!empty($nSerie) && !empty($nEscuela)) {
                    $sql .= " and oT.nOrden = '$nSerie' and oT.escuela = '$nEscuela'";
                } else if(!empty($modelo)) {
                    $sql .= " and odR.equipo_id = '$modelo'";
                } else if(!empty($nEscuela)) {
                    $sql .= " and oT.escuela = '$nEscuela'";
                } else if(!empty($nSerie)) {
                    $sql .= " and oT.nOrden = '$nSerie'";
                }

                $sql .= " order by fechaTotal desc";
                $consult = $db->prepare($sql);

                $consult->execute();

                $countResul = $consult->rowCount();

                if($countResul > 0) {

                    $data = $consult->fetchAll(PDO::FETCH_OBJ);
                    $datos = '';
                    foreach($data as $row) {
                        $datos .= '<div class="list-group"><a href="orden.php?id_orden='.$row->id_order.'" class="list-group-item list-group-item mb-2" aria-current="true">
                        <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">'.$row->nOrden.'</h5>';
                        $fecha1 = strtotime($row->date);
                        $fecha2 = strtotime(date('Y-m-d'));

                        $diff = $fecha2 - $fecha1;

                        $dias = $diff/(60*60*24);
                        $datos .= '<small>Desde: '.floor($dias).' dias</small>';
                        $datos .= '</div>';
                        if($row->isFinished == 1) {
                            $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion Finalizada.</p>
                            <small>Ya no se puede editar.</small>';
                        } else if($row->isFinished == 2) {
                            $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion enviada como pendiente.</p>
                            <small>Ya no se puede editar.</small>';
                        } else if($row->isFinished == 3) {
                            $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Se envio el equipo a destrucción total.</p>
                            <small>Ya no se puede editar.</small>';
                        } else {
                            $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion En Proceso.</p>
                            <small>Aún se puede editar.</small>';
                        }
                    $datos .= '</div></a>';
                    }
                    $datos .= '';

                    echo $datos;
                } else {
                    echo '<h1 class="display-5">No se encontraron ordenes con los datos ingresados.</h1>';
                }
            } else {
                echo '<h1 class="display-5">No se encontraron ordenes con este usuario.</h1>';
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    public static function obtenerOrdenesDelUltimoMes($usuario) {
        $db = getDB();
        date_default_timezone_set("America/Buenos_Aires");

        try {
            $idUser = inventoryClass::obtenerIdUser($usuario);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? order by fechaTotal desc");
            $stmt->execute([$idUser]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_OBJ);

                $datos = '';
                foreach($data as $row) {
                    $datos .= '<div class="list-group"><a href="orden.php?id_orden='.$row->id_order.'" class="list-group-item list-group-item mb-2" aria-current="true">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">'.$row->nOrden.'</h5>';
                    $fecha1 = strtotime($row->date);
                    $fecha2 = strtotime(date('Y-m-d'));

                    $diff = $fecha2 - $fecha1;

                    $dias = $diff/(60*60*24);
                    $datos .= '<small>Desde: '.floor($dias).' dias</small>';
                    $datos .= '</div>';
                    if($row->isFinished == 1) {
                        $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion Finalizada.</p>
                        <small>Ya no se puede editar.</small>';
                    } else if($row->isFinished == 2) {
                        $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion enviada como pendiente.</p>
                        <small>Ya no se puede editar.</small>';
                    } else if($row->isFinished == 3) {
                        $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Se envio el equipo a destrucción total.</p>
                        <small>Ya no se puede editar.</small>';
                    } else {
                        $datos .= '<p class="mb-1">Escuela: '.$row->escuela.'. Reparacion En Proceso.</p>
                        <small>Aún se puede editar.</small>';
                    }
                  $datos .= '</div></a>';
                }
                $datos .= '';

                echo $datos;
            } else {
                echo '<h5>Aún no hay ordenes para visualizar.</h5>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addNewOrder($user, $escuela, $serie, $modelo) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $dataUser = $db->prepare("select * from Users where id_user = ?");
            $dataUser->execute([$idUser]);

            $countDataUser = $dataUser->rowCount();

            if($countDataUser > 0) {
                $obtDataU = $dataUser->fetch();

                if(!($obtDataU['targetProd'] != 0)) {
                    echo json_encode(3);
                } else {
                    $stmt = $db->prepare("select * from ordenesTotales where nOrden = '$serie' and escuela = '$escuela' and date = 'current_time()'");
                    $stmt->execute();
        
                    $count = $stmt->rowCount();
        
                    if(!($count > 0)) {
                        $consultRep = $db->prepare("select * from repuestos_estados where id_repuesto = ?");
                        $consultRep->execute([$modelo]);

                        $countRepModel = $consultRep->rowCount();

                        if($countRepModel > 0) {
                            date_default_timezone_set('America/Buenos_Aires');
        
                            $fecha = date('His');
                            $stmt1 = $db->prepare("INSERT into ordenesTotales (nOrden, usuario_id, escuela, date, hora, fechaTotal) values ('$serie', '$idUser', '$escuela', current_time(), $fecha, current_timestamp())");
            
                            $stmt1->execute();
            
                            if($stmt1) {
                                $getIdOrden = inventoryClass::obtenerIdOrdenTotal($serie, $idUser, $escuela);
            
                                if($getIdOrden != 0) {
                                    $addOrdenR = $db->prepare("INSERT into  ordenRepuestos(repuestos, user_id, orden_id, equipo_id, isFlash, isFlashCap, isFinished) values ('', '$idUser', '$getIdOrden', '$modelo', 0, 0, 0)");
            
                                    $addOrdenR->execute();
            
                                    if($addOrdenR) {
                                        echo json_encode(1);
                                    }
                                } else {
                                    echo json_encode(2);
                                }
                            }
                        } else {
                            echo json_encode(4);
                        }
                    } else {
                        echo json_encode(0);
                    }
                }
                
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function actualizarDatosOrden($user, $orden, $serie, $escuela, $modelo) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos where user_id = ? and id_order = ?");
            $stmt->execute([$idUser, $orden]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetch();
                if($data['repuestos'] != "") {
                    echo 'No puedes modificar una orden que tiene repuestos consumidos.';
                } else {
                    $stmt1 = $db->prepare("UPDATE ordenesTotales SET nOrden = ?, escuela = ? where id_orden = ?");
                    $stmt1->execute([$serie, $escuela, $data['orden_id']]);
    
                    $stmt2 = $db->prepare("UPDATE ordenRepuestos SET equipo_id = ? where id_order = ?");
                    $stmt2->execute([$modelo, $orden]);
    
                    if($stmt1 && $stmt2) {
                        echo "Se actualizaron los datos";
                    }
                }
            } else {
                echo "No se encuentra la orden";
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    public static function seeRepConsumed($usuario, $idOrden) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($usuario);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT inner join equipos as eq on odr.user_id = us.id_user and  odr.orden_id = oT.id_orden and odr.equipo_id = eq.id_equipo where odR.user_id = ? and id_order = ?");
            $stmt->execute([$idUser, $idOrden]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetch();

                
                $obtenerRepuestos = $db->prepare("select * from spareparts as sp inner join equipos_repuestos as eqR inner join equipos as eq  on eqR.repuesto_id=sp.id_code and eqR.equipo_id=eq.id_equipo where eqR.equipo_id = ?");
                $obtenerRepuestos->execute([$data['equipo_id']]);

                $countRepuestosEquipo = $obtenerRepuestos->rowCount();

                $obtenerEquipos = inventoryClass::obtenerEquipos();

                if($countRepuestosEquipo > 0) {
                    $dataOfRepEq = $obtenerRepuestos->fetchAll(PDO::FETCH_OBJ);
                    $datos = '<div class="row">
                    <div class="col-sm-7 row">
                        <div class="row datosOrden">
                            <div class="col-sm-4">
                                <p style="font-size: 22px;">Serie: </p>
                            </div>
                            <div class="col-sm-8 mb-4">
                                <p style="font-size: 20px;">'.$data['nOrden'].'</p>
                            </div>

                            <div class="col-sm-4 mb-4">
                                <p style="font-size: 22px;">Equipo: </p>
                            </div>
                            <div class="col-sm-8 mb-4">
                                <p style="font-size: 20px;">'.$data['nameEq'].'</p>
                            </div>

                            <div class="col-sm-4">
                                <p style="font-size: 22px;">Escuela: </p>
                            </div>
                            <div class="col-sm-8 mb-4">
                                <p style="font-size: 20px;">'.$data['escuela'].'</p>
                            </div>

                            <div class="col-sm-4 mb-4">
                                <label  style="font-size: 22px;">Repuesto: </label>
                            </div>
                            <div class="col-sm-4 mb-4">';
                            if($data['isFinished'] > 0) {
                                $datos .= '<select id="codigoRep" class="form-select nCodigo" disabled>
                                <option value="" selected>Repuestos</option>';
                                foreach($dataOfRepEq as $dOf) {
                                    $datos .= '<option value="'.$dOf->code.'">'.$dOf->name.'</option>';
                                }
                                $datos .= '</select>';
                            } else {
                                $datos .= '<select id="codigoRep" class="form-select nCodigo">
                                <option value="" selected>Repuestos</option>';
                                foreach($dataOfRepEq as $dOf) {
                                    $datos .= '<option value="'.$dOf->code.'">'.$dOf->name.'</option>';
                                }
                                $datos .= '</select>';
                            }

                            $datos .= '</div>
                            <div class="col-sm-2">';
                            if($data['isFinished'] > 0) {
                                $datos .= '<button class="btn btn-outline-success addCodeRep" disabled>Añadir</button>';
                            } else {
                                $datos .= '<button class="btn btn-outline-success addCodeRep">Añadir</button>';
                            }

                            $datos .= '</div>
                            <div class="col-sm-2">';
                            if($data['isFinished'] > 0) {
                                $datos .= '<button class="btn btn-outline-danger quitCodeRep"disabled>Quitar</button>';
                            } else {
                                $datos .= '<button class="btn btn-outline-danger quitCodeRep"">Quitar</button>';
                            }

                            $datos .= '</div>
                            <div class="col-sm-4 mb-4">
                                <label  style="font-size: 22px;">Tipo de stock: </label>
                            </div>
                            <div class="col-sm-4 mb-4">';

                                if($data['isFinished'] > 0) {
                                    $datos .= '<select class="form-select" aria-label="Default select example" id="selectTipoStock" disabled>
                                    <option value="" selected>Tipo</option>';
                                    $obtenerTipoStock = inventoryClass::obtenerTiposStock();
                                    foreach($obtenerTipoStock as $tStock) {
                                        $datos .= '<option value="'.$tStock->id_stock.'">'.$tStock->nameTipoStock.'</option>';
                                    }
                                $datos .= '</select>';
                                } else {
                                    $datos .= '<select class="form-select" aria-label="Default select example" id="selectTipoStock">
                                    <option value="" selected>Tipo</option>';
                                    $obtenerTipoStock = inventoryClass::obtenerTiposStock();
                                    foreach($obtenerTipoStock as $tStock) {
                                        $datos .= '<option value="'.$tStock->id_stock.'">'.$tStock->nameTipoStock.'</option>';
                                    }
                                $datos .= '</select>';
                                }
                                    
                            $datos .= '</div>
                            <div class="col-12 row mt-2 mb-2">
                            <div class="col-2"></div>
                            <div class="col-4">
                                <div class="form-check">';

                                if($data['isFinished'] > 0) {
                                    $datos .= '<input class="form-check-input flasheoId" style="font-size: 21px;" type="radio" value="Flash" name="flash" id="flasheoId" disabled>';
                                } else {
                                    $datos .= '<input class="form-check-input flasheoId" style="font-size: 21px;" type="radio" name="flash" value="Flash" id="flasheoId">';
                                }
                                
                                $datos .= '<label class="form-check-label" style="font-size: 21px;" for="flasheoId">
                                Flasheo
                                </label>
                            </div>
                            </div>
                            <div class="col-5">
                                <div class="form-check">';
                                if($data['isFinished'] > 0) {
                                    $datos .= '<input class="form-check-input" style="font-size: 21px;" type="radio" value="FlashCap" name="flash" id="flasheoCapitalId" disabled>';
                                } else {
                                    $datos .= '<input class="form-check-input" style="font-size: 21px;" type="radio" name="flash" value="FlashCap" id="flasheoCapitalId">';
                                }
                                
                                $datos .= '<label class="form-check-label" style="font-size: 21px;" for="flasheoCapitalId">
                                Flasheo Capital
                                </label>
                            </div>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="col-sm-12 listaRepConsumidos">
                            <div class="col-sm-12 row d-flex justify-content-center mb-5">';
                                if($data['isFinished'] > 0) {
                                    $datos .= '<button class="col-5 btn btn-outline-danger btnEliminarOrden" disabled>Eliminar Orden</button>
                                    <button type="button" class="col-5 btn btn-outline-primary btnEditarOrden" style="margin-left:5px;" data-bs-toggle="modal" data-bs-target="#modalEditarOrden" disabled>
                                    Editar Orden
                                    </button>';
                                } else {
                                    $datos .= '<button class="col-5 btn btn-outline-danger btnEliminarOrden">Eliminar Orden</button>
                                    <button type="button" class="col-5 btn btn-outline-primary btnEditarOrden" style="margin-left:5px;" data-bs-toggle="modal" data-bs-target="#modalEditarOrden">
                                    Editar Orden
                                    </button>';
                                }
                                    
                            $datos .= '</div>

                            <div class="col-sm-10 mb-2" style="border-bottom: solid 1px black;">
                                <p class="text-center" style="font-size: 20px;">Repuestos Consumidos</p>   
                            </div>
                            <div class="col-sm-10 repConsumidos" style="height: 150px; overflow-y: scroll;">';
                            $repuestos = $data['repuestos'];

                            $array = explode(',', $repuestos);
                            $lengthArr = count($array);
                            $datos .= '<ul>';
                            for($i = 0; $i < $lengthArr; $i++) {
                                $dataCode = inventoryClass::obtenerDataCodeWithId($array[$i]);
                                if($dataCode != 0) {
                                    $datos .= '<li>'.$dataCode['code'].' '.$dataCode['name'].'</li>';
                                } else {
                            $datos .= '<h5>Aún no se han consumido repuestos</h5>';
                                }
                            }
                            $datos .= '</ul></div>
                        </div>
                    </div><div class="col-8 mx-auto row" style="margin-left: 235px!important;">';
                
                    if($data['isFinished'] > 0) {
                        $datos .= '<button class="btn btn-outline-success col-3 btnConfirmarReparacion" disabled style="margin-right: 10px!important;">Confirmar Reparación</button><button class="btn btn-outline-danger col-3 btnEnviarPendiente" disabled style="margin-right: 10px!important;">Enviar Pendiente</button>
                        <button class="btn btn-outline-danger col-3 btnDestruccionTotal" disabled>Enviar a Destruccion Total</button>';
                    } else {
                        $datos .= '<button class="btn btn-outline-success col-3 btnConfirmarReparacion" style="margin-right: 10px!important;">Confirmar Reparación</button><button class="btn btn-outline-danger col-3 btnEnviarPendiente" style="margin-right: 10px!important;">Enviar Pendiente</button>
                        <button class="btn btn-outline-danger col-3 btnDestruccionTotal">Enviar a Destruccion Total</button>';
                    }
                    $datos .= '</div></div><!-- Modal -->
                    <div class="modal fade" id="modalEditarOrden" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Orden</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="col-12 row">
                                    <div class="col-5">
                                        <label for="newSerie" class="col-form-label">N° Serie</label>
                                    </div>
                                    <div class="col-7 mb-3">
                                        <input type="text" id="newSerie" class="form-control" value="'.$data['nOrden'].'">
                                    </div>
        
                                    <div class="col-5">
                                        <label for="newEscuela" class="col-form-label">N° Escuela</label>
                                    </div>
                                    <div class="col-7 mb-3">
                                        <input type="text" id="newEscuela" class="form-control" value="'.$data['escuela'].'">
                                    </div>

                                    <div class="col-5">
                                    <label for="newEquipo" class="col-form-label">Modelo</label>
                                    </div>
                                    <div class="col-7">
                                        <select id="selectNewEquipo" class="form-select">'; 
                                        foreach($obtenerEquipos as $equipo) {
                                        $datos .= '<option value="'.$equipo->id_equipo.'"';
                                        if($equipo->id_equipo == $data['id_equipo']) {
                                        $datos .= 'selected';
                                        }
                                        $datos .= '>'.$equipo->nameEq.'</option>';
                                        }
                                        $datos .= '</select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary btnEditarOrGuardar">Guardar Cambios</button>
                            </div>
                            </div>
                        </div>
                    </div><div class="modal fade" id="modalPendientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Pendientes</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-12 row">
                            <div class="col-5">
                                <label for="newSerie" class="col-form-label">N° Serie</label>
                            </div>
                            <div class="col-7 mb-3">
                                <input type="text" id="newSerie" class="form-control" value="'.$data['nOrden'].'" disabled />
                            </div>
        
                            <div class="col-5">
                                <label for="newEscuela" class="col-form-label">N° Escuela</label>
                            </div>
                            <div class="col-7 mb-3">
                                <input type="text" id="newEscuela" class="form-control" value="'.$data['escuela'].'" disabled />
                            </div>

                            <div class="col-5">
                                <label for="newEquipo" class="col-form-label">Modelo</label>
                            </div>
                            <div class="col-7 mb-3">
                                <select id="selectNewEquipo" class="form-select" disabled>'; 
                                foreach($obtenerEquipos as $equipo) {
                                $datos .= '<option value="'.$equipo->id_equipo.'"';
                                if($equipo->id_equipo == $data['id_equipo']) {
                                $datos .= 'selected';
                                }
                                $datos .= '>'.$equipo->nameEq.'</option>';
                                }
                                $datos .= '</select>
                            </div>

                            <div class="col-5">
                                <label for="repFaltante" class="col-form-label">Repuesto Faltante:</label>
                            </div>
                            <div class="col-7 mb-3">
                                <input type="text" id="repFaltante" class="form-control" placeholder="Ingresa el código del repuesto faltante." />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btnEditarOrGuardar">Enviar Pendiente</button>
                    </div>
                    </div>
                    </div>
                </div><div class="modal fade" id="modalDestruccionTotal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Destrucción total</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 row">
                        <div class="col-5">
                        <label for="newSerie" class="col-form-label">N° Serie</label>
                    </div>
                    <div class="col-7 mb-3">
                        <input type="text" id="newSerie" class="form-control" value="'.$data['nOrden'].'" disabled />
                    </div>

                    <div class="col-5">
                        <label for="newEscuela" class="col-form-label">N° Escuela</label>
                    </div>
                    <div class="col-7 mb-3">
                        <input type="text" id="newEscuela" class="form-control" value="'.$data['escuela'].'" disabled />
                    </div>

                    <div class="col-5">
                        <label for="newEquipo" class="col-form-label">Modelo</label>
                    </div>
                    <div class="col-7 mb-3">
                        <select id="selectNewEquipo" class="form-select" disabled>'; 
                        foreach($obtenerEquipos as $equipo) {
                        $datos .= '<option value="'.$equipo->id_equipo.'"';
                        if($equipo->id_equipo == $data['id_equipo']) {
                        $datos .= 'selected';
                        }
                        $datos .= '>'.$equipo->nameEq.'</option>';
                        }
                        $datos .= '</select>
                    </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary btnEditarOrGuardar">Enviar a destrucción total</button>
                    </div>
                    </div>
                </div>
            </div>';
                    echo $datos;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function quitRepToOrder($usuario, $idOrden, $repuestos, $tStock) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($usuario);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");
            $stmt->execute([$idUser, $idOrden]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $consultRep = $db->prepare("SELECT * FROM spareparts where code = ?");
                $consultRep->execute([$repuestos]);

                $countQuitRep = $consultRep->rowCount();
                $idCodigo = inventoryClass::obtenerDatosCodigos($repuestos);
                $validEstado = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? and id_estado = ?");
                $validEstado->execute([$idCodigo, $tStock]);
                $countEstado = $validEstado->rowCount();
                $cantidadTR = $validEstado->fetch(PDO::FETCH_OBJ);

                if($countQuitRep > 0) {
                    if($countEstado > 0) {
                        if($cantidadTR->qty >= 0) {
                            $datos = $stmt->fetch();
                            if($datos['repuestos'] != "") {
                                $idCodeQuit = inventoryClass::obtenerDatosCodigos($repuestos);
                                $array = explode(',', $datos['repuestos']);
                                
                                $codeElim = array_search($idCodeQuit, $array, true);
                                
                                if($codeElim !== false) {
                                    unset($array[$codeElim]);
            
                                    $textoRepuestos = implode(',', $array);
                                
                                    $stmt1 = $db->prepare("update ordenRepuestos set repuestos = ? where id_order = ?");
                                    $stmt1->execute([$textoRepuestos, $idOrden]);
                                    
                                    if($stmt1) {
                                    
                                        $stmt2 = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odr.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");
                                        $stmt2->execute([$idUser, $idOrden]);
                                    
                                        $dataNew = $stmt2->fetch();
                                    
                                        $datosArr = explode(',', $dataNew['repuestos']);
                                    
                                        $lengthArray = count($datosArr);
                                        if($lengthArray > 0) {
                                            $update = $db->prepare("UPDATE repuestos_estados SET qty = qty + 1 where id_repuesto = ? AND id_estado = ?");
                                            $update->execute([$idCodigo, $tStock]);
                                                                        
                                            date_default_timezone_set('America/Buenos_Aires');
            
                                            $fecha = date('His');
            
                                            if($update) {
                                                $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, tipoStock, date, hora, fechaTotal) VALUES('$usuario', '$repuestos', 'Entrada', 1, '$tStock', current_time(), $fecha, current_timestamp())");
                                                $movement->execute();
                                                            
                                                echo '<script>toastr.success("El código se ha devuelto correctamente.", "Consumo de repuestos");</script>'; 
                                            }
                                            $datos = '<ul>';
                                            for($i = 0; $i < $lengthArray; $i++) {
                                                $data = inventoryClass::obtenerDataCodeWithId($datosArr[$i]);
                                                if($data != 0) {
                                                    $datos .= '<li>'.$data['code'].' ' . $data['name'] . '</li>';
                                                } else {
                                                    echo '<h5>Aún no se han consumido repuestos.</h5>';
                                                }
                                            }
                                            $datos .= '</ul>';
                                            echo $datos;
                                        } else {
                                            echo '<h5>Aún no se han consumido repuestos</h5>';
                                        }
                                    } else {
                                        echo '<ul><li></li></ul>';
                                    }
                                } else {
                                    echo '<script>setTimeout(function(){
                                        location.reload();
                                    }, 1500);toastr.error("Aún no has consumido ese repuesto en esta orden :(.", "Consumo de repuestos");</script>'; 
                                } 
                            } else {
                                echo '<h5>Aún no se han consumido repuestos</h5>';
                            }
                            
                        } else {
                            echo '<script>toastr.success("No puedes devolver el repuesto, ya que su stock es -0.", "Consumo de repuestos");</script>';
                        }
                    } else {
                        echo '<script>setTimeout(function(){
                            location.reload();
                        }, 1500);toastr.error("No contamos con stock del repuesto en ese estado.", "Consumo de repuestos");</script>'; 
                    }
                } else {
                    echo '<script>setTimeout(function(){
                        location.reload();
                    }, 1500);toastr.success("El código que se ingreso no existe.", "Consumo de repuestos");</script>'; 
                }
            } else {
                echo '<h2>No existe esa orden</h2>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function enviarOrdenPendiente($user, $orden) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");

            $stmt->execute([$idUser, $orden]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetch();

                if($data['repuestos'] != "") {
                    echo json_encode(2);
                } else {
                    $stmt1 = $db->prepare("UPDATE ordenRepuestos SET isFinished = '2' WHERE (id_order = ?)");
                    $stmt1->execute([$orden]);
    
                    $countStm = $stmt1->rowCount();
    
                    if($countStm > 0) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function addNewEquipo($equipo) {
        $db = getDB();
        try {
            $stmt = $db->prepare("select * from equipos where nameEq = ?");
            $stmt->execute([$equipo]);

            $count = $stmt->rowCount();
            if($count > 0) {
                echo json_encode(0);
            } else {
                $equipo = strtoupper($equipo);
                $stmt1 = $db->prepare("insert into equipos (nameEq) values (?)");
                $stmt1->execute([$equipo]);
    
                if($stmt1) {
                    echo json_encode(1);
                }
            }
        } catch(PDOException $e) {

        }
    }

    public static function enviarADestruccionTotal($user, $idOrden) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");

            $stmt->execute([$idUser, $idOrden]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetch();

                if($data['repuestos'] != "") {
                    echo json_encode(2);
                } else {
                    $stmt1 = $db->prepare("UPDATE ordenRepuestos SET isFinished = '3' WHERE (id_order = ?)");
                    $stmt1->execute([$idOrden]);
    
                    $countStm = $stmt1->rowCount();
    
                    if($countStm > 0) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerTotalReparadasMesActualPorUsuario($user) {
        $db = getDB();

        try {
            $primerDiaMes = date("Y-m-01");
            $ultimoDiaMes = date("Y-m-t");
        
            $stmtCount = $db->prepare("select count(*) as total from planillaUsuario where usuario_id = ? and date >= '$primerDiaMes' and date <= '$ultimoDiaMes'");
            $stmtCount->execute([$user]);
            $dataPlan = $stmtCount->fetch();
            $total = $dataPlan['total'];

            return $total;
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    public static function calcularProductividadMensual($user) {
        $db = getDB();

        try {
            $dataUser = $db->prepare("select * from Users where id_user = ?");
            $dataUser->execute([$user]);

            $countUser = $dataUser->rowCount();
            if($countUser > 0) {
                $dataUserInfo = $dataUser->fetch();
                $promedioDiario = 0;
                $totalReparMensuales = 0;
                $totalPorcentajeHastaElMomento = 0;
                $primerDiaMes = date("Y-m-01");
                $ultimoDiaMes = date("Y-m-t");
                $reparadasAlMomento = inventoryClass::obtenerTotalReparadasMesActualPorUsuario($user);
                $stmt = $db->prepare("select count(distinct date) as total from planillaUsuario where usuario_id = ?  and date >= '$primerDiaMes' and date <= '$ultimoDiaMes'");
                $stmt->execute([$user]);
                $data = $stmt->fetch();
                $totalDiasTrabajados = $data['total'];
    
                $totalReparMensuales = $totalDiasTrabajados * $dataUserInfo['targetProd'];
                if($totalDiasTrabajados > 0) {
                    $promedioDiario = $reparadasAlMomento / $totalDiasTrabajados;
                    $totalPorcentajeHastaElMomento = $reparadasAlMomento * 100 / $totalReparMensuales;
                }
                $array = [
                    "promedioLastDay" => $promedioDiario,
                    "objetivoMensual" => $totalReparMensuales,
                    "totalPorcentaje" => $totalPorcentajeHastaElMomento
                ];
                return $array;
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    public static function addRepToOrder($usuario, $idOrden, $tStock, $repuestos) {
        $db = getDB();

        try {
            $idUser = inventoryClass::obtenerIdUser($usuario);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");
            $stmt->execute([$idUser, $idOrden]);

            $count = $stmt->rowCount();
            $data = $stmt->fetchAll(PDO::FETCH_OBJ);
            $dataRepBDD = "";
            foreach($data as $dat) {
                $dataRepBDD = $dat->repuestos;
            }

            $array = [];
            $textoRepuestos = "";
            if($count > 0) {

                $consultRep = $db->prepare("select * from SpareParts where code = ?");
                $consultRep->execute([$repuestos[0]]);

                $countRep = $consultRep->rowCount();

                if($countRep > 0) {
                    $idCodigo = inventoryClass::obtenerDatosCodigos($repuestos[0]);
                    $validEstado = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? and id_estado = ?");
                    $validEstado->execute([$idCodigo, $tStock]);
                    $countEstado = $validEstado->rowCount();

                    if($countEstado > 0) {
                        $cantidad = $validEstado->fetch(PDO::FETCH_OBJ);
                        if($cantidad->qty > 0) {
                            $update = $db->prepare("UPDATE repuestos_estados SET qty = qty - 1 where id_repuesto = ? AND id_estado = ?");
                            $update->execute([$idCodigo, $tStock]);
                            date_default_timezone_set('America/Buenos_Aires');

                            $fecha = date('His');
                            $movement = $db->prepare("INSERT INTO movements (nombre, code, move, qty, tipoStock, date, hora, fechaTotal) VALUES
                            ('$usuario', '$repuestos[0]', 'Salida', 1, '$tStock', current_time(), $fecha, current_timestamp())");
                            $movement->execute();

                            if($update && $movement) {
                                $lengthRep = count($repuestos);
                                for($i = 0; $i < $lengthRep; $i++) {
                                    $getId = inventoryClass::obtenerDatosCodigos($repuestos[$i]);
                                    array_push($array, $getId);
                                }
                                if($dataRepBDD != "") {
                                    $textoRepuestos = $dataRepBDD.",";
                                    $textoRepuestos .= implode(',', $array);
                                } else {
                                    $textoRepuestos .= implode(',', $array);
                                }
                
                                $stmt1 = $db->prepare("update ordenRepuestos set repuestos = ? where id_order = ?");
                                $stmt1->execute([$textoRepuestos, $idOrden]);
                
                                $array = explode(',', $textoRepuestos);
                                $lengthArr = count($array);
                
                                $datos = '<ul>';
                                for($i = 0; $i < $lengthArr; $i++) {
                                    $data = inventoryClass::obtenerDataCodeWithId($array[$i]);
                                    $datos .= '<li>'.$data['code'].' ' . $data['name'] . '</li>';
                                }
                                
                                $datos .= '</ul>';
                                echo $datos;

                                echo '<script>toastr.success("El repuesto se ha consumido correctamente.", "Consumo de repuestos");</script>';
                            }
                        } else {
                            echo '<script>setTimeout(function(){
                                location.reload();
                            }, 1500);toastr.error("No contamos con stock del repuesto en ese estado..", "Consumo de repuestos");</script>';
                        }
                    } else {
                        echo '<script>setTimeout(function(){
                            location.reload();
                        }, 1500);toastr.error("El repuesto no existe en ese estado.", "Consumo de repuestos");</script>';
                    }
                } else {
                    echo '<script>setTimeout(function(){
                        location.reload();
                    }, 1500);toastr.error("El código que ingresaste no existe.", "Consumo de repuestos");</script>';
                }
            } else {
                echo '<h2>No existe esa orden</h2>';
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerDataCodeWithId($id) {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where id_code = ?");
            $stmt->execute([$id]);

            $countCode = $stmt->rowCount();
            if($countCode > 0) {
                $stmt = $stmt->fetch();
                return $stmt;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public static function addNewRepuesto($code, $name, $equipo) {
        $db = getDB();

        try {
            $verify = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $verify->execute([$code]);

            $count = $verify->rowCount();

            if($count > 0) {
                echo json_encode(2);
            } else {
                $stmt = $db->prepare("INSERT INTO SpareParts (code, name, id_equip) VALUES (?, ?, ?)");
                $stmt->execute([$code, $name, $equipo]);
                if($stmt) {
                    $id = inventoryClass::obtenerDatosCodigos($code);
                    $stmt1 = $db->prepare("insert into equipos_repuestos (repuesto_id, equipo_id) values (?, ?)");
                    $stmt1->execute([$id, $equipo]);

                    if($stmt1) {
                        echo json_encode(1);
                    } else {
                        echo json_encode(0);
                    }
                } else {
                    echo json_encode(0);
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function reducirStock($code, $qty, $tipoStock) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $stmt->execute([$code]);

            $count = $stmt->rowCount();
            $resultData = $stmt->fetch();

            if($count > 0) {
                $stmt1 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                $stmt1->execute([$resultData['id_code'], $tipoStock]);

                $countRE = $stmt1->rowCount();

                if($countRE > 0) {
                    $stateRepAument = $stmt1->fetch();
                    if($stateRepAument['qty'] >= 0 && $stateRepAument['qty'] >= $qty) {
                        $stmt2 = $db->prepare("UPDATE repuestos_estados SET qty = qty - $qty WHERE id = ?");
                        $stmt2->execute([$stateRepAument['id']]);
                        echo json_encode(1);
                    } else {
                        echo json_encode(2);
                    }
                } else {
                    echo json_encode(3);
                }
            } else {
                echo json_encode(3);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function aumentarStock($code, $qty, $tipoStock) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts WHERE code = ?");
            $stmt->execute([$code]);

            $count = $stmt->rowCount();
            $resultData = $stmt->fetch();

            if($count > 0) {
                $stmt1 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                $stmt1->execute([$resultData['id_code'], $tipoStock]);

                $countRE = $stmt1->rowCount();

                if($countRE > 0) {
                    $stateRepAument = $stmt1->fetch();
                    $stmt2 = $db->prepare("UPDATE repuestos_estados SET qty = qty + $qty WHERE id = ?");
                    $stmt2->execute([$stateRepAument['id']]);
                    echo json_encode(1);
                } else {
                    $stmt3 = $db->prepare("INSERT INTO repuestos_estados (id_repuesto, id_estado, qty) VALUES (?, ?, 0)");
                    $stmt3->execute([$resultData['id_code'], $tipoStock]);

                    $stmt4 = $db->prepare("SELECT * FROM repuestos_estados WHERE id_repuesto = ? AND id_estado = ?");
                    $stmt4->execute([$resultData['id_code'], $tipoStock]);

                    $countRE1 = $stmt4->rowCount();

                    if($countRE1 > 0) {
                        $newStateRep = $stmt4->fetch();
                        $idRepEst = $newStateRep['id'];
                        $stmt5 = $db->prepare("UPDATE repuestos_estados SET qty = qty + $qty WHERE id = ?");
                        $stmt5->execute([$idRepEst]);

                        echo json_encode(2);
                    } else {
                        echo json_encode(0);
                    }
                }
            } else {
                echo json_encode(3);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function eliminarOrden($orden, $user) {
        $db = getDB();
        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos where id_order = ? and user_id = ?");
            $stmt->execute([$orden, $idUser]);
            $count = $stmt->rowCount();
            if($count > 0) {
                $data = $stmt->fetch();
                if(!$data['isFinished'] != 0) {
                    $ordenTId = $data['orden_id'];
                    if($data['repuestos'] != "") {
                        echo json_encode(2);
                    } else {
                        $stmt1 = $db->prepare("DELETE FROM ordenRepuestos where id_order = ? and user_id = ?");
                        $stmt1->execute([$orden, $idUser]);
    
                        if($stmt1) {
                            $stmt2 = $db->prepare("DELETE FROM ordenesTotales where id_orden = ?");
                            $stmt2->execute([$ordenTId]);
                            if($stmt2) {
                                echo json_encode(1);
                            } else {
                                echo json_encode(0);
                            }
                        } else {
                            echo json_encode(0);
                        }
                    }
                } else {
                    echo 'No puedes eliminar una orden que ya has finalizado.';
                }
            } else {
                echo 'No existe la orden que quieres eliminar';
            }
        } catch(PDOException $e) {
            $e->getMessage();
        }
    }

    public static function confirmarReparacion($user, $orden, $tipoFlasheo) {
        $db = getDB();
        try {
            $idUser = inventoryClass::obtenerIdUser($user);
            $stmt = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");

            $stmt->execute([$idUser, $orden]);

            $count = $stmt->rowCount();

            if($count > 0) {

                $obtainRepar = $db->prepare("select * from ordenRepuestos as odR inner join Users as us inner join ordenesTotales as oT on odR.user_id = us.id_user and odR.orden_id = oT.id_orden where odR.user_id = ? and id_order = ?");
                $obtainRepar->execute([$idUser, $orden]);

                $countResults = $obtainRepar->rowCount();

                if($countResults > 0 ) {
                    $dataRepar = $obtainRepar->fetch();
    
                    $nOrden = $dataRepar['nOrden'];
                    $nEscuela = $dataRepar['escuela'];
                    $repuestos = $dataRepar['repuestos'];
                    date_default_timezone_set('America/Buenos_Aires');
                    $fecha = date('His');
                    if($tipoFlasheo == "Flash") {
                        $flasheoCap = 0;
                        $flasheo = 1;
                    } else if($tipoFlasheo == "FlashCap") {
                        $flasheoCap = 1;
                        $flasheo = 0;
                    } else if($tipoFlasheo == "") {
                        $flasheoCap = 0;
                        $flasheo = 0;
                    }
    
                    if(empty(trim($repuestos)) && empty($tipoFlasheo)) {
                        echo json_encode(2);
                    } else {
                        $stmt1 = $db->prepare("UPDATE ordenRepuestos SET isFinished = '1' WHERE (id_order = ?)");
                        $stmt1->execute([$orden]);
                        if($stmt1) {
                            $stmt2 = $db->prepare("INSERT into planillaUsuario (usuario_id, escuela, serie, repuesto_id, isFlasheo, isFlasheoCap, date, hora, fechaTotal) values ('$idUser', '$nEscuela', '$nOrden', '$repuestos', '$flasheo', '$flasheoCap', current_time(), $fecha, current_timestamp())");
                            $stmt2->execute();
                            if($stmt2) {
                                echo json_encode(1);
                            } else {
                                echo json_encode(3);
                            }
                        }
                    }
                } else {
                    echo json_encode(5);
                }
                
            } else {
                echo json_encode(6);
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUnEquipo($id) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM equipos where id_equipo = ?");
            $stmt->execute([$id]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataEquipos = $stmt->fetch();

                return $dataEquipos;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerUnTipoStock($id) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM tipostock where id_stock = ?");
            $stmt->execute([$id]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataTipoStock = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataTipoStock;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerOrdenesT($nSerie) {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM ordenesTotales");
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataOrdenes = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataOrdenes;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerIdOrdenTotal($serie, $user, $escuela) {
        $db = getDB();

        try {
            $stmt = $db->prepare("select * from ordenesTotales where nOrden = ? and usuario_id = ? and escuela = ?");
            $stmt->execute([$serie, $user, $escuela]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $data = $stmt->fetch();
                $id = $data['id_orden'];
                return $id;
            } else {
                return 0;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerEquipos() {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM equipos");
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataEquipos = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataEquipos;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerTiposStock() {
        $db = getDB();
        try {
            $stmt = $db->prepare("SELECT * FROM tipostock");
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0) {
                $dataTipoStock = $stmt->fetchAll(PDO::FETCH_OBJ);

                return $dataTipoStock;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerDatosCodigos($code)
    {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where code = ?");
            $stmt->execute([$code]);

            $countCode = $stmt->rowCount();
            if($countCode > 0) {
                $stmt = $stmt->fetch();
                $idCodigo = $stmt['id_code'];
                return $idCodigo;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerEquiposCompatiblesNoAnadidos($code) {
        $db = getDB();

        try {
            $id = inventoryClass::obtenerDatosCodigos($code);
            $stmt = $db->prepare("select * from equipos where id_equipo not in (select equipo_id from equipos_repuestos where repuesto_id = '$id')");

            $stmt->execute();

            $datos = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $datos;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerDataCode($code) {
        $db = getDB();

        try {
            $stmt = $db->prepare("SELECT * FROM SpareParts where code = ?");
            $stmt->execute([$code]);

            $countCode = $stmt->rowCount();
            if($countCode > 0) {
                $stmt = $stmt->fetch();
                return $stmt;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public static function obtenerIdUser($user) {
        $db = getDB();

        try {
            $stmt = $db->prepare("select * from Users where nombre_u = ?");
            $stmt->execute([$user]);

            $count = $stmt->rowCount();

            if($count > 0) {
                $stmt = $stmt->fetch();

                $idUser = $stmt['id_user'];

                return $idUser;
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
        
}

?>