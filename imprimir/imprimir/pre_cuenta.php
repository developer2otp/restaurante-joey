<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$hora = date("g:i:s A");

require __DIR__ . '/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$data = json_decode($_GET['data'],true);
$connector = new WindowsPrintConnector("smb://Lenovo/COCINA");
$printer = new Printer($connector);

try {
  	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> setTextSize(1,1);
	$printer -> text("======================================\n");
	$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
	$printer -> text("PRE-CUENTA\n");
	$printer -> selectPrintMode();
	$printer -> text("SALON: ".utf8_decode($data['desc_salon'])."\n");
	$printer -> text("MESA: ".utf8_decode($data['nro_mesa'])."\n");
	$printer -> text("======================================\n");
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("HORA: ".$hora."\n");
	$printer -> text("_________________________________________\n");
	$printer -> text("CANT   PRODUCTO           IMPORTE\n");
	$printer -> text("-----------------------------------------\n");
	$total = 0;
	//$printer -> setFont( Printer :: FONT_B );
	//$printer -> setTextSize(1,1);
	foreach($data['Detalle'] as $d){
		if($d['cantidad'] > 0){
			$printer -> text("  ".$d['cantidad'].'    '.utf8_decode($d['Producto']['pro_nom']).' '.utf8_decode($d['Producto']['pro_pre']).' | '.number_format(($d['cantidad'] * $d['precio']),2)."\n");
			
			$total = ($d['cantidad'] * $d['precio']) + $total;
		}
	}
	$printer -> text("-----------------------------------------\n");
	$printer -> selectPrintMode(Printer::MODE_DOUBLE_WIDTH);
	$printer -> text("IMPORTE TOTAL: S/".number_format(($total),2)."\n");
	$printer -> text("\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> text("Este no es un comprobante de Pago.\n");
	$printer -> text("Ingrese su DNI o RUC si desea Boleta o Factura\n\n");
	$printer -> text("_______________________________\n");
	$printer -> text("Gracias por su gentil preferencia\n");
	$printer -> text("\n");
	$printer -> text("\n");
	$printer -> cut();
	$printer -> close();

} catch(Exception $e) {
	echo "No se pudo imprimir en esta impresora " . $e -> getMessage() . "\n";
}
?>
echo "<script lenguaje="JavaScript">window.close();</script>";