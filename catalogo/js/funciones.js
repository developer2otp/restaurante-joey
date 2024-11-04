 function recarga(val,val1)
 {
	 var page = val;
	 var seconds = 1000*val1;
	 window.setTimeout(function() {
    window.location.href = page;
}, seconds);
 }
 function refrescar(val,val1){
	 var div = val;
	 var url = val1;
 	$("#"+div).load(url);
 };
 
 function login_user(){
	$('#cargando').show();
	var target = $('#cargando')[0];
	var dato = $('#login').serialize();
	var spinner = new Spinner(opts).spin(target);
	$.post("controller/login.php",dato,
	function(data){
		switch(data)
		{
			case '1':
				toastr.success('Datos correctos ingresando por favor espere...');
				recarga('index.php','2'); 
			break;
			case '2':
				toastr.warning('Los datos son incorrectos.');
				$('#cargando').hide();
			break;
			default:
				toastr.info('Ingrese todos los campos requeridos.');
				$('#cargando').hide();
			break;
		}
		//$('#rlogin').html(data);
		
	});
 return false; // Evitar ejecutar el submit del formulario.
 }// JavaScript Document
 
 function json(val){
	//var dat = codigo;
	if(val == 1)
	{
		var codigo = $('#codigo').val();
	}else{
		var codigo = val;
	}
	if(codigo == '')
	{
		toastr.warning('Ingrese un código de producto.');
	}else{
		$.getJSON('controller/json_ventas.php',{producto:codigo},
		function(data){
			if(data == 1)
			{
				toastr.info('El código no existe en la base de datos.');
			}else{
				if(data.cantidad == 0)
				{
					$('#cantidad').addClass('is-invalid');
				}else{
					$('#cantidad').removeClass('is-invalid');
				}
				$('#nombre').val(data.nombre);
				$('#precio_v').val(data.precio_v);
				$('#cantidad').val(data.cantidad+' '+data.unidad);
				$('#codigo').val(data.codigo);
			}
		});
	}
};

function api_doc(val){
	var doc = val;
	var elemento = $('#cli_'+doc).val();
	var doc_mayu = doc.toUpperCase()

	$.get("controller/api_dni_ruc.php",{tipo:doc,dato:elemento},
	function(data){
		$('#cli_nom').val(data);
		//para boleta a imprimir
		$('span.cli_nom').text(data);
		//
		$('span.cliente_doc').text(doc_mayu+': '+elemento);
	});
	
	return false;
};
//inicio funciones boleta
function pagar(val){
	var monto = val;
	var pagar = $('#pagar').val();
	var vuelto = (pagar-monto).toFixed(2);
	if(vuelto<0){
		$('#vuelto').val('Error');
		$('#finalizar_venta').prop('disabled', true);
	}else{
		$('#vuelto').val(vuelto);
		$('span.vuelto').text(vuelto);
		var pagar_fixed = parseFloat(pagar).toFixed(2);
		$('span.paga').text(pagar_fixed);
		$('#finalizar_venta').prop('disabled', false);
	}
};
//fin funciones boleta

