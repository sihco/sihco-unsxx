<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBRemovableInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=1&&$pat["clinicalid"]!=9)
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
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==9){
          echo "<font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA REMOVIBLE III</b></font>";
        }elseif(isset($pat["clinicalid"])&&$pat["clinicalid"]==1){
          echo "<font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA REMOVIBLE II</b></font>";
        }else{
          echo "<font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA REMOVIBLE II</b></font>";
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
          $name="Alumno:";
          if(isset($pat) && $pat["student"]){
              $if=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
              echo $name;
          }else{
            echo $name."...........................................................................";
          }
          ?>
        </div>
        <div align="left" class="curso">
          <?php
          $name="Curso:";
          if(isset($pat['removablegrade']) && $pat["removablegrade"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removablegrade'];
              echo $name;
          }else{
            echo $name.".............................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="Ficha N.:";
          if(isset($pat['removableid']) && $pat["removableid"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removableid'];
              echo $name;
          }else{
            echo $name."........................";
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
            echo $name."..........................................................................";
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
            echo $name."..............................";
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
        .w30{
          float: left;
          display: inline-block;
          width: 31%;
        }
      </style>
      <div class="">
        <div class="w30" align="left">
          <?php
          $name="Estado Civil:";
          if(isset($pat['patientcivilstatus']) && $pat["patientcivilstatus"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientcivilstatus'];
              echo $name;
          }else{
            echo $name."..................................";
          }
          ?>
        </div>
        <div class="w30" align="left">
          <?php
          $name="Ocupación:";
          if(isset($pat['patientoccupation']) && $pat["patientoccupation"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientoccupation'];
              echo $name;
          }else{
            echo $name."....................................";
          }
          ?>
        </div>
        <div class="w30" align="left">
          <?php
          $name="Dirección:";
          if(isset($pat['patientdirection']) && $pat["patientdirection"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientdirection'];
              echo $name;
          }else{
            echo $name."............................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w30" align="left">
          <?php
          $name="Telefono:";
          if(isset($pat['patientphone']) && $pat["patientphone"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientphone'];
              echo $name;
          }else{
            echo $name.".......................................";
          }
          ?>
        </div>
        <div class="w30" align="left">
          <?php
          $name="Procedencia:";
          if(isset($pat['patientprovenance']) && $pat["patientprovenance"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientprovenance'];
              echo $name;
          }else{
            echo $name."..................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Fecha de inicio:";
          if(isset($pat['startdatetime']) && $pat["startdatetime"]!=-1){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat['startdatetime']);
              echo $name;
          }else{
            echo $name."...........................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="Docente autorizador:";
          if(isset($pat['teacher']) && $pat["teacher"]){
              $d=DBUserInfo($pat['teacher']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$d['userfullname'];
              echo $name;
          }else{
            echo $name."....................................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <br>
      <div class="" align="center">
        <b>HISTORIA CLÍNICA</b>
      </div>
      <div class="" align="left">
        <?php
        $name="Antecedentes hereditarios:";
        if(isset($pat['removablehereditary']) && $pat["removablehereditary"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removablehereditary'];
            echo $name;
        }else{
          echo $name."..................................................................................................................................";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Antecedentes personales generales:";
        if(isset($pat['removablepersonal']) && $pat["removablepersonal"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removablepersonal'];
            echo $name;
        }else{
          echo $name."....................................................................................................................";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Tipo psicológico:";
        if(isset($pat['removablepsychological']) && $pat["removablepsychological"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removablepsychological']);
            echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Receptivo ( )&nbsp;&nbsp;&nbsp;Escéptico ( )&nbsp;&nbsp;&nbsp;Histérico ( )&nbsp;&nbsp;&nbsp;Pasivo ( )";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Tipo de desdentado:";
        if(isset($pat['removabletoothless']) && $pat["removabletoothless"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removabletoothless'];
            echo $name;
        }else{
          echo $name."............................................................................................................................................";
        }
        ?>
      </div>
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
      <div class="" align="left">
        <?php
        $name="<u>Clasificación de Kenedy</u>&nbsp;&nbsp;&nbsp;&nbsp;Superior:";
        if(isset($pat['kenedysc']) && $pat["kenedysc"]&&(($pos=strpos($pat['kenedysc'], "clase")) !== false)){
            $rom=strtoupper(substr( $pat['kenedysc'], $pos+5 ));
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clase ".$rom;
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if(isset($pat['kenedysm']) && $pat["kenedysm"]&&(($pos=strpos($pat['kenedysm'], "modificacion")) !== false)){
            $rom=strtoupper(substr( $pat['kenedysm'], $pos+12 ));
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modificación ".$rom;
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        $name.='&nbsp;&nbsp;&nbsp;Inferior:';
        if(isset($pat['kenedyic']) && $pat["kenedyic"]&&(($pos=strpos($pat['kenedyic'], "clase")) !== false)){
            $rom=strtoupper(substr( $pat['kenedyic'], $pos+5 ));
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Clase ".$rom;
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        if(isset($pat['kenedyim']) && $pat["kenedyim"]&&(($pos=strpos($pat['kenedyim'], "modificacion")) !== false)){
            $rom=strtoupper(substr( $pat['kenedyim'], $pos+12 ));
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Modificación ".$rom;
        }

        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="center">
        <b>DIAGNÓSTICO</b>
      </div>
      <div class="">
          <?php
          $name="<div align=\"left\">¿Usa o usó alguna vez una prótesis bucal?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

          if(isset($pat['diagnosticobucal']) && $pat["diagnosticobucal"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['diagnosticobucal']);
              if($pat['diagnosticobucal']=='si'){
                $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De qué?";
                if(isset($pat['diagnosticodeque']) && $pat['diagnosticodeque']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['diagnosticodeque'];
                }else{
                  $name.="........................................................";
                }
                $name.="</div>";
              }else{

                $name.="</div>";
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;De qué?........................................................";
            $name.="</div>".
            "<div class=\"w50\" align=\"left\">".
            " Duración:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;............................................................".
            "</div>".
            "<div class=\"w50\" align=\"left\">".
            " Resultado:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...............................................................".
            "</div>";
          }
          echo $name;
          ?>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Si la prótesis anterior no fue enteramente satisfactria ¿Cuál cree Ud. Que fue el problema?<br>";
          if(isset($pat['diagnosticoproblema']) && $pat["diagnosticoproblema"]){
              $name.=$pat["diagnosticoproblema"];
              echo $name;
          }else{
            echo $name."............................................................................................................................................................................";
          }
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Cuál fue la causa de la pérdida de sus dientes naturales?";
          if(isset($pat['diagnosticodiente']) && $pat["diagnosticodiente"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['diagnosticodiente']);
              echo $name;
          }else{
            echo $name."&nbsp;&nbsp;&nbsp;&nbsp;Period. ( )&nbsp;&nbsp;&nbsp;&nbsp;Caries ( )&nbsp;&nbsp;&nbsp;&nbsp;Traumatismo ( )&nbsp;&nbsp;&nbsp;Otros ( )";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="" align="center">
        <b>OBSERVACIONES INTRAORALES</b>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Higiene oral: ";
          if(isset($pat['dentalhygiene']) && $pat["dentalhygiene"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['dentalhygiene']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Buena ( )&nbsp;&nbsp;&nbsp;Regular ( )&nbsp;&nbsp;&nbsp;Mala ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;2. Índice de caries: ";
          if(isset($pat['removablecavities']) && $pat["removablecavities"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removablecavities']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Alto ( )&nbsp;&nbsp;&nbsp;Moderado ( )&nbsp;&nbsp;&nbsp;Bajo ( )";
          }
          echo $name;
          ?>
        </div>
      </div>

      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Coincide la oclusón céntrica y la relación céntrica?";
          if(isset($pat['removablecentral']) && $pat["removablecentral"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removablecentral']);
              echo $name;
          }else{
            echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No ( )";
          }
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Existe frenillos o inserciones musculares que podrán intervenir en el máximo ajuste y comodidad?<br>";
          if(isset($pat['bracesoption']) && $pat["bracesoption"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['bracesoption']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['bracesobs']) && $pat["bracesobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['bracesobs'];

          }else{
            $name.="...................................................................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿La saliva es de tipo y calidad normal?";
          if(isset($pat['salivaoption']) && $pat["salivaoption"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['salivaoption']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['salivaobs']) && $pat["salivaobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['salivaobs'];

          }else{
            $name.=".....................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Examine las aéreas siguientes en busca de posibles interferencias en el ajuste y la comodidad optima:<br>";
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Línea milohoidea normal";
          if(isset($pat['milohoideadesc']) && $pat["milohoideadesc"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['milohoideadesc'];
          }else{
            $name.="........................................................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['milohoideaobs']) && $pat["milohoideaobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['milohoideaobs'];

          }else{
            $name.=".........................................................";
          }
          $name.="<br>";
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tejidos de crestas alveolares normales";
          if(isset($pat['alveolaresdesc']) && $pat["alveolaresdesc"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['alveolaresdesc'];
          }else{
            $name.="..................................................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['alveolaresobs']) && $pat["alveolaresobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['alveolaresobs'];

          }else{
            $name.="..........................................";
          }
          $name.="<br>";
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tuberosidad normal";
          if(isset($pat['tuberosidaddesc']) && $pat["tuberosidaddesc"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['tuberosidaddesc'];
          }else{
            $name.=".......................................................................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['tuberosidadobs']) && $pat["tuberosidadobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['tuberosidadobs'];

          }else{
            $name.="..................................................";
          }

          $name.="<br>";
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hueso alveolar de soporte normal";
          if(isset($pat['alveolardesc']) && $pat["alveolardesc"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['alveolardesc'];
          }else{
            $name.=".................................................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['alveolarobs']) && $pat["alveolarobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['alveolarobs'];

          }else{
            $name.="...................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Paladar:";
          if(isset($pat['palateoption']) && $pat["palateoption"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['palateoption']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Triangular ( )&nbsp;&nbsp;&nbsp;Cuadrado ( )&nbsp;&nbsp;&nbsp;Ovoide ( )&nbsp;&nbsp;&nbsp;Plano ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs:";
          if(isset($pat['palateobs']) && $pat["palateobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['palateobs'];

          }else{
            $name.="...........................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Evaluación del reborde residual:";
          if(isset($pat['removableresidual']) && $pat["removableresidual"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['removableresidual'];
          }else{
            $name.=".......................................................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>

      <br>
      <div class="" align="center">
        <b>ASPECTO FACIAL Y ZONAS PRÓXIMAS</b>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Cara:";
          if(isset($pat['dentalfaces']) && $pat["dentalfaces"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['dentalfaces']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asimétrico ( )&nbsp;&nbsp;&nbsp;Triangular ( )&nbsp;&nbsp;&nbsp;Ovoide ( )&nbsp;&nbsp;&nbsp;Cuadrangular ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Tez:";
          if(isset($pat['dentaltez']) && $pat["dentaltez"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['dentaltez']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Asimétrico ( )&nbsp;&nbsp;&nbsp;Morena ( )&nbsp;&nbsp;&nbsp;Blanca ( )&nbsp;&nbsp;&nbsp;Negra ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="Perfil del mentón:";
          if(isset($pat['dentalprofile']) && $pat["dentalprofile"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['dentalprofile']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Recto ( )&nbsp;&nbsp;&nbsp;Cóncavo ( )&nbsp;&nbsp;&nbsp;Convexo ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <br>
      <div class="" align="center">
        <b>ANÁLISIS DE LOS MODELOS PARA DIAGNOSTICO</b>
      </div>
      <div class="" align="left">
        <span>EN EL ARTICULADOR</span>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Existe espacio adecuado entre los rebordes para la prótesis proyectada?";
          if(isset($pat['removableinterocclusal']) && $pat["removableinterocclusal"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removableinterocclusal']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Existe espacio interoclusal adecuado para los descansos de apoyo y los apoyos proyectados, donde sean necesarios?";
          if(isset($pat['removableprosthesis']) && $pat["removableprosthesis"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removableprosthesis']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿El plano oclusal es recurable?";
          if(isset($pat['removableplaneocclusal']) && $pat["removableplaneocclusal"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['removableplaneocclusal']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;Dudoso ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Existen anomalías que no fueron observables en boca?";
          if(isset($pat['anomaliesoption']) && $pat["anomaliesoption"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['anomaliesoption']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs.:";
          if(isset($pat['anomaliesobs']) && $pat["anomaliesobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['anomaliesobs'];
          }else{
            $name.=".............................................";
          }
          echo $name;
          ?>
        </div>
      </div>

      <div style="page-break-before: always;"></div>
      <!--HOJA 2-->

      <div class="" align="left">
        <span>EN EL PARALELIZADOR:</span>
      </div>
      <div class="">
        <div class="" align="left">

          <?php
          $name="¿Qué dientes serían los pilares más adecuados?<br>";
          $name.="&nbsp;&nbsp;&nbsp;Pilar 1";
          if(isset($pat['parpilar1']) && $pat["parpilar1"]){
              $name.="&nbsp;&nbsp;". $pat["parpilar1"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 2";
          if(isset($pat['parpilar2']) && $pat["parpilar2"]){
              $name.="&nbsp;&nbsp;". $pat["parpilar2"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 3";
          if(isset($pat['parpilar2']) && $pat["parpilar3"]){
              $name.="&nbsp;&nbsp;". $pat["parpilar3"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 4";
          if(isset($pat['parpilar2']) && $pat["parpilar4"]){
              $name.="&nbsp;&nbsp;". $pat["parpilar4"];
          }else{
            $name.="..............";
          }

          $name.="&nbsp;&nbsp;&nbsp;Otros";
          if(isset($pat['parotros']) && $pat["parotros"]){
              $name.="&nbsp;&nbsp;". $pat["parotros"];
          }else{
            $name.="..............";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Los pilares tienen áreas retentivas adecuadas en ubucación favorable?";
          if(isset($pat['parfavorable']) && $pat["parfavorable"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['parfavorable']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Pueden formarse planos de guía apropiados sobre los probables pilares?";
          if(isset($pat['parprobables']) && $pat["parprobables"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['parprobables']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿Se reuerirán alteraciones dentales?";
          if(isset($pat['paralteraciones']) && $pat["paralteraciones"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['paralteraciones']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Obs.:";
          if(isset($pat['parobs']) && $pat["parobs"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['parobs'];
          }else{
            $name.=".........................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <br>
      <div class="" align="center">
        <b>INTERPRETACIÓN RADIOGRÁFICA</b>
      </div>
      <div class="">
        <div class="" align="left">

          <?php
          $name="¿Cómo es la relación coronoradicular de cada pilar?<br>";
          $name.="&nbsp;&nbsp;&nbsp;Pilar 1";
          if(isset($pat['radpilar1']) && $pat["radpilar1"]){
              $name.="&nbsp;&nbsp;". $pat["radpilar1"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 2";
          if(isset($pat['radpilar2']) && $pat["radpilar2"]){
              $name.="&nbsp;&nbsp;". $pat["radpilar2"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 3";
          if(isset($pat['radpilar2']) && $pat["radpilar3"]){
              $name.="&nbsp;&nbsp;". $pat["radpilar3"];
          }else{
            $name.="..............";
          }
          $name.="&nbsp;&nbsp;&nbsp;Pilar 4";
          if(isset($pat['radpilar2']) && $pat["radpilar4"]){
              $name.="&nbsp;&nbsp;". $pat["radpilar4"];
          }else{
            $name.="..............";
          }

          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="" align="left">
          <?php
          $name="¿El hueso de soporte parece ser de buena calidad?";
          if(isset($pat['radhueso']) && $pat["radhueso"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat['radhueso']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si ( )&nbsp;&nbsp;&nbsp;No ( )";
          }
          echo $name;
          ?>
        </div>
      </div>






      <style media="screen">
        .tablet{
          margin-left: 10%;
          width: 80%;
          /*background-color: #ff0000;*/
        }

      </style>
      <!--inicio de table-->
      <br>
      <div class="">
        <table width="100%" border=1 >
          <tr align="center">
            <td width="25%">
              MATERIALES
            </td>
            <td width="25%">
              DESPACHADO
            </td>
            <td width="50%">
              <table width="100%" border=0>
                <tr align="center">
                  <td>CAJA</td>
                </tr>
              </table>
              <table width="100%" border=1>
                <tr border=1 align="center">
                  <td >Recibo N.</td>
                  <td>Abonos</td>
                  <td>Fecha</td>
                  <td>Firma</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </td>
            <td>
              <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            </td>
            <td>
              <table width="100%" border=1>
                <tr>
                  <td>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  </td>
                  <td>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  </td>
                  <td>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  </td>
                  <td>
                    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
      <!--fin de table-->
      <div style="page-break-before: always;"></div>
      <!--HOJA 3-->


      <font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA REMOVIBLE II</b></font>
    </div>

    <br>
    <div align="left" class="alumno">
      <?php
      $name="Alumno:";
      if(isset($pat) && $pat["student"]){
          $if=DBUserInfo($pat['student']);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
          echo $name;
      }else{
        echo $name."...........................................................................";
      }
      ?>
    </div>
    <div align="left" class="curso">
      <?php
      $name="Curso:";
      if(isset($pat['removablegrade']) && $pat["removablegrade"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['removablegrade'];
          echo $name;
      }else{
        echo $name."......................";
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
    <div align="left" class="w50">
      <?php
      $name="Valor del trabajo Bs.";
      if(isset($pat["valortrabajo"]) && $pat["valortrabajo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["valortrabajo"];
      }else{
        $name.=".................................................";
      }
      echo $name;
      ?>
    </div>

  </div>
  <div style="clear:both;"></div>
  <div class="">
    <?php
    $name="Trabajos:";
    if(isset($pat["trabajo"]) && $pat["trabajo"]){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["trabajo"];
    }else{
      $name.="..............................................................................................................................................................";
    }
    echo $name;
    ?>
  </div>
  <br>
  <div class="">
    <table width="100%" border=1 >
      <tr align="center">
        <td>
          PROCEDIMIENTO
        </td>
        <td width="25%">
          Vo. Bo. Laboratorio
        </td>
        <td>
          Vo. Bo. Clínica
        </td>
      </tr>
      <tr>
        <td><br>Impresión diagnóstica<br><br> </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro1'])&&$pat['selremopro1']&&isset($pat['tearemopro1'])&&is_numeric($pat['tearemopro1'])) {
            echo "<b>".strtoupper($pat['selremopro1'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro2'])&&$pat['selremopro2']&&isset($pat['tearemopro2'])&&is_numeric($pat['tearemopro2'])) {
            echo "<b>".strtoupper($pat['selremopro2'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Cubetas individuales <br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro3'])&&$pat['selremopro3']&&isset($pat['tearemopro3'])&&is_numeric($pat['tearemopro3'])) {
            echo "<b>".strtoupper($pat['selremopro3'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro4'])&&$pat['selremopro4']&&isset($pat['tearemopro4'])&&is_numeric($pat['tearemopro4'])) {
            echo "<b>".strtoupper($pat['selremopro4'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Impresión definitiva superior<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro5'])&&$pat['selremopro5']&&isset($pat['tearemopro5'])&&is_numeric($pat['tearemopro5'])) {
            echo "<b>".strtoupper($pat['selremopro5'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro6'])&&$pat['selremopro6']&&isset($pat['tearemopro6'])&&is_numeric($pat['tearemopro6'])) {
            echo "<b>".strtoupper($pat['selremopro6'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Impresión definitiva inferior<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro7'])&&$pat['selremopro7']&&isset($pat['tearemopro7'])&&is_numeric($pat['tearemopro7'])) {
            echo "<b>".strtoupper($pat['selremopro7'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro8'])&&$pat['selremopro8']&&isset($pat['tearemopro8'])&&is_numeric($pat['tearemopro8'])) {
            echo "<b>".strtoupper($pat['selremopro8'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Modelos de Trabajo<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro9'])&&$pat['selremopro9']&&isset($pat['tearemopro9'])&&is_numeric($pat['tearemopro9'])) {
            echo "<b>".strtoupper($pat['selremopro9'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro10'])&&$pat['selremopro10']&&isset($pat['tearemopro10'])&&is_numeric($pat['tearemopro10'])) {
            echo "<b>".strtoupper($pat['selremopro10'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Placas de articulación<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro11'])&&$pat['selremopro11']&&isset($pat['tearemopro11'])&&is_numeric($pat['tearemopro11'])) {
            echo "<b>".strtoupper($pat['selremopro11'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro12'])&&$pat['selremopro12']&&isset($pat['tearemopro12'])&&is_numeric($pat['tearemopro12'])) {
            echo "<b>".strtoupper($pat['selremopro12'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Relación maxilomandibular<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro13'])&&$pat['selremopro13']&&isset($pat['tearemopro13'])&&is_numeric($pat['tearemopro13'])) {
            echo "<b>".strtoupper($pat['selremopro13'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro14'])&&$pat['selremopro14']&&isset($pat['tearemopro14'])&&is_numeric($pat['tearemopro14'])) {
            echo "<b>".strtoupper($pat['selremopro14'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Enfilado y encerado<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro15'])&&$pat['selremopro15']&&isset($pat['tearemopro15'])&&is_numeric($pat['tearemopro15'])) {
            echo "<b>".strtoupper($pat['selremopro15'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro16'])&&$pat['selremopro16']&&isset($pat['tearemopro16'])&&is_numeric($pat['tearemopro16'])) {
            echo "<b>".strtoupper($pat['selremopro16'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Prueba en boca<br><br> </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro17'])&&$pat['selremopro17']&&isset($pat['tearemopro17'])&&is_numeric($pat['tearemopro17'])) {
            echo "<b>".strtoupper($pat['selremopro17'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro18'])&&$pat['selremopro18']&&isset($pat['tearemopro18'])&&is_numeric($pat['tearemopro18'])) {
            echo "<b>".strtoupper($pat['selremopro18'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Acrilizado y pulido<br><br> </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro19'])&&$pat['selremopro19']&&isset($pat['tearemopro19'])&&is_numeric($pat['tearemopro19'])) {
            echo "<b>".strtoupper($pat['selremopro19'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro20'])&&$pat['selremopro20']&&isset($pat['tearemopro20'])&&is_numeric($pat['tearemopro20'])) {
            echo "<b>".strtoupper($pat['selremopro20'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Instalación inicial<br><br> </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro21'])&&$pat['selremopro21']&&isset($pat['tearemopro21'])&&is_numeric($pat['tearemopro21'])) {
            echo "<b>".strtoupper($pat['selremopro21'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro22'])&&$pat['selremopro22']&&isset($pat['tearemopro22'])&&is_numeric($pat['tearemopro22'])) {
            echo "<b>".strtoupper($pat['selremopro22'])."</b>";
          }
          ?>
        </td>
      </tr>
      <tr>
        <td><br>Controles mediatos<br><br></td>
        <td align="center">
          <?php
          if (isset($pat['selremopro23'])&&$pat['selremopro23']&&isset($pat['tearemopro23'])&&is_numeric($pat['tearemopro23'])) {
            echo "<b>".strtoupper($pat['selremopro23'])."</b>";
          }
          ?>
        </td>
        <td align="center">
          <?php
          if (isset($pat['selremopro24'])&&$pat['selremopro24']&&isset($pat['tearemopro24'])&&is_numeric($pat['tearemopro24'])) {
            echo "<b>".strtoupper($pat['selremopro24'])."</b>";
          }
          ?>
        </td>
      </tr>
    </table>
  </div>
  <br>
  <div class="">
    <?php
    $name="Observaciones:";
    if(isset($pat["obstrabajo"]) && $pat["obstrabajo"]){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obstrabajo"];
    }else{
      $name.=".................................................................................................................................................";
    }
    echo $name;
    ?>
  </div>
  <br>
  <div class="">
    <div class="w30">
      <?php
      $name="Nota final:";
      if(isset($pat["notatrabajo"]) && $pat["notatrabajo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["notatrabajo"];
      }else{
        $name.="......................................";
      }
      echo $name;
      ?>
    </div>
    <div class="w50">
      <?php
      $name="Firma del docente:";
      if(isset($pat["firmtrabajo"]) && is_numeric($pat["firmtrabajo"])){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
      }else{
        $name.=".....................................................";
      }
      echo $name;
      ?>
    </div>
  </div>
  <div style="clear:both;"></div>

  <div style="page-break-before: always;"></div>
  <!--HOJA 4-->
  <div align="center">
    <font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA REMOVIBLE II</b></font>
  </div>


    <br>
    <div align="left" >
      <?php
      $name="Alumno:";
      if(isset($pat) && $pat["student"]){
          $if=DBUserInfo($pat['student']);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
          echo $name;
      }else{
        echo $name.".............................................................................................................................................................";
      }
      ?>
    </div>
    <div align="left">
      <?php
      $name="Paciente:";
      if(isset($pat["patientfullname"]) && $pat["patientfullname"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
          echo $name;
      }else{
        echo $name."............................................................................................................................................................";
      }
      ?>
    </div>
    <br>
    <div class="" align="center">
      <b>PLAN DE TRATAMIENTO</b>
    </div>

    <style media="screen">
      .verde{
        background-color: 	#008000;
      }
      .catimg {
        /*width: 50px;*/
        background-color: #0000FF;

        width: 400px;
        height: 533px;
      }
      .inline{
        display: inline-block;
        float: left;
      }


    </style>

    <div class="w50">
      <br>
      <br>
      <style media="screen">
      img {
      max-width: 100%;
      max-height: 100%;
      }
      .catbloc {
      height: 463px;
      width: 330px;
      }
      </style>
      <div class="catbloc">
        <!--IMAGES-->
        <?php
        if(!isset($pat['removableodontogram'])||(isset($pat['removableodontogram'])&&$pat['removableodontogram']=='')){
          echo "  <img class=\"b\" src=\"".getPieza("protesis_nueva.png","../images/")."\" alt=\"\">";
        }else{
          echo "  <img class=\"b\" src=\"".$pat['removableodontogram']."\" alt=\"\">";
        }
        ?>
      </div>
    </div>

    <div class="w50">
      <?php
      $name="ESPECIFICACIONES DEL PLAN";
      $name.="<br><br><br>1. APOYOS";
      if(isset($pat["apoyos"]) && $pat["apoyos"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["apoyos"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="2. RETENCIÓN";
      if(isset($pat["retencion"]) && $pat["retencion"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["retencion"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="3. RECIPROCIDAD";
      if(isset($pat["reciprocidad"]) && $pat["reciprocidad"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["reciprocidad"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="4. CONECTOR MAYOR";
      if(isset($pat["conector"]) && $pat["conector"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["conector"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="5. RETENCIÓN INDIRECTA";
      if(isset($pat["indirecta"]) && $pat["indirecta"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["indirecta"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="6. PLANOS GUÍA";
      if(isset($pat["planos"]) && $pat["planos"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["planos"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="7. RETENCIÓN PARA LA BASE";
      if(isset($pat["base"]) && $pat["base"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["base"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      $name.="8. ÁREAS DE MODIFICAR O CONTORNEAR";
      if(isset($pat["contornear"]) && $pat["contornear"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;".$pat["contornear"]."<br><br>";
      }else{
        $name.="<br><br><br>";
      }
      echo $name;
      ?>
    </div>
    <div style="clear:both;"></div>

    <div class="">
      CODIGO DE COLORES:<br><br>
      Azul: Metal colado <br>
      Rojo: Base de resina y alambre labrado <br>
      Verde: Áreas a contornear <br>
      Negro: Dientes artificiales <br>
      <br>
      <?php
      $name="Docente:";

      if(isset($pat["protesis"]) && is_numeric($pat["protesis"])){
          $docented=DBUserInfo($pat['protesis']);
          $docented=$docented['userfullname'];
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$docented";
      }else{
        $name.=".......................................................................";
      }
      echo $name;
      ?>
    </div>
    <br>
    <div class="">
      <div class="w50">
        <?php
        $name="Aprobación para realizar la prótesis:";
        if(isset($pat["protesis"]) && is_numeric($pat["protesis"])){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
        }else{
          $name.="...........................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50">
        <?php
        $name="Fecha:";
        if(isset($pat["protesisfecha"]) && $pat["protesisfecha"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['protesisfecha'];
        }else{
          $name.="................................................................";
        }
        echo $name;
        ?>
      </div>
    </div>
    <div style="clear:both;"></div>
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
