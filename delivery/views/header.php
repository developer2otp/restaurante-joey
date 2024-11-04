<!DOCTYPE html>
<html lang="en">
<head>
<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<input type="hidden" id="url" value="<?php echo URL_DEL; ?>"/>
<input type="hidden" id="url2" value="<?php echo URL; ?>"/>
<input type="hidden" id="moneda" value="<?php Session::get('digDoc');?>"/>

<!-- Title -->
<title><?php echo NAME_NEGOCIO; ?> | Delivery EnLinea</title>

<!-- Favicons -->
<!--
<link rel="shortcut icon" href="<?php echo URL_DEL; ?>public/img/favicon.png">
<link rel="apple-touch-icon" href="<?php echo URL_DEL; ?>public/img/favicon_60x60.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo URL_DEL; ?>public/img/favicon_76x76.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo URL_DEL; ?>public/img/favicon_120x120.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo URL_DEL; ?>public/img/favicon_152x152.png">
-->

<!-- CSS Plugins -->
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/bootstrap/dist/css/bootstrap.min.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/slick-carousel/slick/slick.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/animate.css/animate.min.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/animsition/dist/css/animsition.min.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/formvalidation/formValidation.min.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/datatables/css/dataTables.bootstrap4.css" />

<!-- CSS Icons -->
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/css/themify-icons.css" />
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/plugins/font-awesome/css/font-awesome.min.css" />

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&amp;family=Raleway:wght@100;200;400;500&amp;display=swap" rel="stylesheet">

<!-- CSS Core -->
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/css/core.css" />

<!-- CSS Theme -->
<link id="theme" rel="stylesheet" href="<?php echo URL_DEL; ?>public/css/themes/theme-teal.css"/>
<link rel="stylesheet" href="<?php echo URL_DEL; ?>public/css/style-all.css"/>

<!-- JS Plugins -->
<script src="<?php echo URL_DEL; ?>public/plugins/jquery/dist/jquery.min.js"></script>
</head>

<body class="no-margins">

<!-- Body Wrapper -->
<div id="body-wrapper" class="animsition">
    <!-- Header -->
    <header id="header" class="dark">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <!-- Logo -->
                    <div class="module module-logo light">
                        <a href="<?php echo URL_DEL; ?>">
                            <img src="<?php echo URL_DEL; ?>public/img/logo.png" height="88" alt="">
                        </a>
                    </div>
                </div>

                <div class="col-md-7">
                    <!-- Navigation -->
                    <nav class="module module-navigation left mr-4">
                        <ul id="nav-main" class="nav nav-main">
                            <li>
                                <a href="<?php echo URL_DEL; ?>">Inicio</a>
                            </li>
                            <li>
                                <a href="<?php echo URL_DEL; ?>menu">Nuestra carta</a>
                            </li>
                            <li>
                                <a href="<?php echo URL_DEL; ?>pedidos">Mis pedidos</a>
                            </li>
                        </ul>
                    </nav>

                    <div class="module left">
                        <a href="<?php echo URL_DEL; ?>menu" class="btn btn-outline-primary"><span>Ordenar ahora</span></a>
                    </div>
                </div>

                <div class="col-md-2">
                    <a href="#" class="module module-cart module-cart-1 right" data-toggle="panel-cart">
                        <span class="cart-icon">
                            <i class="ti ti-bag"></i>
                            <span class="notification not1"></span>
                        </span>
                        <span class="cart-value cart-total"></span>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- Header / End -->

    <!-- Header -->
    <header id="header-mobile" class="dark bg-dark">
        <div class="module module-nav-toggle">
            <a href="#" id="nav-toggle" data-toggle="panel-mobile"><span></span><span></span><span></span><span></span></a>
        </div>    

        <div class="module module-logo">
            <a href="<?php echo URL_DEL; ?>">
                <img src="<?php echo URL_DEL; ?>public/img/logo.png" alt="" style="height: 50px;">
            </a>
        </div>

        <a href="#" class="module module-cart module-cart-2" data-toggle="panel-cart">
            <i class="ti ti-bag"></i>
            <span class="notification not2"></span>
        </a>
    </header>
    <!-- Header / End -->
    <!-- Content -->
    <div id="content">