//funcion cambio de tipo de documentos boleta, factura o nota de venta
function ticket(val)
{
	var dato = val;
	switch(dato)
	{
		case 'fac':
		$('#doc').text('RUC'); 
		$('#cli_dni').attr({placeholder: 'RUC', id: 'cli_ruc', onKeyUp: 'api_doc(\'ruc\')', maxlength: '11', onKeyPress: 'if(this.value.length==11) return false;', max: '99999999999'});
		$('#cli_nota').attr({placeholder: 'RUC', id: 'cli_ruc', onKeyUp: 'api_doc(\'ruc\')', maxlength: '11', onKeyPress: 'if(this.value.length==11) return false;', max: '99999999999'});
		$('#cli_ruc').val('');
		$('#cli_nom').val('');
		
		$('span.cli_nom').text('');
		$('span.cliente_doc').text('RUC: ');
		$('span.tipo_comprobante').text("FACTURA ELECTRÓNICA");
		$('#bot_cobrar').prop('disabled', false);
		break;
		
		case 'bole':
		$('#doc').text('DNI');
		$('#cli_ruc').attr({placeholder: 'DNI', id: 'cli_dni', onKeyUp: 'api_doc(\'dni\')', maxlength: '8', onKeyPress: 'if(this.value.length==8) return false;', max: '99999999'});
		$('#cli_dni').val('');
		$('#cli_nota').val('');
		$('#cli_nom').val('');
		$('span.cli_nom').text('CLIENTES VARIOS');
		$('span.cliente_doc').text('DNI: 111111111');
		$('span.tipo_comprobante').text("BOLETA DE VENTA ELECTRÓNICA");
		$('#bot_cobrar').prop('disabled', false);
		break;
		
		case 'nota':
		$('#doc').text('DNI');
		$('#cli_ruc').attr({placeholder: 'DNI', id: 'cli_dni', onKeyUp: 'api_doc(\'dni\')', maxlength: '8', onKeyPress: 'if(this.value.length==8) return false;', max: '99999999'}).val('');
		$('#cli_nom').val('');
		$('#cli_dni').val('');
		$('span.cli_nom').text('CLIENTES VARIOS');
		$('span.cliente_doc').text('DNI: 11111111');
		$('span.tipo_comprobante').text("NOTA DE VENTA");
		$('#bot_cobrar').prop('disabled', false);
		break;
		
	}
	
}

//inicio funciones para carrito
function add_cart(val){
	//var dat = $('#codigo').val();
	var dat = val;
	if(dat == 'servicio')
	{
		var nombre = $('#serv_n').val();
		var precio = $('#serv_p').val();
		
		$.post("controller/add_carrito.php",{codigo:dat,name:nombre,valor:precio},
		function(data){
			switch(data)
			{
				case '0':
					toastr.error('El producto '+dat+' ya está agregado en el carrito.');
				break;
				case '1':
					toastr.success('Producto '+dat+' agregado correctamente.');
					reload_cart();
				break;
				case '2':
					toastr.info('El producto '+dat+' no está registrado en el almacén.');
				break;
				case '3':
					toastr.warning('Ingrese un código de producto.');
				break;
				default:
					toastr.warning('ocurrió algún error :'+data);
				break;
		}
	});
		//var datos = codigo:dat,name:nombre,valor:precio;
		
	}else{
		$.post("controller/add_carrito.php",{codigo:dat},
		function(data){
			switch(data)
			{
				case '0':
					toastr.error('El producto '+dat+' ya está agregado en el carrito.');
				break;
				case '1':
					toastr.success('Producto '+dat+' agregado correctamente.');
					reload_cart();
				break;
				case '2':
					toastr.info('El producto '+dat+' no está registrado en el almacén.');
				break;
				case '3':
					toastr.warning('Ingrese un código de producto.');
				break;
				case '4':
					toastr.warning('Producto agotado en stock.');
				break;
				default:
					toastr.warning('ocurrió algún error :'+data);
				break;
		}
	});
		//var datos = codigo:dat;
		//$.post("controller/add_carrito.php",{codigo:dat},
	}

	
};

function reload_cart(){
	$("#carrito").load('pages/ventas/sub_carrito.php');
	$("#boleta").load('pages/ventas/sub_carrito_total.php');
}

function edit_session(val,val1,val2,val3){
 	var codigo = val;
	var div = val1;
	var op = val2;
	var precio = val3;
	var url = "controller/carrito_edit_session.php";
	
	if(op == 'edit_item_cantidad'){
		var new_val = $('#'+div).val();
		if((new_val=='') || (new_val=='-') || (new_val<1))
		{
			$('#'+div).val('');
			//return true;
		}else{
			var sub_total = val3*new_val;
			$.post(url,{ids:codigo,opcion:op,cantidad:new_val},
			function(data){
				$("#boleta").load('pages/ventas/sub_carrito_total.php');
				$("#pt_"+div).text(sub_total.toFixed(2));
			});
		}

	}else{
		$.post(url,{ids:codigo,opcion:op},
		function(data){
			toastr.warning('Item "'+codigo+'" fué eliminado del carrito.');
			reload_cart();
		});
	}
	
 };
 
function limpiar_cart(){
	$.get("controller/limpiar_carrito.php",
	function(data){
		toastr.info('Todos los productos del carrito fueron limpiados.');
		reload_cart();
	});
};
//fin funciones carrito

