<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

$results_per_page = 15;
$clinicalids="";

$page = isset($_POST['page']) ? $_POST['page'] : 1; //pagina actual
$patientfullname = isset($_POST['patientfullname']) ? htmlspecialchars(trim($_POST['patientfullname'])) : "";
$studentfullname = isset($_POST['studentfullname']) ? htmlspecialchars(trim($_POST['studentfullname'])) : "";
$startage = isset($_POST['startage'])&&is_numeric($_POST['startage']) ? $_POST['startage'] : 0;
$endage = isset($_POST['endage'])&&is_numeric($_POST['endage']) ? $_POST['endage'] : 100;

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


$gender="";
if(isset($_POST['gender'])&& !empty($_POST['gender'])){
  if($_POST['gender'] == 'm') $gender = 'masculino';
  else $gender = 'femenino';
}

if($startage > $endage){
  $tmpage=$startage;
  $startage=$endage;
  $endage=$tmpage;
}

if(isset($_POST['checkboxStates'])){
  $checkboxStates = json_decode($_POST['checkboxStates'], true);
  $ac = array(2, 10, 3, 11, 4, 12, 5, 13, 6, 14, 7, 15, 8, 16, 9, 17);
  $clinicalids="";
  for ($i=0; $i < count($checkboxStates); $i++) {
    if($checkboxStates[$i]){
      if(!empty($clinicalids)){
        $clinicalids.=", ";
      }
      $clinicalids.=$ac[$i];
    }
  }
}

$tabledata='';
$paginationdata='';
$pr=DBAllPatientAdmission($patientfullname, $startage, $endage, $gender, $clinicalids, $studentfullname,
                                          $stdate, $endate);
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
    <div class="row">
      <?php
      $dir='../images/';
      $cdirunsxx = $dir."unsxx.jpeg";
      $cdir = $dir."odontologia.jpg";
      $cunsxx = "data:image/jpg;base64," . base64_encode(file_get_contents($cdirunsxx));
      $c = "data:image/jpg;base64," . base64_encode(file_get_contents($cdir));
      ?>
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
      <div class="col-12">
        <table border="1" width="100%">
          <thead>
            <tr align="center">
              <th>#</th>
              <th>Cod.</th>
              <th>Paciente</th>
              <th>Edad</th>
              <th>Genero</th>
              <th>Remisión</th>
              <th>Est. Designado</th>
              <th>Fecha de registro</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $size=count($pr);
            $tabledata="";
            for ($i=0; $i < $size; $i++) {
                  $tabledata .= " <tr>\n";
                  $tabledata .= "   <td>" . ($i+1). "</td>";
                  $tabledata .= "   <td>" . $pr[$i]['patientadmissionid']. "</td>";
                  $tabledata .= "   <td>". $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
                  $tabledata .= "   <td>" . $pr[$i]["patientage"] . "</td>";
                  $tabledata .= "   <td>" . ucfirst($pr[$i]["patientgender"]) . "</td>";
                  $tabledata .= "   <td>" . $pr[$i]["clinicalspecialty"] . "</td>";

                  $tabledata .= "   <td>" . ucwords($pr[$i]["userfullname"]) ."</td>";
                  $tabledata .= "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";

                  $tabledata .= "</tr>";
            }
            echo $tabledata;
            ?>
          </tbody>
        </table>
        <?php
        echo "<i>#$i Pacientes Remitidos</i> <br>";
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
