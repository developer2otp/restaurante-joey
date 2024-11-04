<?php
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
// var_dump($this->dato);
$fecha = date('Y-m-d H:i:s');
$usuario = Session::get('nombres');
define('EURO',chr(128));
$head = 100;
$pdf = new FPDF_CellFiti('P','mm',array(80,900));
$pdf->AddPage();
$pdf->SetMargins(2,0,0,0);
 
// // CABECERA
$pdf->SetFont('Helvetica','B',15);
$pdf->Cell(72,4,'STOCK DE INVENTARIO',0,1,'L');
$pdf->Ln(3);

$pdf->SetFont('Helvetica','',9);
$pdf->Cell(72,4,'FECHA Y HORA: '.$fecha ,0,1,'L');

$pdf->Ln(3);

$pdf->Cell(72,4,'USUARIO: '.$usuario ,0,1,'L');

// COLUMNAS
$pdf->SetFont('Helvetica', 'B', 9);
$pdf->Cell(50, 10, 'PRODUCTO', 0);
$pdf->Cell(5, 10, 'UNIDAD',0,0,'R');
$pdf->Cell(15, 10, 'STOCK',0,0,'R');
$pdf->Ln(8);
$pdf->Cell(72,0,'','T');
$pdf->Ln(1);

foreach($this->dato as $d){
    $stock_real = $d->ent - $d->sal;

$pdf->SetFont('Helvetica', '', 9);
$pdf->MultiCell(43,4,utf8_decode($d->Producto->ins_nom),0,'L'); 
$pdf->Cell(55, -4, utf8_decode($d->Producto->ins_med),0,0,'R');
$pdf->Cell(12, -4, round($stock_real, 3),0,0,'R');
$pdf->Ln(1);
$pdf->Cell(72,0,'','T');
$pdf->Ln(1);
// $total = ($d->cantidad * $d->precio) + $total;
}

	$pdf->Output('ticket.pdf','i');
?>