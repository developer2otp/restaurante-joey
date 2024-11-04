<?php
date_default_timezone_set('America/Lima');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$hora = date("g:i:s A");

require __DIR__ . '/num_letras.php';
require __DIR__ . '/autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

$data = json_decode($_GET['data'],true);
//AQUI CAMBIAR EL NOMBRE DE LA PC, NOMBRE IMPRESORA
$connector = new WindowsPrintConnector("smb://SISTEMA6/CAJA");
$printer = new Printer($connector);

try {
  	$printer -> setJustification(Printer::JUSTIFY_CENTER);

	$printer -> text("===============================================\n");

	$printer -> text(utf8_decode($data['Empresa']['nomb_com'])."\n");
	$printer -> text("RUC: ".utf8_decode($data['Empresa']['ruc'])."\n");
	$printer -> text(utf8_decode($data['Empresa']['direccion'])."\n");
	$printer -> text("TELF: ".utf8_decode($data['Empresa']['celular'])."\n");

	$printer -> text("-----------------------------------------------\n");

	$elec = (($data['id_tdoc'] == 1 || $data['id_tdoc'] == 2) && $data['Empresa']['sunat'] == 1) ? 'ELECTRONICA' : '';
	$printer -> text($data['desc_td']." ".$elec."\n");
	$printer -> text($data['ser_doc']."-".$data['nro_doc']."\n");
	$printer -> text("-----------------------------------------------\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("FECHA DE EMISION: ".date('d-m-Y h:i A',strtotime($data['fec_ven']))."\n");
	
	if($data['id_tped'] == 1){
		$tipo_atencion = utf8_decode($data['Pedido']['desc_salon']).' - MESA: '.utf8_decode($data['Pedido']['nro_mesa']);
	}else if ($data['id_tped'] == 2){
		$tipo_atencion = "MOSTRADOR";
	}else if ($data['id_tped'] == 3){
		$tipo_atencion = "DELIVERY";
	}
	$printer -> text("TIPO DE ATENCION: ".$tipo_atencion."\n");
	$printer -> text("CLIENTE: ".utf8_decode($data['Cliente']['nombre'])."\n");
	if ($data['Cliente']['tipo_cliente'] == 1){
		$printer -> text("DNI: ".$data['Cliente']['dni']."\n");
	}else if ($data['Cliente']['tipo_cliente'] == 2){
		$printer -> text("RUC: ".$data['Cliente']['ruc']."\n");
	}
	$printer -> text("TELEFONO: ".$data['Cliente']['telefono']."\n");
	$printer -> text("DIRECCION: ".utf8_decode($data['Cliente']['direccion'])."\n");
	$printer -> text("REFERENCIA: ".utf8_decode($data['Cliente']['referencia'])."\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("-----------------------------------------------\n");
	$printer -> text("PRODUCTO                   CANT   P.U   IMPORTE\n");
	$printer -> text("-----------------------------------------------\n");
	
	$total = 0;
	foreach($data['Detalle'] as $d){
		if($d['cantidad'] > 0){
			$printer -> text(utf8_decode($d['Producto']['pro_nom']).' '.utf8_decode($d['Producto']['pro_pre'])."      ".$d['cantidad']."   ".utf8_decode($d['precio'])."   ".number_format(($d['cantidad'] * $d['precio']),2)."\n");
			$total = ($d['cantidad'] * $d['precio']) + $total;
		}
	}
	
	$printer -> text("-----------------------------------------------\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	
	$operacion_gravada = (($data['total'] + $data['comis_tar'] + $data['comis_del'] - $data['desc_monto']) / (1 + $data['igv']));
	$igv = ($operacion_gravada * $data['igv']);

	$printer -> text("SUB TOTAL:                            S/ ".number_format(($data['total']),2)."\n");
	if($data['id_tped'] == 3){
	$printer -> text("COSTO DELIVERY:                       S/ ".number_format(($data['comis_del']),2)."\n");
	}
	$printer -> text("DESCUENTO:                            S/ ".number_format(($data['desc_monto']),2)."\n");
	$printer -> text("OP.GRAVADA:                           S/ ".number_format(($operacion_gravada),2)."\n");
	$printer -> text("IGV:                                  S/ ".number_format(($igv),2)."\n");
	$printer -> text("IMPORTE A PAGAR:                      S/ ".number_format(($data['total'] + $data['comis_del'] - $data['desc_monto']),2)."\n");
	$printer -> text("\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	$printer -> text("SON: ".numtoletras($data['total'] + $data['comis_del'] - $data['desc_monto'])."\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> text("------------- FORMA DE PAGO -------------\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_LEFT);
	
	if($data['id_tpag'] == 1){
		$vuelto = $data['pago_efe_none'] - $data['pago_efe'];
		$printer -> text("PAGO CON: S/".number_format($data['pago_efe_none'],2)."\n");
		$printer -> text("VUELTO: S/".number_format($vuelto,2)."\n");
	} else {
		$printer -> text("PAGO CON: ".$data['desc_tp']."\n");
	}

	$printer -> text("\n");
	$printer -> selectPrintMode();
	$printer -> setJustification(Printer::JUSTIFY_CENTER);
	$printer -> text("Autorizado mediante Resolucion\n");
	$printer -> text("Nro. 034-005-0005294/SUNAT\n");
	$printer -> text("Representacion impresa de la\n");
	$printer -> text("Boleta de Venta Electronica\n");
	$printer -> text("\n");
	$printer -> text("!GRACIAS POR SU PREFERENCIA¡\n");
	$printer -> text("===============================================\n");
	$printer -> text("\n");
	$printer -> cut();
	$printer -> close();

} catch(Exception $e) {
	echo "No se pudo imprimir en esta impresora " . $e -> getMessage() . "\n";
}
?>