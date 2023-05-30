<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBOrthodonticsInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=8&&$pat["clinicalid"]!=16)
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
.cabezera{


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

      <div align="center" class="">
        <?php

        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==16){
          echo "<u><b>CLÍNICA DE ORTODONCIA II</b></u> <br> <br>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==8) {
          echo "<u><b>CLÍNICA DE ORTODONCIA I</b></u> <br> <br>";
        }else{
          echo "<u><b>CLÍNICA DE ORTODONCIA</b></u> <br> <br>";
        }
        ?>

        <u><b>HISTORIA CLÍNICA</b></u>
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
          $name="ALUMNO:";
          if(isset($pat["student"]) && $pat["student"]){
              $if=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
              echo $name;
          }else{
            echo $name."..........................................................................";
          }
          ?>
        </div>
        <div align="left" class="curso">
          <?php
          if(isset($pat["clinicalid"])&&$pat["clinicalid"]==16){
            echo "CURSO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5to Año";
          }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==8) {
            echo "CURSO:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;4to Año";
          }else{
            echo "CURSO:...........................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="GESTIÓN:";
          if(isset($pat['pediatricsiyear']) && $pat["pediatricsiyear"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['pediatricsiyear'];
              echo $name;
          }else{
            echo $name."......................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <style media="screen">
          .pprimero{
            float: left;
            display: inline-block;
            width: 50%;
          }
          .psegundo{
            width: 24%;
            float: left;
            display: inline-block;
          }

        </style>
        <div class="pprimero" align="left">
          <?php
          $name="PACIENTE:";

          if(isset($pat) && $pat["patientfullname"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              echo $name;
          }else{
            echo $name."......................................................";
          }
          ?>
        </div>
        <div class="psegundo" align="left">
          <?php
          $name="EDAD:";

          if(isset($pat) && $pat["patientage"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientage"];
              echo $name;
          }else{
            echo $name.".............................";
          }
          ?>
        </div>
        <div class="psegundo" align="left">
          <?php
          $name="SEXO:";
          if(isset($pat) && $pat["patientgender"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat["patientgender"]);
            echo $name;
          }else{
            echo $name.".........................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="" align="left">
        <?php
        $name="NOMBRE DEL APODERADO:";
        if(isset($pat) && $pat["patientattorney"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientattorney"];
          echo $name;
        }else{
          echo $name.".......................................................................................................................";
        }
        ?>
      </div>
      <div class="">
        <style media="screen">
          .two{
            display: inline-block;
            width: 50%;
            float: left;
          }
          .left25{
            left: 25%;
            margin-left: 25%;
          }
        </style>
        <div class="two" align="left">
          <?php
          $name="DIRECCIÓN:";
          if(isset($pat) && $pat["patientdirection"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientdirection"];
            echo $name;
          }else{
            echo $name.".................................................................";
          }
          ?>
        </div>
        <div class="two" align="left">
          <?php
          $name="TELÉFONO:";
          if(isset($pat) && $pat["patientphone"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientphone"];
            echo $name;
          }else{
            echo $name."...........................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <br>
      <div class="">
        <b> <u>ANAMNESIS</u> </b>
      </div>
      <br>

      <!--motivo de la consulta-->
      <div class="" align="left">
        <?php
        $name="1.-MOTIVO DE LA CONSULTA:";
        if(isset($pat) && $pat["orthodonticsmotconsult"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsmotconsult"]."<br>";

        }else{
          $name.="...................................................................................................................<br>";
        }
        echo $name;
        ?>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <?php
        $name="";
        if(isset($pat) && $pat["orthodonticsalterations"]){
          if($pat["orthodonticsalterations"]=="esthetic"){
            $name.="<div class=\"left25\" align=\"left\">(*)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES DE LA ESTÉTICA DENTOFACIAL</div>";
            $name.="<div class=\"left25\" align=\"left\">(&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES FUNCIONALES</div>";
          }
          if($pat["orthodonticsalterations"]=="functional"){
            $name.="<div class=\"left25\" align=\"left\">(&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES DE LA ESTÉTICA DENTOFACIAL</div>";
            $name.="<div class=\"left25\" align=\"left\">(*)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES FUNCIONALES</div>";
          }

        }else{
          $name.="<div class=\"left25\" align=\"left\">(&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES DE LA ESTÉTICA DENTOFACIAL</div>";
          $name.="<div class=\"left25\" align=\"left\">(&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ALTERACIONES FUNCIONALES</div>";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="2.-ANTECENDENTES HEREDITARIOS:";
        if(isset($pat) && $pat["orthodonticshereditary"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticshereditary"]."<br>";

        }else{
          $name.=".......................................................................................................<br>";
          $name.=".............................................................................................................................................................................<br>";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <span>3.-ANTECENTES PERSONALES:</span>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="ESTADO NUTRICIONAL:";
        if(isset($pat) && $pat["orthodonticsnutritional"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsnutritional"]."<br>";

        }else{
          $name.="...............................................................................................................................<br>";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="LACTANCIA: (DURACIÓN)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        if(isset($pat["tipolactancia"]) && $pat["tipolactancia"]){

          if ($pat['tipolactancia']=="seno") {
            $name.="Seno materno";
          }else{
            $name.="Biberón";
          }
          $name.="&nbsp;&nbsp;";
          if(isset($pat["duracionlactancia"])){
            $name.=$pat["duracionlactancia"];
          }
        }else{
          $name.="SENO MATERNO...................................BIBERÓN...................................<br>";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="ENFERMEDADES INFECCIOSAS:";
        if(isset($pat["orthodonticsdiseases"]) && $pat["orthodonticsdiseases"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsdiseases"];
        }else{
          $name.=".................................................................................................................";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="TRATAMIENTOS FARMACOLÓGICOS:";
        if(isset($pat["orthodonticstreatments"]) && $pat["orthodonticstreatments"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticstreatments"];
        }else{
          $name.="......................................................................................................";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="ANTECEDENTES ODONTOLÓGICOS DE IMPORTACIA:";
        if(isset($pat["orthodonticsimportance"]) && $pat["orthodonticsimportance"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsimportance"];
        }else{
          $name.=".........................................................................";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="MALOS HÁBITOS:";
        if(isset($pat["orthodonticsbadhabits"]) && $pat["orthodonticsbadhabits"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsbadhabits"];
        }else{
          $name.="...........................................................................................................................................";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="TRAUMATISMO:";
        if(isset($pat["orthodonticstrauma"]) && $pat["orthodonticstrauma"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticstrauma"];
        }else{
          $name.=".............................................................................................................................................";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="TIPO DE RESPIRADOR:";
        if(isset($pat["orthodonticsrespirator"]) && $pat["orthodonticsrespirator"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["orthodonticsrespirator"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NASAL ( )&nbsp;&nbsp;&nbsp;BUCAL( )";

        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="4.- ERUPCIÓN DE LA DENTICIÓN:";
        if(isset($pat["orthodonticseruption"]) && $pat["orthodonticseruption"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["orthodonticseruption"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NORMAL ( )&nbsp;&nbsp;&nbsp;PRECOZ ( )&nbsp;&nbsp;&nbsp;TARDIA ( )";

        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="center">
        <b> <u>EXAMEN CLÍNICO</u> </b>
      </div>
      <br>
      <div class="" align="left">
        <span>1.- EXAMEN FACIAL:</span>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="A) FRONTAL:";
        if(isset($pat["dentalfaces"]) && $pat["dentalfaces"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentalfaces"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEMÉTRICO ( )&nbsp;&nbsp;&nbsp;ASIMÉTRICO ( )";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="B) PERFIL:";
        if(isset($pat["dentalprofile"]) && $pat["dentalprofile"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentalprofile"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RECTO ( )&nbsp;&nbsp;&nbsp;CONVEXO ( )&nbsp;&nbsp;&nbsp;CÓNCAVO ( )";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="C) RELACÍÓN LABIAL:";
        if(isset($pat["dentallips"]) && $pat["dentallips"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentallips"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ACEPTABLE ( )&nbsp;&nbsp;&nbsp;PROMINENTE ( )&nbsp;&nbsp;&nbsp;RETRAÍDO ( )";

        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <span>2.-EXAMEN INTRA BUCAL:</span>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="MUCOSA:";
        if(isset($pat["dentalmucosa"]) && $pat["dentalmucosa"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentalmucosa"]);
        }else{
          $name.=".......................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="ENCÍA:";
        if(isset($pat["dentalencias"]) && $pat["dentalencias"]){
          if($pat["dentalencias"]=="difusa"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gingivitis Difusa";
          }
          if($pat["dentalencias"]=="aguda"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gingivitis Aguda";
          }
          if($pat["dentalencias"]=="gingivitis"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Gingivitis cronoca no complicada";
          }
          if($pat["dentalencias"]=="papilar"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Papilar";
          }
          if($pat["dentalencias"]=="guna"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;G.U.N.A";
          }
          if($pat["dentalencias"]=="hiperplasia"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hiperplasia gingival";
          }
        }else{
          $name.=".......................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="INSERCIÓN Y FORMA DE FRENILLOS:";
        if(isset($pat["dentalbraces"]) && $pat["dentalbraces"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentalbraces"]);
        }else{
          $name.=".......................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="BÓVEDA PALATINA:";
        if(isset($pat["dentalpalatine"]) && $pat["dentalpalatine"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentalpalatine"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NORMAL ( )&nbsp;&nbsp;&nbsp;PROFUNDA ( )&nbsp;&nbsp;&nbsp;PLANA ( )";

        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="LENGUA(TAMAÑO/LIMPIEZA):";
        if(isset($pat["dentaltongue"]) && $pat["dentaltongue"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["dentaltongue"]);
        }else{
          $name.=".......................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div style="page-break-before: always;"></div>

      <div class="" align="left">
        <span>3.-ARCADA:</span>
      </div>
      <br>
      <div class="">
        <style media="screen">
          .w30{
            display: inline-block;
            width: 30%;
          }
        </style>
        <div class="w30" align="left">
          <?php
          $name="FORMA:";
          if(isset($pat["forma"]) && $pat["forma"]){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["forma"]);
          }else{
            $name.="...........................";
          }
          echo $name;
          ?>
        </div>
        <div class="w30" align="left">
          <?php
          $name="TAMAÑO:";
          if(isset($pat["tamano"]) && $pat["tamano"]){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["tamano"]);
          }else{
            $name.="...........................";
          }
          echo $name;
          ?>
        </div>
        <div class="w30" align="left">
          <?php
          $name="SIMETRÍA:";
          if(isset($pat["simetria"]) && $pat["simetria"]){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["simetria"]);
          }else{
            $name.="...........................";
          }
          echo $name;
          ?>
        </div>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="TIPO DE DENTICIÓN:";
        if(isset($pat["orthodonticsdentition"]) && $pat["orthodonticsdentition"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["orthodonticsdentition"]);
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEMPORARIA ( )&nbsp;&nbsp;&nbsp;PERMANENTE ( )&nbsp;&nbsp;&nbsp;MIXTA ( )";

        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="PIEZAS AUSENTES POR:";
        if(isset($pat["tipoausente"]) && $pat["tipoausente"]){

          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(".strtoupper($pat["tipoausente"]).")&nbsp;&nbsp;&nbsp;";
          if(isset($pat["piezaausente"]) && $pat["piezaausente"]){
            $name.=$pat["piezaausente"];
          }
        }else{
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(AVULSIÓN)..........................(APLASIA).........................";
        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="PIEZAS CON CARIES:";

        if(isset($pat["orthodonticscavities"]) && $pat["orthodonticscavities"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticscavities"];
          echo $name;
        }else{
          echo $name."...............................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES INCLUIDOS:";

        if(isset($pat["orthodonticsincluded"]) && $pat["orthodonticsincluded"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsincluded"];
          echo $name;
        }else{
          echo $name."..............................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES RETENIDOS:";

        if(isset($pat["orthodonticsretained"]) && $pat["orthodonticsretained"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsretained"];
          echo $name;
        }else{
          echo $name.".............................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES SÚPERNUMEROSAS:";

        if(isset($pat["orthodonticsnumerous"]) && $pat["orthodonticsnumerous"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsnumerous"];
          echo $name;
        }else{
          echo $name."..............................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES OBTURADOS:";

        if(isset($pat["orthodonticssealed"]) && $pat["orthodonticssealed"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticssealed"];
          echo $name;
        }else{
          echo $name."...........................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES RECONSTRUIDOS:";

        if(isset($pat["orthodonticsrebuilt"]) && $pat["orthodonticsrebuilt"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsrebuilt"];
          echo $name;
        }else{
          echo $name."..................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DIENTES CON ENDODONCIA:";

        if(isset($pat["orthodonticsendodontics"]) && $pat["orthodonticsendodontics"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsendodontics"];
          echo $name;
        }else{
          echo $name."...............................................................................................................";
        }
        ?>
      </div>
      <br>

      <br>
      <style media="screen">
      img {
      max-width: 100%;
      max-height: 100%;
      }
      .cat {
      height: 350px;
      width: 850px;
      }
      </style>
      <div class="cat" align="left">
        <!--IMAGES-->
        <?php
        if($pat['orthodonticsgram']==''){
          echo "  <img class=\"b\" src=\"".getPieza("ortodonciagram.png","../images/")."\" alt=\"\">";
        }else{
          echo "  <img class=\"b\" src=\"".$pat['orthodonticsgram']."\" alt=\"\">";
        }

        ?>
      </div>



      <div style="page-break-before: always;"></div>

      <div class="" align="center">
        <b> <u>EXÁMENES COMPLEMENTARIOS</u> </b>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="1.-FOTOS:";

        if(isset($pat["orthodonticsphoto"]) && $pat["orthodonticsphoto"]){

          if($pat['orthodonticsphoto']=='frente'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FRENTE";
          }
          if($pat['orthodonticsphoto']=='perfil'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Perfil(Derecho/Izquierdo)";
          }
          if($pat['orthodonticsphoto']=='cavidad'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Cavidad Oral";
          }
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FRENTE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PERFIL(DERECHO/IZQUIERDO)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;CAVIDAD ORAL:";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="2.-ANÁLISIS DE MODELOS:";

        if(isset($pat["orthodonticsmodel"]) && $pat["orthodonticsmodel"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Mod.&nbsp;&nbsp;".ucfirst($pat["orthodonticsmodel"]);

          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOD. ESTUDIO (&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOD. TRABAJO (&nbsp;)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="3.-EXAMEN RADIOGRÁFICO:";

        if(isset($pat["orthodonticsradiographic"]) && $pat["orthodonticsradiographic"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsradiographic"];

          echo $name;
        }else{
          echo $name."..................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="center">
        <b> <u>DIAGNOSTICO</u> </b>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="PRESUNTIVO:";

        if(isset($pat["orthodonticsdiagnosispre"]) && $pat["orthodonticsdiagnosispre"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsdiagnosispre"];

          echo $name;
        }else{
          echo $name.".............................................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="DEFINITIVO:";

        if(isset($pat["orthodonticsdiagnosisdef"]) && $pat["orthodonticsdiagnosisdef"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticsdiagnosisdef"];

          echo $name;
        }else{
          echo $name."...............................................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="PLAN DE TRATAMIENTO:";

        if(isset($pat["orthodonticstreatmentplan"]) && $pat["orthodonticstreatmentplan"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["orthodonticstreatmentplan"];

          echo $name;
        }else{
          echo $name.".......................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <span>TOMA DE IMPRESIONES</span>
      </div>
      <style media="screen">
        .w50{
          display: inline-block;
          width: 49%;
        }
        .w40{
          display: inline-block;
          width: 40%;
        }
        .w20{
          display: inline-block;
          width: 20%;
        }
      </style>
      <br>
      <div class="">
        <div class="w30">
          <?php
          $name="ESTUDIO:";

          if(isset($pat["orthodonticsstudy"]) && $pat["orthodonticsstudy"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name."..................................";
          }
          ?>
        </div>
        <div class="w30">
          <?php
          $name="TRABAJO:";

          if(isset($pat["orthodonticstreatment"]) && $pat["orthodonticstreatment"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name."..................................";
          }
          ?>
        </div>
        <div class="w30">
          <?php
          $name="DISEÑO:";

          if(isset($pat["orthodonticsdesign"]) && $pat["orthodonticsdesign"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name.".............................";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="">

        <div class="w40" align="left">
          <?php
          $name="LABRADO DE ALAMBRE:";

          if(isset($pat["orthodonticswire"]) && $pat["orthodonticswire"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name."...................";
          }
          ?>
        </div>
        <div class="w20" align="left">
          <?php
          $name="ENCERADO:";

          if(isset($pat["orthodonticswax"]) && $pat["orthodonticswax"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name."..............";
          }
          ?>
        </div>
        <div class="w30">
          <?php
          $name="CONFECCIÓN:";

          if(isset($pat["orthodonticsmaking"]) && $pat["orthodonticsmaking"]=='t'){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

            echo $name;
          }else{
            echo $name.".....................";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="AUTORIZACIÓN DE ACRILIZADO:";

        if(isset($pat["orthodonticsacrylic"]) && $pat["orthodonticsacrylic"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";

          echo $name;
        }else{
          echo $name."...............................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="INSTALACIÓN DE APARATO LOGIA:";

        if((isset($pat["orthodonticsfacility"]) && $pat["orthodonticsfacility"]=='t') || (isset($pat["orthodonticsfacility"])&&$pat["orthodonticsfacility"]=='')){
          $name.=".................................................................................................";
        }else{
          if(isset($pat['logiadesc']) && isset($pat['logiafirma'])&& isset($pat['logiadate'])){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['logiadesc']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if(isset($pat['logiafirma'])&& $pat['logiafirma']=='t'){
              $name.="Firmado";
            }
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['logiadate'];
          }else{
            $name.=".................................................................................................";
          }
        }
        ?>
      </div>
      <br>
      <div class="" align="center">
        <b> <u>EVOLUCIÓN Y CONTROLES</u> </b>
      </div>
      <br>
      <div class="" align="left">
        <?php
        if(isset($pat["orthodonticscontrols"])&& $pat["orthodonticscontrols"]){
          $pat["orthodonticscontrols"] = str_replace("\n", "*", $pat["orthodonticscontrols"]);
          $datad=explode('*',$pat["orthodonticscontrols"]);
          //echo $pat["description"];
          $len=count($datad)-1;
          if($len!=0){
            for($i=0;$i<$len;$i++){
              echo "&nbsp;&nbsp;".$datad[$i]."<br>";
            }
          }else{
            echo "1:......................................................................................................................................................................<br><br>";
            echo "2:......................................................................................................................................................................<br><br>";
            echo "3:......................................................................................................................................................................<br><br>";
            echo "4:......................................................................................................................................................................<br><br>";
            echo "5:......................................................................................................................................................................<br><br>";
          }
        }else{
          echo "1:......................................................................................................................................................................<br><br>";
          echo "2:......................................................................................................................................................................<br><br>";
          echo "3:......................................................................................................................................................................<br><br>";
          echo "4:......................................................................................................................................................................<br><br>";
          echo "5:......................................................................................................................................................................<br><br>";
        }
        ?>
      </div>
      <br>
      <div class="" align="center">
        <b> <u>OBSERVACIONES</u> </b>
      </div>
      <br>
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
            echo ".........................................................................................................................................................................<br>";
            echo ".........................................................................................................................................................................<br>";
            echo ".........................................................................................................................................................................<br>";
          }
        }else{
          echo ".........................................................................................................................................................................<br>";
          echo ".........................................................................................................................................................................<br>";
          echo ".........................................................................................................................................................................<br>";
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
