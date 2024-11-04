<?php
error_reporting(0);
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

define('EURO',chr(128));
$pdf = new FPDF_CellFiti('P','mm',array(72,350));
$pdf->AddPage();
$pdf->SetMargins(0,0,0,0);
 
// DATOS ARQUEO DE CAJA
if($this->dato->estado == 'a'){$estado = 'ABIERTO';}else{$estado = 'CERRADO';}
$pdf->Ln(3);
$pdf->SetFont('Courier','B',12);
$pdf->Cell(72,4,'RANKING DE PRODUCTOS',0,1,'C');
$pdf->SetFont('Courier','B',8);
$pdf->Cell(72,4,'CORTE DE TURNO #COD0'.$this->dato->id_apc,0,1,'C'); 
$pdf->SetFont('Courier','',8); 
$pdf->Cell(72,4,'ESTADO: '.$estado,0,1,'C');       

$pdf->Ln(3);
$pdf->SetFont('Courier','',9);
$pdf->Cell(15, 4, 'CAJERO:', 0);    
$pdf->Cell(20, 4, '', 0);
$pdf->Cell(37, 4, utf8_decode($this->dato->desc_per),0,1,'R');
$pdf->Cell(15, 4, 'CAJA:', 0);    
$pdf->Cell(20, 4, '', 0);
$pdf->Cell(37, 4, utf8_decode($this->dato->desc_caja),0,1,'R');
$pdf->Cell(15, 4, 'TURNO:', 0);    
$pdf->Cell(20, 4, '', 0);
$pdf->Cell(37, 4, utf8_decode($this->dato->desc_turno),0,1,'R');
if($this->dato->estado == 'a'){$fecha_cierre = '';}else{$fecha_cierre = date('d-m-Y h:i A',strtotime($this->dato->fecha_cierre));}
$pdf->Cell(15, 4, 'FECHA APERTURA:', 0);    
$pdf->Cell(20, 4, '', 0);
$pdf->Cell(37, 4, date('d-m-Y h:i A',strtotime($this->dato->fecha_aper)),0,1,'R');
$pdf->Cell(15, 4, 'FECHA CIERRE:', 0);    
$pdf->Cell(20, 4, '', 0);
$pdf->Cell(37, 4, $fecha_cierre,0,1,'R');
$pdf->Ln(1);

//PRODUCTOS VENDIDOS
$pdf->Ln(0);
//$pdf->SetFont('Courier','B',10);
$pdf->Cell(72,8,'==================================',0,1,'C');
$pdf->Ln(1);
// COLUMNAS
$pdf->SetFont('Courier', 'B', 8);
$pdf->Cell(10, 4, 'CANT.',0,0,'R');
$pdf->Cell(37, 4, 'PRODUCTO', 0);
$pdf->Cell(10, 4, 'P.U.',0,0,'R');
$pdf->Cell(15, 4, 'IMP.',0,0,'R');
$pdf->Ln(4);
$pdf->Cell(72,0,'','T');
$pdf->Ln(1);

$friendsByAge=array();
 
foreach ($this->dato->Detalle as $k => $pro) {
    $cate=$pro->Producto->pro_cat;
    unset($pro->Producto->pro_cat);
    $friendsByAge[$cate][] = $pro;
}

$cantidad_total = 0;
$importe_total = 0;
foreach ($friendsByAge as $k=>$amigos){    
	$pdf->Ln(1);
	$pdf->SetFont('Courier','B',8);
	$pdf->Cell(72,4,utf8_decode($k),0,1,'L');
	$pdf->Ln(1);
	$total = 0;
    foreach ($amigos as $amigo){
		$pdf->SetFont('Courier', '', 8);
		$pdf->Cell(8,4, $amigo->cantidad,0,0,'R');
		$pdf->MultiCell(42,4,utf8_decode($amigo->Producto->pro_pre),0,'L'); 
		$pdf->Cell(56, -4, $amigo->precio,0,0,'R');
		$pdf->Cell(15, -4, number_format(($amigo->cantidad * $amigo->precio),2),0,0,'R');
		$pdf->Ln(1);
		$total = ($amigo->cantidad * $amigo->precio) + $total;

        $cantidad_total = $cantidad_total + $amigo->cantidad;
        
    }
	$importe_total = $importe_total + $total;

	$pdf->Cell(71,4,number_format($total,2),0,1,'R');
	$pdf->Ln(2);
	$pdf->Cell(72,0,'','T');

}

$pdf->Cell(72,0,'','T');
$pdf->Ln(6); 
$pdf->Cell(52,4, $cantidad_total,0,0,'L');
$pdf->Cell(20,4,number_format($importe_total,2),0,0,'R');
$pdf->Ln(6);

$pdf->Cell(72,0,'','T');
$pdf->Ln(6); 
$pdf->Cell(72,4,'DATOS DE IMPRESION',0,1,'');
$pdf->Cell(72,4,'USUARIO: '.Session::get('nombres').' '.Session::get('apellidos'),0,1,'');
date_default_timezone_set($_SESSION["zona_horaria"]);
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$pdf->Cell(72,4,'FECHA: '.date("d-m-Y h:i A"),0,1,'');
$pdf->Ln(8);
$pdf->Cell(72,4,'___________________________________',0,1,'C');
$pdf->Cell(72,4,utf8_decode($this->dato->desc_per),0,1,'C');
// PIE DE PAGINA
$pdf->Ln(10);
$pdf->Output('ticket.pdf','i');
?>