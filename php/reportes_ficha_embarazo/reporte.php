<?php
session_start();   
include "../funtions.php";
	
//CONEXION A DB
$mysqli = connect_mysqli(); 

//ajuntar la libreria excel
include "../../PHPExcel/Classes/PHPExcel.php";

$desde = $_GET['desde'];
$hasta = $_GET['hasta'];
$dato = $_GET['dato'];
$colaborador = $_GET['colaborador'];
$usuario = $_SESSION['colaborador_id'];	

$mes=nombremes(date("m", strtotime($desde)));
$mes1=nombremes(date("m", strtotime($hasta)));
$año=date("Y", strtotime($desde));
$año2=date("Y", strtotime($hasta));

if($colaborador != ""){
	$where = "WHERE am.fecha BETWEEN '$desde' AND '$hasta' AND c.colaborador_id = '$profesional' AND am.estado = 1";
}else if($dato != ""){
	$where = "WHERE CONCAT(p.nombre,' ',p.apellido) LIKE '%$dato%' OR p.apellido LIKE '$dato%' OR p.identidad LIKE '$dato%' AND am.estado = 1";
}else{
	$where = "WHERE am.fecha BETWEEN '$desde' AND '$hasta' AND am.estado = 1";
}

//EJECUTAMOS LA CONSULTA DE BUSQUEDA

$registro = "SELECT am.*, p.identidad AS 'identidad', CONCAT(p.apellido, ' ', p.nombre) AS 'usuario', CONCAT(c.apellido, ' ', c.nombre) AS 'profesional', s.nombre AS 'servicio',
(CASE WHEN p.genero = 'H' THEN 'X' ELSE '' END) AS 'h',
(CASE WHEN p.genero = 'M' THEN 'X' ELSE '' END) AS 'm',
(CASE WHEN am.paciente = 'N' THEN 'X' ELSE '' END) AS 'n',
(CASE WHEN am.paciente = 'S' THEN 'X' ELSE '' END) AS 's', d.nombre AS 'departamento', m.nombre AS 'municipio', p.localidad AS 'localidad'
FROM embarazo AS am
INNER JOIN pacientes AS p
ON am.pacientes_id = p.pacientes_id
INNER JOIN colaboradores AS c
ON am.colaborador_id = c.colaborador_id
INNER JOIN servicios AS s
ON am.servicio_id = s.servicio_id
INNER JOIN departamentos AS d
ON p.departamento_id = d.departamento_id
INNER JOIN municipios AS m
  ON p.municipio_id = m.municipio_id
".$where."
  ORDER BY am.fecha DESC";

$result = $mysqli->query($registro);

//OBTENER NOMBRE DE EMPRESA
$query_empresa = "SELECT e.nombre AS 'empresa'
FROM users AS u
INNER JOIN empresa AS e
ON u.empresa_id = e.empresa_id
WHERE u.colaborador_id = '$usuario'";
$result_empresa = $mysqli->query($query_empresa) or die($mysqli->error);;
$consulta_empresa = $result_empresa->fetch_assoc();

$empresa_nombre = '';

if($result_empresa->num_rows>0){
   $empresa_nombre = $consulta_empresa['empresa'];	
}  
 
$objPHPExcel = new PHPExcel(); //nueva instancia
 
$objPHPExcel->getProperties()->setCreator("ING. EDWIN VELASQUEZ"); //autor
$objPHPExcel->getProperties()->setTitle("Reporte Atenciones"); //titulo
 
