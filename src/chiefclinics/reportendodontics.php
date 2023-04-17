<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBEndodonticsInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=4&&$pat["clinicalid"]!=12)
    ForceLoad("index.php");
}else{
  ForceLoad("index.php");
}
$pat2=$r;
$pat=array_merge($pat, $pat2);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Home</title>
<style>

.container{
    text-align:center
}
.left{
    float: left;
}
.right{
    float: right;
}
.center{
   display:inline-block
}
.inline{
  display: inline-block
  float:left;
}

.check {
    background-color: #3361FF;
    border: 2px solid #ccc;
    border-radius: 50%;

}
.blue {
  background-color: #0E5DF0;
}
.yellow {
  background-color: #F0DB0E;
}
.red {
  background-color: #F01F0E;
}

.ajuste {
 height: 100%;
 width: 100%;
 object-fit: contain;
}

.cat {
 height:80px;
 width: 100px;
}
.idfolio{
  display: inline-block;
  float: right;
}


</style>
  </head>
  <body>

    <div class="container">
      <?php
      $dir='../images/';
      ?>
      <div align="center">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==12){
          echo "<font SIZE=4><b>FICHA CLINICA DE ENDODONCIA III</b></font>";
        }
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==4){
          echo "<font SIZE=4><b>FICHA CLINICA DE ENDODONCIA II</b></font>";
        }else{
          echo "<font SIZE=4><b>FICHA CLINICA DE ENDODONCIA III</b></font>";
        }
        ?>

      </div>

      <br>

      <div class="">
        <style media="screen">
          .alumno{
            float: left;
            display: inline-block;
            width: 50%
          }
          .curso{
            float: left;
            display: inline-block;
            width: 24%
          }
          .gestion{
            float: left;
            display: inline-block;
            width: 24%
          }
        </style>
        <div align="left" class="alumno">
          <?php
          $name="Universitario:";
          if(isset($pat) && $pat["student"]){
              $if=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
              echo $name;
          }else{
            echo $name."...................................................................";
          }
          ?>
        </div>
        <div align="left" class="curso">
          <?php
          $name="Curso:";
          if(isset($pat['endodonticsgrade']) && $pat["endodonticsgrade"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['endodonticsgrade'];
              echo $name;
          }else{
            echo $name."...............................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="Gestión:";
          if(isset($pat['endodonticsyear']) && $pat["endodonticsyear"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['endodonticsyear'];
              echo $name;
          }else{
            echo $name.".......................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div align="left" class="alumno">
          <?php
          $name="Paciente:";
          if(isset($pat["patientfullname"]) && $pat["patientfullname"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              echo $name;
          }else{
            echo $name."...........................................................................";
          }
          ?>
        </div>
        <div align="left" class="curso">
          <?php
          $name="Edad:";
          if(isset($pat['patientage']) && $pat["patientage"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientage'];
              echo $name;
          }else{
            echo $name.".................................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="Sexo:";
          if(isset($pat['patientgender']) && $pat["patientgender"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat['patientgender']);
              echo $name;
          }else{
            echo $name."............................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <style media="screen">
        .w50{
          float: left;
          display: inline-block;
          width: 48%;
        }
      </style>

      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Procedencia:";
          if(isset($pat['patientprovenance']) && $pat["patientprovenance"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientprovenance'];
              echo $name;
          }else{
            echo $name.".................................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="Ocupación:";
          if(isset($pat['patientoccupation']) && $pat["patientoccupation"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientoccupation'];
              echo $name;
          }else{
            echo $name."..................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Domicilio:";
          if(isset($pat['patientdirection']) && $pat["patientdirection"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientdirection'];
              echo $name;
          }else{
            echo $name."....................................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="Telf:";
          if(isset($pat['patientphone']) && $pat["patientphone"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientphone'];
              echo $name;
          }else{
            echo $name.".............................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>


      <br>
      <div class="">
        <style media="screen">
          .plan{
            display: inline-block;
            width: 25%;
          }
          .option{
            display: inline-block;
            width: 50%;
          }
        </style>
        <div class="plan">
          <div class="">
            Trabajos:
          </div>
          <br>

        </div>
        <div class="option">
          <div class="" align="left">

            <?php
            $name="Unirradicular:";
            if(isset($pat["trabajo1"]) && $pat["trabajo1"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."..........................................";
            }
            ?>
          </div>
          <div class="" align="left">

            <?php
            $name="Birradicular:";
            if(isset($pat["trabajo2"]) && $pat["trabajo2"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."............................................";
            }
            ?>
          </div>
          <div class="" align="left">

            <?php
            $name="Multiradicular:";
            if(isset($pat["trabajo3"]) && $pat["trabajo3"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."........................................";
            }
            ?>
          </div>
        </div>
      </div>

      <div class="">

          <div class="w50" align="left">
            <?php
            $name="Autorizado Dr. (a):";
            if(isset($pat["teacher"]) && $pat["teacher"]){
              $tea=DBUserInfo($pat['teacher']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tea["userfullname"];
              echo $name;
            }else{
              echo $name.".......................................................";
            }
            ?>
          </div>
          <div class="w50" align="left">
            <?php
            $name="Fecha de Inicio:";
            if(isset($pat["startdatetime"]) && $pat["startdatetime"]!=-1){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat["startdatetime"]);
              echo $name;
            }else{
              echo $name."...........................................................";
            }
            ?>
          </div>
      </div>

      <div style=" clear: both;"></div>
      <style media="screen">
        table {
           border: 1px solid #000;
           border-collapse: collapse;
        }
        th, td {
           border: 1px solid #000;
           padding: 0.1em;
        }
      </style>
      <!--inicio tabla de procedimientos-->
      <br>
      <div class="">
        <table width="100%">
          <thead>
            <tr>
              <th width="12%">Número de pieza</th>
              <th width="12%">Diagnóstico</th>
              <th width="12%">Rx Pre - operatoria</th>
              <th width="12%">Fecha de Inicio</th>
              <th width="12%">Vo.Bo. Apertura</th>
              <th width="12%">Rx Conductometría</th>
              <th width="12%">Obturación</th>
              <th width="12%">Rx Post - operatoria</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $isEmpty=true;
            if(isset($pat['tableprocedures'])&&isset($pat['tableprocedures']['pieza'])&&$pat['tableprocedures']){
              $size=count($pat['tableprocedures']['pieza']);
              $content="";
              for ($i=0; $i < $size; $i++) {
                $content.="<tr>";

                if($pat['tableprocedures']['pieza'][$i]=='')
                  $content.="<td><br><br></td>";
                else
                  $content.="<td>".$pat['tableprocedures']['pieza'][$i]."</td>";
                $content.="<td>".$pat['tableprocedures']['clase'][$i]."</td>";
                $log=explode('=',$pat['tableprocedures']['caries'][$i]);
                if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
                  $content.="<td>Si<br>".datetimeconv($log[1])."</td>";
                }else{
                  $content.="<td></td>";
                }
                $log=explode('=',$pat['tableprocedures']['inicio'][$i]);
                if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
                  $content.="<td>Si<br>".datetimeconv($log[1])."</td>";
                }else{
                  $content.="<td></td>";
                }
                $log=explode('=',$pat['tableprocedures']['preparacion'][$i]);
                if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
                  $content.="<td>Si<br>".datetimeconv($log[1])."</td>";
                }else{
                  $content.="<td></td>";
                }
                $log=explode('=',$pat['tableprocedures']['cavitaria'][$i]);
                if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
                  $content.="<td>Si<br>".datetimeconv($log[1])."</td>";
                }else{
                  $content.="<td></td>";
                }
                $content.="<td>".$pat['tableprocedures']['obturacion'][$i]."</td>";
                $log=explode('=',$pat['tableprocedures']['pulido'][$i]);
                if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
                  $content.="<td>Si<br>".datetimeconv($log[1])."</td>";
                }else{
                  $content.="<td></td>";
                }
                $content.="</tr>";
              }
              if($content!=""){
                echo $content;
                $isEmpty=false;
              }
            }
            if($isEmpty){
              $content="<tr>";
              $content.="<td width=\"12%\"><br><br><br></td><td width=\"12%\"></td><td width=\"12%\"></td><td width=\"12%\"></td><td width=\"12%\"></td><td width=\"12%\"></td><td width=\"12%\"></td><td width=\"12%\"></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              echo $content;
            }
            ?>
          </tbody>
        </table>
        <br>
        <div class="" align="left">
          <?php
          $name="Tratamiento(s) concluido(s): ";
          if(isset($pat['treatmentdesc'])&&$pat['treatmentdesc']){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;".$pat['treatmentdesc'];
          }else{
            $name.="...............................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <br>
        <div class="">
          <div class="w50" align="left">
            <?php
            $name="Fecha: ";
            if(isset($pat['treatmentdate'])&&$pat['treatmentdate']){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;".$pat['treatmentdate'];
            }else{
              $name.="..........................................................................";
            }
            echo $name;
            ?>
          </div>
          <div class="w50" align="left">
            <?php
            $name="Firma del Docente: ";
            if(isset($pat['treatmentfirm'])&&$pat['treatmentfirm']=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;Si";
            }else{
              $name.=".......................................................";
            }
            echo $name;
            ?>
          </div>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <!--fin tabla de procedimientos-->




      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
          .edad{
            display: inline-block;
            float: left;
            width: 15%;
          }
          .pro{
            display: inline-block;
            float: left;
            width: 40%;
          }
        </style>

      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
        .tres2{
          display: inline-block;
          float: left;
          width: 20%;
        }
        .grado{
          display: inline-block;
          float: left;
          width: 40%;
        }
        .nac{
          display: inline-block;
          float: left;
          width: 28%;
        }
        </style>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <br>

    <div align="center" class="">
      <b>ODONTOGRAMA</b>
    </div>


    <br>
    <style media="screen">
      .separador{
        width: 40px;
        height: 75px;
        display: inline-block;
      }
      .separador2{
        width: 117px;
        height: 75px;
        display: inline-block;
      }
      .sep{
        width: 55px;
        display: inline-block;
      }
      .pieza{
        width: 35px;
        height: 75px;
        display: inline-block;

      }
      .piezapp{
        width: 35px;
        height: 60px;
        display: inline-block;

        position: relative;
        left: 50px;
        /*background-color: #ff0000;*/
      }
      img {
      max-width: 100%;
      max-height: 100%;
      }
      .piezap{
        /*background-color: #ff0000;*/
        display: inline-block;
        /*position: relative;
        width: 35px;*/
        height: 7%;
        width: 5%;
      }

      .catimg {
        /*width: 50px;*/
        /*background-color: #0000FF;*/
        height: 78%;
        width: 100%;
      }

      .cuadro{
        display: inline-block;
        width: 49%;
        height: 100px;

      }
      .t{
        clear:float;
        float: left;
        margin-top: 25px;
        margin-left: 9px;
      }
      .f{
        clear:float;
        float: left;
        margin-top: 25px;
        /*margin-left: 9px;*/
      }
      .l{
        clear:float;
        float: left;
        margin-top: 34px;
      }
      .c{

        clear:float;
        float: left;
        margin-top: 34px;
        margin-left: 9px;
      }
      .r{
        clear:float;
        float: left;
        margin-top: 34px;
        margin-left: 24px;
      }
      .b{
        clear:float;
        float: left;
        margin-top: 47px;
        margin-left: 9px;
      }

      .to{
        clear:float;
        float: left;
        margin-top: 20px;
        margin-left: 0px;
      }
      .lo{
        clear:float;
        float: left;
        margin-top: 20px;
        margin-left: 20px;
      }
      .ro{
        clear:float;
        float: left;
        margin-top: 20px;
        margin-left: 0px;
      }
      .bo{
        clear:float;
        float: left;
        margin-top: 40px;
        margin-left: 0px;
      }

      .st{
        clear:float;
        float: left;
        margin-top: 25px;
        margin-left: 9px;
      }
      .sl{
        clear:float;
        float: left;
        margin-top: 34px;
      }
      .sc{

        clear:float;
        float: left;
        margin-top: 34px;
        margin-left: 9px;
      }
      .sr{
        clear:float;
        float: left;
        margin-top: 34px;
        margin-left: 24px;
      }
      .sb{
        clear:float;
        float: left;
        margin-top: 47px;
        margin-left: 9px;
      }

      .number{
        margin-left: 10px;
        clear:float;
        float: left;
      }
    </style>
    <br>
    <div style="clear:both;"></div>
    <?php
    $a= array();
    $a['diente18-a']='';$a['diente17-a']='';$a['diente16-a']='';$a['diente15-a']='';$a['diente14-a']='';$a['diente13-a']='';$a['diente12-a']='';$a['diente11-a']='';
    $a['diente21-a']='';$a['diente22-a']='';$a['diente23-a']='';$a['diente24-a']='';$a['diente25-a']='';$a['diente26-a']='';$a['diente27-a']='';$a['diente28-a']='';

    $a['diente41b-a']='';$a['diente42b-a']='';$a['diente43b-a']='';$a['diente44b-a']='';$a['diente45b-a']='';$a['diente46b-a']='';$a['diente47b-a']='';$a['diente48b-a']='';
    $a['diente31b-a']='';$a['diente32b-a']='';$a['diente33b-a']='';$a['diente34b-a']='';$a['diente35b-a']='';$a['diente36b-a']='';$a['diente37b-a']='';$a['diente38b-a']='';


    //echo $pat['periodonticsiigram'];
    //echo $pat['periodonticsiioleary'];
    if(isset($pat['endodonticsodontogram'])&&$pat['endodonticsodontogram']!=''){

      $gramdata=explode(']', $pat['endodonticsodontogram']);
      $n=count($gramdata);

      for($i=0;$i<$n-1;$i++){
        $data=explode('[',$gramdata[$i]);
        $data=explode('=',$data[1]);

        $a[$data[0]]=trim($data[1]);

      }
    }
    echo "<div style=\"clear:both;\"></div>";
    //echo $gram;

    echo "<br>";
    echo "<div class=\"sep\"></div>";

    $dir1='../images/img/';
    $dir2='';
    for ($i=1; $i <= 2 ; $i++) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezap\">";
          $jj=$j;
          $nameimg="";
          if($i==1){
              echo "  <span>".$i.$j."</span>";
              $dir2=$dir1."tabla1/";
          }
          else{
            echo "  <span>".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
            $dir2=$dir1."tabla2/";
          }

          if($a['diente'.$i.$jj.'-a']!=''){
            $dir2.=$a['diente'.$i.$jj.'-a'].'/';
          }
          $nameimg="periodontograma-dientes-arriba-".$i.$jj.".png";

          echo "<div class=\"catimg\">";
          echo "  <img src=\"".getPieza($nameimg,$dir2)."\" alt=\"\">";
          echo "</div>";

          echo "</div>\n";
      }
    }


    echo "<div style=\"clear:both;\"></div>";
    //inferior
    echo "<br>";
    echo "<div class=\"sep\"></div>";
    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezap\">";
          $jj=$j;
          if($i==4){
            $dir2=$dir1."tabla7/";
          }else{
            $jj=(($j-9)*(-1));
            $dir2=$dir1."tabla8/";
          }
          if($a['diente'.$i.$jj.'b-a']!=''){
            $dir2.=$a['diente'.$i.$jj.'b-a'].'/';
          }
          $nameimg="periodontograma-dientes-abajo-".$i.$jj."b.png";
          echo "<div class=\"catimg\">";
          echo "  <img src=\"".getPieza($nameimg, $dir2)."\" alt=\"\">";
          echo "</div>";
          if($i==4){
            echo "  <span>".$i.$j."</span>";
          }else{
            echo "  <span>".$i.(($j-9)*(-1))."</span>";
          }

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    echo "<br>";


    ?>
    <div style="clear:both;"></div>
    <!--pagina 2-->
    <div style="page-break-before: always;"></div>
    <style media="screen">
      .ttable{
        margin-left: 80px;
        margin-right: 80px;
      }
    </style>
    <br>
    <br>
    <br>
    <div class="ttable">
      <table width="100%">
        <thead>
          <th>MATERIALES</th>
          <th>DESPACHADO</th>
        </thead>
        <tbody>
          <tr>
            <td width="50%">
              <?php
              if(isset($pat["endodonticsmaterial"])&& $pat["endodonticsmaterial"]){
                $pat["endodonticsmaterial"] = str_replace("\n", "*", $pat["endodonticsmaterial"]);
                $datad=explode('*',$pat["endodonticsmaterial"]);
                //echo $pat["description"];
                $len=count($datad);
                if($len!=0){
                  for($i=0;$i<$len;$i++){
                    echo "&nbsp;&nbsp;".$datad[$i]."<br>";
                  }
                }
              }
              ?>
            </td>
            <td width="50%">
              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <br><br>


    <div class="">
      <?php
      $name="Trabajo Concluido el:&nbsp;&nbsp;&nbsp;&nbsp;";
      if(isset($pat['enddatetime'])&&$pat['enddatetime']!=-1){
        $name.=datetimeconv($pat['enddatetime']);
      }else {
        $name.=".................................................................";
      }
      echo $name;
      ?>
    </div>

    <div class="" align="left">
      Observaciones:
    </div>
    <div class="" align="left">
      <?php
      if(isset($pat["observationdesc"])&& $pat["observationdesc"]){
        $pat["observationdesc"] = str_replace("\n", "*", $pat["observationdesc"]);
        $datad=explode('*',$pat["observationdesc"]);
        //echo $pat["description"];
        $len=count($datad)-1;
        if($len!=0){
          for($i=0;$i<$len;$i++){
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
        }else{
          echo ".........................................................................................................................................................................<br>";
          echo ".........................................................................................................................................................................<br>";
        }
      }else{
        echo ".........................................................................................................................................................................<br>";
        echo ".........................................................................................................................................................................<br>";
      }
      ?>
    </div>
















<!--PAGINA 1 FIN-->

<!--PAGINA 2 INICIO
<div style="page-break-before: always;"></div>
<h1>grover sierra</h1>-->



<!--PAGINA 2 FIN-->


  </body>

</html>


<?php
//https://parzibyte.me/blog/2019/12/25/generar-pdf-php-dompdf/ 9:00pm a 11:30pm
//https://programmerclick.com/article/89841075890/
$html=ob_get_clean();
//$html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" ...>';
//$html = file_get_contents(__DIR__ . '/hoja.php');
//echo $html;
//sudo apt-get install php7.0-mbstring
//apt-get install php7.2-xml

//require '../vendor/autoload.php';
require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;

//use Dompdf\Options;//nueva
//$options=new Options();
//$options->setchroot(__DIR__);
//$options->set('isRemoteEnebled',TRUE);

$dompdf=new Dompdf();

//https://noviello.it/es/como-instalar-composer-en-ubuntu-20-04-lts/
$options=$dompdf->getOptions();
$options->set(array('isRemoteEnebled'=>true));
$dompdf->setOptions($options);
$options->setIsHtml5ParserEnabled(true);
//$dompdf->loadHtml($html);

$dompdf->loadHtml($html);
$dompdf->setPaper('letter');

$dompdf->render();
$type=false;
if(!isset($_GET["id"]))
  $type=false;
$dompdf->stream("archivo_.pdf",array("Attachment"=>$type));


?>
