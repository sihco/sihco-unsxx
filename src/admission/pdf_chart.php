<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

$currdate=time();
$stdate = isset($_POST['stdate']) ? $_POST['stdate'] : '2023-01-01';
$endate = isset($_POST['endate']) ? $_POST['endate'] : date("Y-m-d", $currdate);

$stdate = strtotime($stdate);
$endate = strtotime($endate);
if($stdate>$endate){
  $tmpdate=$stdate;
  $stdate=$endate;
  $endate=$tmpdate;
}
if($endate >= strtotime(date("Y-m-d", $currdate))){
  $endate=time();
}else{
  $endate=$endate+3600*24-1;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reporte Admision</title>
<style>
.bg-primary{
  background-color: blue;
}
.bg-danger{
  background-color: red;
}
.bg-yellow{
  background-color: yellow;
}
.row{
  font-size: 0;
}
.fs-1{ font-size: 5px !important;}
.fs-2{ font-size: 10px !important;}
.fs-3{ font-size: 15px !important;}
.fs-4{ font-size: 20px !important;}
.fs-5{ font-size: 25px !important;}
.fs-6{ font-size: 30px !important;}
.fs-7{ font-size: 35px !important;}
.fs-8{ font-size: 40px !important;}
.fs-9{ font-size: 50px !important;}
.fs-10{ font-size: 55px !important;}
.fs-11{ font-size: 60px !important;}
.fs-12{ font-size: 65px !important;}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12{
  display: inline-block;
  font-size: 16px;
}
.col-1 { width: 8.33%;}
.col-2 { width: 16.66%;}
.col-3 { width: 25%;}
.col-4 { width: 33.33%;}
.col-5 { width: 41.66%;}
.col-6 { width: 50%;}
.col-7 { width: 58.33%;}
.col-8 { width: 66.66%;}
.col-9 { width: 75%;}
.col-10 { width: 83.33%;}
.col-11 { width: 91.66%;}
.col-12 { width: 100%;}

img {
  height: 100%;
  width: 100%;
}
.img-1 {
  width: 100px;
  height: 80px;
}
.img-unsxx {
  width: 65px;
  height: 80px;
}
.img-chart {
  width: 680px;
  height: 400px;
}
.pl-1{
  padding-left: 23px !important;
}
table {
   border: 1px solid #000;
   border-collapse: collapse;
}
th, td {
   border: 1px solid #000;
   padding: 0.1em;
}
</style>
  </head>
  <body>
    <?php
    $dir='../images/';
    $cdirunsxx = $dir."unsxx.jpeg";
    $cdir = $dir."odontologia.jpg";
    $cunsxx = "data:image/jpg;base64," . base64_encode(file_get_contents($cdirunsxx));
    $c = "data:image/jpg;base64," . base64_encode(file_get_contents($cdir));

    $std=date('Y-m-d', $stdate);
    $end=date('Y-m-d', $endate);

    //funcion para sacar numero de pacientes
    $a = DBCountpatientclinicalInfo($stdate, $endate);
    $prosthodontics= array(0,0,0,0);
    $operative=array(0,0,0,0);
    $surgery=array(0,0,0,0);
    $pediatrics=array(0,0,0,0);

    for ($i=0; $i < count($a); $i++) {
      switch ($a[$i]['clinicalid']) {
        case 2: $prosthodontics[0] = $a[$i]['amount']; break;
        case 3: $prosthodontics[1] = $a[$i]['amount']; break;
        case 10: $prosthodontics[2] = $a[$i]['amount']; break;
        case 11: $prosthodontics[3] = $a[$i]['amount']; break;

        case 4: $operative[0] = $a[$i]['amount']; break;
        case 5: $operative[1] = $a[$i]['amount']; break;
        case 12: $operative[2] = $a[$i]['amount']; break;
        case 13: $operative[3] = $a[$i]['amount']; break;

        case 6: $surgery[0] = $a[$i]['amount']; break;
        case 7: $surgery[1] = $a[$i]['amount']; break;
        case 14: $surgery[2] = $a[$i]['amount']; break;
        case 15: $surgery[3] = $a[$i]['amount']; break;

        case 8: $pediatrics[0] = $a[$i]['amount']; break;
        case 9: $pediatrics[1] = $a[$i]['amount']; break;
        case 16: $pediatrics[2] = $a[$i]['amount']; break;
        case 17: $pediatrics[3] = $a[$i]['amount']; break;
      }
    }
    ?>

    <div class="row">
      <div class="col-2" align = "center">
        <div class="img-unsxx pl-1">
          <img src="<?php echo $cunsxx; ?>" alt="">
        </div>
      </div>
      <div class="col-8" align="center">
        <div class="fs-4"><b>UNIVERSIDAD NACIONAL "SIGLO XX"</b></div>
        <div class="fs-4"><b>CARRERA ODONTOLOGIA</b></div>
        <div class="fs-3"><i>UNIDAD ACADEMICA ACREDITADA AL C.E.U.B</i></div>
        <div class="fs-3"><i>POR RESOLUCION N<sup>0</sup> 006/2016 DE LA IX CENU</i></div>
        <div class="fs-3"><i>ACREDITADA AL SISTEMA ARCU-SUR POR RES. N<sup>0</sup> 026/2023</i></div>
      </div>
      <div class="col-2" align="right">
        <div class="img-1">
          <img src="<?php echo $c; ?>" alt="">
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12" align="center">
        <?php
        echo 'Llallagua, ';
        if($std == $end){
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate);
        }else{
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate)." al ".dateconvmonth($endate)." ".dateconvday($endate)." del ".dateconvyear($endate);
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p align="center" style="font-size:18px">MODULO PROSTODONCIA</p>
        <div class="img-chart" align="center">
          <?php
          if(isset($_POST['prostpng'])){
            $img = $_POST['prostpng'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            echo "<img src='data:image/png;base64,".base64_encode($fileData)."' alt='Imagen'>";
          }
          ?>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<b>#".$prosthodontics[0]."</b> Pacientes admitidos a la especilidad Prostodoncia Removible II<br><br>";
        echo "<b>#".$prosthodontics[1]."</b> Pacientes admitidos a la especilidad Prostodoncia Fija II<br><br>";
        echo "<b>#".$prosthodontics[2]."</b> Pacientes admitidos a la especilidad Prostodoncia Removible III<br><br>";
        echo "<b>#".$prosthodontics[3]."</b> Pacientes admitidos a la especilidad Prostodoncia Fija III<br><br>";
        echo "<b>Total #".($prosthodontics[0]+$prosthodontics[1]+$prosthodontics[2]+$prosthodontics[3])." pacientes admitidos al MODULO PROSTODONCIA </b>";
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<i>Datos del SIHCO (Sistema de Historial Clinico Odontologico) - UNSXX</i>";
        ?>
      </div>
    </div>
    <!--SEGUNDA PAGINA-->
    <div style="page-break-before: always;"></div>

    <div class="row">
      <div class="col-2" align = "center">
        <div class="img-unsxx pl-1">
          <img src="<?php echo $cunsxx; ?>" alt="">
        </div>
      </div>
      <div class="col-8" align="center">
        <div class="fs-4"><b>UNIVERSIDAD NACIONAL "SIGLO XX"</b></div>
        <div class="fs-4"><b>CARRERA ODONTOLOGIA</b></div>
        <div class="fs-3"><i>UNIDAD ACADEMICA ACREDITADA AL C.E.U.B</i></div>
        <div class="fs-3"><i>POR RESOLUCION N<sup>0</sup> 006/2016 DE LA IX CENU</i></div>
        <div class="fs-3"><i>ACREDITADA AL SISTEMA ARCU-SUR POR RES. N<sup>0</sup> 026/2023</i></div>
      </div>
      <div class="col-2" align="right">
        <div class="img-1">
          <img src="<?php echo $c; ?>" alt="">
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12" align="center">
        <?php
        echo 'Llallagua, ';
        if($std == $end){
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate);
        }else{
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate)." al ".dateconvmonth($endate)." ".dateconvday($endate)." del ".dateconvyear($endate);
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p align="center" style="font-size:18px">MODULO OPERATORIA</p>
        <div class="img-chart" align="center">
          <?php
          if(isset($_POST['operapng'])){
            $img = $_POST['operapng'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            echo "<img src='data:image/png;base64,".base64_encode($fileData)."' alt='Imagen'>";
          }
          ?>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<b>#".$operative[0]."</b> Pacientes admitidos a la especilidad Operatoria Dental II<br><br>";
        echo "<b>#".$operative[1]."</b> Pacientes admitidos a la especilidad Endodoncia II<br><br>";
        echo "<b>#".$operative[2]."</b> Pacientes admitidos a la especilidad Operatoria Dental III<br><br>";
        echo "<b>#".$operative[3]."</b> Pacientes admitidos a la especilidad Endodoncia III<br><br>";
        echo "<b>Total #".($operative[0]+$operative[1]+$operative[2]+$operative[3])." pacientes admitidos al MODULO OPERATORIA </b>";
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<i>Datos del SIHCO (Sistema de Historial Clinico Odontologico) - UNSXX</i>";
        ?>
      </div>
    </div>

    <!--TERCERA PAGINA-->
    <div style="page-break-before: always;"></div>

    <div class="row">
      <div class="col-2" align = "center">
        <div class="img-unsxx pl-1">
          <img src="<?php echo $cunsxx; ?>" alt="">
        </div>
      </div>
      <div class="col-8" align="center">
        <div class="fs-4"><b>UNIVERSIDAD NACIONAL "SIGLO XX"</b></div>
        <div class="fs-4"><b>CARRERA ODONTOLOGIA</b></div>
        <div class="fs-3"><i>UNIDAD ACADEMICA ACREDITADA AL C.E.U.B</i></div>
        <div class="fs-3"><i>POR RESOLUCION N<sup>0</sup> 006/2016 DE LA IX CENU</i></div>
        <div class="fs-3"><i>ACREDITADA AL SISTEMA ARCU-SUR POR RES. N<sup>0</sup> 026/2023</i></div>
      </div>
      <div class="col-2" align="right">
        <div class="img-1">
          <img src="<?php echo $c; ?>" alt="">
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12" align="center">
        <?php
        echo 'Llallagua, ';
        if($std == $end){
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate);
        }else{
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate)." al ".dateconvmonth($endate)." ".dateconvday($endate)." del ".dateconvyear($endate);
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p align="center" style="font-size:18px">MODULO CIRUGIA</p>
        <div class="img-chart" align="center">
          <?php
          if(isset($_POST['surgepng'])){
            $img = $_POST['surgepng'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            echo "<img src='data:image/png;base64,".base64_encode($fileData)."' alt='Imagen'>";
          }
          ?>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<b>#".$surgery[0]."</b> Pacientes admitidos a la especilidad Cirugia Bucal II<br><br>";
        echo "<b>#".$surgery[1]."</b> Pacientes admitidos a la especilidad Periodoncia II<br><br>";
        echo "<b>#".$surgery[2]."</b> Pacientes admitidos a la especilidad Cirugia Bucal III<br><br>";
        echo "<b>#".$surgery[3]."</b> Pacientes admitidos a la especilidad Periodoncia III<br><br>";
        echo "<b>Total #".($surgery[0]+$surgery[1]+$surgery[2]+$surgery[3])." pacientes admitidos al MODULO CIRUGIA </b>";
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<i>Datos del SIHCO (Sistema de Historial Clinico Odontologico) - UNSXX</i>";
        ?>
      </div>
    </div>

    <!--CUARTA PAGINA-->
    <div style="page-break-before: always;"></div>

    <div class="row">
      <div class="col-2" align = "center">
        <div class="img-unsxx pl-1">
          <img src="<?php echo $cunsxx; ?>" alt="">
        </div>
      </div>
      <div class="col-8" align="center">
        <div class="fs-4"><b>UNIVERSIDAD NACIONAL "SIGLO XX"</b></div>
        <div class="fs-4"><b>CARRERA ODONTOLOGIA</b></div>
        <div class="fs-3"><i>UNIDAD ACADEMICA ACREDITADA AL C.E.U.B</i></div>
        <div class="fs-3"><i>POR RESOLUCION N<sup>0</sup> 006/2016 DE LA IX CENU</i></div>
        <div class="fs-3"><i>ACREDITADA AL SISTEMA ARCU-SUR POR RES. N<sup>0</sup> 026/2023</i></div>
      </div>
      <div class="col-2" align="right">
        <div class="img-1">
          <img src="<?php echo $c; ?>" alt="">
        </div>
      </div>
    </div>
    <hr>
    <div class="row">
      <div class="col-12" align="center">
        <?php
        echo 'Llallagua, ';
        if($std == $end){
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate);
        }else{
          echo dateconvmonth($stdate)." ".dateconvday($stdate)." del ".dateconvyear($stdate)." al ".dateconvmonth($endate)." ".dateconvday($endate)." del ".dateconvyear($endate);
        }
        ?>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <p align="center" style="font-size:18px">MODULO ODONTOPEDIATRIA</p>
        <div class="img-chart" align="center">
          <?php
          if(isset($_POST['pediapng'])){
            $img = $_POST['pediapng'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $fileData = base64_decode($img);
            echo "<img src='data:image/png;base64,".base64_encode($fileData)."' alt='Imagen'>";
          }
          ?>
        </div>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<b>#".$pediatrics[0]."</b> Pacientes admitidos a la especilidad Odontopediatria I<br><br>";
        echo "<b>#".$pediatrics[1]."</b> Pacientes admitidos a la especilidad Ortodoncia I<br><br>";
        echo "<b>#".$pediatrics[2]."</b> Pacientes admitidos a la especilidad Odontopediatria II<br><br>";
        echo "<b>#".$pediatrics[3]."</b> Pacientes admitidos a la especilidad Ortodoncia II<br><br>";
        echo "<b>Total #".($pediatrics[0]+$pediatrics[1]+$pediatrics[2]+$pediatrics[3])." pacientes admitidos al MODULO ODONTOPEDIATRIA </b>";
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <?php
        echo "<i>Datos del SIHCO (Sistema de Historial Clinico Odontologico) - UNSXX</i>";
        ?>
      </div>
    </div>

  </body>

</html>


<?php
$html=ob_get_clean();
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

$dompdf=new Dompdf();
$options=$dompdf->getOptions();
$options->set(array('isRemoteEnebled'=>true));
$dompdf->setOptions($options);
$options->setIsHtml5ParserEnabled(true);
$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();
$type=false;
$dompdf->stream("Reporte_Admision.pdf",array("Attachment"=>$type));

?>
