<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPediatricsiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=7&&$pat["clinicalid"]!=15)
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
  </head>
  <body>

    <div class="container">
      <?php
      $dir='../images/';
      ?>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <div align="left" class="">
        <b>IDENTIFICACIÓN DEL NIÑO</b>
      </div>

      <div class="">
        <style media="screen">
          .psegundo{
            float: left;
            width: 30%;
            display: inline-block;
          }
          .pprimero{
            float: left;
            width: 70%;
            display: inline-block;
          }
        </style>
        <div class="pprimero" align="left">
          <?php
          $name="Apellido y Nombre:";

          if(isset($pat) && $pat["patientfullname"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              echo $name;
          }else{
            echo $name.".............................................................................................";
          }
          ?>
        </div>
        <div class="psegundo" align="left">
          <?php
          $name="Edad:";

          if(isset($pat) && $pat["patientage"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientage"];
              echo $name;
          }else{
            echo $name."....................................";
          }
          ?>
        </div>
      </div>

      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
          .two{
            display: inline-block;
            width: 50%;
            float: left;
          }
        </style>
        <div align="left" class="two">
          <?php
          $name="Nacionalidad:";
          if(isset($pat) && $pat["patientnationality"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientnationality"];
            echo $name;
          }else{
            echo $name."...................................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Sexo:";
          if(isset($pat) && $pat["patientgender"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientgender"];
            echo $name;
          }else{
            echo $name.".........................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left" class="two">
          <?php
          $name="Fecha de Nacimiento:";
          if(isset($pat["patientdatebirth"]) && $pat["patientdatebirth"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientdatebirth"];
            echo $name;
          }else{
            echo $name."......................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Lugar de Nacimiento:";
          if(isset($pat["patientplacebirth"]) && $pat["patientplacebirth"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientplacebirth"];
            echo $name;
          }else{
            echo $name."...............................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left" class="two">
          <?php
          $name="Nombre del padre:";
          if(isset($pat["patientfathername"]) && $pat["patientfathername"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfathername"];
            echo $name;
          }else{
            echo $name."...........................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Ocupación:";
          if(isset($pat["patientfatheroccupation"]) && $pat["patientfatheroccupation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfatheroccupation"];
            echo $name;
          }else{
            echo $name."...............................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>

      <div class="">
        <div align="left" class="two">
          <?php
          $name="Nombre del madre:";
          if(isset($pat["patientmothername"]) && $pat["patientmothername"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientmothername"];
            echo $name;
          }else{
            echo $name."..........................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Ocupación:";
          if(isset($pat["patientmotheroccupation"]) && $pat["patientmotheroccupation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientmotheroccupation"];
            echo $name;
          }else{
            echo $name."...............................................................";
          }
          ?>
        </div>
      </div>

      <div style=" clear: both;"></div>
      <div class="">
        <u>Hermanos. Nombre y edades:</u>
      </div>
      <div style=" clear: both;"></div>
      <div class="">

        <?php
        //echo $pat['patientbrothers'];
        $bro=array();
        if(isset($pat['patientbrothers'])){
            $bro=explode('#',$pat['patientbrothers']);
        }
        $abrother=array();
        $s=count($bro);
        if($s>1){
          $names=explode(',',$bro[0]);
          $ages=explode(',',$bro[1]);
          $size=count($names);
          for ($i=0; $i < $size-1; $i++) {
              $abrother[$names[$i]]=$ages[$i];
          }
        }


        $ii=0;
        foreach ($abrother as $key => $value) {
          //echo $key.'=>'.$value.':';
          echo "<div align=\"left\" class=\"two\">".
          "Nombre:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$key.
          "   </div>";
          echo "<div align=\"left\" class=\"two\">".
          "Edad:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$value.
          "   </div><div style=\" clear: both;\"></div>";

          $ii++;
        }
        if($ii==0){
          echo "<div align=\"left\">".
          "............................................................................................................................................................................<br>".
          "............................................................................................................................................................................".
          "</div>";
        }
        ?>
      </div>
      <div style=" clear: both;"></div>

      <div class="">
        <div align="left" class="two">
          <?php
          $name="Domicilio:";
          if(isset($pat) && $pat["patientdirection"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientdirection"];
            echo $name;
          }else{
            echo $name."........................................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Localidad:";
          if(isset($pat) && $pat["patientlocation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientlocation"];
            echo $name;
          }else{
            echo $name."................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <div align="left" class="two">
          <?php
          $name="Escuela:";
          if(isset($pat) && $pat["patientschools"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientschools"];
            echo $name;
          }else{
            echo $name."............................................................................";
          }
          ?>
        </div>
        <div align="left" class="two">
          <?php
          $name="Grado que cursa:";
          if(isset($pat) && $pat["patientschool"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientschool"];
            echo $name;
          }else{
            echo $name."......................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="" align="left">
        <?php
        $name="QUIEN LO REFIERE:";
        if(isset($pat) && $pat["pediatricsirefer"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsirefer"];
          echo $name;
        }else{
          echo $name.".......................................................................................................................................";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Por que razón:";
        if(isset($pat) && $pat["pediatricsireason"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsireason"];
          echo $name;
        }else{
          echo $name.".....................................................................................................................................................";
        }
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="SIGNOS VITALES:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Temperatura:";
        if(isset($pat["temp"]) && $pat["temp"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["temp"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="...........";
        }
        $name.="F.C:";
        if(isset($pat["fc"]) && $pat["fc"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["fc"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="...........";
        }
        $name.="F.R:";
        if(isset($pat["fr"]) && $pat["fr"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["fr"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="...........";
        }
        $name.="P. Art. Sist:";
        if(isset($pat["pd"]) && $pat["pd"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["pd"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="...............";
        }
        $name.="<br>";
        $name.="Talla:";
        if(isset($pat["talla"]) && $pat["talla"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["talla"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="..............";
        }
        $name.="Peso:";
        if(isset($pat["peso"]) && $pat["peso"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["peso"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="..............";
        }
        $name.="Constitución:";
        if(isset($pat["constit"]) && $pat["constit"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["constit"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="..............";
        }
        $name.="Pulso:";
        if(isset($pat["pulso"]) && $pat["pulso"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["pulso"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="..............";
        }
        $name.="P. Art. Diast:";
        if(isset($pat["diast"]) && $pat["diast"]){
          $name.="&nbsp;&nbsp;&nbsp;".$pat["diast"]."&nbsp;&nbsp;&nbsp;";
        }else{
          $name.="..............";
        }



        echo $name;
        ?>

      </div>
      <!--motivo de la consulta-->
      <div class="" align="left">
        <?php
        $name="MOTIVO DE LA CONSULTA:<br>";
        if(isset($pat) && $pat["pediatricsimotconsult"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsimotconsult"];

        }else{
          $name.="............................................................................................................................................................................<br>";
          $name.="............................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="ACTITUD DEL NIÑO Y DE SUS PADRES EN ESTA SITUACIÓN ODONTÓLOGICA:<br>";
        if(isset($pat) && $pat["pediatricsiattitude"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiattitude"];

        }else{
          $name.="............................................................................................................................................................................<br>";
          $name.="............................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <br>
      <br>
      <div class="" align="left">

        <?php
        $name="ALUMNO<br>Apellido y Nombre:";
        if(isset($pat) && $pat["student"]){
            $if=DBUserInfo($pat['student']);
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
            echo $name;
        }else{
          echo $name."............................................................................................................................................";
        }
        ?>
      </div>
      <div class="" align="left">

        <?php
        $name="Sillón N.:";
        if(isset($pat) && $pat["pediatricsiarmchair"]!=-1){
            $name.="&nbsp;&nbsp;&nbsp;".$pat['pediatricsiarmchair']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }else{
          $name.=".............";
        }
        $name.="DOCENTE RESPONSABLE:";
        if(isset($pat) && $pat["teacher"]){
            $i=DBUserInfo($pat['teacher']);
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$i['userfullname'];
        }else{
          $name.="...............................................................................................";
        }

        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="OBSERVACIONES:";
        if(isset($pat) && isset($pat['observationdesc']) && $pat['observationdesc']!=""){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['observationdesc'];
          echo $name;
        }else{
          echo "$name..........................................................................................................................................<br>";
          echo "............................................................................................................................................................................<br>";
          echo "............................................................................................................................................................................";
        }
        ?>
        <br>
      </div>
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <div class="" align="left">
        <?php
        $name="<b>ANTECEDENTES ODONTOLÓGICOS</b><br>";
        $name.="DEL NIÑO: Atención previa:";
        if(isset($pat) && $pat["pediatricsiprior"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiprior"];
          $name.="<br>";
        }else{
          $name.="...........................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Fecha de la última atención:";

        if(isset($pat) && $pat["pediatricsilastattention"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsilastattention"];
          echo $name;
        }else{
          echo $name."..............................................................................................................................";
        }
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Atención periódica:";
        if(isset($pat["periodica"]) && $pat["periodica"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodica"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.="............................";
        }

        $name.="Cada cuanto?";
        if(isset($pat["periodicacuales"]) && $pat["periodicacuales"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodicacuales"];
          //echo $name;
        }else{
          $name.="..........................................................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Mencionar experiencias traumáticas:";
        if(isset($pat["traumaticas"]) && $pat["traumaticas"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["traumaticas"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.="............................";
        }

        $name.="Cuales?:";
        if(isset($pat["traumaticascuales"]) && $pat["traumaticascuales"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["traumaticascuales"]."<br>";
          //echo $name;
        }else{
          $name.=".......................................................................<br>";
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Actitud del niño frente a la odontologia:";
        if(isset($pat) && $pat["pediatricsiodontoattitude"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiodontoattitude"]."<br>";
          //echo $name;
        }else{
          $name.="...........................................................................................................<br>";
          $name.="...........................................................................................................................................................................<br>";
        }

        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="ANTECEDENTES MEDICOS DEL NIÑO<br>";
        $name.="Enfermedades del: Sistema respiratorio, circulatorio, digestivo, renal, alergisas, fiebre Reumática, accidentes:<br>";
        if(isset($pat) && $pat["pediatricsidiseases"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsidiseases"]."<br>";
          //echo $name;
        }else{
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Intervenciones quirúrgicas:";
        if(isset($pat) && $pat["pediatricsiinterventions"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiinterventions"];
          //echo $name;
        }else{
          $name.="................................................................................................................................";
        }

        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Con explicaciones previas:";
        if(isset($pat["conexplicaciones"]) && $pat["conexplicaciones"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["conexplicaciones"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.="..................................................";
        }

        $name.="Sin explicaciones:";
        if(isset($pat["sinconexplicaciones"]) && $pat["sinconexplicaciones"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["sinconexplicaciones"]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.=".................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="Experiencias traumáticas:(Inyecciones):";
        if(isset($pat["experienciastraumaticas"]) && $pat["experienciastraumaticas"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["experienciastraumaticas"];
          //echo $name;
        }else{
          $name.="...........................................................................................................";
        }

        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Otras:";
        if(isset($pat["experienciastraumaticasotros"]) && $pat["experienciastraumaticasotros"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["experienciastraumaticasotros"];
          //echo $name;
        }else{
          $name.="..................................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Va al médico periódicamente:";
        if(isset($pat["medicoperiodicamente"]) && $pat["medicoperiodicamente"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["medicoperiodicamente"];
          //echo $name;
        }else{
          $name.=".................................................";
        }
        $name.="Irregularmente:";
        if(isset($pat["medicoirregularmente"]) && $pat["medicoirregularmente"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["medicoirregularmente"];
          //echo $name;
        }else{
          $name.=".................................................";
        }

        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="ALIMENTACIÓN:<br>";
        $name.="Tipo y consistencia:";
        if(isset($pat) && $pat["pediatricsiconsistency"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiconsistency"]."<br>";
          //echo $name;
        }else{
          $name.="...........................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="DIETA:(en relación con el consumo de Hidratos de Carbono)<br><br>";
        $name.="Desayuno:";
        if(isset($pat["desayuno"]) && $pat["desayuno"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["desayuno"];
          //echo $name;
        }else{
          $name.=".........................................................................................................................................................";
        }
        $name.="<br>Entre desayuno y almuerzo:";
        if(isset($pat["desayunoalmuerzo"]) && $pat["desayunoalmuerzo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["desayunoalmuerzo"];
          //echo $name;
        }else{
          $name.=".............................................................................................................................";
        }
        $name.="<br>Almuerzo:";
        if(isset($pat["almuerzo"]) && $pat["almuerzo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["almuerzo"];
          //echo $name;
        }else{
          $name.=".........................................................................................................................................................";
        }
        $name.="<br>Merienda:";
        if(isset($pat["merienda"]) && $pat["merienda"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["merienda"];
          //echo $name;
        }else{
          $name.="..........................................................................................................................................................";
        }
        $name.="<br>Cena:";
        if(isset($pat["cena"]) && $pat["cena"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["cena"];
          //echo $name;
        }else{
          $name.=".................................................................................................................................................................";
        }
        $name.="<br>Despues de la cena, antes de acostarse:";
        if(isset($pat["despuescena"]) && $pat["despuescena"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["despuescena"];
          //echo $name;
        }else{
          $name.="............................................................................................................";
        }
        $name.="<br>Durante la noche si se despierta:";
        if(isset($pat["despierta"]) && $pat["despierta"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["despierta"];
          //echo $name;
        }else{
          $name.="......................................................................................................................";
        }
        $name.="<br>Número de veces que consume azúcar o dulces por dia:";
        if(isset($pat["dulcedia"]) && $pat["dulcedia"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["dulcedia"];
          //echo $name;
        }else{
          $name.=".................................................................................";
        }
        $name.="<br>Riesgo de caries: Bajo(0 a 4)";
        if(isset($pat["riesgocaries"]) && $pat["riesgocaries"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["riesgocaries"];
          //echo $name;
        }else{
          $name.="............................................................................................................................";
        }
        $name.="<br>Actitud del niño frente a al alimentación:";
        if(isset($pat["actitudalimentacion"]) && $pat["actitudalimentacion"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["actitudalimentacion"];
          //echo $name;
        }else{
          $name.="........................................................................................................";
        }



        echo $name;
        ?>
      </div>


      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>

      <div class="" align="left">
        <?php
        $name="<b>CONTROL MECANICO DE PLACA BACTERIANA:</b><br>";
        $name.="Con técnica:";
        if(isset($pat["tecnicabacterial"]) && $pat["tecnicabacterial"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["tecnicabacterial"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.=".......................";
        }
        $name.="Enseñado por:";
        if(isset($pat["ensenadopor"]) && $pat["ensenadopor"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["ensenadopor"];
          //echo $name;
        }else{
          $name.="........................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Tipo de cepillo:";
        if(isset($pat["tipocepillo"]) && $pat["tipocepillo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["tipocepillo"];
        }else{
          $name.=".................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Dentífrico:";
        if(isset($pat["dentifrico"]) && $pat["dentifrico"]){
          if($pat['dentifrico']=="nousa"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Usa";
          }
          if($pat['dentifrico']=="unocomun"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uno Comun";
          }
          if($pat['dentifrico']=="confluoruro"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Con Fluoruro";
          }
          if($pat['dentifrico']=="otros"){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Otros";
          }

        }else{
          $name.=".........................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="<b>TERAPIA CON FLUORUROS:</b><br>";
        $name.="FLOURUROS INGESTA:";
        if(isset($pat["tecnicabacterial"]) && $pat["tecnicabacterial"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["tecnicabacterial"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.=".......................";
        }
        $name.="Desde que edad?:";
        if(isset($pat["foururoedad"]) && $pat["foururoedad"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["foururoedad"];
          //echo $name;
        }else{
          $name.="............................................................................";
        }
        $name.="<br>En forma continua o discontinua:";
        if(isset($pat["foururocontinua"]) && $pat["foururocontinua"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["foururocontinua"];
          //echo $name;
        }else{
          $name.=".....................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="FLUORUROS TÓPICOS:";
        if(isset($pat["topicos"]) && $pat["topicos"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["topicos"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.=".......................";
        }
        $name.="Cada cuanto tiempo?:";
        if(isset($pat["topicostiempo"]) && $pat["topicostiempo"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["topicostiempo"];
          //echo $name;
        }else{
          $name.="......................................................................";
        }
        $name.="<br>En forma continua o discontinua:";
        if(isset($pat["topicoscontinua"]) && $pat["topicoscontinua"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["topicoscontinua"];
          //echo $name;
        }else{
          $name.=".....................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="ENJUAGATORIOS FLUORADOS:";
        if(isset($pat["enjuagatorio"]) && $pat["enjuagatorio"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["enjuagatorio"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.=".........................";
        }

        $name.="<br>En forma continua o discontinua:";
        if(isset($pat["enjuagatoriocontinua"]) && $pat["enjuagatoriocontinua"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat["enjuagatoriocontinua"]);
          //echo $name;
        }else{
          $name.=".....................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="SELLADORES:";
        if(isset($pat) && $pat["pediatricsisealants"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["pediatricsisealants"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.="................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="HÁBITOS ORALES:";
        if(isset($pat) && $pat["pediatricsioralhabits"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst( $pat["pediatricsioralhabits"])."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          //echo $name;
        }else{
          $name.="........................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>
      <br>
      <div class="" align="left">
        <?php
        $name="Resumir brevemente la actitud de los padres frente al interrogatorio:<br>";
        if(isset($pat) && $pat["pediatricsiresumefather"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsiresumefather"];
          //echo $name;
        }else{
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="PRIMERA VISITA<br>";
        $name.="ACTITUD DEL NIÑO:";
        if(isset($pat["actituddelnino"]) && $pat["actituddelnino"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["actituddelnino"];
          //echo $name;
        }else{
          $name.=".....................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }

        $name.="<br>ACTITUD DE LOS PADRES:";
        if(isset($pat["actituddelpadre"]) && $pat["actituddelpadre"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["actituddelpadre"];
          //echo $name;
        }else{
          $name.=".........................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }
        $name.="<br>O ACOMPAÑANTES:";
        if(isset($pat["actitudacompanante"]) && $pat["actitudacompanante"]){
          $name.="<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["actitudacompanante"];
          //echo $name;
        }else{
          $name.=".....................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>

      <div class="" align="left">
        <?php
        $name="SÍNTESIS de la historia y de la primera visita con el objeto de orientar el tratamiento<br>";
        if(isset($pat) && $pat["pediatricsifirstsynthesis"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["pediatricsifirstsynthesis"];
          //echo $name;
        }else{
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................<br>";
          $name.="...........................................................................................................................................................................";
        }

        echo $name;
        ?>
      </div>
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <!--ODONTOPEDIATRIA INICIO-->
      <div class="left">
        <div class="">
          ODONTOGRAMA
        </div>
      </div>

      <br>

      <br>
      <style media="screen">
        .separador{
          width: 40px;
          height: 75px;
          display: inline-block;
        }
        .separador2{
          width: 40px;
          height: 75px;
          display: inline-block;
        }
        .pieza{
          width: 35px;
          height: 75px;
          display: inline-block;

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
        .odontot{
          display: inline-block;
          width: 45%;
          float:left;
          margin-left: 20px;
        }
        .odontott{
          margin-left: 30px;
        }
        .odontot2{
          display: inline-block;
          width: 45%;
          margin-left: 10px;
          margin-top: -30px;
        }
        .odontott2{
          margin-left: 30px;
        }
      </style>
      <div align="left" class="odontot">
        <table border="1" width="100%">
          <tr>
            <td width="1.25%"><?php echo (isset($pat['tl8'])&&$pat['tl8'])?$pat['tl8']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl7'])&&$pat['tl7'])?$pat['tl7']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl6'])&&$pat['tl6'])?$pat['tl6']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl5'])&&$pat['tl5'])?$pat['tl5']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl4'])&&$pat['tl4'])?$pat['tl4']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl3'])&&$pat['tl3'])?$pat['tl3']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl2'])&&$pat['tl2'])?$pat['tl2']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tl1'])&&$pat['tl1'])?$pat['tl1']:'&nbsp;'; ?></td>
          </tr>
        </table>
      </div>
      <div align="left" class="odontot odontott">
        <table border="1" width="100%">
          <tr>
            <td width="1.25%"><?php echo (isset($pat['tr8'])&&$pat['tr8'])?$pat['tr8']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr7'])&&$pat['tr7'])?$pat['tr7']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr6'])&&$pat['tr6'])?$pat['tr6']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr5'])&&$pat['tr5'])?$pat['tr5']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr4'])&&$pat['tr4'])?$pat['tr4']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr3'])&&$pat['tr3'])?$pat['tr3']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr2'])&&$pat['tr2'])?$pat['tr2']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['tr1'])&&$pat['tr1'])?$pat['tr1']:'&nbsp;'; ?></td>
          </tr>
        </table>
      </div>

      <br>
      <br>
      <div style="clear:both;"></div>
      <?php
      $matriz=array(array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f')),
                    array(array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'),array('t','l','c','r','b','f'))
                  );
      //echo $matriz[8][8][4];
      //para recuperar
      $draw="";
      if(isset($pat["draw"]) && $pat["draw"]!=""){
        $conf=globalconf();
        $draw=trim(decryptData($pat["draw"], $conf["key"]));
        //echo $draw;
        $ma=explode('}',$draw);
        for($i=0;$i<count($ma)-1; $i++){
          $fila=explode('[',$ma[$i]);
          $r=intval(substr($fila[0],1,1));
          $c=intval(substr($fila[0],2,1));
          $data=explode(']',$fila[1]);
          $data=explode(',',$data[0]);
          if(isset($data[0])&&validodontogram($data[0],'t')) $matriz[$r][$c][0]=$data[0];
          if(isset($data[1])&&validodontogram($data[1],'l')) $matriz[$r][$c][1]=$data[1];
          if(isset($data[2])&&validodontogram($data[2],'c')) $matriz[$r][$c][2]=$data[2];
          if(isset($data[3])&&validodontogram($data[3],'r')) $matriz[$r][$c][3]=$data[3];
          if(isset($data[4])&&validodontogram($data[4],'b')) $matriz[$r][$c][4]=$data[4];
          if(isset($data[5])&&validodontogram($data[5],'')) $matriz[$r][$c][5]=$data[5];
        }
      }

      for ($i=1; $i <= 2 ; $i++) {
        for ($j=8; $j >= 1 ; $j--) {
            echo "<div class=\"pieza\">";
            $jj=$j;
            if($i==1)
              echo "  <span class=\"number\">".$i.$j."</span>";
            else{
              echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
              $jj=(($j-9)*(-1));
            }

            echo "  <img class=\"t\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
            echo "  <img class=\"l\" src=\"".getPieza($matriz[$i][$jj][1].".png")."\" alt=\"\">";
            echo "  <img class=\"c\" src=\"".getPieza($matriz[$i][$jj][2].".png")."\" alt=\"\">";
            echo "  <img class=\"r\" src=\"".getPieza($matriz[$i][$jj][3].".png")."\" alt=\"\">";
            echo "  <img class=\"b\" src=\"".getPieza($matriz[$i][$jj][4].".png")."\" alt=\"\">";
            if($matriz[$i][$jj][5]!='f')
              echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";

            echo "</div>\n";
        }
        if($i==1)
          echo "<div class=\"separador\"></div>\n";
      }
      echo "<div style=\"clear:both;\"></div>";
      echo "<div class=\"separador2\"></div>";
      for ($i=5; $i <= 6 ; $i++) {
        for ($j=5; $j >= 1 ; $j--) {
            echo "<div class=\"pieza\">";
            $jj=$j;
            if($i==5)
              echo "  <span class=\"number\">".$i.$j."</span>";
            else{
              echo "  <span class=\"number\">".$i.(($j-6)*(-1))."</span>";
              $jj=(($j-6)*(-1));
            }

            echo "  <img class=\"st\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
            echo "  <img class=\"sl\" src=\"".getPieza($matriz[$i][$jj][1].".png")."\" alt=\"\">";
            echo "  <img class=\"sc\" src=\"".getPieza($matriz[$i][$jj][2].".png")."\" alt=\"\">";
            echo "  <img class=\"sr\" src=\"".getPieza($matriz[$i][$jj][3].".png")."\" alt=\"\">";
            echo "  <img class=\"sb\" src=\"".getPieza($matriz[$i][$jj][4].".png")."\" alt=\"\">";
            if($matriz[$i][$jj][5]!='f')
              echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";

            echo "</div>\n";
        }
        if($i==5)
          echo "<div class=\"separador\"></div>\n";
      }
      echo "<div style=\"clear:both;\"></div>";
      echo "<div class=\"separador2\"></div>";
      for ($i=8; $i >= 7 ; $i--) {
        for ($j=5; $j >= 1 ; $j--) {
            echo "<div class=\"pieza\">";
            $jj=$j;
            if($i==8)
              echo "  <span class=\"number\">".$i.$j."</span>";
            else{
              echo "  <span class=\"number\">".$i.(($j-6)*(-1))."</span>";
              $jj=(($j-6)*(-1));
            }

            echo "  <img class=\"st\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
            echo "  <img class=\"sl\" src=\"".getPieza($matriz[$i][$jj][1].".png")."\" alt=\"\">";
            echo "  <img class=\"sc\" src=\"".getPieza($matriz[$i][$jj][2].".png")."\" alt=\"\">";
            echo "  <img class=\"sr\" src=\"".getPieza($matriz[$i][$jj][3].".png")."\" alt=\"\">";
            echo "  <img class=\"sb\" src=\"".getPieza($matriz[$i][$jj][4].".png")."\" alt=\"\">";
            if($matriz[$i][$jj][5]!='f')
              echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
            echo "</div>\n";
        }
        if($i==8)
          echo "<div class=\"separador\"></div>\n";
      }
      echo "<div style=\"clear:both;\"></div>";
      for ($i=4; $i >= 3 ; $i--) {
        for ($j=8; $j >= 1 ; $j--) {
            echo "<div class=\"pieza\">";
            $jj=$j;
            if($i==4)
              echo "  <span class=\"number\">".$i.$j."</span>";
            else{
              echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
              $jj=(($j-9)*(-1));
            }

            echo "  <img class=\"t\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
            echo "  <img class=\"l\" src=\"".getPieza($matriz[$i][$jj][1].".png")."\" alt=\"\">";
            echo "  <img class=\"c\" src=\"".getPieza($matriz[$i][$jj][2].".png")."\" alt=\"\">";
            echo "  <img class=\"r\" src=\"".getPieza($matriz[$i][$jj][3].".png")."\" alt=\"\">";
            echo "  <img class=\"b\" src=\"".getPieza($matriz[$i][$jj][4].".png")."\" alt=\"\">";
            if($matriz[$i][$jj][5]!='f')
              echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
            echo "</div>\n";
        }
        if($i==4)
          echo "<div class=\"separador\"></div>\n";
      }
      ?>
      <div align="left" class="odontot2">
        <table border="1" width="100%">
          <tr>
            <td width="1.25%"><?php echo (isset($pat['bl8'])&&$pat['bl8'])?$pat['bl8']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl7'])&&$pat['bl7'])?$pat['bl7']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl6'])&&$pat['bl6'])?$pat['bl6']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl5'])&&$pat['bl5'])?$pat['bl5']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl4'])&&$pat['bl4'])?$pat['bl4']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl3'])&&$pat['bl3'])?$pat['bl3']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl2'])&&$pat['bl2'])?$pat['bl2']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['bl1'])&&$pat['bl1'])?$pat['bl1']:'&nbsp;'; ?></td>
          </tr>
        </table>
      </div>
      <div align="left" class="odontot2 odontott2">
        <table border="1" width="100%">
          <tr>
            <td width="1.25%"><?php echo (isset($pat['br8'])&&$pat['br8'])?$pat['br8']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br7'])&&$pat['br7'])?$pat['br7']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br6'])&&$pat['br6'])?$pat['br6']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br5'])&&$pat['br5'])?$pat['br5']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br4'])&&$pat['br4'])?$pat['br4']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br3'])&&$pat['br3'])?$pat['br3']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br2'])&&$pat['br2'])?$pat['br2']:'&nbsp;'; ?></td>
            <td width="1.25%"><?php echo (isset($pat['br1'])&&$pat['br1'])?$pat['br1']:'&nbsp;'; ?></td>
          </tr>
        </table>
      </div>

      <div style="clear:both;"></div>
      <style media="screen">
        .borde{
          border-color: gray;
          border-width: 1px;
          border-style: dotted;
        }
      </style>


      <?php
/*
      if(isset($pat)&& $pat["description"]){
        $pat["description"] = str_replace("\n", "*", $pat["description"]);
        $datad=explode('*',$pat["description"]);
        //echo $pat["description"];

        $len=count($datad)-1;
        if($len!=0){
          $len1=$len/2;
          echo "<div style=\"display: inline-block;width:49%;\" class=\"borde\">";
          for($i=0;$i<$len1;$i++){
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
          echo "</div>";
          echo "<div style=\"display: inline-block;width:49%;\" class=\"borde\">";
          for ($i=$i; $i < $len; $i++) {
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
          echo "</div>";
        }else{
          echo "faffff".$pat["description"];
        }
      }*/
      ?>
      <br>
      <!--ODONTOPEDIATRIA FIN-->
      <div style="clear:both;"></div>
      <br>
      <style media="screen">
        .tabletwo{
          display: inline-block;
          width: 48%;
        }
      </style>
      <br>
      <div class="">
        <div align="left" class="tabletwo">
          <table border="1" width="80%">
            <tr >
              <td width="20%">CPOD</td>
              <td>
                <?php
                if(isset($pat["cpod"]) && $pat["cpod"]){
                  echo "&nbsp;&nbsp;".$pat["cpod"];
                }
                ?>
              </td>
            </tr>
            <tr >
              <td width="20%">CPOS</td>
              <td>
                <?php
                if(isset($pat["cpos"]) && $pat["cpos"]){
                  echo "&nbsp;&nbsp;".$pat["cpos"];
                }
                ?>
              </td>
            </tr>
          </table>

        </div>
        <div align="left" class="tabletwo">
          <table border="1" width="80%">
            <tr >
              <td width="20%">ceod</td>
              <td>
                <?php
                if(isset($pat["ceod"]) && $pat["ceod"]){
                  echo "&nbsp;&nbsp;".$pat["ceod"];
                }
                ?>
              </td>
            </tr>
            <tr >
              <td width="20%">ceos</td>
              <td>
                <?php
                if(isset($pat["ceos"]) && $pat["ceos"]){
                  echo "&nbsp;&nbsp;".$pat["ceos"];
                }
                ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <br>
      <br>
      <div class="">
        <div align="left" class="tabletwo">
          Cantidad de dientes presentes
          <table border="1" width="80%">
            <tr >
              <td width="20%">Pri</td>
              <td>
                <?php
                if(isset($pat["pri"]) && $pat["pri"]){
                  echo "&nbsp;&nbsp;".$pat["pri"];
                }
                ?>
              </td>
            </tr>
            <tr >
              <td width="20%">Per</td>
              <td>
                <?php
                if(isset($pat["per"]) && $pat["per"]){
                  echo "&nbsp;&nbsp;".$pat["per"];
                }
                ?>
              </td>
            </tr>
          </table>

        </div>
        <div align="left" class="tabletwo">
          <table border="1" width="80%">
            <tr>
              <td width="20%"><b>TIPO</b></td>
              <td><b>DIENTE</b></td>
            </tr>
            <tr >
              <td width="20%">Activa</td>
              <td>
                <?php
                if(isset($pat["activa"]) && $pat["activa"]){
                  echo "&nbsp;&nbsp;".$pat["activa"];
                }
                ?>
              </td>
            </tr>
            <tr >
              <td width="20%">Lenta</td>
              <td>
                <?php
                if(isset($pat["lenta"]) && $pat["lenta"]){
                  echo "&nbsp;&nbsp;".$pat["lenta"];
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="20%">Detenida</td>
              <td>
                <?php
                if(isset($pat["detenida"]) && $pat["detenida"]){
                  echo "&nbsp;&nbsp;".$pat["detenida"];
                }
                ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <?php if(isset($pat['clinicalid'])&&$pat['clinicalid']==15){ ?>
      <div class="" align="left">
        <b>DIAGNOSTICO RADIOGRÁFICO</b>
      </div>
      <style media="screen">
        .w50{
          width: 49%;
          display: inline-block;
        }
      </style>
      <br>
      <div class="w50" align="left">
        <?php
        $name="EDAD DENTARIA:";
        if(isset($pat['dentaria']) && $pat["dentaria"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["dentaria"];
        }else{
          $name.="................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="ANQUILOSIS:";
        if(isset($pat['anquilosis']) && $pat["anquilosis"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["anquilosis"];
        }else{
          $name.=".........................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="AGENESIAS:";
        if(isset($pat['agenesias']) && $pat["agenesias"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["agenesias"];
        }else{
          $name.=".........................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="ERUPCIÓN ECTÓPICA:";
        if(isset($pat['ectopica']) && $pat["ectopica"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["ectopica"];
        }else{
          $name.="........................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="SUPERNUMERARIOS:";
        if(isset($pat['supernumerarios']) && $pat["supernumerarios"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["supernumerarios"];
        }else{
          $name.=".........................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="ERUPCIÓN PRECOZ:";
        if(isset($pat['precoz']) && $pat["precoz"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["precoz"];
        }else{
          $name.="............................................";
        }
        echo $name;
        ?>
      </div>
      <div align="left">
        <?php
        $name="OBSERVACIONES:";
        if(isset($pat['dentariaobs']) && $pat["dentariaobs"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["dentariaobs"];
        }else{
          $name.="........................................................................................................................................<br>";
          $name.="..........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
    <?php } ?>
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <!--indice de oleary inicio-->
      <!--Php inicio-->

      <style media="screen">

        .piezapp{
          width: 35px;
          height: 60px;
          display: inline-block;

          position: relative;
          left: 50px;
          /*background-color: #ff0000;*/
        }

        .f{
          clear:float;
          float: left;
          margin-top: 25px;
          /*margin-left: 9px;*/
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

        .number{
          margin-left: 10px;
          clear:float;
          float: left;
        }
      </style>
      <br>
      <div style="clear:both;"></div>
      <?php


      $oly['ttlt8']='';$oly['ttlb8']='';$oly['ttll8']='';$oly['ttlr8']=''; $oly['ttrt8']='';$oly['ttrb8']='';$oly['ttrl8']='';$oly['ttrr8']='';
      $oly['ttlt7']='';$oly['ttlb7']='';$oly['ttll7']='';$oly['ttlr7']=''; $oly['ttrt7']='';$oly['ttrb7']='';$oly['ttrl7']='';$oly['ttrr7']='';
      $oly['ttlt6']='';$oly['ttlb6']='';$oly['ttll6']='';$oly['ttlr6']=''; $oly['ttrt6']='';$oly['ttrb6']='';$oly['ttrl6']='';$oly['ttrr6']='';
      $oly['ttlt5']='';$oly['ttlb5']='';$oly['ttll5']='';$oly['ttlr5']=''; $oly['ttrt5']='';$oly['ttrb5']='';$oly['ttrl5']='';$oly['ttrr5']='';
      $oly['ttlt4']='';$oly['ttlb4']='';$oly['ttll4']='';$oly['ttlr4']=''; $oly['ttrt4']='';$oly['ttrb4']='';$oly['ttrl4']='';$oly['ttrr4']='';
      $oly['ttlt3']='';$oly['ttlb3']='';$oly['ttll3']='';$oly['ttlr3']=''; $oly['ttrt3']='';$oly['ttrb3']='';$oly['ttrl3']='';$oly['ttrr3']='';
      $oly['ttlt2']='';$oly['ttlb2']='';$oly['ttll2']='';$oly['ttlr2']=''; $oly['ttrt2']='';$oly['ttrb2']='';$oly['ttrl2']='';$oly['ttrr2']='';
      $oly['ttlt1']='';$oly['ttlb1']='';$oly['ttll1']='';$oly['ttlr1']=''; $oly['ttrt1']='';$oly['ttrb1']='';$oly['ttrl1']='';$oly['ttrr1']='';

      $oly['tblt8']='';$oly['tblb8']='';$oly['tbll8']='';$oly['tblr8']=''; $oly['tbrt8']='';$oly['tbrb8']='';$oly['tbrl8']='';$oly['tbrr8']='';
      $oly['tblt7']='';$oly['tblb7']='';$oly['tbll7']='';$oly['tblr7']=''; $oly['tbrt7']='';$oly['tbrb7']='';$oly['tbrl7']='';$oly['tbrr7']='';
      $oly['tblt6']='';$oly['tblb6']='';$oly['tbll6']='';$oly['tblr6']=''; $oly['tbrt6']='';$oly['tbrb6']='';$oly['tbrl6']='';$oly['tbrr6']='';
      $oly['tblt5']='';$oly['tblb5']='';$oly['tbll5']='';$oly['tblr5']=''; $oly['tbrt5']='';$oly['tbrb5']='';$oly['tbrl5']='';$oly['tbrr5']='';
      $oly['tblt4']='';$oly['tblb4']='';$oly['tbll4']='';$oly['tblr4']=''; $oly['tbrt4']='';$oly['tbrb4']='';$oly['tbrl4']='';$oly['tbrr4']='';
      $oly['tblt3']='';$oly['tblb3']='';$oly['tbll3']='';$oly['tblr3']=''; $oly['tbrt3']='';$oly['tbrb3']='';$oly['tbrl3']='';$oly['tbrr3']='';
      $oly['tblt2']='';$oly['tblb2']='';$oly['tbll2']='';$oly['tblr2']=''; $oly['tbrt2']='';$oly['tbrb2']='';$oly['tbrl2']='';$oly['tbrr2']='';
      $oly['tblt1']='';$oly['tblb1']='';$oly['tbll1']='';$oly['tblr1']=''; $oly['tbrt1']='';$oly['tbrb1']='';$oly['tbrl1']='';$oly['tbrr1']='';


      $oly['btlt8']='';$oly['btlb8']='';$oly['btll8']='';$oly['btlr8']=''; $oly['btrt8']='';$oly['btrb8']='';$oly['btrl8']='';$oly['btrr8']='';
      $oly['btlt7']='';$oly['btlb7']='';$oly['btll7']='';$oly['btlr7']=''; $oly['btrt7']='';$oly['btrb7']='';$oly['btrl7']='';$oly['btrr7']='';
      $oly['btlt6']='';$oly['btlb6']='';$oly['btll6']='';$oly['btlr6']=''; $oly['btrt6']='';$oly['btrb6']='';$oly['btrl6']='';$oly['btrr6']='';
      $oly['btlt5']='';$oly['btlb5']='';$oly['btll5']='';$oly['btlr5']=''; $oly['btrt5']='';$oly['btrb5']='';$oly['btrl5']='';$oly['btrr5']='';
      $oly['btlt4']='';$oly['btlb4']='';$oly['btll4']='';$oly['btlr4']=''; $oly['btrt4']='';$oly['btrb4']='';$oly['btrl4']='';$oly['btrr4']='';
      $oly['btlt3']='';$oly['btlb3']='';$oly['btll3']='';$oly['btlr3']=''; $oly['btrt3']='';$oly['btrb3']='';$oly['btrl3']='';$oly['btrr3']='';
      $oly['btlt2']='';$oly['btlb2']='';$oly['btll2']='';$oly['btlr2']=''; $oly['btrt2']='';$oly['btrb2']='';$oly['btrl2']='';$oly['btrr2']='';
      $oly['btlt1']='';$oly['btlb1']='';$oly['btll1']='';$oly['btlr1']=''; $oly['btrt1']='';$oly['btrb1']='';$oly['btrl1']='';$oly['btrr1']='';

      $oly['bblt8']='';$oly['bblb8']='';$oly['bbll8']='';$oly['bblr8']=''; $oly['bbrt8']='';$oly['bbrb8']='';$oly['bbrl8']='';$oly['bbrr8']='';
      $oly['bblt7']='';$oly['bblb7']='';$oly['bbll7']='';$oly['bblr7']=''; $oly['bbrt7']='';$oly['bbrb7']='';$oly['bbrl7']='';$oly['bbrr7']='';
      $oly['bblt6']='';$oly['bblb6']='';$oly['bbll6']='';$oly['bblr6']=''; $oly['bbrt6']='';$oly['bbrb6']='';$oly['bbrl6']='';$oly['bbrr6']='';
      $oly['bblt5']='';$oly['bblb5']='';$oly['bbll5']='';$oly['bblr5']=''; $oly['bbrt5']='';$oly['bbrb5']='';$oly['bbrl5']='';$oly['bbrr5']='';
      $oly['bblt4']='';$oly['bblb4']='';$oly['bbll4']='';$oly['bblr4']=''; $oly['bbrt4']='';$oly['bbrb4']='';$oly['bbrl4']='';$oly['bbrr4']='';
      $oly['bblt3']='';$oly['bblb3']='';$oly['bbll3']='';$oly['bblr3']=''; $oly['bbrt3']='';$oly['bbrb3']='';$oly['bbrl3']='';$oly['bbrr3']='';
      $oly['bblt2']='';$oly['bblb2']='';$oly['bbll2']='';$oly['bblr2']=''; $oly['bbrt2']='';$oly['bbrb2']='';$oly['bbrl2']='';$oly['bbrr2']='';
      $oly['bblt1']='';$oly['bblb1']='';$oly['bbll1']='';$oly['bblr1']=''; $oly['bbrt1']='';$oly['bbrb1']='';$oly['bbrl1']='';$oly['bbrr1']='';


      $oly['ctlt8']='';$oly['ctlb8']='';$oly['ctll8']='';$oly['ctlr8']=''; $oly['ctrt8']='';$oly['ctrb8']='';$oly['ctrl8']='';$oly['ctrr8']='';
      $oly['ctlt7']='';$oly['ctlb7']='';$oly['ctll7']='';$oly['ctlr7']=''; $oly['ctrt7']='';$oly['ctrb7']='';$oly['ctrl7']='';$oly['ctrr7']='';
      $oly['ctlt6']='';$oly['ctlb6']='';$oly['ctll6']='';$oly['ctlr6']=''; $oly['ctrt6']='';$oly['ctrb6']='';$oly['ctrl6']='';$oly['ctrr6']='';
      $oly['ctlt5']='';$oly['ctlb5']='';$oly['ctll5']='';$oly['ctlr5']=''; $oly['ctrt5']='';$oly['ctrb5']='';$oly['ctrl5']='';$oly['ctrr5']='';
      $oly['ctlt4']='';$oly['ctlb4']='';$oly['ctll4']='';$oly['ctlr4']=''; $oly['ctrt4']='';$oly['ctrb4']='';$oly['ctrl4']='';$oly['ctrr4']='';
      $oly['ctlt3']='';$oly['ctlb3']='';$oly['ctll3']='';$oly['ctlr3']=''; $oly['ctrt3']='';$oly['ctrb3']='';$oly['ctrl3']='';$oly['ctrr3']='';
      $oly['ctlt2']='';$oly['ctlb2']='';$oly['ctll2']='';$oly['ctlr2']=''; $oly['ctrt2']='';$oly['ctrb2']='';$oly['ctrl2']='';$oly['ctrr2']='';
      $oly['ctlt1']='';$oly['ctlb1']='';$oly['ctll1']='';$oly['ctlr1']=''; $oly['ctrt1']='';$oly['ctrb1']='';$oly['ctrl1']='';$oly['ctrr1']='';

      $oly['cblt8']='';$oly['cblb8']='';$oly['cbll8']='';$oly['cblr8']=''; $oly['cbrt8']='';$oly['cbrb8']='';$oly['cbrl8']='';$oly['cbrr8']='';
      $oly['cblt7']='';$oly['cblb7']='';$oly['cbll7']='';$oly['cblr7']=''; $oly['cbrt7']='';$oly['cbrb7']='';$oly['cbrl7']='';$oly['cbrr7']='';
      $oly['cblt6']='';$oly['cblb6']='';$oly['cbll6']='';$oly['cblr6']=''; $oly['cbrt6']='';$oly['cbrb6']='';$oly['cbrl6']='';$oly['cbrr6']='';
      $oly['cblt5']='';$oly['cblb5']='';$oly['cbll5']='';$oly['cblr5']=''; $oly['cbrt5']='';$oly['cbrb5']='';$oly['cbrl5']='';$oly['cbrr5']='';
      $oly['cblt4']='';$oly['cblb4']='';$oly['cbll4']='';$oly['cblr4']=''; $oly['cbrt4']='';$oly['cbrb4']='';$oly['cbrl4']='';$oly['cbrr4']='';
      $oly['cblt3']='';$oly['cblb3']='';$oly['cbll3']='';$oly['cblr3']=''; $oly['cbrt3']='';$oly['cbrb3']='';$oly['cbrl3']='';$oly['cbrr3']='';
      $oly['cblt2']='';$oly['cblb2']='';$oly['cbll2']='';$oly['cblr2']=''; $oly['cbrt2']='';$oly['cbrb2']='';$oly['cbrl2']='';$oly['cbrr2']='';
      $oly['cblt1']='';$oly['cblb1']='';$oly['cbll1']='';$oly['cblr1']=''; $oly['cbrt1']='';$oly['cbrb1']='';$oly['cbrl1']='';$oly['cbrr1']='';


      if(isset($pat['pediatricsioleary'])&&$pat['pediatricsioleary']!=''){

        $gramdata=explode(']', $pat['pediatricsioleary']);
        $n=count($gramdata);
        for($i=0;$i<$n-1;$i++){
          $data=explode('[',$gramdata[$i]);
          $data=explode('=',$data[1]);

          if(trim($data[1])==''){
            $oly[$data[0]]='';//substr($data[0],3,1);
          }elseif (trim($data[1])=='red') {
            $oly[$data[0]]='caries';//substr($data[0],3,1).'caries';

          }elseif (trim($data[1])=='gra') {
            $oly[$data[0]]='gram';//substr($data[0],3,1).'caries';
            //echo "dfadsf";
          }
        }
      }

      ?>
      <div style="clear:both;"></div>


      <!--Php inicio-->


      <div class="">
        <div class="">
          <b>ÍNDICE DE O'LEARY</b>
        </div>
        <div class="">
          (Con revelado de placa)
        </div>
        <br>
        <div class="">
          <table width="100%" border=1>
            <tr>
              <td width="50%">
                CONTROL N. 1
              </td>
              <td width="15%">
                <?php
                if(isset($pat['info1'])) echo $pat['info1'];
                else echo "%";
                ?>

              </td>
              <td width="24%">
                Fecha:
                <?php
                if(isset($pat['date1'])) echo $pat['date1'];
                ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="">
          <!--primera oleary inicio-->
          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4){

                  }else{
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }

                  if($oly['tt'.$lf.'t'.$jj] =='gram' || $oly['tt'.$lf.'l'.$jj] =='gram' ||$oly['tt'.$lf.'r'.$jj] =='gram' ||$oly['tt'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['tt'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['tt'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['tt'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['tt'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>

          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4)
                    echo "  <span class=\"number\">".$j."</span>";
                  else{
                    echo "  <span class=\"number\">".(($j-9)*(-1))."</span>";
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }

                  if($oly['tb'.$lf.'t'.$jj] =='gram' || $oly['tb'.$lf.'l'.$jj] =='gram' ||$oly['tb'.$lf.'r'.$jj] =='gram' ||$oly['tb'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['tb'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['tb'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['tb'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['tb'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>
          <!--primera oleary fin-->
        </div>

        <br>
        <div class="">
          <table width="100%" border=1>
            <tr>
              <td width="50%">
                CONTROL N. 2
              </td>
              <td width="15%">
                <?php
                if(isset($pat['info2'])) echo $pat['info2'];
                else echo "%";
                ?>

              </td>
              <td width="24%">
                Fecha:
                <?php
                if(isset($pat['date2'])) echo $pat['date2'];
                ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="">
          <!--primera oleary inicio-->
          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4){

                  }else{
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }


                  if($oly['bt'.$lf.'t'.$jj] =='gram' || $oly['bt'.$lf.'l'.$jj] =='gram' ||$oly['bt'.$lf.'r'.$jj] =='gram' ||$oly['bt'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['bt'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['bt'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['bt'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['bt'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>

          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4)
                    echo "  <span class=\"number\">".$j."</span>";
                  else{
                    echo "  <span class=\"number\">".(($j-9)*(-1))."</span>";
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }

                  if($oly['bb'.$lf.'t'.$jj] =='gram' || $oly['bb'.$lf.'l'.$jj] =='gram' ||$oly['bb'.$lf.'r'.$jj] =='gram' ||$oly['bb'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['bb'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['bb'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['bb'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['bb'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>
          <!--primera oleary fin-->
        </div>

        <!--tercera oleary inicio todo-->
        <br>
        <div class="">
          <table width="100%" border=1>
            <tr>
              <td width="50%">
                CONTROL N. 3
              </td>
              <td width="15%">
                <?php
                if(isset($pat['info3'])) echo $pat['info3'];
                else echo "%";
                ?>

              </td>
              <td width="24%">
                Fecha:
                <?php
                if(isset($pat['date3'])) echo $pat['date3'];
                ?>
              </td>
            </tr>
          </table>
        </div>
        <div class="">
          <!--primera oleary inicio-->
          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4){

                  }else{
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }


                  if($oly['ct'.$lf.'t'.$jj] =='gram' || $oly['ct'.$lf.'l'.$jj] =='gram' ||$oly['ct'.$lf.'r'.$jj] =='gram' ||$oly['ct'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['ct'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['ct'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['ct'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['ct'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>

          <div class="">
            <?php
            echo "<div style=\"clear:both;\"></div>";

            for ($i=4; $i >= 3 ; $i--) {
              for ($j=8; $j >= 1 ; $j--) {
                  echo "<div class=\"piezapp\">";
                  $jj=$j;
                  $lf='l';
                  if($i==4)
                    echo "  <span class=\"number\">".$j."</span>";
                  else{
                    echo "  <span class=\"number\">".(($j-9)*(-1))."</span>";
                    $jj=(($j-9)*(-1));
                    $lf='r';
                  }

                  if($oly['cb'.$lf.'t'.$jj] =='gram' || $oly['cb'.$lf.'l'.$jj] =='gram' ||$oly['cb'.$lf.'r'.$jj] =='gram' ||$oly['cb'.$lf.'b'.$jj] =='gram'){
                    echo "  <img class=\"to\" src=\"".getPieza("t.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza("r.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza("l.png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza("b.png","../images/oleary/")."\" alt=\"\">";
                    //echo "FABIAN SIERA";
                    echo "  <img class=\"f\" src=\"".getPieza("tgram.png","../images/oleary/")."\" alt=\"\">";
                  }else{
                    echo "  <img class=\"to\" src=\"".getPieza('t'.$oly['cb'.$lf.'t'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"lo\" src=\"".getPieza('r'.$oly['cb'.$lf.'r'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"ro\" src=\"".getPieza('l'.$oly['cb'.$lf.'l'.$jj].".png","../images/oleary/")."\" alt=\"\">";
                    echo "  <img class=\"bo\" src=\"".getPieza('b'.$oly['cb'.$lf.'b'.$jj].".png","../images/oleary/")."\" alt=\"\">";

                  }
                  //if($matriz[$i][$jj][5]!='f')
                    //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
                  echo "</div>\n";
              }
            }
            echo "<div style=\"clear:both;\"></div>";
            ?>
          </div>
          <!--primera oleary fin-->
        </div>

        <!--tercera oleary fin todo-->


      </div>

      <!--indice de oleary fin-->
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <!--anomalias inicio-->
      <?php if(isset($pat['clinicalid'])&&$pat['clinicalid']==15){ ?>
      <div class="" align="left">
        <b>ANOMALÍA DENTARIAS</b>
      </div>

      <br>
      <div class="w50" align="left">
        <?php
        $name="De inicición y proliferación:";
        if(isset($pat['iniciacion']) && $pat["iniciacion"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="......................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="Decalcificación:";
        if(isset($pat['calcificacion']) && $pat["calcificacion"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="........................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="De histodiferenciación:";
        if(isset($pat['histo']) && $pat["histo"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="..............................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="Deerupción:";
        if(isset($pat['erupcion']) && $pat["erupcion"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="..............................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="De morfo diferenciación:";
        if(isset($pat['morfo']) && $pat["morfo"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="...........................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="Deabrasión:";
        if(isset($pat['abrasion']) && $pat["abrasion"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="..............................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50" align="left">
        <?php
        $name="De aposición:";
        if(isset($pat['aposicion']) && $pat["aposicion"]=='t'){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
        }else{
          $name.="..............................................................";
        }
        echo $name;
        ?>
      </div>
      <div class="w50"></div>
      <div align="left">
        <?php
        $name="OBSERVACIONES:";
        if(isset($pat['anomaliaobs']) && $pat["anomaliaobs"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["anomaliaobs"];
        }else{
          $name.="........................................................................................................................................<br>";
          $name.="..........................................................................................................................................................................";
        }
        echo $name;
        ?>
      </div>
      <br><br>
    <?php } ?>
      <!--anomalias fin-->
      <div class="" align="left">
        <b>PLAN DE TRATAMIENTO INTEGRAL INDIVIDUALIZADO</b>
      </div>
      <br>
      <div class="" align="left">
        <?php
        if(isset($pat["pediatricsitreatmentplan"])&& $pat["pediatricsitreatmentplan"]){
          $pat["pediatricsitreatmentplan"] = str_replace("\n", "*", $pat["pediatricsitreatmentplan"]);
          $datad=explode('*',$pat["pediatricsitreatmentplan"]);
          //echo $pat["description"];

          $len=count($datad);

          if($len!=0){


            echo "<div style=\"width:100%;\" class=\"borde\">";
            for($i=0;$i<$len;$i++){
              echo "&nbsp;&nbsp;".$datad[$i]."<br>";
            }
            echo "</div>";
          }
        }else{
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
          echo "..............................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <br>
      <!--tabla urgencias inicio-->
      <div class="" align="left">
        <b>URGENCIAS</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php
          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'urgency');
          }

          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla urgencias fin-->
      <br><br>
      <!--tabla inactivacion inicio-->
      <div class="" align="left">
        <b>INACTIVACION</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'inactivation');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }

          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla inactivacion fin-->
      <br><br>
      <!--tabla inactivacion inicio-->
      <div class="" align="left">
        <b>CONTROL QUIMICO - MECANICO DEL BIO FIL</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'quimic');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }

          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }

          echo $html;
          ?>
        </table>
      </div>
      <!--tabla inactivacion fin-->
      <br><br>
      <!--tabla morfologico inicio-->
      <div class="" align="left">
        <b>REFUERZO MORFOLÓGICO</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'morfologic');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }

          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla morfologico fin-->

      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <br>
      <!--tabla estructural inicio-->
      <div class="" align="left">
        <b>REFUERZO ESTRUCTURAL</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'estruct');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla estructural fin-->
      <br><br>
      <!--tabla pulpar inicio-->
      <div class="" align="left">
        <b>TRATAMIENTO PULPAR</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td colspan="2"><b>SECIONES</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'pulpar');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $key=$typeinfo[$i]['controlid'];

            $html.="<td>";
            if(isset($typeinfo[$i][$key."sessionpulpar-0"])&&$typeinfo[$i][$key."sessionpulpar-0"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-0"])&&$typeinfo[$i][$key."sessionpulpar-0"]=='f')
              $html.="No";
            $html.="</td>
              <td>";
            if(isset($typeinfo[$i][$key."sessionpulpar-1"])&&$typeinfo[$i][$key."sessionpulpar-1"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-1"])&&$typeinfo[$i][$key."sessionpulpar-1"]=='f')
              $html.="No";
            $html.="</td>";

            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla pulpar fin-->
      <!--tabla pulpar inicio-->
      <!--<div class="" align="left">
        <b>TRATAMIENTO PULPAR</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>SECIONES</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>-->
          <?php
          /*
          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'pulpar');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $key=$typeinfo[$i]['controlid'];
            $html.="<td>";
            $html.="
            <table width=\"100%\">
              <tr>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionpulpar-0"])&&$typeinfo[$i][$key."sessionpulpar-0"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-0"])&&$typeinfo[$i][$key."sessionpulpar-0"]=='f')
              $html.="No";

            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionpulpar-1"])&&$typeinfo[$i][$key."sessionpulpar-1"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-1"])&&$typeinfo[$i][$key."sessionpulpar-1"]=='f')
              $html.="No";
            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionpulpar-2"])&&$typeinfo[$i][$key."sessionpulpar-2"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-2"])&&$typeinfo[$i][$key."sessionpulpar-2"]=='f')
              $html.="No";
            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionpulpar-3"])&&$typeinfo[$i][$key."sessionpulpar-3"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionpulpar-3"])&&$typeinfo[$i][$key."sessionpulpar-3"]=='f')
              $html.="No";
            $html.="</td>
              </tr>
            </table>
            ";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>";
          }
          echo $html;
          */
          ?>
        <!--</table>
      </div>-->
      <!--tabla pulpar fin-->
      <br><br>
      <!--tabla cirugia inicio-->
      <div class="" align="left">
        <b>CIRUGIA</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>FIRMA</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'surgery');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlstart"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlstart"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }

          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla cirugia fin-->
      <div style="page-break-before: always;"></div>
      <div align="center" class="">
        <div class="" style=" display: inline-block; width:48%;">
          <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
          <br>
        </div>
        <div class="" style="display: inline-block; width:51%;">
          CARRERA DE ODONTOLOGIA
        </div>
        <font size="4">
        <?php
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==15){
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA II</b>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==7) {
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }else{
          echo "<b>FICHA CLINICA ODONTOPEDIATRIA I</b>";
        }
        ?>
        </font>
      </div>
      <div style="clear:both;"></div>
      <hr>
      <br>
      <!--tabla pulpar inicio-->
      <div class="" align="left">
        <b>REHABILITACIÓN</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td colspan="2"><b>SECIONES</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>
          <?php

          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'rehabilitation');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $key=$typeinfo[$i]['controlid'];

            $html.="<td>";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-0"])&&$typeinfo[$i][$key."sessionrehabilitation-0"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-0"])&&$typeinfo[$i][$key."sessionrehabilitation-0"]=='f')
              $html.="No";

            $html.="</td>
              <td>";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-1"])&&$typeinfo[$i][$key."sessionrehabilitation-1"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-1"])&&$typeinfo[$i][$key."sessionrehabilitation-1"]=='f')
              $html.="No";
            $html.="</td>";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>".
            "<tr><td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
          }
          echo $html;
          ?>
        </table>
      </div>
      <!--tabla rehabilitacion fin-->
      <!--tabla pulpar inicio-->
      <!--<div class="" align="left">
        <b>REHABILITACIÓN</b>
      </div>
      <div class="">
        <table border=1 width="100%">
          <tr>
            <td><b>FECHA</b></td>
            <td><b>PIEZA</b></td>
            <td><b>DIAGNOSTICO</b></td>
            <td><b>TRATAMIENTO</b></td>
            <td><b>SECIONES</b></td>
            <td><b>CONCLUSION</b></td>
          </tr>-->
          <?php
          /*
          $typeinfo=array();
          if(isset($_GET['id'])){
            $typeinfo=DBAllPediatricsiControlInfo($_GET['id'], 'rehabilitation');
          }
          $html="";
          for ($i=0; $i < count($typeinfo); $i++) {
            $html.="<tr>\n";
            $html.="<td>".$typeinfo[$i]["controldate"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controlpart"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controldiagnosis"]."</td>\n";
            $html.="<td>".$typeinfo[$i]["controltreatment"]."</td>\n";
            $key=$typeinfo[$i]['controlid'];
            $html.="<td>";
            $html.="
            <table width=\"100%\">
              <tr>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-0"])&&$typeinfo[$i][$key."sessionrehabilitation-0"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-0"])&&$typeinfo[$i][$key."sessionrehabilitation-0"]=='f')
              $html.="No";

            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-1"])&&$typeinfo[$i][$key."sessionrehabilitation-1"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-1"])&&$typeinfo[$i][$key."sessionrehabilitation-1"]=='f')
              $html.="No";
            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-2"])&&$typeinfo[$i][$key."sessionrehabilitation-2"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-2"])&&$typeinfo[$i][$key."sessionrehabilitation-2"]=='f')
              $html.="No";
            $html.="</td>
              <td border=1 >";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-3"])&&$typeinfo[$i][$key."sessionrehabilitation-3"]=='t')
              $html.="Si";
            if(isset($typeinfo[$i][$key."sessionrehabilitation-3"])&&$typeinfo[$i][$key."sessionrehabilitation-3"]=='f')
              $html.="No";
            $html.="</td>
              </tr>
            </table>
            ";
            $html.="</td>\n";
            $html.="<td>";
            if ($typeinfo[$i]["controlend"]=='t')
              $html.="Si";
            if ($typeinfo[$i]["controlend"]=='f')
              $html.="No";
            $html.="</td>\n";
            $html.="</tr>\n";
          }
          if($i==0){
            $html.="".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>".
            "<tr><td><br></td><td></td><td></td><td></td><td><table width=\"100%\"><tr><td><br><br></td><td></td><td></td><td></td></tr></table></td><td></td></tr>";
          }
          echo $html;*/
          ?>
        <!--</table>
      </div>-->
      <!--tabla rehabilitacion fin-->
      <br><br>
      <div class="" align="left" >
        MONITOREO
      </div>
      <div class="" align="left">
        <?php
        if(isset($pat["pediatricsimonitoring"])&& $pat["pediatricsimonitoring"]){
          $pat["pediatricsimonitoring"] = str_replace("\n", "*", $pat["pediatricsimonitoring"]);
          $datad=explode('*',$pat["pediatricsimonitoring"]);
          //echo $pat["description"];
          $len=count($datad)-1;
          if($len!=0){
            for($i=0;$i<$len;$i++){
              echo "&nbsp;&nbsp;".$datad[$i]."<br>";
            }
          }else{
            echo "<br>.............................................................................................................................................................................<br>";
          }
        }else{
          echo "<br>.............................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <br>
      <div class="" align="left" >
        COMENTARIO
      </div>
      <div class="" align="left">
        <?php
        if(isset($pat["pediatricsicomment"])&& $pat["pediatricsicomment"]){
          $pat["pediatricsicomment"] = str_replace("\n", "*", $pat["pediatricsicomment"]);
          $datad=explode('*',$pat["pediatricsicomment"]);
          //echo $pat["description"];
          $len=count($datad);
          if($len!=0){
            for($i=0;$i<$len;$i++){
              echo "&nbsp;&nbsp;".$datad[$i]."<br>";
            }
          }else{
            echo "<br>.............................................................................................................................................................................<br>";
            echo ".............................................................................................................................................................................<br>";
            echo ".............................................................................................................................................................................<br>";

          }
        }else{
          echo "<br>.............................................................................................................................................................................<br>";
          echo ".............................................................................................................................................................................<br>";
          echo ".............................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <br><br>
      <div class="" align="left" >
        Fecha Conclusión:<?php

        if (isset($pat['enddatetime'])&& $pat['enddatetime']!=-1) {
          echo "&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat2['enddatetime']);
        }else{
          echo "..............................................................";
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
