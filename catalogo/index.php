<?php
include_once('../config.php');
include_once('class/database.php');
$dato = new func();
$data = $dato->listar_datos("tm_producto_catg", "", "id_catg ASC", "fetchAll");
$empresa = $dato->listar_datos("tm_empresa", "id_de = 1", "", "fetch");
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MENÚ | <?php echo NAME_NEGOCIO;?></title>

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Amatic+SC:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
<input type="hidden" id="url" value="<?php echo URL; ?>"/>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <a href="<?php  echo URL.'catalogo/';?>" class="logo d-flex align-items-center me-auto me-lg-0">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1><?php echo NAME_NEGOCIO;?><span>.</span></h1>
      </a>

      

      <a class="btn-book-a-table" href="<?php echo URL.'catalogo/' ?>">Inicio</a>
      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">
        <span><br><br></span>
        <div class="section-header">
          <h2>Nuestro Menú</h2>
          <p>Consulta Nuestro <span>Delicioso Menú</span></p>
        </div>

        
        <?php
        $c = 0;
        echo '<ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">';
        foreach($data as $value){
          $c =$c+1;
          if($c===1)
          {
            echo '<input type="hidden" id="id_catg" value="'.$value->id_catg.'"/>';
            echo '<input type="hidden" id="desc" value="'.$value->descripcion.'"/>';
            $a_class = '<a class="nav-link active show" onClick="listar('.$value->id_catg.',\''.$value->descripcion.'\');" data-bs-toggle="tab" data-bs-target="#menu-'.$value->id_catg.'">';
            $title = $value->descripcion;
          }else{
            $a_class = '<a class="nav-link" onClick="listar('.$value->id_catg.',\''.$value->descripcion.'\');" data-bs-toggle="tab" data-bs-target="#menu-'.$value->id_catg.'">';
          }
          echo '<li class="nav-item">';
          echo $a_class;
          echo '<h4>'.$value->descripcion.'</h4>';
          echo '</a>';
          echo '</li>';
        }

        echo '</ul>';
        //opciones
        echo '<br><div class="text-center"><div id="resultado"></div></div>';
        //echo '<div class="tab-content" data-aos="fade-up" data-aos-delay="300">';
        //for($i=0;$c<$i;$i++){
          //<div class="tab-pane fade active show" id="menu-starters">
        //}
        //echo '</div>';
        //echo '</div>';
        //echo '</div>';
        ?>
        
<!--
        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">

        </div>-->
<!-- hasta aqui nomas-->
      </div>
    </section><!-- End Menu Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="container">
      <div class="row gy-3">
        <div class="col-lg-3 col-md-6 d-flex">
          <i class="bi bi-geo-alt icon"></i>
          <div>
            <h4>Dirección</h4>
            <p>
              <?php echo $empresa->direccion_comercial;?> <br>
              <?php echo NAME_CIUDAD;?><br>
            </p>
          </div>

        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-telephone icon"></i>
          <div>
            <h4>Reservaciones</h4>
            <p>
              <strong>Teléfono:</strong> <?php echo $empresa->celular;?><br>
              <strong>Correo:</strong> <?php echo $empresa->email;?><br>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links d-flex">
          <i class="bi bi-clock icon"></i>
          <div>
            <h4>Horario de Atención</h4>
            <p>
              <?php echo HORARIO_ATENCION;?>
            </p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6 footer-links">
          <h4>Nuestras Redes Sociales</h4>
          <div class="social-links d-flex">
            <a href="<?php echo URL_TW;?>" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="<?php echo URL_FB;?>" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="<?php echo URL_INS;?>" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="<?php echo URL_LINK;?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span><?php echo NAME_NEGOCIO;?></span></strong>. Todos los Derechos Reservados.
      </div>
    </div>

  </footer><!-- End Footer -->
  <!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <!-- JQuery Main JS File -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>

$(document).ready(function() {
  var id_cat = $('#id_catg').val();
  var desc = $('#desc').val();
  listar(id_cat,desc);
});

function listar(id_cat, desc) {
    var html_header = '<div class="tab-content" data-aos="fade-up" data-aos-delay="300">' +
        '<div class="tab-pane fade active show" id="menu-' + id_cat + '">' +
        '<div class="tab-header text-center">' +
        '<p>Menú</p>' +
        '<h3>' + desc + '</h3>' +
        '</div>' +
        '<div class="row gy-5">';

    var html_footer = '</div>' +
        '</div>' +
        '</div>';

    var html_body = '';
    $('#resultado').attr({class: 'spinner-border text-success', role: 'status', html: '<span class="sr-only">Loading...</span>'});
    $.ajax({
        dataType: 'JSON',
        type: 'POST',
        url: $("#url").val() + 'catalogo/controllers/listar.php',
        data: {
            id_catg: id_cat
        },
        success: function(data) {
          if(data.length  === 0){
              html_body = "<p class='price'>No hay platos agregados para "+desc+".<p>";
            }

            $.each(data, function(i, campo) {
              if(campo == false)
              {
                html_body += '<div class="col-lg-4 menu-item">' +
                    '<a href="../public/images/productos/default.png" id="miImagen" class="glightbox"><img src="../public/images/productos/default.png" class="menu-img img-fluid" alt=""></a>' +
                    
                    '<p class="price">' +
                    'PRODUCTO SIN PRESENTACION'+
                    '</p>' +
                    '</div>';
              }else{
                html_body += '<div class="col-lg-4 menu-item">' +
                    '<a href="../public/images/productos/'+campo.imagen+'" id="miImagen" class="glightbox"><img src="../public/images/productos/'+campo.imagen+'" class="menu-img img-fluid" alt=""></a>' +
                    '<h4>' + campo.presentacion + '</h4>' +
                    '<p class="price">' +
                    'S/. ' + campo.precio +
                    '</p>' +
                    '</div>';
              }
            });

            var finalHTML = html_header + html_body + html_footer;
            $('#resultado').removeAttr("class").removeAttr("role").html(finalHTML);
            //$('#resultado').html(finalHTML);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //console.log(errorThrown + ' ' + textStatus);
            $('#resultado').removeAttr("class").removeAttr("role").html("<p class='price'>No hay platos agregados para "+desc+".<p>");
        }
    });
}
  </script>
</body>

</html>
