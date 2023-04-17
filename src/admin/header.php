
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
        <title>Admin Odontologia</title>
        <link rel="shortcut icon" href="../images/favicon.png">


        <link href="../assets/graphic/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">-->

        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/all.min.js"></script>
        <link href="../css/base.css" rel="stylesheet">

        <?php
        //funcion retorna true o false si no existe usertable en session false si es id diferente false
        //si ho hay usertable en session  FALSE
        //de usuario es true su multi llogion  TRUE
        //si el ip son diferentes FALSE
        if(!isset($_POST['noflush']))
            ob_end_flush();
        if(!ValidSession()){
            InvalidSession("admin/index.php");////funcion para expirar el session y registar 3= debug en logtable
            ForceLoad("../index.php");//index.php
        }
        $_SESSION["usertable"]["contestnumber"]=0;//para ejercicios generales
        if($_SESSION["usertable"]["usertype"] != "admin"){//system
            IntrusionNotify("admin/index.php");
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
                        <li><a class="dropdown-item" href="../index.php">Salir del sistema</a></li>
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
                            <div class="sb-sidenav-menu-heading">MODULOS</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Tabla de Fichas Clinicas
                            </a>
                            <div class="sb-sidenav-menu-heading">Interfaz</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Usuarios
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="user.php">Usuarios</a>
                                    <a class="nav-link" href="decide.php">Inscribir a Clínica</a>
                                    <a class="nav-link" href="log.php">System</a>
                                </nav>
                            </div>
                            <!--paginas para modulos-->
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                                <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                                Fichas de Admisión
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">

                                    <a class="nav-link" href="admission.php">Nueva Admisión</a>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        PROSTODONCIA
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="tremovibleii.php">Prostodoncia Removible II</a>
                                            <a class="nav-link" href="tremovibleiii.php">Prostodoncia Removible III</a>
                                            <a class="nav-link" href="tfijaii.php">Prostodoncia Fija II</a>
                                            <a class="nav-link" href="tfijaiii.php">Prostodoncia Fija III</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        OPERATORIA
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="toperatoriaii.php">Operatoria Dental II</a>
                                            <a class="nav-link" href="tendodonciaii.php">Endodoncia II</a>
                                            <a class="nav-link" href="toperatoriaiii.php">Operatoria Dental III</a>
                                            <a class="nav-link" href="tendodonciaiii.php">Endodoncia III</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError2" aria-expanded="false" aria-controls="pagesCollapseError2">
                                        CIRUGIA
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError2" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="tcirugiaii.php">CIRUGIA BUCAL II</a>
                                            <a class="nav-link" href="tperiodonciaii.php">PERIODONCIA II</a>
                                            <a class="nav-link" href="tcirugiaiii.php">CIRUGIA BUCAL III</a>
                                            <a class="nav-link" href="tperiodonciaiii.php">PERIODONCIA III</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError3" aria-expanded="false" aria-controls="pagesCollapseError3">
                                        ODONTOPEDIATRIA
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError3" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="todontopediatriai.php">Odontopediatria I</a>
                                            <a class="nav-link" href="tortodonciai.php">Ortodoncia I</a>
                                            <a class="nav-link" href="todontopediatriaii.php">Odontopediatria II</a>
                                            <a class="nav-link" href="tortodonciaii.php">Ortodoncia II</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
                            <div class="sb-sidenav-menu-heading">Otros</div>
                            <a class="nav-link" href="statistics.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                                Estadisticas
                            </a>
                            <a class="nav-link" href="backup.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                                backup
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logueado como:</div>
                        <?php echo $_SESSION["usertable"]["userfullname"]; ?>
                    </div>
                </nav>
            </div>
            <!--inicio de div contenido-->
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
