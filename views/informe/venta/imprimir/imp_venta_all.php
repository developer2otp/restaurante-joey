<?php
require_once ('public/lib/print/num_letras.php');
require_once ('public/lib/pdf/cellfit.php');
require_once ('public/lib/phpqrcode/qrlib.php');
//funcion sin html
function rip_tags($string) { 
    // ----- remove HTML TAGs ----- 
    $string = preg_replace ('/<[^>]*>/', ' ', $string); 
    // ----- remove control characters ----- 
    $string = str_replace("\r", '', $string);    // --- replace with empty space
    $string = str_replace("\n", ' ', $string);   // --- replace with space
    $string = str_replace("\t", ' ', $string);   // --- replace with space
    // ----- remove multiple spaces ----- 
    $string = trim(preg_replace('/ {2,}/', ' ', $string));
    
    return $string; 
}

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
$ruta_img = 'public/qr/' . $this->dato->name_file_sunat . '.png';

$igvRate = Session::get('igv') / 100 + 1;

$nombreProductoThreshold = 22;

$exceedingProductCount = 0;
foreach ($this->dato->Detalle as $detalle) {
    if (strlen($detalle->nombre_producto) > $nombreProductoThreshold) {
        $exceedingProductCount++;
    }
}

$detalleCount = count($this->dato->Detalle);
$baseQuantity = ($detalleCount == 2) ? ($detalleCount * 8) : (($detalleCount > 3) ? ($detalleCount * 6) : ($detalleCount * 4));

$adjustedQuantity = $baseQuantity + ($exceedingProductCount * 4);
$cantidad = ($detalleCount > 3) ? $adjustedQuantity + 200 : $adjustedQuantity + 205;

$totalMarginAdjustment = ($this->dato->id_tdoc == 2) ? 20 : 20;
$total_margen = ($this->dato->id_tdoc != 3) ? $cantidad - $totalMarginAdjustment : $cantidad - 60;

$addMarginFile = file_exists($ruta_img) ? 5 : 0;

$pdf = new FPDF_CellFiti('P','mm',array(72, $total_margen + $addMarginFile));

$pdf->AddPage();
$pdf->SetMargins(0,0,0,0);

