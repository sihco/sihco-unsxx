<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBSurgeryiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=13)
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
   display:inline-block;
}
.inline{
  display: inline-block;
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
    <font SIZE=2>
    <div class="container">
      <?php
      $dir='../images/';
      ?>
      <div align="center">
        <b>HISTORIA CLÍNICA<br> CIRUGÍA BUCAL III</b>
      </div>
      <div align="left">
        <u>A.- DATOS CIVILES</u>
      </div>

      <style media="screen">
      .w80{
        width: 80%;
        display: inline-block;
        float: left;
      }
      .w70{
        width: 70%;
        display: inline-block;
        float: left;
      }
      .w60{
        width: 60%;
        display: inline-block;
        float: left;
      }
      .w50{
        width: 50%;
        display: inline-block;
        float: left;
      }
      .w45{
        width: 45%;
        display: inline-block;
        float: left;
      }
      .w40{
        width: 40%;
        display: inline-block;
        float: left;
      }
      .w39{
        width: 39%;
        display: inline-block;
        float: left;
      }
      .w38{
        width: 38%;
        display: inline-block;
        float: left;
      }
      .w37{
        width: 37%;
        display: inline-block;
        float: left;
      }
      .w36{
        width: 36%;
        display: inline-block;
        float: left;
      }
      .w35{
        width: 35%;
        display: inline-block;
        float: left;
      }
      .w34{
        width: 34%;
        display: inline-block;
        float: left;
      }
      .w33{
        width: 33%;
        display: inline-block;
        float: left;
      }
      .w32{
        width: 32%;
        display: inline-block;
        float: left;
      }
      .w31{
        width: 31%;
        display: inline-block;
        float: left;
      }
      .w30{
        width: 30%;
        display: inline-block;
        float: left;
      }
      .w29{
        width: 29%;
        display: inline-block;
        float: left;
      }
      .w28{
        width: 28%;
        display: inline-block;
        float: left;
      }
      .w27{
        width: 27%;
        display: inline-block;
        float: left;
      }
      .w26{
        width: 26%;
        display: inline-block;
        float: left;
      }
      .w25{
        width: 25%;
        display: inline-block;
        float: left;
      }
      .w24{
        width: 24%;
        display: inline-block;
        float: left;
      }
      .w23{
        width: 23%;
        display: inline-block;
        float: left;
      }
      .w22{
        width: 22%;
        display: inline-block;
        float: left;
      }
      .w21{
        width: 21%;
        display: inline-block;
        float: left;
      }
      .w20{
        width: 20%;
        display: inline-block;
        float: left;
      }
      .w19{
        width: 19%;
        display: inline-block;
        float: left;
      }
      .w18{
        width: 18%;
        display: inline-block;
        float: left;
      }
      .w17{
        width: 17%;
        display: inline-block;
        float: left;
      }
      .w16{
        width: 16%;
        display: inline-block;
        float: left;
      }
      .w15{
        width: 15%;
        display: inline-block;
        float: left;
      }
      .w12{
        width: 12%;
        display: inline-block;
        float: left;
      }
      .w11{
        width: 11%;
        display: inline-block;
        float: left;
      }
      .w10{
        width: 10%;
        display: inline-block;
        float: left;
      }
      .w9{
        width: 9%;
        display: inline-block;
        float: left;
      }
      .w8{
        width: 8%;
        display: inline-block;
        float: left;
      }
      .w7{
        width: 7%;
        display: inline-block;
        float: left;
      }
      .w6{
        width: 6%;
        display: inline-block;
        float: left;
      }
      .w5{
        width: 5%;
        display: inline-block;
        float: left;
      }
      .w4{
        width: 4%;
        display: inline-block;
        float: left;
      }
      .w3{
        width: 3%;
        display: inline-block;
        float: left;
      }
      .w2{
        width: 2%;
        display: inline-block;
        float: left;
      }
      .w1{
        width: 1%;
        display: inline-block;
        float: left;
      }
      </style>
      <div class="">
        <div align="left" class="w50">
          <?php
          $name="NOMBRES Y APELLIDOS:";
          if(isset($pat["patientfullname"]) && $pat["patientfullname"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              echo $name;
          }else{
            echo $name."..............................................................................";
          }
          ?>
        </div>
        <div align="left" class="w12">
          <?php
          $name="EDAD:";
          if(isset($pat['patientage']) && $pat["patientage"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientage'];
              echo $name;
          }else{
            echo $name."....................";
          }
          ?>
        </div>
        <div align="left" class="w18">
          <?php
          $name="SEXO:";
          if(isset($pat['patientgender']) && $pat["patientgender"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat['patientgender']);
              echo $name;
          }else{
            echo $name."....................";
          }
          ?>
        </div>
        <div align="left" class="w27">
          <?php
          $name="ESTADO CIVIL:";
          if(isset($pat['patientcivilstatus']) && $pat["patientcivilstatus"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat['patientcivilstatus']);
              echo $name;
          }else{
            echo $name."...................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w26" align="left">
          <?php
          $name="DOMICILIO:";
          if(isset($pat['patientdirection']) && $pat["patientdirection"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientdirection'];
              echo $name;
          }else{
            echo $name.".....................................";
          }
          ?>
        </div>
        <div class="w26" align="left">
          <?php
          $name="OCUPACIÓN:";
          if(isset($pat['patientoccupation']) && $pat["patientoccupation"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientoccupation'];
              echo $name;
          }else{
            echo $name."...............................";
          }
          ?>
        </div>
        <div class="w28" align="left">
          <?php
          $name="PROCEDENCIA:";
          if(isset($pat['patientprovenance']) && $pat["patientprovenance"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientprovenance'];
              echo $name;
          }else{
            echo $name."...............................";
          }
          ?>
        </div>
        <div class="w24" align="left">
          <?php
          $name="FONO.:";
          if(isset($pat['patientphone']) && $pat["patientphone"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientphone'];
              echo $name;
          }else{
            echo $name."..................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w15" align="left">
          <?php
          $name="PRÁCTICA N.:";
          if(isset($pat['surgeryiipractice']) && $pat["surgeryiipractice"]){
              $name.="&nbsp;&nbsp;&nbsp;".$pat['surgeryiipractice'];
              echo $name;
          }else{
            echo $name."......";
          }
          ?>
        </div>
        <div class="w45" align="left">
          <?php
          $name="SUPERVISADO POR Dr.(a):";
          if(isset($pat["teacher"]) && $pat["teacher"]){
            $tea=DBUserInfo($pat['teacher']);
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tea["userfullname"];
            echo $name;
          }else{
            echo $name."................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="RECEPCIONADO POR UNIV.:";
          if(isset($pat) && $pat["student"]){
              $student=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$student['userfullname'];
              echo $name;
          }else{
            echo $name."...........................................";
          }
          ?>
        </div>

      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="FECHA:";
          if(isset($pat["startdatetime"]) && $pat["startdatetime"]!=-1){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat["startdatetime"]);
            echo $name;
          }else{
            echo $name.".....................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <br>
      <div align="left">
        <u>B.- ANAMNESIS</u>
      </div>
      <div class="">
        <div align="left">
          <u>B.1.- ANAMNESIS PRÓXIMA PERSONAL</u>
        </div>
        <div align="left">
          <?php
          $name="MOTIVO DE LA CONSULTA:";
          if(isset($pat['surgeryiimotconsult']) && $pat["surgeryiimotconsult"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['surgeryiimotconsult'];
              echo $name;
          }else{
            echo $name."....................................................................................................................................................................";
          }
          ?>
        </div>
        <div align="left">
          <?php
          $name="HISTORIA DEL MOTIVO DE LA CONSULTA:";
          if(isset($pat['historiaconsulta']) && $pat["historiaconsulta"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['historiaconsulta'];
              echo $name;
          }else{
            echo $name.".......................................................................................................................................<br>";
            echo "........................................................................................................................................................................................................................";
          }
          ?>
        </div>
        <div align="left">
          <?php
          $name="ANAMNESIS FAMILIAR:";
          if(isset($pat['anamnesisfamiliar']) && $pat["anamnesisfamiliar"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['anamnesisfamiliar'];
              echo $name;
          }else{
            echo $name."...........................................................................................................................................................................<br>";
            echo "........................................................................................................................................................................................................................";
          }
          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
          <u>B.2.- ANAMNESIS REMOTA PERSONAL</u>
        </div>
        <div align="left">
          <?php
          if(isset($pat["startdatetime"]) && $pat["startdatetime"]==null){
            echo "Responda a todas las preguntas encerrando Si o No y rellene todos los espacios en blanco. Esta información es completamente confidencial.";
          }
          ?>
        </div>
        <div align="left">
          <?php
          $name="1.- ¿Está siendo atendido por un médico?";
          if(isset($pat["remota1"]) && $pat["remota1"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota1']);
              if($pat['remota1']=='si'){
                $name.="<br>¿De qué está siendo tratado?";
                if(isset($pat['obsremota1']) && $pat['obsremota1']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota1'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="Si su respuesta es SI, ¿De que está siendo siendo tratado?...........................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="2.- ¿Ha tenido alguna enfermedada grave o ha sido intervenido quirúrgicamente?";
          if(isset($pat["remota2"]) && $pat["remota2"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota2']);
              if($pat['remota2']=='si'){
                $name.="<br>¿Cuál es la enfermedad o el tipo de intervención?";
                if(isset($pat['obsremota2']) && $pat['obsremota2']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota2'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="Si su respuesta es SI, ¿Cuál es la enfermedad o el tipo de intervención?.....................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="3.- ¿Ha estado hospitalizado en los últimos cinco años?";
          if(isset($pat["remota3"]) && $pat["remota3"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota3']);
              if($pat['remota3']=='si'){
                $name.="<br>¿Cuál fue el motivo?";
                if(isset($pat['obsremota3']) && $pat['obsremota3']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota3'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="Si su respuesta es SI, ¿Cuál fue el motivo?...................................................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="4.- ¿Ud. padece o ha padecido alguna de las siguientes enfermedades?<br>";
          $tab1="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if(isset($pat["remota4a"]) && $pat["remota4a"]){
              $name.=$tab1."a.- Fiebre reumática o enfermedad cardiaca reumática.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4a']);
          }else{
            $name.=$tab1."a.- Fiebre reumática o enfermedad cardiaca reumática.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.=$tab1."b.- Enfermedades cardiovasculares (problemas cardiacos, infarto al corazón, angina de pecho, ictus, hipertensión arterial, soplo,<br>".$tab1."cardiaco, oclusión, coronaria, ateroesclerosis)";
          $name.="<br>";
          if(isset($pat["remota4b1"]) && $pat["remota4b1"]){
              $name.=$tab1.$tab1."¿siente presión o dolor en el pecho al hacer ejercicios?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4b1']);
          }else{
            $name.=$tab1.$tab1."¿siente presión o dolor en el pecho al hacer ejercicios?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4b2"]) && $pat["remota4b2"]){
              $name.=$tab1.$tab1."¿alguna vez le falta el aire al hacer un ejercicio leve?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4b2']);
          }else{
            $name.=$tab1.$tab1."¿alguna vez le falta el aire al hacer un ejercicio leve?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4b3"]) && $pat["remota4b3"]){
              $name.=$tab1.$tab1."¿se le hinchan los tobillos?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4b3']);
          }else{
            $name.=$tab1.$tab1."¿se le hinchan los tobillos?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4b4"]) && $pat["remota4b4"]){
              $name.=$tab1.$tab1."¿se queda sin aliento cuando se acuesta o precisa varias almohadas para dormir?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4b4']);
          }else{
            $name.=$tab1.$tab1."¿se queda sin aliento cuando se acuesta o precisa varias almohadas para dormir?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4b5"]) && $pat["remota4b5"]){
              $name.=$tab1.$tab1."¿le han dicho alguna vez que tiene soplo cardíaco?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4b5']);
          }else{
            $name.=$tab1.$tab1."¿le han dicho alguna vez que tiene soplo cardíaco?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4c"]) && $pat["remota4c"]){
              $name.=$tab1."c.- Asma o fiebre del heno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4c']);
          }else{
            $name.=$tab1."c.- Asma o fiebre del heno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4d"]) && $pat["remota4d"]){
              $name.=$tab1."d.- Eczema o reacción cutánea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4d']);
          }else{
            $name.=$tab1."d.- Eczema o reacción cutánea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4e"]) && $pat["remota4e"]){
              $name.=$tab1."e.- Desmayos o convulsiones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4e']);
          }else{
            $name.=$tab1."e.- Desmayos o convulsiones&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.=$tab1."f.- Diabetes";
          $name.="<br>";
          if(isset($pat["remota4f1"]) && $pat["remota4f1"]){
              $name.=$tab1.$tab1."¿tiene que orinar más de 6 veces al día?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4f1']);
          }else{
            $name.=$tab1.$tab1."¿tiene que orinar más de 6 veces al día?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4f2"]) && $pat["remota4f2"]){
              $name.=$tab1.$tab1."¿tiene sed casi siempre?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4f2']);
          }else{
            $name.=$tab1.$tab1."¿tiene sed casi siempre?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4f3"]) && $pat["remota4f3"]){
              $name.=$tab1.$tab1."¿siente seca la boca con frecuencia?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4f3']);
          }else{
            $name.=$tab1.$tab1."¿siente seca la boca con frecuencia?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4g"]) && $pat["remota4g"]){
              $name.=$tab1."g.- Hepatitis, ictericia o enfermedad hepática&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4g']);
          }else{
            $name.=$tab1."g.- Hepatitis, ictericia o enfermedad hepática&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4h"]) && $pat["remota4h"]){
              $name.=$tab1."h.- Artritis u otras enfermedades articulares&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4h']);
          }else{
            $name.=$tab1."h.- Artritis u otras enfermedades articulares&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4i"]) && $pat["remota4i"]){
              $name.=$tab1."i.- Úlcera de estómago&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4i']);
          }else{
            $name.=$tab1."i.- Úlcera de estómago&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4j"]) && $pat["remota4j"]){
              $name.=$tab1."j.- Problemas renales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4j']);
          }else{
            $name.=$tab1."j.- Problemas renales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4k"]) && $pat["remota4k"]){
              $name.=$tab1."k.- Tuberculosis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4k']);
          }else{
            $name.=$tab1."k.- Tuberculosis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4l"]) && $pat["remota4l"]){
              $name.=$tab1."l.- Covid 19&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4l']);
          }else{
            $name.=$tab1."l.- Covid 19&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4m"]) && $pat["remota4m"]){
              $name.=$tab1."m.- Enfermedad venérea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4m']);
          }else{
            $name.=$tab1."m.- Enfermedad venérea&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota4n"]) && $pat["remota4n"]){
              $name.=$tab1."n.- Otras&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota4n']);
          }else{
            $name.=$tab1."n.- Otras&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }

          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="5.- ";
          if(isset($pat["remota51"]) && $pat["remota51"]){
              $name.="¿Ha tenido sangrado anormal en relación con extracciones dentarias, operaciones o traumas?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota51']);
          }else{
            $name.="¿Ha tenido sangrado anormal en relación con extracciones dentarias, operaciones o traumas?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota52"]) && $pat["remota52"]){
              $name.=$tab1."¿Se le forman moretones con facilidad?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota52']);
          }else{
            $name.=$tab1."¿Se le forman moretones con facilidad?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";

          $name.=$tab1."¿Ha recibido trasfuciones de sangre?";
          if(isset($pat["remota53"]) && $pat["remota53"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota53']);
              if($pat['remota53']=='si'){
                $name.="<br>".$tab1."explique las circunstancias";
                if(isset($pat['obsremota53']) && $pat['obsremota53']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota53'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.=$tab1."Si su respuesta es SI, explique las circunstancias...........................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="6.- ¿Tiene alguna enfermedad sanguínea como anemia, trasfornos de la coagulación u otras?";
          if(isset($pat["remota6"]) && $pat["remota6"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota6']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.="7.- ¿Ha precisado cirugía o tratamiento con radioterapia por un tumor, cáncer u otra patología de cabeza y cuello?";
          if(isset($pat["remota7"]) && $pat["remota7"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota7']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="8.- ¿Está tomando alguno de los siguientes medicamentos?";
          $name.="<br>";
          if(isset($pat["remota81"]) && $pat["remota81"]){
              $name.=$tab1."Antibióticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota81']);
          }else{
            $name.=$tab1."Antibióticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota82"]) && $pat["remota82"]){
              $name.=$tab1."Anticoagulantes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota82']);
          }else{
            $name.=$tab1."Anticoagulantes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota83"]) && $pat["remota83"]){
              $name.=$tab1."Fármacos parar controlar la presión arterial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota83']);
          }else{
            $name.=$tab1."Fármacos parar controlar la presión arterial&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota84"]) && $pat["remota84"]){
              $name.=$tab1."Antidiabéticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota84']);
          }else{
            $name.=$tab1."Antidiabéticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota85"]) && $pat["remota85"]){
              $name.=$tab1."Tranquilizantes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota85']);
          }else{
            $name.=$tab1."Tranquilizantes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          echo $name;
          ?>
        </div>
      </div>
      <!--PAGINA 1 FIN-->
      <!--PAGINA 2 INICIO-->
      <div style="page-break-before: always;"></div>
      <div class="">
        <div align="left">
          <?php
          $name="<br>";
          if(isset($pat["remota86"]) && $pat["remota86"]){
              $name.=$tab1."Cortisona&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota86']);
          }else{
            $name.=$tab1."Cortisona&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota87"]) && $pat["remota87"]){
              $name.=$tab1."Hormonas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota87']);
          }else{
            $name.=$tab1."Hormonas&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota88"]) && $pat["remota88"]){
              $name.=$tab1."Aspirina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota88']);
          }else{
            $name.=$tab1."Aspirina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota89"]) && $pat["remota89"]){
              $name.=$tab1."Fármacos para controlar el corazón&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota89']);
          }else{
            $name.=$tab1."Fármacos para controlar el corazón&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota810"]) && $pat["remota810"]){
              $name.=$tab1."Fármacos para la osteoporosis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota810']);
          }else{
            $name.=$tab1."Fármacos para la osteoporosis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota811"]) && $pat["remota811"]){
              $name.=$tab1."Anticonceptivos orales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota811']);
          }else{
            $name.=$tab1."Anticonceptivos orales&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          if(isset($pat["remota812"]) && $pat["remota812"]){
              $name.=$tab1."Otros (incluye medicación tradicional)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota812']);
          }else{
            $name.=$tab1."Otros (incluye medicación tradicional)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }

          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="9.- ¿Tiene alergia a algún medicamento?";
          if(isset($pat["remota9"]) && $pat["remota9"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota9']);
              if($pat['remota9']=='si'){
                $name.="<br>Indique el nombre del medicamento";
                if(isset($pat['obsremota9']) && $pat['obsremota9']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota9'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="Si su respuesta es SI, indique el nombre del medicamento...........................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="10.- ¿Tuvo alguna reacción por la administración de anestésicos locales?";
          if(isset($pat["remota10"]) && $pat["remota10"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota10']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <?php
          $name="";
          $swn='11';
          if(isset($pat['patientgender']) && $pat["patientgender"]=='femenino'){
            $swn='12';
            $name="11.- En caso de ser mujer:";
            $name.="<br>";
            if(isset($pat["remota111"]) && $pat["remota111"]){
                $name.=$tab1."¿Está embarazada o ha tenido un retraso reciente en su periodo menstrual?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota111']);
            }else{
              $name.=$tab1."¿Está embarazada o ha tenido un retraso reciente en su periodo menstrual?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
            }
            $name.="<br>";
            if(isset($pat["remota112"]) && $pat["remota112"]){
                $name.=$tab1."¿Está dando de lactar?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota112']);
            }else{
              $name.=$tab1."¿Está dando de lactar?&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
            }
            $name.="<br>";
          }
          $name.="$swn.- ¿Padece alguna enfermedad que cree que deba saber?";
          if(isset($pat["remota12"]) && $pat["remota12"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['remota12']);
              if($pat['remota12']=='si'){
                $name.="<br>Incluye enfermedades confidenciales";
                if(isset($pat['obsremota12']) && $pat['obsremota12']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obsremota12'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="Si su respuesta es SI, incluye enfermedades confidenciales..........................................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div align="left">
          <u>C.- HISTORIA ODONTOLÓGICA</u>
        </div>
        <div align="left">
          <?php
          $name="1.- ¿Visita regularmente a su dentista?";
          if(isset($pat["historia1"]) && $pat["historia1"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia1']);
              if($pat['remota12']=='si'){
                $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;¿Cuándo fue la útima vez?";
                if(isset($pat['obshistoria1']) && $pat['obshistoria1']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obshistoria1'];
                }else{
                  $name.="..........................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;En caso afirmativo, ¿Cuándo fue la última vez?.................................";
          }
          $name.="<br>";
          $name.="2.- ¿Cuántas veces al día se cepilla los dientes?";
          if(isset($pat["historia2"]) && $pat["historia2"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['historia2'];
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4";
          }
          $name.="<br>";
          $name.="3.- ¿Siente dolor cuando mastica?";
          if(isset($pat["historia3"]) && $pat["historia3"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia3']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.="4.- ¿Siente la encía irritada o adolorida?";
          if(isset($pat["historia4"]) && $pat["historia4"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia4']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.="5.- ¿Ya ha sido sometido a tratamiento quirúrgico en la boca?";
          if(isset($pat["historia5"]) && $pat["historia5"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia5']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.="6.- ¿Tiene dificultad de abrir la boca excesivamente?";
          if(isset($pat["historia6"]) && $pat["historia6"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia6']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO";
          }
          $name.="<br>";
          $name.="7.- ¿Relación de oclusión de primeros molares:?";
          if(isset($pat["historia7"]) && $pat["historia7"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat['historia7']);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normooclusíon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mesiooclusíon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;distooclusión";
          }
          $name.="<br>";
          $name.="8.- ¿Tuvo alguna mala experiencia durante o después de una atención odontológica?";
          if(isset($pat["historia8"]) && $pat["historia8"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat['historia8']);
              if($pat['historia8']=='si'){
                $name.="<br>Expliquelo";
                if(isset($pat['obshistoria8']) && $pat['obshistoria8']){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['obshistoria8'];
                }else{
                  $name.="...................................................................................";
                }
              }
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO<br>";
            $name.="En caso afirmativo, expliquelo...........................................................................................................................";
          }
          echo $name;

          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
          <u>D.- EXAMEN FÍSICO</u>
          <br>
          D.1.- GENERAL
        </div>
        <div align="left">
          <?php
          $name="-SIGNOS VITALES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Presión Arterial";
          if(isset($pat["arterial"]) && $pat["arterial"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['arterial'];
          }else{
            $name.=".......................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frecuencia Cardiaca";
          if(isset($pat["cardiaca"]) && $pat["cardiaca"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['cardiaca'];
          }else{
            $name.=".......................";
          }
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Frecuencia Respiratoria";
          if(isset($pat["respiratoria"]) && $pat["respiratoria"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['respiratoria'];
          }else{
            $name.=".......................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="-TÓRAX:";
          if(isset($pat["torax"]) && $pat["torax"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['torax'];
          }else{
            $name.=".........................................................................................";
          }
          $name.="<br>-EXTREMIDADES:";
          if(isset($pat["extremidades"]) && $pat["extremidades"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['extremidades'];
          }else{
            $name.="........................................................................";
          }
          echo $name;
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="-ABDOMEN:";
          if(isset($pat["abdomen"]) && $pat["abdomen"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['abdomen'];
          }else{
            $name.="...................................................................................";
          }
          $name.="<br>-PIEL Y FANERAS:";
          if(isset($pat["faneras"]) && $pat["faneras"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['faneras'];
          }else{
            $name.="........................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left">
          <?php
          $name="-EXAMEN NEUROLÓGICO:";
          if(isset($pat["neurologico"]) && $pat["neurologico"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['neurologico'];
          }else{
            $name.=".....................................................................................................................................................................";
          }
          $name.="<br>D.2.- SEGMENTARIO";
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="-CUELLO:";
          if(isset($pat["cuello"]) && $pat["cuello"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['cuello'];
          }else{
            $name.=".......................................................................................";
          }
          $name.="<br>";
          $name.="-CARA:";
          if(isset($pat["cara"]) && $pat["cara"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['cara'];
          }else{
            $name.="............................................................................................";
          }
          $name.="<br>";
          $name.="-GRANGLIOS LINFATICOS:";
          if(isset($pat["linfaticos"]) && $pat["linfaticos"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['linfaticos'];
          }else{
            $name.="........................................................";
          }
          echo $name;
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="-CRÁNEO:";
          if(isset($pat["craneo"]) && $pat["craneo"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['craneo'];
          }else{
            $name.=".......................................................................................";
          }
          $name.="<br>-MÚSCULOS:";
          if(isset($pat["musculos"]) && $pat["musculos"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['musculos'];
          }else{
            $name.="..................................................................................";
          }
          $name.="<br>-A.T.M:";
          if(isset($pat["atm"]) && $pat["atm"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['atm'];
          }else{
            $name.=".............................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left">
          <?php
          $name="-GLÁNDULAS SALIVALES:";
          if(isset($pat["salivales"]) && $pat["salivales"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['salivales'];
          }else{
            $name.=".....................................................................................................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div align="center">
          EXAMEN INTRAORAL
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $name="-VESTÍBULO BUCAL:";
          if(isset($pat["vestibulo"]) && $pat["vestibulo"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['vestibulo'];
          }else{
            $name.="...............................................................................................................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="-PARED ANTERIOR:";
          if(isset($pat["anterior"]) && $pat["anterior"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['anterior'];
          }else{
            $name.="....................................................................";
          }
          $name.="<br>";
          $name.="-PARED POSTERIOR:";
          if(isset($pat["posterior"]) && $pat["posterior"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['posterior'];
          }else{
            $name.="..................................................................";
          }
          $name.="<br>";
          $name.="-PAREDES LATERALES:";
          if(isset($pat["laterales"]) && $pat["laterales"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['laterales'];
          }else{
            $name.="............................................................";
          }
          echo $name;
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="-PARED SUPERIOR:";
          if(isset($pat["superior"]) && $pat["superior"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['superior'];
          }else{
            $name.=".....................................................................";
          }
          $name.="<br>-PARED INFERIOR:";
          if(isset($pat["inferior"]) && $pat["inferior"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['inferior'];
          }else{
            $name.="......................................................................";
          }
          $name.="<br>-LENGUA";
          if(isset($pat["lengua"]) && $pat["lengua"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['lengua'];
          }else{
            $name.=".......................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left">
          <?php
          $name="-ENCIAS";
          if(isset($pat["encias"]) && $pat["encias"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['encias'];
          }else{
            $name.="......................................................................................................................................................................................................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
          -PIEZAS DENTARIAS:
        </div>
      </div>
      <div class="">
        <div align="center">
          <b>ODONTOGRAMA</b>
        </div>
      </div>
      <!--diagrama de odontograma inicio-->
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
      if(isset($pat['surgeryiiodontogram'])&&$pat['surgeryiiodontogram']!=''){
        //echo $pat['fixedodontogram'];

        $gramdata=explode(']', $pat['surgeryiiodontogram']);
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
      <!--PAGINA 2 FIN-->
      <div style="page-break-before: always;"></div>
      <!--PAGINA 3 INICIO-->
      <div class="">
        <div align="left">
          <?php
          $name="CLASIFICACIÓN DEL ESTADO FÍSICO:";
          if(isset($pat["surgeryiiasa"]) && $pat["surgeryiiasa"]){
              $asa=substr($pat['surgeryiiasa'],3);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA ".strtoupper($asa);
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA I&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA II&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ASA III&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ver anexo 1)";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $nivel1=0;
          if(isset($pat["nivelansiedad1"]) && $pat["nivelansiedad1"]){
            $nivel1=intval($pat['nivelansiedad1']);
          }
          $nivel2=0;
          if(isset($pat["nivelansiedad2"]) && $pat["nivelansiedad2"]){
            $nivel2=intval($pat['nivelansiedad2']);
          }
          $nivel3=0;
          if(isset($pat["nivelansiedad3"]) && $pat["nivelansiedad3"]){
            $nivel3=intval($pat['nivelansiedad3']);
          }
          $nivel4=0;
          if(isset($pat["nivelansiedad4"]) && $pat["nivelansiedad4"]){
            $nivel4=intval($pat['nivelansiedad4']);
          }
          $nivel=$nivel1+$nivel2+$nivel3+$nivel4;
          $msgnivel='';
          if($nivel1!=0&&$nivel2!=0&&$nivel3!=0&&$nivel4!=0){
            if($nivel<=5){
              $msgnivel='muy poco ansioso';
            }else if ($nivel<=10) {
              $msgnivel='ansiedad leve';
            }else if ($nivel<=15) {
              $msgnivel='ansiedad moderada';
            }else if (nivel<=20) {
              $msgnivel='ansiedad extrema';
            }else{
              $msgnivel='ansiedad extrema';
            }
          }

          $name="NIVEL DE ANSIEDAD:";
          if(isset($msgnivel) && $msgnivel){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$msgnivel."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ver anexo 2)";
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;muy poca ansiedad&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ansiedad leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ansiedad moderada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ansiedad extrema&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ver anexo 2)";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $name="E.- HIPÓTESIS DIAGNÓSTICA<br>";
          echo $name;
          if(isset($pat["surgeryiidiagnosishypothesis"])&& $pat["surgeryiidiagnosishypothesis"]){
            $pat["surgeryiidiagnosishypothesis"] = str_replace("\n", "*", $pat["surgeryiidiagnosishypothesis"]);
            $datad=explode('*',$pat["surgeryiidiagnosishypothesis"]);
            //echo $pat["description"];
            $len=count($datad);
            if($len!=0){
              for($i=0;$i<$len;$i++){
                echo "&nbsp;&nbsp;".$datad[$i]."<br>";
              }
            }else{
              echo "......................................................................................................................................................................................................................<br>";
              echo "......................................................................................................................................................................................................................<br>";
            }
          }else{
            echo "......................................................................................................................................................................................................................<br>";
            echo "......................................................................................................................................................................................................................<br>";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="">
        <div align="left">
          <u>F.- EXÁMENES COMPLEMENTARIOS</u>
        </div>
      </div>
      <br>
      <div class="">
        <div align="left">
          <?php
          $name="EXAMEN DE LABORATORIO:";
          if(isset($pat["laboratorio1"]) && is_numeric($pat["laboratorio1"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hemograma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;hemograma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["laboratorio2"]) && is_numeric($pat["laboratorio2"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cuagulograma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;cuagulograma&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["laboratorio3"]) && is_numeric($pat["laboratorio3"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;glicemia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;glicemia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["laboratorio4"]) && is_numeric($pat["laboratorio4"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;creatinina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;creatinina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["laboratorio5"]) && is_numeric($pat["laboratorio5"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otros&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otros&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          $name.="<br>";
          $name.="ESTUDIO HISTOPATOLÓGICO:";
          if(isset($pat["histopatologico1"]) && is_numeric($pat["histopatologico1"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;citología&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;citología&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["histopatologico2"]) && is_numeric($pat["histopatologico2"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia escisional&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia escisional&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["histopatologico3"]) && is_numeric($pat["histopatologico3"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia incisional&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia incisional&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["histopatologico4"]) && is_numeric($pat["histopatologico4"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia aspiración&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;biopsia aspiración&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          $name.="<br>";
          $name.="IMAGENOLOGÍA:";
          if(isset($pat["diagenologia1"]) && is_numeric($pat["diagenologia1"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;periapical&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;periapical&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["diagenologia2"]) && is_numeric($pat["diagenologia2"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;oclusal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;oclusal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["diagenologia3"]) && is_numeric($pat["diagenologia3"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ortopantomografía&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ortopantomografía&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["diagenologia4"]) && is_numeric($pat["diagenologia4"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lateral de cráneo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;lateral de cráneo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["diagenologia5"]) && is_numeric($pat["diagenologia5"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tomografía&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tomografía&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["diagenologia6"]) && is_numeric($pat["diagenologia6"])){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otros&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;otros&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }

          $name.="<br>";
          $name.="FOTOGRAFÍA ODONTOLÓGICA:";
          if(isset($pat["fotografia1"]) && is_numeric($pat["fotografia1"])){
              $name.="&nbsp;&nbsp;de frente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;de frente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["fotografia2"]) && is_numeric($pat["fotografia2"])){
              $name.="&nbsp;&nbsp;de perfil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;de perfil&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["fotografia3"]) && is_numeric($pat["fotografia3"])){
              $name.="&nbsp;&nbsp;maxilar intrabucal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;&nbsp;maxilar intrabucal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["fotografia4"]) && is_numeric($pat["fotografia4"])){
              $name.="&nbsp;&nbsp;mandibular intrabucal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;mandibular intrabucal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          if(isset($pat["fotografia5"]) && is_numeric($pat["fotografia5"])){
              $name.="&nbsp;&nbsp;en oclusión&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI";
          }else{
              $name.="&nbsp;&nbsp;en oclusión&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }

          echo $name;
          ?>
        </div>
      </div>
      <br>
      <div class="">
        <div align="left">
          <u>G.- DIAGNÓSTICO FINAL</u>
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $name="";
          if(isset($pat["surgeryiidiagnosis"]) && $pat["surgeryiidiagnosis"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["surgeryiidiagnosis"];
          }else{
              $name.="......................................................................................................................................................................................................................";
          }

          echo $name;
          ?>
        </div>
      </div>
      <br>
      <div class="">
        <div align="left">
          <?php
          $nivel1=0;
          if(isset($pat["gradodificultad1"]) && $pat["gradodificultad1"]){
            $nivel1=intval($pat['gradodificultad1']);
          }
          $nivel2=0;
          if(isset($pat["gradodificultad2"]) && $pat["gradodificultad2"]){
            $nivel2=intval($pat['gradodificultad2']);
          }
          $nivel3=0;
          if(isset($pat["gradodificultad3"]) && $pat["gradodificultad3"]){
            $nivel3=intval($pat['gradodificultad3']);
          }
          $nivelgrado=$nivel1+$nivel2+$nivel3;
          $msggrado='';
          if($nivel1!=0&&$nivel2!=0&&$nivel3!=0){
            if($nivelgrado<=4){
              $msggrado='Leve';
            }else if ($nivelgrado<=7) {
              $msggrado='Moderada';
            }else if ($nivelgrado<=10) {
              $msggrado='Grave';
            }else{
              $msggrado='Grave';
            }

          }

          $name="GRADO DE DIFICULTAD QUIRÚRGICA (cordales inferiores):";
          if(isset($msggrado) && $msggrado){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$msggrado."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ver anexo 3)";
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;moderada&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;grave&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (ver anexo 2)";
          }
          echo $name;
          ?>
        </div>
      </div>
      <div class="">
        <div align="left">
            <u>H.- CONSENTIMIENTO DEL PACIENTE</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ver anexo 4)
        </div>
      </div>
      <br>
      <div class="">
        <div align="left">
          <u>I.- PLAN DE TRATAMIENTO</u>
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $name="INMEDIATO";
          if(isset($pat["inmediato"]) && $pat["inmediato"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["inmediato"];
          }else{
            $name.="...............................................................................................................................................................................................";
          }
          $name.="<br>";
          $name.="MEDIATO";
          if(isset($pat["mediato"]) && $pat["mediato"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["mediato"];
          }else{
            $name.="...................................................................................................................................................................................................";
          }
          echo $name;

          ?>
        </div>
      </div>
      <div class="">
        <div align="center">
          ANEXO 4
        </div>
      </div>
      <style media="screen">
      .text-justify{
        text-align: justify;
      }
      .m2{
        margin-left: 20px;
      }
      .firmimg {
        /*width: 50px;*/
        /*background-color: #0000FF;*/
        height: 70%;
        width: 70%;
      }
      </style>
      <div class="">
        <div class="text-justify">
          El presente anexo, debe ser firmado por el paciente que será sometido a la intervención.<br>
          Nuestra explicación de los procedimientos, su propósito, beneficios, complicaciones y alternativas de tratamiento, fueron discutidos con usted
          durante el examen clínico. Su consentimiento verbal para llevar a cabo el tratamiento es realmente todo lo requerido. Sin embargo, a fin de
          evitar situaciones de tipo legal, le solicitamos que lea los párrafos siguientes y si está de acuerdo, estampe su firma al final. Gracias<br>
          Posibles complicaciones a presentarse:
        </div>
        <div class="m2 text-justify">
          <br>
          1.- Se me ha informado y entiendo que ocasionalmente, durante y después de la cirugía, podrían presentarse las siguientes situaciones:<br>
          Dolor, infeccíon, hinchazón, sangrado, alteración del color del labio y/o cara, adormecimiento y hormigueo en la lengua y labios, mentón, encias,
          mejillas y dientes, tromboflebitis por la inyección accidental de la anestesia en una vena, situación casi imposible debido a la técnica depurada a utilizarse.<br>
          2.- Mantener la boca abierta durante mucho tiempo, puede provocar molestias en la articulación temporomandibular, por lo tanto podria manifestar cierto grado de
          dificultad al abrir o cerrar la boca. Se podrían presentarse lesiones accidentales de dientes adyacentes o en restauraciones de otros dientes, dolor posoperatorio referido
          hacia el oído, cuello y cabeza. Podría padecer náuseas, vómitos o reacciones alérgicas debido a la medicación indicada.<br>
          3.- El hecho de aplicar fuerza sobre los dientes y huesos, podría provocarme fracturas, contusiones, complicaciones en los senos maxilares,
          fistulas y aperturas del antro nasal. Los medicamentos como los sedantes y anestésicos pueden causarme somnolencia, falta de lucidez y de coordinación, todo lo cual puede acentuarse por consumo de alcohol o de otras drogas.
          Por lo tanto, no podré conducir ningún vehículo o manejar dispositivos peligrosos mientras tome tales medicamentos o esté bajo sus efectos.<br>
          4.- Accedo a que se me administre anestesia local, sedación o analgesia según el juicio del odontólogo encargado.<br>
          5.- Se me ha indicado por escrito, tomar antes y después de la intervención, medicamentos (antibióticos, analgésicos, antiinflamatorios) con sus respectivas dosis, frecuencias e ingesta. Es de suma importancia que las indicaciones se cumplan al
          de la letra, de lo contrario aumenta la posibilidad de generar resistencia de los microorganismo a los antibióticos, lo que es altamente peligroso para mi salud.<br>
          6.- Se me ha explicado y entiendo, que no hay ninguna garantía en cuanto al resultado o la curación, dibido a que, aun habiendo tomado todas las precauciones del caso, cada persona tiene su propia forma de reaccionar frente a una misma acción quirúrgica.<br>
          Por lo tanto, otorgo mi consentimiento para que el Univ.:<?php echo $student['userfullname']; ?> realice el procedimiento quirúrgico que me ha propuesto de la menera que me explico previamente y cualquier otro procedimiento que se considere necesario o aconsejable como corolario de la operación proyectada.<br>
          <br>
        </div>
      </div>
      <div class="">
        <div align="left">
          FIRMA DEL PACIENTE
        </div>
      </div>
      <div class="">
        <div class="firmimg">
          <?php
          if(isset($pat['surgeryiiconsent'])&&$pat['surgeryiiconsent']){
            echo '<img src="'.$pat['surgeryiiconsent'].'">';
          }else{
            echo "<br>......................................................";
          }
          ?>
        </div>
      </div>
      <!--PAGINA 3 FIN-->
      <div style="page-break-before: always;"></div>
      <!--PAGINA 4 INICIO-->

      <div class="">
        <?php
        $st=DBAllSurgeryTokenInfo($_GET['id']);//funcion para sacar la informacion
        $sw=true;
        $content="";
        for ($i=0; $i < count($st); $i++) {
          $sw=false;
          $userinfo=DBUserInfo($st[$i]['student']);
          $content.="<div align=\"center\">".
          "PREOPERATORIO".
          "</div>".
          "<div align=\"left\">";
          if((isset($st[$i]['preoperatorio1'])&&$st[$i]['preoperatorio1'])||
          (isset($st[$i]['preoperatorio2'])&&$st[$i]['preoperatorio2'])||
          (isset($st[$i]['preoperatorio3'])&&$st[$i]['preoperatorio3'])||
          (isset($st[$i]['preoperatorio4'])&&$st[$i]['preoperatorio4'])){
            $content.="Zona a intervenir:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['preoperatorio1']=='true'?'maxiliar anterior':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['preoperatorio2']=='true'?'maxilar posterior':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['preoperatorio3']=='true'?'mandíbula anterior':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".
            ($st[$i]['preoperatorio4']=='true'?'mandíbula posterior':'')."</u>";
          }else{
            $content.="Zona a intervenir:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxiliar anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxilar posterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula posterior";
          }
          $content.="</div>".
          "<br>".
          "<div align=\"left\">".
          "Diagnostico quirúrgico:".($st[$i]['tokendiagnosis']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokendiagnosis']:'.............................................................................................................................................................................')."".
          "</div>".
          "<br>".
          "<div align=\"left\">";
          if((isset($st[$i]['premedication1'])&&$st[$i]['premedication1'])||
          (isset($st[$i]['premedication2'])&&$st[$i]['premedication2'])||
          (isset($st[$i]['premedication3'])&&$st[$i]['premedication3'])||
          (isset($st[$i]['premedication4'])&&$st[$i]['premedication4'])){
            $content.="Premedicación:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['premedication1']=='true'?'Antibióticos':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['premedication2']=='true'?'Antiinflamatorios':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['premedication3']=='true'?'Analgésicos':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".
            ($st[$i]['premedication4']=='true'?'Ansiolíticos':'')."</u>";
          }else{
            $content.="Premedicación:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antibióticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antiinflamatorios&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Analgésicos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ansiolíticos";
          }
          $content.="</div>".
          "<div align=\"left\">".
          "Dosis:".($st[$i]['tokendose']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokendose']:'.............................................')."".
          "</div>".
          "<br>".
          "<div align=\"center\">".
          "INTRAOPERATORIO".
          "</div>".
          "<div align=\"left\" class=\"w33\">".
          "Fecha:".($st[$i]['tokendate']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokendate']:'......................................................')."".
          "</div>".
          "<div align=\"left\" class=\"w33\">".
          "Hora inicio:".($st[$i]['tokenhourstart']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenhourstart']:'..................................................')."".
          "</div>".
          "<div align=\"left\" class=\"w33\">".
          "Hora final:".($st[$i]['tokenhourend']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenhourend']:'..................................................')."".
          "</div>".
          "<div style=\"clear:both;\"></div>".
          "<br>".
          "<div align=\"left\" class=\"w50\">".
          "Cirujano:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$userinfo['userfullname']."".
          "</div>".
          "<div align=\"left\" class=\"w50\">".
          "Asistente/Instrumentista:".($st[$i]['tokenattendee']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenattendee']:'..............................................................')."".
          "</div>".
          "<div style=\"clear:both;\"></div>".
          "<br>".
          "<div align=\"left\" class=\"w50\">".
          "Medicamento anestésico:".($st[$i]['tokenanesthetic']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenanesthetic']:'..................................................................')."".
          "</div>".
          "<div align=\"left\" class=\"w50\">".
          "Técnica:".($st[$i]['tokentechnique']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokentechnique']:'........................................................................................')."".
          "</div>".
          "<div style=\"clear:both;\"></div>".
          "<br>".
          "<div align=\"left\" class=\"w33\">".
          "Firma de autorización:".(is_numeric($st[$i]['tokenauthorization'])?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI':'................................')."".
          "</div>".
          "<div align=\"left\" class=\"w33\">".
          "Firma de seguimiento:".(is_numeric($st[$i]['tokentracing'])?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI':'................................')."".
          "</div>".
          "<div align=\"left\" class=\"w33\">".
          "Firma de finalización:".(is_numeric($st[$i]['tokenending'])?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SI':'................................')."".
          "</div>".
          "<div style=\"clear:both;\"></div>".
          "<br>".
          "<div align=\"left\">".
          "Observaciones/recomendaciones del profesor:".($st[$i]['tokenobsintra']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenobsintra']:'.........................................................................................................................................')."".
          "</div>".
          "<br>".
          "<div align=\"center\">".
          "POSTOPERATORIO".
          "</div>".
          "<br>".
          "<div align=\"left\">".
          "Valorar:".
          "</div>".
          "<br>".
          "<div align=\"left\">";
          if((isset($st[$i]['sensibilidad1'])&&$st[$i]['sensibilidad1'])||
          (isset($st[$i]['sensibilidad2'])&&$st[$i]['sensibilidad2'])||
          (isset($st[$i]['sensibilidad3'])&&$st[$i]['sensibilidad3'])||
          (isset($st[$i]['sensibilidad4'])&&$st[$i]['sensibilidad4'])){
            $content.="Sensibilidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['sensibilidad1']=='true'?'normal':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['sensibilidad2']=='true'?'parestesia':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['sensibilidad3']=='true'?'anestesia':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".
            ($st[$i]['sensibilidad4']=='true'?'disestesia':'')."</u>";
          }else{
            $content.="Sensibilidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;anestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;disestesia";
          }
          $content.="</div>".
          "<div align=\"left\">";
          if((isset($st[$i]['edema1'])&&$st[$i]['edema1'])||
          (isset($st[$i]['edema2'])&&$st[$i]['edema2'])||
          (isset($st[$i]['edema3'])&&$st[$i]['edema3'])||
          (isset($st[$i]['edema4'])&&$st[$i]['edema4'])){
            $content.="Edema:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['edema1']=='true'?'ausente':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['edema2']=='true'?'leve':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['edema3']=='true'?'moderado':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".
            ($st[$i]['edema4']=='true'?'agudo':'')."</u>";
          }else{
            $content.="Edema:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ausente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;moderado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agudo";
          }
          $content.="</div>".
          "<div align=\"left\">";
          if((isset($st[$i]['buccalmucosa1'])&&$st[$i]['buccalmucosa1'])||
          (isset($st[$i]['buccalmucosa2'])&&$st[$i]['buccalmucosa2'])){
            $content.="Mucosa bucal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['buccalmucosa1']=='true'?'normal':'')."</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>".($st[$i]['buccalmucosa2']=='true'?'alterada':'')."</u>";
          }else{
            $content.="Mucosa bucal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;alterada";
          }
          $content.="</div>".
          "<br>".
          "<div align=\"left\">".
          "Observaciones/recomendaciones del profesor:".($st[$i]['tokenobspost']!=''?'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$st[$i]['tokenobspost']:'.........................................................................................................................................')."".
          "</div>".
          "<br>".
          "<hr>";
        }
        if($sw==true){
            //no ingrese inicio
            $content.="<div align=\"center\">".
            "PREOPERATORIO".
            "</div>".
            "<div align=\"left\">".
            "Zona a intervenir:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxiliar anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxilar posterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula posterior".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Diagnostico quirúrgico:...............................................................................................................................................................................".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Premedicación:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antibióticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antiinflamatorios&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Analgésicos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ansiolíticos".
            "</div>".
            "<div align=\"left\">".
            "Dosis:...............................................".
            "</div>".
            "<br>".
            "<div align=\"center\">".
            "INTRAOPERATORIO".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Fecha:.........../........../..........".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Hora inicio:............................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Hora final:.............................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w50\">".
            "Cirujano:...........................................................................................".
            "</div>".
            "<div align=\"left\" class=\"w50\">".
            "Asistente/Instrumentista:.................................................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w50\">".
            "Medicamento anestésico:.................................................................".
            "</div>".
            "<div align=\"left\" class=\"w50\">".
            "Técnica:...........................................................................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de autorización:...................................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de seguimiento:...................................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de finalización:...................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\">".
            "Observaciones/recomendaciones del profesor:............................................................................................................................................".
            "</div>".
            "<br>".
            "<div align=\"center\">".
            "POSTOPERATORIO".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Valorar:".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Sensibilidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;anestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;disestesia".
            "</div>".
            "<div align=\"left\">".
            "Edema:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ausente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;moderado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agudo".
            "</div>".
            "<div align=\"left\">".
            "Mucosa bucal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;alterada".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Observaciones/recomendaciones del profesor:...........................................................................................................................................".
            "</div>".
            "<hr>";
            $content.="<div align=\"center\">".
            "PREOPERATORIO".
            "</div>".
            "<div align=\"left\">".
            "Zona a intervenir:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxiliar anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;maxilar posterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula anterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;mandíbula posterior".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Diagnostico quirúrgico:...............................................................................................................................................................................".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Premedicación:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antibióticos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Antiinflamatorios&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Analgésicos&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ansiolíticos".
            "</div>".
            "<div align=\"left\">".
            "Dosis:...............................................".
            "</div>".
            "<br>".
            "<div align=\"center\">".
            "INTRAOPERATORIO".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Fecha:.........../........../..........".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Hora inicio:............................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Hora final:.............................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w50\">".
            "Cirujano:...........................................................................................".
            "</div>".
            "<div align=\"left\" class=\"w50\">".
            "Asistente/Instrumentista:.................................................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w50\">".
            "Medicamento anestésico:.................................................................".
            "</div>".
            "<div align=\"left\" class=\"w50\">".
            "Técnica:...........................................................................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de autorización:...................................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de seguimiento:...................................".
            "</div>".
            "<div align=\"left\" class=\"w33\">".
            "Firma de finalización:...................................".
            "</div>".
            "<div style=\"clear:both;\"></div>".
            "<br>".
            "<div align=\"left\">".
            "Observaciones/recomendaciones del profesor:............................................................................................................................................".
            "</div>".
            "<br>".
            "<div align=\"center\">".
            "POSTOPERATORIO".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Valorar:".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Sensibilidad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;parestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;anestesia&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;disestesia".
            "</div>".
            "<div align=\"left\">".
            "Edema:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ausente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;leve&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;moderado&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;agudo".
            "</div>".
            "<div align=\"left\">".
            "Mucosa bucal:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;normal&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;alterada".
            "</div>".
            "<br>".
            "<div align=\"left\">".
            "Observaciones/recomendaciones del profesor:...........................................................................................................................................".
            "</div>";
            //no ingrese fin
        }

        echo $content;
        ?>
      </div>
      <!--PAGINA 4 FIN-->
      <div style="page-break-before: always;"></div>
      <!--PAGINA 5 INICIO-->
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
      <div class="">
        <div align="center">
          <u>ANEXO 1</u>
        </div>
      </div>
      <br>
      <div class="">
        <table border="1" width="100%">
          <thead>
            <tr align="center">
              <th colspan="3">SISTEMA DE CLASIFICACIÓN A.S.A.</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th>CATEGORÍA</th>
              <th>ESTADO DE SALUD PREOPERATORIO</th>
              <th>CARACTERÍSTICAS/EJEMPLOS</th>
            </tr>
            <tr>
              <td>ASA I</td>
              <td>PACIENTE NORMAL Y SALUDABLE</td>
              <td>EL PACIENTE TIENE CAPACIDAD PARA SUBIR UN TRAMO DE ESCALERAS SIN PRESENTAR
                 MOLESTIAS; ANSIEDAD BAJA O NULA; RIESGO BAJO O NULO</td>
            </tr>
            <tr>
              <td>ASA II</td>
              <td>PACIENTE CON ENFERMEDAD SISTÉMICA LEVE</td>
              <td>EL PACIENTE ES CAPAZ DE SUBIR UN TRAMO DE ESCALERAS,
                PERO NECESITA DETENERSE AL TERMINAR EL EJERCICIO DEBIDO A
                QUE PRESENTA MALESTAR; ANTECEDENTE DE ESTADOS PATOLÓGICOS
                BIEN CONTROLADOS QUE INCLUYEN DIABETES NO DEPENDIENTE DE INSULINA,
                PREHIPERTENSION, EPILEPSIA, ASMA O ENFERMEDADES TIROIDEAS</td>
            </tr>
            <tr>
              <td>ASA III</td>
              <td>PACIENTE CON ENFERMEDAD SISTÉMICA GRAVE</td>
              <td>EL PACIENTE ES CAPAZ DE SUBIR UN TRAMO DE ESCALERAS, PERO NECESITA DETENERSE
                 AL TERMINAR EL EJERCICIO DEBIDO A QUE PRESENTA MALESTAR; ANTECEDENTE DE ANGINA
                  DE PECHO, INFARTO DE MIOCARDIO; ENFERMEDAD CEREBROVASCULAR; INSUFICIENCIA
                   CARDIACA HACE MAS DE SEIS MESES.</td>
            </tr>
          </tbody>
        </table>
      </div>
      <br>
      <div class="">
        <div align="center">
          <u>ANEXO 2</u>
        </div>
      </div>
      <div class="">
        <div align="left">
          <?php
          $name="DETERMINACIÓN DE LA ESCALA DE ANSIEDAD DENTAL(modificado de CORAH)";
          $name.="<br>";
          $name.="Si tuviera que asistir a la clínica odontológica mañana, ¿cómo se sentiria?";
          $name.="<br>";
          $ad = array('Bien, no me importaría', 'Estaría un poco preocupado', 'Estaría muy preocupado', 'Estaría con miedo a lo que podría ocurrir', 'No podría dormir');
          if(isset($pat["nivelansiedad1"]) && is_numeric($pat["nivelansiedad1"])&&
          (intval($pat["nivelansiedad1"]) >=1 && intval($pat["nivelansiedad1"])<=5)){

              $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad1']=='1'?'<u>'.$ad[0].'</u>':$ad[0])."<br>";
              $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad1']=='2'?'<u>'.$ad[1].'</u>':$ad[1])."<br>";
              $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad1']=='3'?'<u>'.$ad[2].'</u>':$ad[2])."<br>";
              $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad1']=='4'?'<u>'.$ad[3].'</u>':$ad[3])."<br>";
              $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad1']=='5'?'<u>'.$ad[4].'</u>':$ad[4])."<br>";

          }else{
            $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[0]."<br>";
            $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[1]."<br>";
            $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[2]."<br>";
            $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[3]."<br>";
            $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[4]."<br>";
          }
          $name.="<br>";
          $name.="Cuando usted está en la sala de espera de la clínica, esperando que el estudiante le llame ¿Cómo se sentiría?";
          $name.="<br>";
          $ad = array('Tranquilo', 'Intranquilo', 'Tenso', 'Ansioso, con miedo', 'Tan ansioso que empiezo a sudar y sentirme mal');
          if(isset($pat["nivelansiedad2"]) && is_numeric($pat["nivelansiedad2"])&&
          (intval($pat["nivelansiedad2"]) >=1 && intval($pat["nivelansiedad2"])<=5)){

              $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad2']=='1'?'<u>'.$ad[0].'</u>':$ad[0])."<br>";
              $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad2']=='2'?'<u>'.$ad[1].'</u>':$ad[1])."<br>";
              $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad2']=='3'?'<u>'.$ad[2].'</u>':$ad[2])."<br>";
              $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad2']=='4'?'<u>'.$ad[3].'</u>':$ad[3])."<br>";
              $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad2']=='5'?'<u>'.$ad[4].'</u>':$ad[4])."<br>";

          }else{
            $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[0]."<br>";
            $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[1]."<br>";
            $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[2]."<br>";
            $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[3]."<br>";
            $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[4]."<br>";
          }
          $name.="<br>";
          $name.="Si usted está sentado en el sillón dental, esperando que el estudiante prepare el material e instrumental para realizar la anestesia ¿cómo se siente?";
          $name.="<br>";
          $ad = array('Tranquilo', 'Intranquilo', 'Tenso', 'Ansioso, con miedo', 'Tan ansioso que empiezo a sudar y sentirme mal');
          if(isset($pat["nivelansiedad3"]) && is_numeric($pat["nivelansiedad3"])&&
          (intval($pat["nivelansiedad3"]) >=1 && intval($pat["nivelansiedad3"])<=5)){

              $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad3']=='1'?'<u>'.$ad[0].'</u>':$ad[0])."<br>";
              $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad3']=='2'?'<u>'.$ad[1].'</u>':$ad[1])."<br>";
              $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad3']=='3'?'<u>'.$ad[2].'</u>':$ad[2])."<br>";
              $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad3']=='4'?'<u>'.$ad[3].'</u>':$ad[3])."<br>";
              $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad3']=='5'?'<u>'.$ad[4].'</u>':$ad[4])."<br>";

          }else{
            $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[0]."<br>";
            $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[1]."<br>";
            $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[2]."<br>";
            $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[3]."<br>";
            $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[4]."<br>";
          }
          $name.="<br>";
          $name.="Si usted está ya sentado en el sillón dental, observando que el estudiante toma los instrumentos para comenzar el procedimiento ¿cómo se siente?";
          $name.="<br>";
          $ad = array('Tranquilo', 'Intranquilo', 'Tenso', 'Ansioso, con miedo', 'Tan ansioso que empiezo a sudar y sentirme mal');
          if(isset($pat["nivelansiedad4"]) && is_numeric($pat["nivelansiedad4"])&&
          (intval($pat["nivelansiedad4"]) >=1 && intval($pat["nivelansiedad4"])<=5)){

              $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad4']=='1'?'<u>'.$ad[0].'</u>':$ad[0])."<br>";
              $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad4']=='2'?'<u>'.$ad[1].'</u>':$ad[1])."<br>";
              $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad4']=='3'?'<u>'.$ad[2].'</u>':$ad[2])."<br>";
              $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad4']=='4'?'<u>'.$ad[3].'</u>':$ad[3])."<br>";
              $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($pat['nivelansiedad4']=='5'?'<u>'.$ad[4].'</u>':$ad[4])."<br>";

          }else{
            $name.=$tab1."1.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[0]."<br>";
            $name.=$tab1."2.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[1]."<br>";
            $name.=$tab1."3.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[2]."<br>";
            $name.=$tab1."4.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[3]."<br>";
            $name.=$tab1."5.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[4]."<br>";
          }
          $name.="<br>";

          echo $name;
          ?>
        </div>
      </div>
      <style media="screen">
        .total{
          margin-left: 170px;
        }
      </style>
      <div class="">
        <div align="center" class="w50">
          <?php
          $name="TOTAL<br><br>";
          $name.="<div class=\"total\"><table border=1><tr><td align=\"center\">";
          $swt=false;
          if(isset($nivel) && $nivel){
            $swt=true;
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;<b>".$nivel."</b>&nbsp;&nbsp;&nbsp;&nbsp;";
          }else{
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          }
          $name.="</td></tr></table></div>";
          echo $name;
          ?>
        </div>
        <div align="left" class="w50">
          <?php
          $name="Valoración:<br><br>";
          $ad = array('muy poco ansioso', 'ansiedad leve', 'ansiedad moderada', 'ansiedad extrema');
          if($swt&&(intval($nivel) >=4 && intval($nivel)<=20)){

              $name.=$tab1."Hasta 5 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($nivel<=5?'<u>'.$ad[0].'</u>':$ad[0])."<br>";
              $name.=$tab1."De 6 a 10 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($nivel>=6&&$nivel<=10?'<u>'.$ad[1].'</u>':$ad[1])."<br>";
              $name.=$tab1."De 11 a 15 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($nivel>=11&&$nivel<=15?'<u>'.$ad[2].'</u>':$ad[2])."<br>";
              $name.=$tab1."De 16 a 20 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".($nivel>=16&&$nivel<=20?'<u>'.$ad[3].'</u>':$ad[3])."<br>";

          }else{
            $name.=$tab1."Hasta 5 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[0]."<br>";
            $name.=$tab1."De 6 a 10 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[1]."<br>";
            $name.=$tab1."De 11 a 15 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[2]."<br>";
            $name.=$tab1."De 16 a 20 puntos:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$ad[3]."<br>";

          }
          echo $name;

          ?>
        </div>
        <div style="clear:both;"></div>
      </div>
      <!--PAGINA 5 FIN-->
      <!--PAGINA 6 INICIO-->
      <div style="page-break-before: always;"></div>
      <div class="">
        <div align="center">
          <u>ANEXO 3</u>
          <br>
          <br>
          DETERMINACIÓN DEL GRADO DE DIFICULTAD QUIRÚRGICA DE LA EXODONCIA DE CORDALES INFERIORES(MODIFICADO DEL ÍNDICE DE KOERNER)
        </div>
      </div>
      <br>
      <div class="">
        <div align="left" class="w70">
          <table>
            <thead>
              <tr align="center">
                <th colspan="2">CLASIFICACIÓN DE WINTER - PELL Y GREGORY</th>
                <th>VALOR</th>
                <th>VALOR ASIGNADO</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td rowspan="4">RELACIÓN DE LOS EJES MAYORES DEL 2. Y 3. MOLAR</td>
                <td>ANGULO ABIERTO HACIA ATRÁS Y ABAJO</td>
                <td>1</td>
                <td rowspan="4">
                  <?php
                  if(isset($pat['gradodificultad1']) && $pat["gradodificultad1"]){
                    echo $pat['gradodificultad1'];
                  }else{
                    echo "&nbsp;&nbsp;";
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td>PERPENDICULAR</td>
                <td>2</td>
              </tr>
              <tr>
                <td>PARALELOS</td>
                <td>3</td>
              </tr>
              <tr>
                <td>ANGULO ABIERTO HACIA ATRÁS Y ARRIBA</td>
                <td>4</td>
              </tr>
              <!--SEGUNDO-->
              <tr>
                <td rowspan="3">PROFUNDIDAD VERTICAL</td>
                <td>BORDE OCLUSAL ENTRE EL CUELLO ANATÓMICO Y EL BORDE OCLUSAL DEL 2. MOLAR</td>
                <td>1</td>
                <td rowspan="3">

                  <?php
                  if(isset($pat['gradodificultad2']) && $pat["gradodificultad2"]){
                    echo $pat['gradodificultad2'];
                  }else{
                    echo "&nbsp;&nbsp;";
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td>BORDE OCLUSAL ENTRE EL CUELLO ANATÓMICO Y EL BORDE OCLUSAL DEL 2. MOLAR</td>
                <td>2</td>
              </tr>
              <tr>
                <td>BORDE OCLUSAL POR DEBAJO DEL CUELLO ANATÓMICO DEL 2. MOLAR</td>
                <td>3</td>
              </tr>
              <!--TERCER-->
              <tr>
                <td rowspan="3">PROFUNDIDAD ANTEROPOSTERIOR</td>
                <td>LA CORONA NO ESTA CUBIERTA POR LA RAMA</td>
                <td>1</td>
                <td rowspan="3">

                  <?php
                  if(isset($pat['gradodificultad3']) && $pat["gradodificultad3"]){
                    echo $pat['gradodificultad3'];
                  }else{
                    echo "&nbsp;&nbsp;";
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td>LA MITAD DISTAL DEL DIÁMETRO MESIODISTAL DE LA CORONA ESTA CUBIERTO POR LA RAMA</td>
                <td>2</td>
              </tr>
              <tr>
                <td>TODO EL DIÁMETRO MESIODISTAL DE LA CORONA ESTA CUBIERTO POR LA RAMA</td>
                <td>3</td>
              </tr>
              <tr>
                <td colspan="3" align="center">TOTAL OBTENIDO</td>
                <td> <b><?php if($nivelgrado>0){echo $nivelgrado;} ?></b> </td>
              </tr>
            </tbody>
          </table>
        </div>
        <style media="screen">
          .pl-40{
            padding-left: 40px;
          }
        </style>
        <div class="w30 pl-40" align="left">
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          <br>
          ESCALA DE PUNTUACIÓN
          <br>
          <br>
          <table border="1">
            <tr>
              <td>Leve</td>
              <td>3 a 4</td>
            </tr>
            <tr>
              <td>Moderada</td>
              <td>5 a 7</td>
            </tr>
            <tr>
              <td>Grave</td>
              <td>7 a 10</td>
            </tr>
          </table>
          <br><br>
          <?php
          if(isset($nivelgrado) && $nivelgrado>0){
              echo "<b><u>".$msggrado."</u></b>";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>


      <!--PAGINA 6 INICIO-->
    </div>
    <br><br><br>
    <div class="">
      <?php
      $name="Trabajo Conluido el:&nbsp;&nbsp;&nbsp;&nbsp;";
      if($pat['enddatetime']!=-1){
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
          echo "......................................................................................................................................................................................................................<br>";
          echo "......................................................................................................................................................................................................................<br>";
        }
      }else{
        echo "......................................................................................................................................................................................................................<br>";
        echo "......................................................................................................................................................................................................................<br>";
      }
      ?>
    </div>















<!--PAGINA 1 FIN-->

<!--PAGINA 2 INICIO
<div style="page-break-before: always;"></div>
<h1>grover sierra</h1>-->



<!--PAGINA 2 FIN-->

  </font>
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