//crear qrcode
function create_qrcode(text, typeNumber, errorCorrectionLevel, mode, mb) {
	qrcode.stringToBytes = qrcode.stringToBytesFuncs[mb];
	var qr = qrcode(typeNumber || 4, errorCorrectionLevel || 'M');
	qr.addData(text, mode);
	qr.make();
	return qr.createImgTag();
};

function update_qrcode(val) {
	var datos = val;
	var url = 'http://localhost/adminlte/pages/comprobantes/imprimir.php?cod='+datos;
	var text = url.replace(/^[\s\u3000]+|[\s\u3000]+$/g, '');
	document.getElementById('qr_code').innerHTML = create_qrcode(text, '0', 'M', 'Byte', 'default');
};
//fin crear qrcode

 function fin_venta(val,val1){
	 var c_u = val;
	 var c_v = val1;
	 var c_html = $('#cod_html').html();
	 $.post("controller/guardar_comprobante.php",{html:c_html,cod_u:c_u,cod_v:c_v},
	function(data){
		toastr.info('Venta finalizada exitosamente!');
	});
 }
 
 function enviar_comprobante(val){
	 var email = $('#email').val();
	 var c_u = val;
	 $('#send_doc').prop('disabled', true);
	 
	 if(c_u == 0)
	 {
		 toastr.warning('Cargar comprobante');
	 }else if(email != null){
		 //url relativas ../../
		$.post("../../controller/send_comprobante.php",{email:email,cod_u:c_u},
			function(data){
				
				if(data == 1){
					toastr.success('Comprobante enviado al correo: '+email);
				}else if(data == 2){
					toastr.warning('Ingrese su correo.');
					$('#send_doc').prop('disabled', false);
				}else{
					toastr.error('Ocurrió algún error.');
					$('#send_doc').prop('disabled', false);
				}
			});
	 }else{
		 toastr.warning('Ingrese su correo.');
		 $('#send_doc').prop('disabled', false);
	 }
 };
 
 function export_pdf(val,val1,val2){
	 var nom_doc = val;
	 var id_html = val1;
	 var opc = val2;
	 //var pdf = new jsPDF('p', 'pt', 'c8');
	 //var height = $('#'+id_html).outerHeight(true)*1.01;
	 var height = $('#'+id_html).height()*1.04;
	 //[margeny, margenx]
//	 var pdf = new jsPDF('p', 'pt', [height, 249.45]);
	 var pdf = new jsPDF('p', 'pt', [height, 200]);
	 //var pdf = new jsPDF('p', 'mm', [80, 300]);
		//pdf.html(html_f, {
			pdf.html(document.getElementById(id_html), {
			callback: function (pdf) {
				
				if(opc == 'save')
				{
					pdf.output('save', 'comprobante_'+nom_doc+'.pdf');
				}else if(opc == 'print'){
					pdf.autoPrint();
					
					var iframe = document.createElement('iframe');
					iframe.setAttribute('style', 'position:absolute;right:0; top:0; bottom:0; height:100%; width:300px');
					document.body.appendChild(iframe);
					iframe.src = pdf.output('datauristring');
					//pdf.output('dataurlnewwindow');
					//console.log('valor de heigh : '+height);
					//window.open(pdf.output('bloburl'), '_blank');
				}else if(opc == 'view'){
					var iframe = document.createElement('iframe');
					iframe.setAttribute('style', 'position:absolute;right:0; top:0; bottom:0; height:100%; width:500px');
					document.body.appendChild(iframe);
					iframe.src = pdf.output('datauristring');
				}
				
			}
		});
 };
 
 //inicio guardar user
 function save(val,val1){
 	var formu = val; 
 	var url = val1;
	var dato = $('#'+formu).serialize();

	$.post(url,{dato},
    function(data){
		
		switch(data)
		{
		case '1':
			toastr.success('Datos guardados correctamente.');
		break;
		
		case '2':
			toastr.error('El correo ya se encuentra registrado.');
		break;
		
		case '3':
			toastr.error('El usuario ya se encuentra registrado.');
		break;
		
		default:
			toastr.info('Ingrese todos los datos.');
		break;
		}
         });

 };