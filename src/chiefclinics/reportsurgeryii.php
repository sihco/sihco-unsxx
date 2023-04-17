<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBRemissionSurgeryiiInfo($id))==null){
    ForceLoad("index.php");
  }
}


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
  display: inline-block;

}
.ajuste {
 height: 100%;
 width: 100%;
 object-fit: contain;
}
.titulo{
  padding-top: 20px;
  width: 80%;
  height: 75px;
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
      <div align="center" class="cabezera titulo">
        <font SIZE=4><b>
          <?php
          if ($pat["clinical"]==13) {
            echo "Ficha Clinica de Cirugia Bucal III";
          }elseif($pat["clinical"]==5){
            echo "Ficha Clinica de Cirugia Bucal II";
          }
          ?>
        </b></font>
      </div>

      <div style="clear:both;"></div>
      <div class="idfolio">
        <div class="" style="padding-right: 135px;">
          N. DE FICHA: <?php
          if(isset($pat) && $pat["surgeryiiid"]!="")
            echo $pat["surgeryiiid"];
          ?>
        </div>
        <div class="">
          Fecha/Hora:
          <?php
          if($pat['startdatetime']!=-1){
            echo datetimeconv($pat['startdatetime']);
          }else{
            if(isset($pat['time']) && $pat["time"]!="")
              echo datetimeconv($pat['time']);
            else
              echo ".....................................";
          }

          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div>
        <div class="left">
          <b>ANAMNESIS</b>
        </div>
      </div>
      <div style="clear:both;"></div>
      <br>
      <div class="">
        <div class="left">
          <?php
          $name="Nombres y Apellidos:";
          $size=0;
          if(isset($pat) && $pat["patientfullname"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              $size=$size+strlen($pat["patientfullname"]);
              echo $name;
          }else{
            echo $name."...................................................................................................";
          }
          ?>
        </div>
      </div>

      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
          .dir{
            display: inline-block;
            width: 50%;
            float: left;
          }
          .loc{
            display: inline-block;
            width: 31%;
            float: left;
          }
        </style>


        <div align="left" class="loc">
          <?php
          $name="Sexo:";
          if(isset($pat) && $pat["patientgender"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientgender"];
            echo $name;
          }else{
            echo $name.".........................................";
          }
          ?>
        </div>
        <div align="left" class="loc">
          <?php
          $name="Edad:";
          if(isset($pat) && $pat["patientage"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientage"];
            echo $name;
          }else{
            echo $name.".........................................";
          }
          ?>
        </div>
        <div align="left" class="loc">
          <?php
          $name="Domicilio:";
          if(isset($pat) && $pat["patientlocation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientlocation"];
            echo $name;
          }else{
            echo $name."...............................................";
          }
          ?>
        </div>

      </div>
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
        <div align="left" class="loc">

          <?php
          $name="Telf:";
          if(isset($pat) && $pat["patientphone"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientphone"];
            echo $name;
          }else{
            echo $name."...........................................";
          }
          ?>
        </div>
        <div align="left" class="loc">
          <?php
          $name="Natural de:";
          if(isset($pat) && $pat["patientprovenance"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientprovenance"];
            echo $name;
          }else{
            echo $name."....................................";
          }
          ?>
        </div>
        <div align="left" class="loc">
          <?php
          $name="Ocupacion:";
          if(isset($pat) && $pat["patientoccupation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientoccupation"];
            echo $name;
          }else{
            echo $name."..............................................";
          }
          ?>
        </div>
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
    <div class="">
      <div class="left">
        <b>ANTECEDENTES MEDICOS GENERALES</b>
      </div>
    </div>
    <br>
    <br>
    <div class="">
      <table width="100%" border=1>
        <tr>
          <td>ENFERMEDAD</td>
          <td>SI</td>
          <td>NO</td>
          <td>OBSERVACIONES</td>
        </tr>
      <?php
      $a = array('Cardiopatías', 'Fiebre Reumática', 'Artritis', 'Tuberculosis', 'Silicosis',
          'Epilepsia', 'Hepatitis', 'Diabetes', 'Hipertension Arterial', 'Alergias', 'Asma', 'Embarazo',
          'Habitos / vicios', 'Recibe tratamiento Medico');
      $st=false;
      if(isset($pat["patientgmh"])){
          $p=cleanpatientgmh($pat["patientgmh"]);
          $st=true;
      }
      for ($i=0; $i < count($a); $i++) {
        echo "<tr>";
        echo "<td>".$a[$i]."</td>";

        if ($st) {
          if ($p[$i]["status"]=="true") {
            echo "<td></td><td><span class=\"check\">&nbsp; &nbsp;</span> </td>";
          }else {
            echo "<td><span class=\"check\">&nbsp; &nbsp;</span></td><td></td> ";
          }
          echo "<td>".$p[$i]["obs"]."</td>";
        }else{
          echo "<td></td><td></td><td></td>";
        }
        echo "</tr>";
      }
      ?>
      </table>
    </div>
    <br>

    <div style=" clear: both;"></div>
    <div class="">
      <div class="">

        <?php
        $name="Consultas y tratamientos odontologicos anteriores:";
        if(isset($pat)&& $pat["lastconsult"]!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["lastconsult"];

          echo $name;
        }else{
          echo $name.".................................................................................................";
          echo "<br>";
          echo "..................................................................................................................................................................................";
        }
        ?>
      </div>
      <div class="">

        <?php
        $name="Motivo de la consulta:";
        if(isset($pat)&& $pat["motconsult"]!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["motconsult"];

          echo $name;
        }else{
          echo $name."..............................................................................................................................................";
          echo "<br>";
          echo "..................................................................................................................................................................................";
        }
        ?>
      </div>
      <div class="">

        <?php
        $name="Estado general del paciente:";
        if(isset($pat)&& $pat["generalstatus"]!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["generalstatus"];

          echo $name;
        }else{
          echo $name.".....................................................................................................................................";
          echo "<br>";
          echo "..................................................................................................................................................................................";
        }
        ?>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <br>
    <div class="">
      <div class="left">
        <b>EXAMEN CLINICO</b>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <div class="">
      <b>EXTRAORAL</b>
    </div>
    <br>
    <div class="">
      <div class="left" style="width:48%;">
        <div class="">
          <?php
          $name="FACIES:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalfaces"]=='simetrico')
              $name.="Simetrico";
            if($pat["dentalfaces"]=='asimetrico')
              $name.="Asimetrico";
            echo $name;
          }else{
            echo $name."..............................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="PERFIL:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalprofile"]=='recto')
              $name.="Recto";
            if($pat["dentalprofile"]=='concavo')
              $name.="Concavo";
            if($pat["dentalprofile"]=='convexo')
              $name.="Convexo";
            echo $name;
          }else{
            echo $name."...............................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="CICATRICES:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalscars"]!='')
              $name.=$pat['dentalscars'];
            echo $name;
          }else{
            echo $name.".....................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="A.T.M:";

          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalatm"]=='normal')
              $name.="Aparentemente Normal";
            if($pat["dentalatm"]=='dolor')
              $name.="Dolor";
            if($pat["dentalatm"]=='chasquidos')
              $name.="Chasquidos";
            if($pat["dentalatm"]=='crujidos')
              $name.="Crujidos";
            if($pat["dentalatm"]=='dtm')
              $name.="D.T.M";
            if($pat["dentalatm"]=='trismus')
              $name.="Trismus";
            echo $name;
          }else{
            echo $name.".................................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="GANGLIOS:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalganglia"]=='normal')
              $name.="Aparentemente Normal";
            if($pat["dentalganglia"]=='inflamados')
              $name.="Inflamados";
            if($pat["dentalganglia"]=='adenitis')
              $name.="Adenitis";

            echo $name;
          }else{
            echo $name."........................................................";
          }
          ?>
        </div>

      </div>
      <div class="left" style="width:48%;">
        <div class="">
          <?php
          $name="LABIOS:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentallips"]=='medianos')
              $name.="Medianos";
            if($pat["dentallips"]=='delgados')
              $name.="Delgados";
            if($pat["dentallips"]=='gruesos')
              $name.="Gruesos";
            echo $name;
          }else{
            echo $name."...................................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="ULCERACIONES:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalulcerations"]=='no')
              $name.="No";
            if($pat["dentalulcerations"]=='si')
              $name.="Si";

            echo $name;
          }else{
            echo $name."...................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="QUEILITIS:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalcheilitis"]=='no')
              $name.="No";
            if($pat["dentalcheilitis"]=='si')
              $name.="Si";
            echo $name;
          }else{
            echo $name."..............................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="COMISURAS:";

          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalcommissures"]=='normal')
              $name.="Aparentemente Normal";
            if($pat["dentalcommissures"]=='presenta')
              $name.="Presenta queilitis";
            echo $name;
          }else{
            echo $name."..........................................................";
          }
          ?>
        </div>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <br>
    <div class="">
      <b>INTRAORAL</b>
    </div>
    <br>
    <div class="">
      <div class="left" style="width:48%;">
        <div class="">
          <?php
          $name="LENGUA:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentaltongue"]=='saburra')
              $name.="Saburra";
            if($pat["dentaltongue"]=='fisurada')
              $name.="Fisurada";
            if($pat["dentaltongue"]=='geografica')
              $name.="Geografica";
            if($pat["dentaltongue"]=='otros')
              $name.="Otros";
            echo $name;
          }else{
            echo $name."............................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="PISO DE LA BOCA:";
          if(isset($pat)){

            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalpiso"]=='aparentemente')
              $name.="Aparentemente Normal";
            if($pat["dentalpiso"]=='toruslingua')
              $name.="Torus lingua";
            if($pat["dentalpiso"]=='ranula')
              $name.="Ránula";
            if($pat["dentalpiso"]=='toruslingua')
              $name.="Frenillo lingual Alto";
            if($pat["dentalpiso"]=='mucocele')
              $name.="Mucocele";

            echo $name;
          }else{
            echo $name."...........................................";
          }
          ?>
        </div>
        <div class="">
          <?php

          $name="ENCIAS:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalencias"]=='gingivitis')
              $name.="Gingivitis cronoca no complicada";
            if($pat["dentalencias"]=='difusa')
              $name.="Gingivitis Difusa";
            if($pat["dentalencias"]=='aguda')
              $name.="Gingivitis Aguda";
            if($pat["dentalencias"]=='guna')
              $name.="G.U.N.A";
            if($pat["dentalencias"]=='hiperplasia')
              $name.="Hiperplasia gingival";
            if($pat["dentalencias"]=='papilar')
              $name.="Papilar";

            echo $name;
          }else{
            echo $name."..............................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="MUCOSA BUCAL:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalmucosa"]=='normal')
              $name.="Aparentemente normal";
            if($pat["dentalmucosa"]=='alteracion')
              $name.="Con alteracion";


            echo $name;
          }else{
            echo $name.".............................................";
          }
          ?>
        </div>

      </div>
      <div class="left" style="width:48%;">
        <div class="">
          <?php
          $name="TIPO DE OCLUSION:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentaltypeo"]=='normo')
              $name.="Normo oclusion";
            if($pat["dentaltypeo"]=='disto')
              $name.="Disto oclusion";
            if($pat["dentaltypeo"]=='mesio')
              $name.="Mesio oclusion";
            if($pat["dentaltypeo"]=='abierta')
              $name.="Mordida abierta anterior";

            echo $name;
          }else{
            echo $name.".............................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="TIPO DE PROTESIS:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentaltypep"]=='removible')
              $name.="Removible";
            if($pat["dentaltypep"]=='fija')
              $name.="Fija";
            if($pat["dentaltypep"]=='total')
              $name.="Total";

            echo $name;
          }else{
            echo $name."...............................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="HIGEINE BUCAL:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalhygiene"]=='buena')
              $name.="Buena";
            if($pat["dentalhygiene"]=='regular')
              $name.="Regular";
            if($pat["dentalhygiene"]=='mala')
              $name.="Mala";

            echo $name;
          }else{
            echo $name."...................................................";
          }
          ?>
        </div>
      </div>

    </div>

    <div style=" clear: both;"></div>
    <!--pagina 2-->
    <div style="page-break-before: always;"></div>

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
        width: 117px;
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
    </style>
    <br>
    <div style="clear:both;">
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
    if(isset($pat) && $pat["draw"]!=""){
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
    <div style="clear:both;"></div>
    <style media="screen">
      .borde{
        border-color: gray;
        border-width: 1px;
        border-style: dotted;
      }
    </style>


    <?php

    if(isset($pat)&& $pat["odontogramdesc"]){
      $pat["odontogramdesc"] = str_replace("\n", "*", $pat["odontogramdesc"]);
      $datad=explode('*',$pat["odontogramdesc"]);
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
        echo "faffff".$pat["odontogramdesc"];
      }
    }
    ?>
    <br>
    <div class="">

      <?php
      $name="HISTORIA DE LA ENFERMEDAD ACTUAL:";
      if(isset($pat)){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["surgeryiidisease"];

        echo $name;
      }else{
        echo $name."...................................................................................................";
      }
      ?>
    </div>
    <br>
    <div class="">
      <b>EXAMENES COMPLEMENTARIOS</b>
    </div>
    <div class="">
      <?php
      $name="";
      if(isset($pat) &&isset($pat['exam'])&&isset($pat['pieza'])&& $pat['exam']!=""&&$pat['pieza']!=""){
        $name.="RX ".strtoupper($pat["exam"])." PIEZA:".$pat['pieza'];

        echo $name;
      }else{
        echo $name."RX PERIAPICAL:......:PIEZA................RX OCLUSAL:......:PIEZA........RX PANORAMICO:.......:";
      }
      ?>

    </div>
    <div class="">
      <b>DIAGNOSTICO</b>
    </div>
    <div class="">
      <?php
      $name="";
      if(isset($pat) && $pat['surgeryiidiagnosis']!=""){
        $name.=$pat['surgeryiidiagnosis'];

        echo $name;
      }else{
        echo $name."...........................................................................................................................................................................";
      }
      ?>
    </div>
    <br>
    <hr>
    <div class="">
      <div class="">
        <b>TRATAMIENTO</b>
      </div>
      <div class="">
        <?php
        $name="";
        if(isset($pat) &&isset($pat['treatment']) && $pat['treatment']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".strtoupper($pat["treatment"]);
          echo $name;
        }else{

          echo $name."a. SINTOMATICO..............................................................................................................................................<br>";
          echo $name."b. ETIOLOGICA..............................................................................................................................................<br>";
          echo $name."c. QUIRURGICO..............................................................................................................................................<br>";
          echo $name."d. MEDICO FARMACOLOGICO..............................................................................................................................................<br>";

        }
        ?>
      </div>

    </div>
    <br>
    <div class="">
      <style media="screen">
      .anes1{
        width: 30%;
        height: 75px;
        display: inline-block;
        padding-left: 100px;

      }
      .anes2{
        width: 50%;
        height: 75px;
        display: inline-block;
      }
      </style>
      <div class="anes1">
        <br><br><br>
        ANESTESIAS
      </div>
      <div class="anes2">
        <?php
        $name="SPIX:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='spix')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="MENTONIANA:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='mentoniana')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="LOCAL:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='local')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="INFRAORBITARIA:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;";
          if($pat['anestesia']=='infraorbitaria')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="TUBEROSITARIA:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='tuberositoria')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="CARREA:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='carrea')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
        <br>
        <?php
        $name="GENERAL:";
        if(isset($pat) && isset($pat['anestesia']) && $pat['anestesia']!=""){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat['anestesia']=='general')
            $name.="Si";
          echo $name;
        }else{
          echo $name."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........................................";
        }
        ?>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <div class="">

    </div>

    <br>
    <br>

    <br>
    <div class="">
      <b>PRESCRIPCIONES</b>
    </div>
    <div class="">
      <?php
      $name="RP/.&nbsp;&nbsp;&nbsp;&nbsp;";
      if(isset($pat) && $pat['surgeryiiprescriptions']!=""){
        $name.=$pat['surgeryiiprescriptions'];
        echo $name;
      }else{
        echo "$name....................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................";
      }
      ?>
      <br>
    </div>

    <div class="">
      <?php
      $name="INDICACIONES:.&nbsp;&nbsp;&nbsp;&nbsp;";
      if(isset($pat) && $pat['surgeryiiindications']!=""){
        $name.=$pat['surgeryiiindications'];
        echo $name;
      }else{
        echo "$name............................................................................................................................................<br>";
        echo "...............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................";
      }
      ?>
      <br>
    </div>
    <div class="">
      <b>TRATAMIENTO P.O Y EVOLUCION</b>
    </div>
    <div class="">
      <?php
      $name="";
      if(isset($pat) && $pat['surgeryiievolution']!=""){
        $name.=$pat['surgeryiievolution'];
        echo $name;
      }else{
        echo "$name..............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................";
      }
      ?>
      <br>
    </div>
    <div class="">
      <b>OBSERVACIONES DEL CATEDRATICO</b>
    </div>
    <div class="">
      <?php
      $name="";
      if(isset($pat) && isset($pat['description']) && $pat['description']!=""){
        $name.=$pat['description'];
        echo $name;
      }else{
        echo "$name..............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................<br>";
        echo "...............................................................................................................................................................................";
      }
      ?>
      <br>
    </div>
    <br><br>
    <div class="">
      <style media="screen">
        .col1{
          display: inline-block;
          width: 48%;
        }
        .punto{
          display: inline;
          padding-top: 0px;
        }
      </style>
      <div class="col1">
        <?php
        $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";

        if(isset($pat) && $pat['teacher']!=0){
          $teacher=DBUserInfo($pat['teacher']);
          $name.=$teacher['userfullname'].'<br>Fecha Inicio:&nbsp;&nbsp;&nbsp;&nbsp;';
          if($pat['startdatetime']!=-1){
            $name.=datetimeconv($pat['startdatetime']);
          }
        }else{
          $name.="<br>Fecha Inicio:";
        }
        echo $name;
        ?>
      </div>

      <div class="col1">
        <?php
        $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";

        if(isset($pat) && $pat['teacher']!=0){
          $teacher=DBUserInfo($pat['teacher']);
          $name.=$teacher['userfullname'].'<br>Fecha Conclusión:&nbsp;&nbsp;&nbsp;&nbsp;';
          if($pat['enddatetime']!=-1){
            $name.=datetimeconv($pat['enddatetime']);
          }
        }else{
          $name.="<br>Fecha Conclusión:";
        }
        echo $name;
        ?>
      </div>
    </div>
    <div class="">
      <div class="">
        <style media="screen">
          .col1{
            display: inline-block;
            width: 48%;
          }
          .punto{
            display: inline;
            padding-top: 0px;
          }
        </style>
        <div class="col1">
          <?php
          $name="";
          if(isset($pat) && $pat["studentname"]){
            $name.=$pat["studentname"];

            echo $name;
          }else{
            echo $name;
          }

          ?>
        </div>
        <div class="col1">
          <?php
          $name="";
          if(isset($pat) && $pat["studentci"]){
            $name.=$pat["studentci"];

            echo $name;
          }else{
            echo $name;
          }

          ?>
        </div>
      </div>

      <div class="punto">
        ...............................................................................................................................
      </div>
      <div class="">
        <div class="col1">
          Apellidos y Nombres del Alumno
        </div>
        <div class="col1">
          C.I.
        </div>
      </div>
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
$dompdf->setPaper('legal');

$dompdf->render();
$type=false;
if(!isset($_GET["id"]))
  $type=false;
$dompdf->stream("archivo_.pdf",array("Attachment"=>$type));


?>