//inicio estilos
$titulo = new PHPExcel_Style(); //nuevo estilo
$titulo->applyFromArray(
  array('alignment' => array( //alineacion
      'wrap' => false,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'font' => array( //fuente
      'bold' => true,
      'size' => 12
    )
));
 
$subtitulo = new PHPExcel_Style(); //nuevo estilo
 
$subtitulo->applyFromArray(
  array('font' => array( //fuente
      'arial' => true,
	  'bold' => true,
      'size' => 11
    ),	
	'alignment' => array( //alineacion
      'wrap' => true,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),'fill' => array( //relleno de color
      'type' => PHPExcel_Style_Fill::FILL_SOLID,
      'color' => array('rgb' => 'bfbfbf')
    ),
	'borders' => array( //bordes
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    )
));

$texto = new PHPExcel_Style(); //nuevo estilo
$texto->applyFromArray(
  array('alignment' => array( //alineacion
      'wrap' => false,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'font' => array( //fuente
      'bold' => true,
      'size' => 10
    ),
	'borders' => array( //bordes
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    )
));
 
$other = new PHPExcel_Style(); //nuevo estilo
$other->applyFromArray(
  array('alignment' => array( //alineacion
      'wrap' => false,
      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
    ),
    'font' => array( //fuente
      'bold' => true,
      'size' => 10
    )
));

$bordes = new PHPExcel_Style(); //nuevo estilo
 
$bordes->applyFromArray(
  array('borders' => array(
      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
    ),
	'alignment' => array( //alineacion
      'wrap' => true
    ),
));

//fin estilos
 
$objPHPExcel->createSheet(0); //crear hoja
$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora
$objPHPExcel->getActiveSheet()->setTitle("Reporte Atenciones Embarazo"); //establecer titulo de hoja
 
//orientacion hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
 
//tipo papel
$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LETTER);
$objPHPExcel->getActiveSheet()->freezePane('E6'); //INMOVILIZA PANELES
//establecer impresion a pagina completa
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
//fin: establecer impresion a pagina completa
 
//establecer margenes
$margin = 0.5 / 2.54; // 0.5 centimetros
$marginBottom = 1.2 / 2.54; //1.2 centimetros
$objPHPExcel->getActiveSheet()->getPageMargins()->setTop($margin);
$objPHPExcel->getActiveSheet()->getPageMargins()->setBottom($marginBottom);
$objPHPExcel->getActiveSheet()->getPageMargins()->setLeft($margin);
$objPHPExcel->getActiveSheet()->getPageMargins()->setRight($margin);

//incluir imagen
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setPath('../../img/logo.png'); //ruta
$objDrawing->setWidth(200); //Ancho
$objDrawing->setHeight(60); //Alto
$objDrawing->setCoordinates('A1');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet()); //incluir la imagen
//establecer titulos de impresion en cada hoja
$objPHPExcel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 5);
 
$fila=1;
$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A3:AX3");
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $empresa_nombre);
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:AX$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:AX$fila");

$fila=2;
$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A4:AX4");
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Reporte de Atenciones Embarazo");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:AX$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:AX$fila");

