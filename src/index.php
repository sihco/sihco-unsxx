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
    <link href="css/styles.css" rel="stylesheet" />
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
		<!--<script src="assets/graphic/all.min.js"></script>-->
    <title>Historial Clinico <?php echo $SIHCOVERSION; ?> - Login</title>
		<link rel="shortcut icon" href="images/favicon.png">
    <!--<link rel=stylesheet href="Css.php" type="text/css">-->

    <script language="JavaScript" src="sha256.js"></script>
    <script language="JavaScript">
function computeHASH()
{
	var userHASH, passHASH;
	userHASH = document.form1.name.value;
	passHASH = js_myhash(js_myhash(document.form1.password.value)+'<?php echo session_id(); ?>');
	document.form1.name.value = '';
	document.form1.password.value = '                                                                                 ';
	document.location = 'index.php?name='+userHASH+'&password='+passHASH;
}
</script>
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
<body class="bg-secondary" id="fondo" onload="document.form1.name.focus()">
  <div id="layoutAuthentication">
              <div id="layoutAuthentication_content">
                  <main>
                      <div class="container">
                          <div class="row justify-content-center">
                              <div class="col-lg-5">
                                  <div class="cardfabian shadow-lg border-0 rounded-lg mt-5">
                                      <div class="card-header"><h3 class="text-center font-weight-light text-white my-4">Acceso</h3></div>
                                      <div class="card-body">
                                          <form name="form1" action="javascript:computeHASH()">

                                              <div class="form-floating mb-3">
                                                  <input class="form-control" id="name" name="name" placeholder="name@example.com" />
                                                  <label for="name">Usuario</label>
                                              </div>
                                              <div class="form-floating mb-3">
                                                  <input class="form-control" id="password" name="password" type="password" placeholder="Password" />
                                                  <label for="password">Contraseña</label>
                                              </div>

                                              <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                  <a class="small" href="password.html">Has olvidado tu contraseña?</a>
                                                  <!--<a class="btn btn-primary" href="index.html">Iniciar sesion</a>-->
                                                  <input type="submit" class="btn btn-primary" name="Submit" value="Iniciar sesion">
                                              </div>

                                          </form>
																					<div class="row">
																						<div class="col-12" align="center">
																							<a href="clinicalview.php" class="text-white"> <b>HOME</b> </a>
																						</div>
																					</div>
                                      </div>
                                      <div class="card-footer text-center py-3"></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </main>
              </div>
							<!--<a href="downl.php">Descargar firefox</a>-->
							<a href="downl.php">Descargar CamScanner</a>
							<!--<a href="https://play.google.com/store/apps/details?id=com.intsig.camscanner">Descargar CamScanner</a>-->
              <div id="layoutAuthentication_footer">
                  <footer class="py-4 bg-light mt-auto">
                      <div class="container-fluid px-4">
                          <div class="d-flex align-items-center justify-content-between small">
                              <div class="text-muted">
																Historial Clínico 2022
																<?php include('footnote.php'); ?>
															</div>
                          </div>
                      </div>
                  </footer>
              </div>
          </div>
					<!--<script src="assets/graphic/bootstrap.bundle.min.js"></script>-->
					<script src="js/scripts.js"></script>";
				</body>
		</html>
