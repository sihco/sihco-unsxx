
<!--HEADER PARA ADMINISTRADOR-->
<?php
ob_start();
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");

header("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <link rel="icon" href="data:;base64,iVBORw0KGgo=">

        <title>Admision Odontologia</title>
        <!--firma digital-->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>-->
        <script src="../assets/graphic/signature_pad.min.js"></script>

        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">-->
        <link rel="stylesheet" href="../assets/graphic/bootstrap.min.css">

        <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">-->
        <link rel="stylesheet" href="../assets/graphic/font-awesome.min.css">

        <!--<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />-->
        <link rel="stylesheet" href="../assets/graphic/jquery.dataTables.min.css">

        <link href="../css/styles.css" rel="stylesheet" />
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/all.min.js"></script>
        <!-- Bootstrap CSS -->
        <link href="../css/base.css" rel="stylesheet">

        <!--<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">-->
        <link rel="stylesheet" href="../assets/graphic/font-awesome2.min.css">
        <?php
        //funcion retorna true o false si no existe usertable en session false si es id diferente false
        //si ho hay usertable en session  FALSE
        //de usuario es true su multi llogion  TRUE
        //si el ip son diferentes FALSE
        if(!isset($_POST['noflush']))
            ob_end_flush();
        if(!ValidSession()){
            InvalidSession("chiefclinics/index.php");////funcion para expirar el session y registar 3= debug en logtable
            ForceLoad("../index.php");//index.php
        }
        $_SESSION["usertable"]["contestnumber"]=0;//para ejercicios generales
        if($_SESSION["usertable"]["usertype"] != "chiefclinics"){//system
            IntrusionNotify("chiefclinics/index.php");
            ForceLoad("../index.php");//index.php
        }
        ?>

    </head>
    <!--fin de head-->
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.html">Odontologia UNSXX</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
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
                        <li><a class="dropdown-item" href="" data-toggle="modal" data-target="#updateModal">Mi cuenta</a></li>
                        <li><a class="dropdown-item" href="#!">Mis notificaciones</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../index.php">Logout</a></li>
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
                                Fichas Clinicas
                            </a>
                            <div class="sb-sidenav-menu-heading">Interfaz</div>

                            <a class="nav-link" href="decide.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Inscribir Clínica
                            </a>

                            <!--paginas para modulos-->


                            <div class="sb-sidenav-menu-heading">Otros</div>
                            <a class="nav-link" href="statistics.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Estadisticas
                            </a>
                            <!--<a class="nav-link" href="register.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                Registros
                            </a>-->
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logueado como:</div>
                        <?php echo $_SESSION["usertable"]["userfullname"]; ?>
                    </div>
                </nav>
            </div>
            <!--inicio de div contenido-->
