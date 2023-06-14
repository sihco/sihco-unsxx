<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionInfo($id))==null){
    ForceLoad("admission.php");
  }
}

if(!isset($_SESSION['usertable']['usertype'])||
($_SESSION['usertable']['usertype']!='admin'&&$_SESSION['usertable']['usertype']!='admission'&&$_SESSION['usertable']['usertype']!='teacher'&&$_SESSION['usertable']['usertype']!='student'&&$_SESSION['usertable']['usertype']!='chiefclinics')){
  ForceLoad("admission.php");
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Reporte</title>
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
  float:left;
}
.ajuste {
 height: 100%;
 width: 100%;
 object-fit: contain;
}
.titulo{
  padding-top: 25px;
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
      $cdir = $dir."odontologia.jpg";

      $c = "data:image/jpg;base64," . base64_encode(file_get_contents($cdir));
      ?>
      <div class="cabezera cat">
        <img class="ajuste" src="<?php echo $c; ?>" alt="">
      </div>
      <div align="center" class="cabezera titulo">
        <font SIZE=6><b>CLINICA DE ADMISION</b></font>
      </div>

      <div style="clear:both;"></div>
      <div class="idfolio">
        <div class="" style="padding-right: 179px;">
          Folio N. <?php
          if(isset($pat) && $pat["patientadmissionid"]!="")
            echo $pat["patientadmissionid"];

          ?>
        </div>
        <div class="" align="left">
          Fecha/Hora:
          <?php
          if(isset($pat) && $pat["updatetime"]!="")
            echo $DateAndTime = date('d-m-Y h:i:s a', $pat["updatetime"]);
          else
            echo "..................................";
          ?>
        </div>

      </div>
      <div style="clear:both;"></div>
      <div>
        <div class="left">
          DATOS PERSONALES O FILIACION:
        </div>
      </div>
      <div style="clear:both;"></div>
      <br>
      <div class="">
        <div class="left">
          <?php
          $name="Nombres y Apellidos:";
          $size=0;
          if(isset($pat) && $pat["patientname"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientname"].
              "&nbsp;".$pat["patientfirstname"]."&nbsp;".$pat["patientlastname"];

              echo $name;
          }else{
            echo $name."..............................................................................................................................................";
          }
          ?>
        </div>
      </div>

      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
          .dir{
            display: inline-block;
            float: left;
            width: 50%;
          }
          .loc{
            display: inline-block;
            float: left;
          }
        </style>

        <div align="left" class="dir">
          <?php
          $name="Direccion:";
          $size=0;
          if(isset($pat) && $pat["patientdirection"]){

              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientdirection"];
              $size=$size+strlen($pat["patientdirection"]);
              echo $name;
          }else{
            echo $name."........................................................................";
          }
          ?>
        </div>
        <div class="loc">
          <?php
          $name="Localidad:";
          if(isset($pat) && $pat["patientlocation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientlocation"];
            echo $name;
          }else{
            echo $name.".....................................................................";
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
        <div align="left" class="edad">

          <?php
          $name="Edad:";
          if(isset($pat) && $pat["patientage"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientage"];
            echo $name;
          }else{
            echo $name.".................";
          }
          ?>
        </div>
        <div class="pro" align="left">
          <?php
          $name="Procedencia:";
          if(isset($pat) && $pat["patientprovenance"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientprovenance"];
            echo $name;
          }else{
            echo $name."...................................................";
          }
          ?>
        </div>
        <div class="pro" align="left">
          <?php
          $name="Telf:";
          if(isset($pat) && $pat["patientphone"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientphone"];
            echo $name;
          }else{
            echo $name."......................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="">
        <style media="screen">
        .tres{
          display: inline-block;
          float: left;
          width: 30%;
        }
        </style>
        <div  align="left" class="tres">

          <?php
          $name="Genero:";
          if(isset($pat) && $pat["patientgender"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientgender"]);
            echo $name;
          }else{
            echo $name."........................................";
          }
          ?>
        </div>
        <div class="tres" align="left">
          <?php
          $name="Estado Civil:";
          if(isset($pat) && $pat["patientcivilstatus"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientcivilstatus"]);
            echo $name;
          }else{
            echo $name."................................";
          }
          ?>
        </div>
        <div class="tres" align="left">
          <?php
          $name="Ocupación:";
          if(isset($pat) && $pat["patientoccupation"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientoccupation"];
            echo $name;
          }else{
            echo $name."..................................................";
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
          width: 25%;
        }
        .grado{
          display: inline-block;
          float: left;
          width: 35%;
        }
        .nac{
          display: inline-block;
          float: left;
          width: 28%;
        }
        </style>
        <div align="left" class="nac">
          <?php
          $name="Nacionalidad:";
          if(isset($pat) && $pat["patientnationality"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientnationality"]);
            echo $name;
          }else{
            echo $name."............................";
          }
          ?>
        </div>
        <div align="left" class="grado">
          <?php
          $name="Grado de Escolaridad:";
          if(isset($pat) && $pat["patientschool"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["patientschool"]);
            echo $name;
          }else{
            echo $name."....................................";
          }
          ?>
        </div>
        <div align="left" class="tres2">
          <?php
          $name="Apoderado:";
          if(isset($pat) && $pat["patientattorney"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientattorney"];
            echo $name;
          }else{
            echo $name."...................................";
          }
          ?>
        </div>
      </div>
    </div>
    <div style=" clear: both;"></div>
    <br>
    <div class="">
      <div class="left">
        ANTECEDENTES MEDICOS GENERALES
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
          'Habitos / vicios', 'Otros');//Recibe tratamiento Medico
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

    <div class="">
      <div class="left">
        TRIAGE
      </div>
    </div>
    <div style=" clear: both;"></div>
    <div class="">
      <style media="screen">
      .caja3{
        display: inline-block;
        float: left;
        width: 33%;
      }
      </style>
      <div class="caja3" align="left">

        <?php
        $name="Temperatura:";
        if(isset($pat) && $pat["triagetemperature"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["triagetemperature"];
          echo $name;
        }else{
          echo $name."...................................";
        }
        ?>
      </div>
      <div class="caja3" align="left">
        <?php
        $name="Cefalea:";
        if(isset($pat)){
          if($pat["triageheadache"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."...........................................";
        }
        ?>
      </div>
      <div class="caja3" align="left">
        <?php
        $name="Dificultad Respiratoria:";
        if(isset($pat)){
          if($pat["triagerespiratory"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."...................";
        }
        ?>
      </div>
      <div style=" clear: both;"></div>
      <div class="caja3" align="left">
        <?php
        $name="Dolor de Garganta:";
        if(isset($pat)){
          if($pat["triagethroat"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."..........................";
        }
        ?>
      </div>

      <div class="caja3" align="left">
        <?php
        $name="Malestar General:";
        if(isset($pat["triagegeneral"])){
          if($pat["triagegeneral"]=='t')
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
          else
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No";
          echo $name;
        }else{
          echo $name."............................";
        }
        ?>
      </div>
      <div class="caja3" align="left">
        <?php
        $name="Vacuna:";
        if(isset($pat)){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
          if($pat["triagevaccine"]=='1')
            $name.="1 Dosis";
          if($pat["triagevaccine"]=='2')
            $name.="2 Dosis";
          if($pat["triagevaccine"]=='3')
            $name.="3 Dosis";
          if($pat["triagevaccine"]=='n')
            $name.="Ninguno";
          echo $name;
        }else{
          echo $name."............................................";
        }
        ?>
      </div>
    </div>
    <br><br>
    <div class="">
      <div class="left">
        EXAMEN BUCODENTAL
      </div>
    </div>
    <br>
    <br>

    <div class="">
      <div class="left" style="width:48%;">
        <div class="">

          <?php
          $name="Lengua:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentaltongue"]=='normal')
              $name.="Normal";
            if($pat["dentaltongue"]=='saburra')
              $name.="Saburral";
            if($pat["dentaltongue"]=='fisurada')
              $name.="Fisurada";
            if($pat["dentaltongue"]=='geografica')
              $name.="Geografica";
            if($pat["dentaltongue"]=='otros')
              $name.="Otros";
            echo $name;
          }else{
            echo $name.".......................................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="Piso de la boca:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalpiso"]=='aparentemente')
              $name.="Aparentemente Normal";
            if($pat["dentalpiso"]=='toruslingua')
              $name.="Torus lingual";

            echo $name;
          }else{
            echo $name."...........................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="Encias:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalencias"]=='normal')
              $name.="Normal";
            if($pat["dentalencias"]=='gingivitis')
              $name.="Gingivitis cronica no complicada";
            if($pat["dentalencias"]=='difusa')
              $name.="Difusa";
            if($pat["dentalencias"]=='papilar')
              $name.="Papilar";

            echo $name;
          }else{
            echo $name."........................................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="Mucosa Bucal:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentalmucosa"]=='normal')
              $name.="Aparentemente normal";
            if($pat["dentalmucosa"]=='alteracion')
              $name.="Con alteración";


            echo $name;
          }else{
            echo $name."............................................................";
          }
          ?>
        </div>

      </div>
      <div class="left" style="width:48%;">
        <div class="">
          <?php
          $name="Tipo de Oclusión:";
          if(isset($pat)){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            if($pat["dentaltypeo"]=='normo')
              $name.="Normo oclusión";
            if($pat["dentaltypeo"]=='disto')
              $name.="Disto oclusión";
            if($pat["dentaltypeo"]=='mesio')
              $name.="Mesio oclusión";
            //if($pat["dentaltypeo"]=='abierta')
            //  $name.="Abierta anterior";
            if($pat["dentaltypeo"]=='normal')
              $name.="Mordida Normal";
            if($pat["dentaltypeo"]=='malposicion')
              $name.="Mal posición dental";
            if($pat["dentaltypeo"]=='sobre')
              $name.="SobreMordida";
            if($pat["dentaltypeo"]=='abierta')
              $name.="Mordida Abierta";
            if($pat["dentaltypeo"]=='cruzada')
              $name.="Mordida Cruzada";
            if($pat["dentaltypeo"]=='bis')
              $name.="Mordida Bis a Bis";
            if($pat["dentaltypeo"]=='--')
              $name.="--";

            echo $name;
          }else{
            echo $name.".........................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="Tipo de Protesis:";
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
            echo $name."...........................................................";
          }
          ?>
        </div>
        <div class="">
          <?php
          $name="Higiene Bucal:";
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
            echo $name."..............................................................";
          }
          ?>
        </div>
      </div>

    </div>

    <!--PAGINA 2 INICIO-->
    <div style="page-break-before: always;"></div>

    <div class="">
      <?php
      $name="Ultima Consulta:";
      if(isset($pat) && $pat["lastconsult"]){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["lastconsult"];

        echo $name;
      }else{
        echo $name."...................................................................................................................................................";
      }
      ?>
    </div>
    <div class="">
      <?php
      $name="Motivo de Consulta:";
      if(isset($pat) && $pat["motconsult"]){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["motconsult"];

        echo $name;
      }else{
        echo $name."..............................................................................................................................................";
      }
      ?>
    </div>
    <br>
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
      .w25{
        display: inline-block;
        width: 24%;
      }
    </style>
    <div class="">
      <font size="2">
      <div class="w25">
        <?php
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("ccaries.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Fractura/Caries</span><br>";
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("cobturado.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Obturado</span><br><br><br>";
        ?>
      </div>
      <div class="w25">
        <?php
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("sellados.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Sellados</span><br>";
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("perdidoausente.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Extraido o Ausente</span>";
        ?>
      </div>
      <div class="w25">
        <?php
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("necrosispulpar.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Necrosis pulpar</span><br>";
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("corona.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Coronas</span>";
        ?>
      </div>
      <div class="w25">
        <?php
        echo "  <img style=\"display:inline:block;\" src=\"".getPieza("exodonciaindicada.png")."\" alt=\"\"> = <span style=\"display:inline:block;\"> Exodoncia Indicada</span><br><br><br>";
        ?>
      </div>
      </font>
    </div>
    <div style="clear:both;"></div>
    <br>
    <?php

    if(isset($pat)&& $pat["description"]){
      $pat["description"] = str_replace("\n", "*", $pat["description"]);
      $datad=explode('*',$pat["description"]);
      //echo $pat["description"];

      $len=count($datad)-1;
      if($len!=0){
        $len1=$len/3;
        echo "<div style=\"display: inline-block;width:33%;\" class=\"borde\">";
        for($i=0;$i<$len1;$i++){
          echo "&nbsp;&nbsp;".$datad[$i]."<br>";
        }
        echo "</div>";
        echo "<div style=\"display: inline-block;width:33%;\" class=\"borde\">";
        for ($i=$i; $i < $len1*2; $i++) {
          echo "&nbsp;&nbsp;".$datad[$i]."<br>";
        }
        echo "</div>";
        echo "<div style=\"display: inline-block;width:33%;\" class=\"borde\">";
        for ($i=$i; $i < $len; $i++) {
          echo "&nbsp;&nbsp;".$datad[$i]."<br>";
        }
        echo "</div>";
      }else{
        echo $pat["description"];
      }
    }
    ?>
    <br>
    <div class="left">
      <div class="">
        HISTORIA DE LA PATOLOGIA ACTUAL Y REMISION
      </div>
    </div>
    <br>
    <br>
    <div class="">
      <div class="">
        <?php
        $name="Diagnostico Presuntivo:";
        if(isset($pat) && $pat["diagnosis"]){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["diagnosis"];

          echo $name;
        }else{
          echo $name."........................................................................................................................................";
        }
        ?>
      </div>
      <div class="">
        <?php
        $name="Remision:";
        if(isset($pat['remission']['clinicalspecialty']) && $pat['remission']['clinicalspecialty']){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['remission']['clinicalspecialty'];
          echo $name;
        }else{
          echo $name."..............................................................................................................................................................";
        }
        ?>
      </div>
      <div class="">
        <?php
        $name="Estudiante Designado:";
        if(isset($pat['remission']['studentid']) && is_numeric($pat['remission']['studentid'])){
          $stinfo=DBUserInfo($pat['remission']['studentid']);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Univ. ".$stinfo['userfullname'];
          echo $name;
        }else{
          echo $name."....................................................................................................................";
        }
        ?>
      </div>
      <!--<div class="">

        <?php
        //$name="Examinado Por:";
        //if(isset($pat['studentid']) && $pat["studentid"]){
        //  $u=DBUserInfo($pat['studentid']);
        //  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$u['userfullname'];
        //  echo $name;
        //}else{
        //  echo $name.".....................................................................................................................................................";
        //}
        ?>
      </div>-->
      <div class="">
        <?php
        $name="Responsable Clinica Admision:";

        if(isset($pat["responsibleid"]) && $pat["responsibleid"]){
          $uf=DBUserInfo($pat["responsibleid"]);
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dr.(a) ".$uf["userfullname"];

          echo $name;
        }else{
          echo $name."...........................................................................................................................";
        }
        ?>
      </div>

    </div>














    <br>
    <div class="">
      Los datos proporcionados por el <u>paciente</u> son confiables y se compromete a cumplir las normas de la
      Carrera de Odontologia.
    </div>
<!-- por lo que firma en constancia-->
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
  $type=true;
$dompdf->stream("archivo_.pdf",array("Attachment"=>$type));


?>
