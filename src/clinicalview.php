<?php

ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
$_SESSION["loc"] = dirname($_SERVER['PHP_SELF']);
if($_SESSION["loc"]=="/") $_SESSION["loc"] = "";
$_SESSION["locr"] = dirname(__FILE__);
if($_SESSION["locr"]=="/") $_SESSION["locr"] = "";

require_once("globals.php");
require_once("db.php");

if (!isset($_GET["name"])) {

	//
	//para la validacion de login yes
	if (ValidSession())
	  	DBLogOut($_SESSION["usertable"]["usernumber"], $_SESSION["usertable"]["username"]=='admin');

	session_unset();
	session_destroy();
	session_start();
	$_SESSION["loc"] = dirname($_SERVER['PHP_SELF']);
	if($_SESSION["loc"]=="/") $_SESSION["loc"] = "";
	$_SESSION["locr"] = dirname(__FILE__);
	if($_SESSION["locr"]=="/") $_SESSION["locr"] = "";

}
if(isset($_GET["getsessionid"])) {
	echo session_id();
	exit;
}
ob_end_flush();

require_once('version.php');

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
		<!--firma digital-->
		<link href="assets/graphic/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
		<link href="css/styles.css" rel="stylesheet" />
		<!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->

		<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
		<script src="assets/graphic/all.min.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
		<!--<script src="assets/graphic/all.min.js"></script>-->
    <title>Historial Clinico <?php echo $SIHCOVERSION; ?> - Login</title>
    <style media="screen">
    img {
    max-width: 100%;
    max-height: 100%;
    }

    .cat {
    height: 50px;
    }
    .simg-1{
      height: 50px;
    }
    .simg-2{
      height: 100px;
    }
    .verde{
      filter: invert(100%);
    }
		/*******************
		slide 4
		*******************/
		@-webkit-keyframes imagescale {
		  0% {
		    transform: scale(1);
		    -webkit-transform: scale(1);
		    -moz-transform: scale(1);
		    -o-transform: scale(1);
		  }
		  100% {
		    transform: scale(1.3);
		    -webkit-transform: scale(1.3);
		    -moz-transform: scale(1.3);
		    -o-transform: scale(1.3);
		  }
		}
		@keyframes imagescale {
		  0% {
		    transform: scale(1);
		    -webkit-transform: scale(1);
		    -moz-transform: scale(1);
		    -o-transform: scale(1);
		  }
		  100% {
		    transform: scale(1.3);
		    -webkit-transform: scale(1.3);
		    -moz-transform: scale(1.3);
		    -o-transform: scale(1.3);
		  }
		}

		.slider4 .slide-image {
		  animation: imagescale 15s ease-in-out infinite alternate;
		  -webkit-animation: imagescale 15s ease-in-out infinite alternate;
		  -moz-animation: imagescale 15s ease-in-out infinite alternate;
		  -o-webkit-animation: imagescale 15s ease-in-out infinite alternate;
		}
    </style>
		<link rel="shortcut icon" href="images/favicon.png">
    <!--<link rel=stylesheet href="Css.php" type="text/css">-->
<?php
if(function_exists("globalconf") && function_exists("sanitizeVariables")) {

  if(isset($_GET["name"]) && $_GET["name"] != "" ) {

    	$name = $_GET["name"];
    	$password = $_GET["password"];
			//para login ... log....
    	$usertable = DBLogIn($name, $password);

			if(!$usertable) {
    		ForceLoad("index.php");
    	}else {

      			echo "<script language=\"JavaScript\">\n";
      			echo "document.location='" . $_SESSION["usertable"]["usertype"] . "/index.php';\n";
      			echo "</script>\n";
      }
      exit;

  }
} else {
  echo "<script language=\"JavaScript\">\n";
  echo "alert('No se pueden cargar los archivos de configuración. Posible problema de permisos de archivos en el directorio SIHCO.');\n";
  echo "</script>\n";
}

?>



