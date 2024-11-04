<?php

	// Cargamos Requests y Culqi PHP
	require 'views/checkout/culqi/requests/library/Requests.php';
	Requests::register_autoloader();
	require 'views/checkout/culqi/culqi/lib/culqi.php';

	// Configurar tu API Key y autenticación
	#$SECRET_KEY = "sk_test_c1cae7b815657df7";
	$SECRET_KEY = "sk_test_4673da110ee5e385";
	$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

	$culqi->Charges->create(
		array(
			"amount" => $_POST['precio'],
			"capture" => true,
			"currency_code" => "PEN",
			"description" => $_POST['producto'],
			"customer_id" => $_POST['customer_id'],
			"address" => $_POST['address'],
			"address_city" => $_POST['address_city'],
			"first_name" => $_POST['first_name'],
			"email" => $_POST['email'],
			"installments" => 0,
			"source_id" => $_POST['token']
		)
	);

	echo "exito";

	exit();
?>