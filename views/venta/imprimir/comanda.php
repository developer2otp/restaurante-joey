<?php
// /venta/impresion_comanda/
include_once ('config.php');
require_once ('public/lib/print/num_letras.php');
require_once ('public/lib/pdf/cellfit.php');

class FPDF_CellFiti extends FPDF_CellFit
{
	function AutoPrint($dialog=false)
	{
		//Open the print dialog or start printing immediately on the standard printer
		$param=($dialog ? 'true' : 'false');
		$script="print($param);";
		$this->IncludeJS($script);
	}

	function AutoPrintToPrinter($server, $printer, $dialog=false)
	{
		//Print on a shared printer (requires at least Acrobat 6)
		$script = "var pp = getPrintParams();";
		if($dialog)
			$script .= "pp.interactive = pp.constants.interactionLevel.full;";
		else
			$script .= "pp.interactive = pp.constants.interactionLevel.automatic;";
		$script .= "pp.printerName = '\\\\\\\\".$server."\\\\".$printer."';";
		$script .= "print(pp);";
		$this->IncludeJS($script);
	}
}


// Array ( [pedido_tipo] => 1 [pedido_numero] => SALON 01 [pedido_cliente] => MESA: 3B [pedido_mozo] => CINTHYA ELISA CHAVEZ [correlativo_imp] => 000046 [nombre_imp] => COCINA [nombre_pc] => DESKTOP-F1QI6FD [codigo_anulacion] => 0 [items] => Array ( [0] => Array ( [producto_id] => 8 [area_id] => 1 [nombre_imp] => COCINA [producto] => CHULETA A LO POBRE [presentacion] => PLATO [comentario] => PALTA, ARROZ, ENSALADA FRESCA [cantidad] => 1 [precio] => 18.00 [total] => 18 [id] => 0 ) ) )



date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$hora = date("g:i:s A");
$fecha = date("d/m/y");

$data = json_decode($_GET['data'],true);
//$cantidad = (count($data['items'])*5)+76;
//32
$c = 0;
foreach($data['items'] as $value){
	$suma = strlen($value['cantidad'])+strlen($value['producto'])+strlen($value['presentacion']);
	if($suma > 30)
	{
		$c = $c+1;
	}
}
if(count($data['items'])>3)
{
	$cantidad = (count($data['items'])*5)+($c*4)+85;
}else{
$cantidad = (count($data['items'])*5)+($c*4)+80;
}
if($data['pedido_tipo'] == 2){
	$cantidad += 5;
}
if(PRICE_COMANDA === false){
	$restar = 12;
}
define('EURO',chr(128));
$pdf = new FPDF_CellFiti('P','mm',array(80,$cantidad-$restar));
$pdf->AddPage();
$pdf->SetMargins(0,0,0,0);
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(75,4,''.$data['nombre_imp'].'',0,1,'L');
$pdf->SetFont('Helvetica','',9);
$pdf->Cell(75,0,'===================================',0,1,'C');
$pdf->SetFont('Helvetica','',12);
$pdf->Ln(1);
$pdf->Cell(75,2,'',0,1,'C');
if($data['pedido_tipo'] == 1){
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(75,4,'MESA',0,1,'C');
}elseif($data['pedido_tipo'] == 2){
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(75,4,'MOSTRADOR',0,1,'C');
}elseif($data['pedido_tipo'] == 3){
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(75,4,'DELIVERY',0,1,'C');
}
if($data['codigo_anulacion'] <> 1){
	$pdf->Ln(1);
	$pdf->SetFont('Helvetica','',12);
	$pdf->Cell(75,2,'Comanda #'.$data['correlativo_imp'].'',0,1,'C');
	$pdf->Cell(75,2,'',0,1,'C');
	$pdf->SetFont('Helvetica','',9);
	$pdf->Cell(75,0,'===================================',0,1,'C');
}
$pdf->Ln(3);
$pdf->SetFont('Helvetica','',12);
$pdf->Cell(75,4,"".$fecha." - ".$hora."",0,1,'C');
$pdf->Ln(1);
if($data['pedido_tipo'] == 1){
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(75,4,$data['pedido_numero']." - ".$data['pedido_cliente']."\n",0,1,'C');
	$pdf->Ln(1);
	$pdf->SetFont('Helvetica','',11);
	$pdf->Cell(75,4,"MOZO: ".$data['pedido_mozo']."\n",0,1,'C');
}elseif($data['pedido_tipo'] == 2){
	$pdf->SetFont('Helvetica','',11);
	$pdf->MultiCell(75,6,"LLEVAR #".$data['pedido_numero']." - CLIENTE:".$data['pedido_cliente']."\n",0,'L'); 
	$pdf->Ln(2);
}elseif($data['pedido_tipo'] == 3){
	$pdf->SetFont('Helvetica','',11);
	$pdf->MultiCell(75,6,"DELIVERY #".$data['pedido_numero']." - CLIENTE:".$data['pedido_cliente']."\n",0,'L'); 
	$pdf->Ln(2);
}
$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(75,2,'______________________________________',0,1,'C');
$pdf->Ln(2);
// PRODUCTOS
$c = 0;
$precio = 0;
$pdf->SetFont('Helvetica', 'B', 10);

foreach ($data['items'] as $value) {
    $itemText = ' > ' . utf8_decode($value['cantidad']) . ' ' . utf8_decode($value['presentacion']);
    $commentText = !empty($value['comentario']) ? "  * " . $value['comentario'] : '';

    //if (($data['pedido_tipo'] == 2) && (PRICE_COMANDA === true)) {
    if (PRICE_COMANDA === true) {
        $c++;
        $precio += $value['precio'];
        $itemText .= '  |     S/. ' . $value['precio'];
    }

    $pdf->MultiCell(75, 4, $itemText, 0, 'L');

    if (!empty($commentText)) {
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->MultiCell(75, 4, $commentText, 0, 'L');
        $pdf->SetFont('Helvetica', 'B', 10);
    }
}

$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(75,2,'_______________________________________',0,3,'C');
if(PRICE_COMANDA === true){
$pdf->Ln(4);
$pdf->SetFont('Helvetica', 'B', 15);
$pdf->Cell(75,0,'********************************',0,1,'C');
if($c > 0){
	$pdf->SetFont('Helvetica', 'B', 13);
	$pdf->Cell(75,5,"TOTAL: S/. ".number_format($precio,2),0,1,'R'); 
}
// PIE DE PAGINA
$pdf->Ln(2);
}
$pdf->Output('ticket.pdf','i');

?>