// CABECERA
if ($this->empresa['logo']) {
    $url_logo = URL . "public/images/" . $this->empresa['logo'];
	$pdf->Image($url_logo, L_CENTER, 2, L_DIMENSION, 0);
	$pdf->Cell(72, L_ESPACIO, '', 0, 1, 'C');
}
$pdf->SetFont('Helvetica', '', 7);
$pdf->Cell(72, 4, '', 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(72, 4, utf8_decode($this->empresa['nombre_comercial']), 0, 1, 'C');
$pdf->SetFont('Helvetica', '', 9);
$pdf->Cell(72, 4, utf8_decode(Session::get('tribAcr')).': '.utf8_decode($this->empresa['ruc']), 0, 1, 'C');
//$pdf->Multicell(72,4, $pdf->WriteHTML($this->empresa['direccion_comercial']));
$pdf->MultiCell(72, 4, utf8_decode($this->empresa['direccion_comercial']), 0, 'C');
$pdf->Cell(72, 4, 'TELF: '.utf8_decode($this->empresa['celular']), 0, 1, 'C');
 
// DATOS FACTURA
$elec = ($this->dato->id_tdoc == 1 || $this->dato->id_tdoc == 2) && Session::get('f_pro') == 3 ? 'ELECTRÓNICA' : '';     
$pdf->Ln(1);
$pdf->SetFont('Helvetica', 'B', 10);
$pdf->Cell(72, 4, utf8_decode($this->dato->desc_td) . ' ' . utf8_decode($elec), 0, 1, 'C');
$pdf->Cell(72, 4, utf8_decode($this->dato->ser_doc) . ' - ' . utf8_decode($this->dato->nro_doc), 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('Helvetica', '', 8);
$pdf->Cell(72, 4, 'FECHA DE EMISION: ' . date('d-m-Y h:i A', strtotime($this->dato->fec_ven)), 0, 1, '');

$tipoAtencion = '';
if ($this->dato->id_tped == 1) {
    $tipoAtencion = utf8_decode('TIPO DE ATENCION') . ': ' . utf8_decode($this->dato->Pedido->desc_salon) . ' - MESA: ' . utf8_decode($this->dato->Pedido->nro_mesa);
} else if ($this->dato->id_tped == 2) {
    $tipoAtencion = 'TIPO DE ATENCION: MOSTRADOR';
} else if ($this->dato->id_tped == 3) {
    $tipoAtencion = 'TIPO DE ATENCION: DELIVERY';
}
$pdf->Cell(72, 4, $tipoAtencion, 0, 1, '');

$pdf->MultiCell(72, 4, 'CLIENTE: ' . utf8_decode($this->dato->Cliente->nombre), 0, 1, '');

if ($this->dato->id_tdoc != 3) {
    $tipoDocumento = $this->dato->Cliente->tipo_cliente == 1 ? Session::get('diAcr') : Session::get('tribAcr');
    $documento = $this->dato->Cliente->tipo_cliente == 1 ? $this->dato->Cliente->dni : $this->dato->Cliente->ruc;

    $pdf->Cell(72, 4, utf8_decode($tipoDocumento) . ': ' . utf8_decode($documento), 0, 1, '');
    $pdf->MultiCell(72, 4, 'TELEFONO: ' . utf8_decode($this->dato->Cliente->telefono), 0, 1, '');
    $pdf->MultiCell(72, 4, 'DIRECCION: ' . utf8_decode($this->dato->Cliente->direccion), 0, 1, '');
    //$pdf->MultiCell(72, 4, 'REFERENCIA: ' . utf8_decode($this->dato->Cliente->referencia), 0, 1, '');
    $pdf->Ln(3);
}

// COLUMNAS
$pdf->SetFont('Helvetica', 'B', 8);
$pdf->Cell(72, 0, '', 'T');
$pdf->Ln(0);
$pdf->Cell(5, 4, 'CANT.', 0, 0);
$pdf->Cell(42, 4, 'PRODUCTO', 0, 0, 'C');
$pdf->Cell(10, 4, 'P.U.', 0, 0, 'R');
$pdf->Cell(15, 4, 'IMP.', 0, 0, 'R');
$pdf->Ln(4);
$pdf->Cell(72, 0, '', 'T');
$pdf->Ln(0);

// PRODUCTOS
$total = 0;
$total_ope_gravadas = 0;
$total_igv_gravadas = 0;
$total_ope_exoneradas = 0;
$total_igv_exoneradas = 0;

foreach ($this->dato->Detalle as $d) {
    $isGravada = $d->codigo_afectacion == '10';

    $total_ope_gravadas += $isGravada ? $d->valor_venta : 0;
    $total_igv_gravadas += $isGravada ? $d->total_igv : 0;
    $total_ope_exoneradas += !$isGravada ? $d->valor_venta : 0;
    $total_igv_exoneradas += !$isGravada ? $d->total_igv : 0;

    $pdf->SetFont('Helvetica', '', 8);
    $pdf->Cell(10, 4, $d->cantidad, 0, 0, 'L');
    $pdf->MultiCell(42, 4, utf8_decode($d->nombre_producto), 0, 'L');
    $pdf->Cell(57, -4, $d->precio_unitario, 0, 0, 'R');
    $pdf->Cell(15, -4, number_format(($d->cantidad * $d->precio_unitario), 2), 0, 0, 'R');
    $pdf->Ln(0);
    $pdf->Cell(72,0,'','T');
	$pdf->Ln(0);

    if ($d->cantidad > 0) {
        $total += ($d->cantidad * $d->precio_unitario);
    }
}

// Agregar línea final
$pdf->Cell(72, 0, '', 'T');
$pdf->Ln(0);

 
// SUMATORIO DE LOS PRODUCTOS Y EL IVA
$sbt = ($this->dato->total + $this->dato->comis_tar + $this->dato->comis_del - $this->dato->desc_monto) / (1 + $this->dato->igv);
$igv = $sbt * $this->dato->igv;

$pdf->SetFont('Helvetica', '', 8);

if ($this->dato->id_tdoc != 3) {
    $pdf->Cell(72, 0, '', 'T');
    $pdf->Ln(0);

    // Subtotal
    $subtotal = ($total_ope_exoneradas > 0) ?
        (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) :
        (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) / $igvRate;
    $pdf->Cell(37, 10, 'SUB TOTAL', 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(15, 10, number_format($subtotal, 2), 0, 0, 'R');
    $pdf->Ln(4);

    // Operaciones Gravadas
    $gravadas = ($total_ope_gravadas > 0) ?
        (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) / $igvRate :
        0;
    $pdf->Cell(37, 10, 'OP. GRAVADA', 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(15, 10, number_format($gravadas, 2), 0, 0, 'R');
    $pdf->Ln(4);

    // Operaciones Exoneradas
    $pdf->Cell(37, 10, 'OP. EXONERADA', 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(15, 10, number_format($total_ope_exoneradas, 2), 0, 0, 'R');
    $pdf->Ln(4);

    // Impuesto
    $impuesto = ($total_ope_exoneradas > 0) ?
        (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) - (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) :
        (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) - (($this->dato->total - $this->dato->desc_monto) + $this->dato->comis_del) / $igvRate;
    $pdf->Cell(37, 10, Session::get('impAcr'), 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(15, 10, number_format($impuesto, 2), 0, 0, 'R');

    // Descuento
    if ($this->dato->desc_monto > 0) {
        $pdf->Ln(4);
        $pdf->Cell(37, 10, 'DESCUENTO', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '-' . number_format($this->dato->desc_monto, 2), 0, 0, 'R');
    }

    // Delivery
    if ($this->dato->comis_del > 0) {
        $pdf->Ln(4);
        $pdf->Cell(37, 10, 'DELIVERY', 0);
        $pdf->Cell(20, 10, '', 0);
        $pdf->Cell(15, 10, '(' . number_format($this->dato->comis_del, 2) . ')', 0, 0, 'R');
    }
    $pdf->Ln(5);

    // Total
    $pdf->SetFont('Helvetica', 'B', 8);
    $pdf->Cell(37, 10, 'TOTAL', 0);
    $pdf->Cell(20, 10, '', 0);
    $pdf->Cell(15, 10, number_format(($this->dato->total + $this->dato->comis_del - $this->dato->desc_monto), 2), 0, 0, 'R');
    $pdf->Ln(7);

    // Cantidad en letras
    $pdf->Ln(1);
    $pdf->SetFont('Helvetica', '', 8);
    $pdf->MultiCell(72, 4, 'SON: ' . numtoletras($this->dato->total + $this->dato->comis_del - $this->dato->desc_monto), 0, 'L');
    $pdf->Ln(1);

    // Línea final
    $pdf->Cell(72, 0, '', 'T');
}

$pdf->Ln(0);

if ($this->dato->id_tpag == 2) {
    renderPaymentDetails($pdf, 'TARJETA', $this->dato->pago_tar);
} elseif ($this->dato->id_tpag == 3) {
    renderPaymentDetails($pdf, 'EFECTIVO', $this->dato->pago_efe);
    renderPaymentDetails($pdf, 'TARJETA', $this->dato->pago_tar);
}

function renderPaymentDetails($pdf, $label, $amount)
{
    $pdf->Cell(37, 4, $label, 0);
    $pdf->Cell(20, 4, '', 0);
    $pdf->Cell(15, 4, number_format($amount, 2), 0, 0, 'R');
    $pdf->Ln(4);
    $pdf->Cell(72, 0, '', 'T');
}

//$ruta_img = 'public/qr/' . $this->dato->name_file_sunat . '.png';

$pdf->Ln(1);

if (file_exists($ruta_img) && !empty($this->dato->name_file_sunat)) {

    $pdf->Cell(25, 25, $pdf->Image($ruta_img, 1, $pdf->GetY(), 25), 0);
	renderQRDetails($pdf, $this->dato);

} else {
    renderPaymentDetails2($pdf, 'PAGO CON', $this->dato->pago_efe_none);
    $vuelto = $this->dato->pago_efe_none - $this->dato->pago_efe;
    renderPaymentDetails2($pdf, 'VUELTO', $vuelto);

    if ($this->dato->id_tpag > 3) {
        renderPaymentDetails2($pdf, $this->dato->desc_tp, $this->dato->pago_tar);
    }

    if ($this->dato->desc_tipo == 1) {
        renderPaymentDetails2($pdf, 'CORTESIA', 0.00);
    }

    if ($this->dato->desc_tipo == 3) {
        renderPaymentDetails2($pdf, 'CREDITO PERSONAL', $this->dato->desc_monto);
    }

    $pdf->Ln(8);
    $pdf->SetFont('Helvetica', 'B', 9);
    $pdf->Cell(72, 0, utf8_decode('CONDICIÓN DE PAGO: CONTADO'), 0, 1, 'L');
    $pdf->Ln(2);
    $pdf->Cell(72, 0, '', 'T');
}

$pdf->SetFont('Helvetica', '', 8);
// Comentario comprobante
if (!empty($this->empresa['comentario_comprobante'])) {
    $pdf->Ln(1);
    $str = rip_tags($this->empresa['comentario_comprobante']);
    $pdf->MultiCell(70, 4, $str, 0, 'C');
}

// Representación impresa
if ($this->dato->id_tdoc != 3) {
    $pdf->Ln(4);
    $representacionImpresa = utf8_decode('Representación impresa de la ') . $this->dato->desc_td . ' ';
    $representacionImpresa .= isset($elec) ? utf8_decode($elec) : '';
    $representacionImpresa .= ' consulte en: www.sunat.gob.pe';
    $pdf->MultiCell(70, 4, $representacionImpresa, 0, 'C');
}

$pdf->Ln(4);
$pdf->Cell(72,0,'GRACIAS POR SU PREFERENCIA',0,0,'C');

function renderQRDetails($pdf, $dato)
{
    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Cell(0, 8, utf8_decode('CÓDIGO HASH:'), 0);
    $pdf->Ln(1);

    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Cell(14, 12, '', 0, 0, 'L');
    $pdf->Cell(67, 12, utf8_decode($dato->hash_cpe), 0, 0, 'C');
    $pdf->Ln(1);

    $pdf->SetFont('Helvetica', 'B', 7);
    $pdf->Cell(67, 18, utf8_decode('CONDICIÓN DE PAGO: CONTADO'), 0, 0, 'R');
    $pdf->Ln(1);

    $pdf->SetFont('Helvetica', '', 7);
    $pdf->Cell(41, 23, utf8_decode('PAGÓ CON:'), 0, 0, 'R');
    $pdf->Cell(0, 23, utf8_decode($dato->pago_efe_none), 0, 0, 'L');
    $pdf->Ln(0);

    $vuelto = ($dato->pago_efe_none - $dato->pago_efe);
    $pdf->Cell(37.5, 29, 'VUELTO:', 0, 0, 'R');
    $pdf->Cell(0, 29, number_format($vuelto, 2), 0, 0, 'L');
    $pdf->Ln(17);
}

function renderPaymentDetails2($pdf, $label, $amount)
{
    $pdf->Ln(0);
    $pdf->Cell(37, 5, $label, 0);
    $pdf->Cell(20, 5, '', 0);
    $pdf->Cell(15, 5, number_format($amount, 2), 0, 0, 'R');
    $pdf->Ln(3);
}

$pdf->Output('ticket.pdf','I');