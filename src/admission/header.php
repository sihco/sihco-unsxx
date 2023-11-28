
<!--HEADER PARA ADMINISTRADOR-->
<?php
/*ob_start();
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

header("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();*/
ob_start();
// Establecer la expiración a 1 semana (7 días)
$expiration_time = gmdate("D, d M Y H:i:s", strtotime("+7 days"))." GMT";
header("Expires: $expiration_time");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: max-age=604800, no-cache, must-revalidate");  // max-age en segundos (7 días)
header("Pragma: no-cache");

header("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();

require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');
$main=false;
if(isset($_SESSION["usertable2"])&&$_SESSION["usertable2"]["active"]){
  $main=true;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admision Odontologia</title>
        <link rel="shortcut icon" href="../images/favicon.png">
        <!--firma digital-->
        <link href="../assets/graphic/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->

        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/all.min.js"></script>
        <link href="../css/base.css" rel="stylesheet">
        <link rel="stylesheet" href="../assets/graphic/sweetalert2.min.css">
        <?php
        //funcion retorna true o false si no existe usertable en session false si es id diferente false
        //si ho hay usertable en session  FALSE
        //de usuario es true su multi llogion  TRUE
        //si el ip son diferentes FALSE
        if(!isset($_POST['noflush']))
            ob_end_flush();
        if(!ValidSession()){
            InvalidSession("admission/index.php");////funcion para expirar el session y registar 3= debug en logtable
            ForceLoad("../index.php");//index.php
        }

        if($_SESSION["usertable"]["usertype"] != "admission"){//system
            IntrusionNotify("admission/index.php");
            ForceLoad("../index.php");//index.php
        }
        ?>
    </head>
    <!--fin de head-->
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Odontologia UNSXX</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <?php
            if($main){
                echo "<div class=\"pl-4\">";
                echo "<span class=\"text-primary\"><b>Encargado Clinica Admisión:&nbsp;</b></span>";
                echo "<span class=\"text-white\">".$_SESSION['usertable']['userfullname']."</span>";
                echo "</div>";
            }
            ?>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
              <!--
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
                -->
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="" data-bs-toggle="modal" data-bs-target="#updateModal">Mi cuenta</a></li>
                        <li><a class="dropdown-item" href="#!">Mis notificaciones</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <?php if($main){ ?>
                            <li><a class="dropdown-item" href="newadmission.php?logout">Cerrar sesión</a></li>
                        <?php }else{ ?>
                            <li><a class="dropdown-item" href="../index.php">Cerrar sesión</a></li>
                        <?php } ?>

                    </ul>
                </li>
            </ul>
        </nav>
        <!--PARA ACTUALIZAR DATOS DEL USUARIO-->

        <!--PARA UPDATE-->
        <?php
        include '../optionlower.php';
        ?>

        <!--fin nav-->
        <!--inicio layoutSidenav-->
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">REMITIDOS</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tabla De Remitidos
                            </a>
                            <div class="sb-sidenav-menu-heading">Interfaz</div>

                            <a class="nav-link" href="listadmission.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Admisión
                            </a>
                            <a class="nav-link" href="follow.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Seguimiento a pacientes
                            </a>
                            <a class="nav-link" href="reportadmission.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Reportes Admisión
                            </a>
                            <!--paginas para modulos-->

                            <div class="sb-sidenav-menu-heading">Otros</div>
                            <a class="nav-link" href="statistics.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Estadisticas
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Registros
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">

                        <?php
                        if($main&& isset($_SESSION['usertable2']['userfullname'])&& $_SESSION['usertable2']['userfullname']!=''){
                            echo "<div class=\"small\">Ingresó para admisiones como:</div>";
                            echo $_SESSION["usertable2"]["userfullname"];
                        }else{
                          echo "<div class=\"small\">Logueado como:</div>";
                          echo $_SESSION["usertable"]["userfullname"];
                        }
                        ?>
                    </div>
                </nav>
            </div>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
