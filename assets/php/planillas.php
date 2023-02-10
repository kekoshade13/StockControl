<?php
require "../../vendor/autoload.php";
require_once('connection.php');
require_once('inventoryClass.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



try {
    $db = getDB();

    if(!empty($_GET['usuario'])) {
        $usuario = $_GET['usuario'];
    }

    if(!empty($_GET['fechaI'])) {
        $fechaI = $_GET['fechaI'];
    } else {
        $fechaI = "";
    }
    if(!empty($_GET['fechaF'])) {
        $fechaF = $_GET['fechaF'];
    } else {
        $fechaF = "";
    }

    $idUser = inventoryClass::obtenerIdUser($usuario);
    $sql = "select * from planillaUsuario where usuario_id = $idUser";

    if($fechaI != "" && $fechaF != "") {
        $sql .= " and date >= '$fechaI' and date <= '$fechaF'";
    } else if($fechaI != "") {
        $sql .= " and date >= '$fechaI'";
    } else if($fechaF != "") {
        $sql .= " and date <= '$fechaF'";
    }
    $stmt = $db->prepare($sql);
    $stmt->execute();

        $data = $stmt->fetchAll(PDO::FETCH_OBJ);
        $spreadsheet = new Spreadsheet();
        $spreadsheet
            ->getProperties()
            ->setCreator("Creado por José Paz")
            ->setLastModifiedBy('José Paz')
            ->setTitle('Planilla de reparaciones')
            ->setDescription('Archivo generado automaticamente');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Planilla de reparaciones");

        $sheet->setCellValue('A1', 'Usuario');
        $sheet->getStyle('A1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->setCellValue('B1', 'Escuela');
        $sheet->getStyle('B1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->setCellValue('C1', 'Serie');
        $sheet->getStyle('C1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->setCellValue('D1', 'Repuestos');
        $sheet->getStyle('D1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->setCellValue('E1', 'Flasheo');
        $sheet->getStyle('E1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->setCellValue('F1', 'Flasheo Capital');
        $sheet->getStyle('F1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB('C4DE9F');
        $sheet->getColumnDimension('F')->setWidth(25);



        $numeroFila = 2;
        $numeroDeRep = 0;
        $array = [];
        foreach($data as $row) {

            $array = explode(',', $row->repuesto_id);
            $repuestos = [];
            $lengthArr = count($array);
            for ($i = 0; $i < $lengthArr; $i++) {
                if($row->repuesto_id == "") {
                    array_push($repuestos, "No se consumieron repuestos.");
                } else {
                    $infoRep = inventoryClass::obtenerDataCodeWithId($array[$i]);
                    array_push($repuestos, $infoRep['name']);
                }
            }

            $sheet->setCellValueByColumnAndRow(1, $numeroFila, $usuario);
            $sheet->setCellValueByColumnAndRow(2, $numeroFila, $row->escuela);
            $sheet->setCellValueByColumnAndRow(3, $numeroFila, $row->serie);

            //Flasheos
            if($row->isFlasheo == "0") {
                $sheet->setCellValueByColumnAndRow(5, $numeroFila, "No");
            } else if($row->isFlasheo == "1") {
                $sheet->setCellValueByColumnAndRow(5, $numeroFila, "Si");
            }
            if($row->isFlasheoCap == "0") {
                $sheet->setCellValueByColumnAndRow(6, $numeroFila, "No");
            } else if($row->isFlasheoCap == "1") {
                $sheet->setCellValueByColumnAndRow(6, $numeroFila, "Si");
            }
            //Fin Flasheos
            foreach($repuestos as $rep) {
                $sheet->setCellValueByColumnAndRow(4, $numeroFila, $rep);
                $sheet->getStyle('A1')->getAlignment()->setWrapText(true);
                $numeroFila++;
            }
            $numeroFila++;
        }
        $fileName="planillaReparaciones.xlsx";
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
        exit();
} catch(PDOException $e) {
    echo $e->getMessage();
}
?>