</head>
<body class="bg-secondary">
	<div class="py-2" style="background: linear-gradient(#000046, #1cb5e0);">
		<h2><div class="col-12 text-white" align="center" id="miDiv"></div></h2>
	</div>



	<div class="bg-danger">
		<!--inicio carousel -->
		<div id="carouselExampleDark" class="carousel slide" data-bs-ride="carousel">
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
				<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
				<button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
			</div>
			<div class="carousel-inner">
				<div class="carousel-item active slider4" data-bs-interval="10000">
					<img src="images/admision.jpeg" class="slide-image" alt="...">
					<div class="carousel-caption"><!--d-none d-md-block-->
						<!--inicio datos de totales paciente-->
						<div class="row p-3" style="background-color: rgba(0, 0, 0, 0.3);">
					      <div class="col-xl-3 col-md-6">
					          <div class="card bg-success text-white mb-4">
					              <div class="card-body">PROSTODONCIA</div>
					              <div class="card-footer d-flex align-items-center justify-content-between">
					                  <div class="cat text-white">
					                    <img src="images/patient.png" class="verde slide-image" alt="">
					                  </div>
					                  <span class="small text-white">
					                    <b>160</b> PACIENTES ATENDIDOS
					                  </span>
					              </div>

					          </div>
					      </div>
					      <div class="col-xl-3 col-md-6">
					          <div class="card bg-warning text-white mb-4">
					              <div class="card-body">OPERATORIA</div>
					              <div class="card-footer d-flex align-items-center justify-content-between">
					                  <div class="cat text-white">
					                    <img src="images/patient.png" class="verde" alt="">
					                  </div>
					                  <span class="small text-white">
					                    <b>160</b> PACIENTES ATENDIDOS
					                  </span>
					              </div>

					          </div>
					      </div>
					      <!--PARA MODULOS DE CIRUGIA II-->
					      <div class="col-xl-3 col-md-6">
					          <div class="card bg-primary text-white mb-4">
					              <div class="card-body">CIRUGIA</div>
					              <div class="card-footer d-flex align-items-center justify-content-between">
					                  <div class="cat text-white">
					                    <img src="images/patient.png" class="verde" alt="">
					                  </div>
					                  <span class="small text-white">
					                    <b>160</b> PACIENTES ATENDIDOS
					                  </span>
					              </div>

					          </div>
					      </div>

					      <div class="col-xl-3 col-md-6">
					          <div class="card bg-danger text-white mb-4">
					              <div class="card-body">ODONTOPEDIATRIA</div>
					              <div class="card-footer d-flex align-items-center justify-content-between">
					                  <div class="cat text-white">
					                    <img src="images/patient.png" class="verde" alt="">
					                  </div>
					                  <span class="small text-white">
					                    <b>160</b> PACIENTES ATENDIDOS
					                  </span>
					              </div>

					          </div>
					      </div>
								<div class="col-12">
						      <div class="simg-2" align="center">
						        <img src="images/dentista.gif"alt="No disponible .gif">
						      </div>
						    </div>
					  </div>
						<!--fin datos de totales paciente-->
						<p>Sistema de historial clínico odontológico - UNSXX</p>
					</div>
				</div>
				<div class="carousel-item" data-bs-interval="2000">
					<img src="images/admision.jpeg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block d-sm-block">
						<h5>Second slide label</h5>
						<p>Some representative placeholder content for the second slide.</p>
					</div>
				</div>
				<div class="carousel-item">
					<img src="images/admision.jpeg" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block d-sm-block">
						<h5>Third slide label</h5>
						<p>Some representative placeholder content for the third slide.</p>
					</div>
				</div>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
		<!--fin carousel -->
	</div>


		<!--<script src="assets/graphic/bootstrap.bundle.min.js"></script>-->
		<script src="assets/graphic/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="js/scripts.js"></script>
		<script src="assets/graphic/jquery-3.5.1.min.js"></script>
		<script src="assets/graphic/chart.js"></script>

    <script>
    var textoCompleto = "CLINICA ODONTOLOGICA - UNSXX";
    var velocidadEscritura = 50; // Velocidad de escritura en milisegundos

    var div = document.getElementById('miDiv');
    var indice = 0;

    function escribirTexto() {
      div.innerHTML += textoCompleto.charAt(indice);
      indice++;

      if (indice <= textoCompleto.length) {
        setTimeout(escribirTexto, velocidadEscritura);
      }else{
				indice = 0;
				div.innerHTML='';
				sleep(3000);
				escribirTexto();
			}
		}
		escribirTexto();
		function sleep(ms) {
		  const inicio = Date.now();
		  let actual = null;

		  do {
		    actual = Date.now();
		  } while (actual - inicio < ms);
		}
    </script>
 </body>
</html>