$fila=3;
$objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A5:AX5");
$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", "Desde: $mes $año Hasta: $mes1 $año2");
$objPHPExcel->getActiveSheet()->mergeCells("A$fila:AX$fila"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($titulo, "A$fila:AX$fila");

$fila=4;

$objPHPExcel->getActiveSheet()->SetCellValue("A$fila", 'N°');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5); 
$objPHPExcel->getActiveSheet()->mergeCells("A4:A5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("B$fila", 'Fecha');
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(13);
$objPHPExcel->getActiveSheet()->mergeCells("B4:B5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("C$fila", 'Nombre del Paciente');
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45); 
$objPHPExcel->getActiveSheet()->mergeCells("C4:C5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("D$fila", 'Identidad');
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
$objPHPExcel->getActiveSheet()->mergeCells("D4:D5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'Genero');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(8);
$objPHPExcel->getActiveSheet()->mergeCells("E4:F4"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'Paciente');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(22);
$objPHPExcel->getActiveSheet()->mergeCells("G4:H4"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'Procedencia');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(70);
$objPHPExcel->getActiveSheet()->mergeCells("I4:K4"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("L$fila", 'Edad');
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
$objPHPExcel->getActiveSheet()->mergeCells("L4:L5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("M$fila", 'HGO');
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("M4:M5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("N$fila", 'G');
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("N4:N5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("O$fila", 'P');
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("O4:O5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("P$fila", 'C');
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("P4:P5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", 'A');
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("Q4:Q5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("R$fila", 'OB');
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("R4:R5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("S$fila", 'HV');
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("S4:S5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("T$fila", 'HM');
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("T4:T5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("U$fila", 'FUP');
$objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("U4:U5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("V$fila", 'Complicaciones');
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("V4:V5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("W$fila", 'FUM');
$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("W4:W5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("X$fila", 'EG por FUM');
$objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("X4:X5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", 'FPP');
$objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("Y4:Y5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("Z$fila", 'EG por USG');
$objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("Z4:Z5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", 'Ultrasonido');
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(30);
$objPHPExcel->getActiveSheet()->mergeCells("AA4:AA5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AB$fila", 'Último Citología');
$objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AB4:AB5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", 'Tipo y RH');
$objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AC4:AC5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AD$fila", 'VDRL');
$objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AD4:AD5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AE$fila", 'Antecedentes Patológicos Personales');
$objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AE4:AE5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AF$fila", 'Antecedentes Patológicos Familiares');
$objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AF4:AF5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AG$fila", 'Antecedentes Inmuno-alergicos');
$objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AG4:AG5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AH$fila", 'Antecedentes Quirurgicos');
$objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AH4:AH5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AI$fila", 'Vacunas');
$objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AI4:AI5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AJ$fila", 'VPH');
$objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AJ4:AJ5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AK$fila", 'Otros');
$objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AK4:AK5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AL$fila", 'HEA');
$objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AL4:AL5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AM$fila", 'PEA');
$objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AM4:AM5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AN$fila", 'Peso');
$objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AN4:AN5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AO$fila", 'Talla');
$objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AO4:AO5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AP$fila", 'AFU');
$objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AP4:AP5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AQ$fila", 'FCF');
$objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AQ4:AQ5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AR$fila", 'MF');
$objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AR4:AR5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AS$fila", 'Presentación');
$objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(40);
$objPHPExcel->getActiveSheet()->mergeCells("AS4:AS5"); //unir celdas

$objPHPExcel->getActiveSheet()->SetCellValue("AT$fila", 'GO');
$objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AT4:AT5"); //unir celdas

$objPHPExcel->getActiveSheet()->SetCellValue("AU$fila", 'Ultrasonido');
$objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AU4:AU5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AV$fila", 'DX');
$objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AV4:AV5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AW$fila", 'TX');
$objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AW4:AW5"); //unir celdas
$objPHPExcel->getActiveSheet()->SetCellValue("AX$fila", 'Atención');
$objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(20);
$objPHPExcel->getActiveSheet()->mergeCells("AX4:AX5"); //unir celdas
$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:AX$fila"); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle("A$fila:AX$fila")->getFont()->setBold(true); //negrita

$fila=5;
$objPHPExcel->getActiveSheet()->SetCellValue("E$fila", 'H');
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(4);
$objPHPExcel->getActiveSheet()->SetCellValue("F$fila", 'M');
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(4);
$objPHPExcel->getActiveSheet()->SetCellValue("G$fila", 'Nuevo');
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(8);
$objPHPExcel->getActiveSheet()->SetCellValue("H$fila", 'Subsiguiente');
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(14);
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'Departamento');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(4);
$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'Municipio');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(4);
$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'Localidad');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(4);
$objPHPExcel->getActiveSheet()->SetCellValue("I$fila", 'Departamento');
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue("J$fila", 'Municipio');
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
$objPHPExcel->getActiveSheet()->SetCellValue("K$fila", 'Localidad');
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);

$objPHPExcel->getActiveSheet()->setSharedStyle($subtitulo, "A$fila:AX$fila"); //establecer estilo
$objPHPExcel->getActiveSheet()->getStyle("A$fila:AX$fila")->getFont()->setBold(true); //negrita
 
//rellenar con contenido
$valor = 1;
if($result->num_rows>0){
	while($registro2 = $result->fetch_assoc()){
	   $fila+=1;
	   $objPHPExcel->getActiveSheet()->SetCellValue("A$fila", $valor);
       $objPHPExcel->getActiveSheet()->SetCellValue("B$fila", $registro2['fecha']);
       $objPHPExcel->getActiveSheet()->SetCellValue("C$fila", $registro2['usuario']);
	   
	   if( strlen($registro2['identidad'])<10 ){
		   $objPHPExcel->getActiveSheet()->setCellValueExplicit("D$fila", 'No porta identidad', PHPExcel_Cell_DataType::TYPE_STRING);		   
	   }else{
		   $objPHPExcel->getActiveSheet()->setCellValueExplicit("D$fila", $registro2['identidad'], PHPExcel_Cell_DataType::TYPE_STRING);
	   }
	          
	   $objPHPExcel->getActiveSheet()->SetCellValue("E$fila", $registro2['h']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("F$fila", $registro2['m']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("G$fila", $registro2['n']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("H$fila", $registro2['s']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("I$fila", $registro2['departamento']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("J$fila", $registro2['municipio']);
	   $objPHPExcel->getActiveSheet()->SetCellValue("K$fila", $registro2['localidad']);
     $objPHPExcel->getActiveSheet()->SetCellValue("L$fila", $registro2['edad']);

     $objPHPExcel->getActiveSheet()->SetCellValue("M$fila", $registro2['hgo_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("N$fila", $registro2['g_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("O$fila", $registro2['p_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("P$fila", $registro2['c_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("Q$fila", $registro2['a_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("R$fila", $registro2['ob_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("S$fila", $registro2['hv_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("T$fila", $registro2['hm_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("U$fila", $registro2['fup_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("V$fila", $registro2['complicaciones']);
     $objPHPExcel->getActiveSheet()->SetCellValue("W$fila", $registro2['fum_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("X$fila", $registro2['eg_fum']);
     $objPHPExcel->getActiveSheet()->SetCellValue("Y$fila", $registro2['fpp']);
     $objPHPExcel->getActiveSheet()->SetCellValue("Z$fila", $registro2['eg_usg']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AA$fila", $registro2['ultrasonido_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AB$fila", $registro2['ultima_citologia_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AC$fila", $registro2['tipo_rh']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AD$fila", $registro2['vdrl']);      
     $objPHPExcel->getActiveSheet()->SetCellValue("AE$fila", $registro2['ante_patologicos_person']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AF$fila", $registro2['ante_pato_fami']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AG$fila", $registro2['ante_inmuno_alergicos']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AH$fila", $registro2['ante_quirurgicos']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AI$fila", $registro2['vacunas_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AJ$fila", $registro2['vph_anten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AK$fila", $registro2['otros_anten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AL$fila", $registro2['hea_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AM$fila", $registro2['pa_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AN$fila", $registro2['peso_anten']);     
     $objPHPExcel->getActiveSheet()->SetCellValue("AO$fila", $registro2['talla_anten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AP$fila", $registro2['afu']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AQ$fila", $registro2['fcf']); 
     $objPHPExcel->getActiveSheet()->SetCellValue("AR$fila", $registro2['mf']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AS$fila", $registro2['presentacion']);    
     $objPHPExcel->getActiveSheet()->SetCellValue("AT$fila", $registro2['go_aten']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AU$fila", $registro2['ultrasonido']); 
     $objPHPExcel->getActiveSheet()->SetCellValue("AV$fila", $registro2['dx']);
     $objPHPExcel->getActiveSheet()->SetCellValue("AW$fila", $registro2['tx']);        
	   
	   //CONSULTAR LOS PRODUCTOS ENTREGADOS AL PACIENTE
	   $fecha = $registro2['fecha'];
	   $colaborador_id = $registro2['colaborador_id'];
	   $servicio_id = $registro2['servicio_id'];
	   $pacientes_id = $registro2['pacientes_id'];
	   $atencion = "";
	   
	   $query_productos = "SELECT p.nombre AS 'producto'
			FROM facturas AS f
			INNER JOIN facturas_detalle AS fd
			ON f.facturas_id = fd.facturas_id
			INNER JOIN productos AS p
			ON fd.productos_id = p.productos_id
			WHERE f.fecha = '$fecha' AND f.servicio_id = '$servicio_id' AND f.colaborador_id = '$colaborador_id' AND f.pacientes_id = '$pacientes_id'";
	   $result_atencion = $mysqli->query($query_productos);
	   
	   while($registro_atencion = $result_atencion->fetch_assoc()){
			$atencion .= $registro_atencion['producto'].", ";
	   }
	   
	   $atencion = rtrim($atencion,', ');
	   $objPHPExcel->getActiveSheet()->SetCellValue("AX$fila", $atencion);	   
	   
    //Establecer estilo
    $objPHPExcel->getActiveSheet()->setSharedStyle($bordes, "A$fila:AX$fila");	
	  $valor++;
   }	
}
 
//*************Guardar como excel 2003*********************************
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); //Escribir archivo
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setDifferentOddEven(false);
$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('Página &P / &N');

$objPHPExcel->removeSheetByIndex(
    $objPHPExcel->getIndex(
        $objPHPExcel->getSheetByName('Worksheet')
    )
);
 
// Establecer formado de Excel 2003
header("Content-Type: application/vnd.ms-excel");
 
// nombre del archivo
header('Content-Disposition: attachment; filename="Reporte de Atenciones Embarazo'.$mes.'_'.$año.'.xls"');
//**********************************************************************
 
//****************Guardar como excel 2007*******************************
//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //Escribir archivo
//
//// Establecer formado de Excel 2007
//header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//
//// nombre del archivo
//header('Content-Disposition: attachment; filename="kiuvox.xlsx"');
//**********************************************************************
 
//forzar a descarga por el navegador
$objWriter->save('php://output');

$result->free();//LIMPIAR RESULTADO
$mysqli->close();//CERRAR CONEXIÓN
?>