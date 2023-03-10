<?php

require "../../vendor/autoload.php";
require_once('connection.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = getDB();
try {
        $documento = new Spreadsheet();
        $documento
            ->getProperties()
            ->setCreator("Creado por José Paz")
            ->setLastModifiedBy('José Paz')
            ->setTitle('Consumo De Repuestos Detallado')
            ->setDescription('Archivo generado automaticamente');
        
        $hojaDeProductos = $documento->getActiveSheet();
        $hojaDeProductos->setTitle("Consumo");
        
        $encabezado = ["Salida"];
        $hojaDeProductos->fromArray($encabezado, null, 'A1');
        $encabezado1 = ["Código del repuesto", "Cantidad"];
        $hojaDeProductos->fromArray($encabezado1, null, 'A2');

        $encabezadoEntrada = ['Entrada'];
        $hojaDeProductos->fromArray($encabezadoEntrada, null, 'D1');
        $encabezadoEntrada1 = ['Código del repuesto', 'Cantidad'];
        $hojaDeProductos->fromArray($encabezadoEntrada1, null, 'D2');


        $cabezaTilo = ['Consumo de Tilo'];
        $hojaDeProductos->fromArray($cabezaTilo, null, 'G1');
        $cabezaTilo2 = ['Repuesto', 'Cantidad'];
        $hojaDeProductos->fromArray($cabezaTilo2, null, 'G2');


        $nombre = $_POST['select_usuario'];
        if(!empty($_POST['fechaIn'])) {
            $fechaIni = $_POST['fechaIn'];
        } else {
            $fechaIni = "";
        }

        if(!empty($_POST['fechaFn'])) {
            $fechaFin = $_POST['fechaFn'];
        } else {
            $fechaFin = "";
        }
        $sql = "select distinct code, count(qty) as cantidad from Movements where nombre ='$nombre'";

        if($fechaIni != "" && $fechaFin != "") {
            $sql .= " and date >= '$fechaIni' and date <= '$fechaFin'";
        } else if($fechaIni != "") {
            $sql .= " and date >= '$fechaIni'";
        } else if($fechaFin != "") {
            $sql .= " and date <= '$fechaFin'";
        }

        $sql .= " and move = 'Salida' group by code order by code asc";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        $numeroDeFila = 3;
        while($res = $stmt->fetch(PDO::FETCH_OBJ)) {
            $hojaDeProductos->setCellValueByColumnAndRow(1, $numeroDeFila, $res->code);
            $hojaDeProductos->setCellValueByColumnAndRow(2, $numeroDeFila, $res->cantidad);
            $numeroDeFila++;
        }

        $sql1 = "select distinct code, count(qty) as cantidad from Movements where nombre ='$nombre'";

        if($fechaIni != "" && $fechaFin != "") {
            $sql1 .= " and date >= '$fechaIni' and date <= '$fechaFin'";
        } else if($fechaIni != "") {
            $sql1 .= " and date >= '$fechaIni'";
        } else if($fechaFin != "") {
            $sql1 .= " and date <= '$fechaFin'";
        }

        $sql1 .= " and move = 'Entrada' group by code order by code asc";

        $stmt1 = $db->prepare($sql1);
        $stmt1->execute();

        $numeroDeFila1 = 3;
        while($res1 = $stmt1->fetch(PDO::FETCH_OBJ)) {
            $hojaDeProductos->setCellValueByColumnAndRow(4, $numeroDeFila1, $res1->cantidad);
            $hojaDeProductos->setCellValueByColumnAndRow(5, $numeroDeFila1, $res1->code);
            $numeroDeFila1++;
        }

        $sqlTilo = "select distinct CodRep, sum(qty) as Cantidad
        from SpendingTiloReps
        where usu ='$nombre'
        group by CodRep
        order by CodRep asc";

        $stmt2 = $db->prepare($sqlTilo);
        $stmt2->execute();

        $numeroDeFila2 = 3;
        while($res2 = $stmt2->fetch(PDO::FETCH_OBJ)) {
            $hojaDeProductos->setCellValueByColumnAndRow(7, $numeroDeFila2, $res2->CodRep);
            $hojaDeProductos->setCellValueByColumnAndRow(8, $numeroDeFila2, $res2->Cantidad);
            $numeroDeFila2++;
        }


        $fileName="consumoSalidaYEntradaStock.xlsx";
        $writer = new Xlsx($documento);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        exit();
} catch(PDOException $e) {
    echo '"error":{"text:"'. $e->getMessage().'}}';
}

?>

