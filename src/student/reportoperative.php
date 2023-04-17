<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBOperativeInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=3&&$pat["clinicalid"]!=11)
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
        if(isset($pat["clinicalid"])&&$pat["clinicalid"]==11){
          echo "<font SIZE=4><b>FICHA CLINICA DE OPERATORIA DENTAL III</b></font>";
        }elseif (isset($pat["clinicalid"])&&$pat["clinicalid"]==3) {
          echo "<font SIZE=4><b>FICHA CLINICA DE OPERATORIA DENTAL II</b></font>";
        }else{
          echo "<font SIZE=4><b>FICHA CLINICA DE OPERATORIA DENTAL</b></font>";
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
            echo $name."..............................................................................";
          }
          ?>
        </div>
        <div align="left" class="curso">
          <?php
          $name="Curso:";
          if(isset($pat['operativegrade']) && $pat["operativegrade"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['operativegrade'];
              echo $name;
          }else{
            echo $name."....................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="Gestión:";
          if(isset($pat['operativeyear']) && $pat["operativeyear"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['operativeyear'];
              echo $name;
          }else{
            echo $name."....................";
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
            echo $name."..............................................................................";
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
            echo $name."....................";
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
            echo $name."....................";
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
          $name="Domicilio:";
          if(isset($pat['patientdirection']) && $pat["patientdirection"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientdirection'];
              echo $name;
          }else{
            echo $name.".........................................................";
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
            echo $name.".........................................................";
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
            $name="Obturación de amalgama:";
            if(isset($pat["trabajo1"]) && $pat["trabajo1"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."......................";
            }
            ?>
          </div>
          <div class="" align="left">

            <?php
            $name="Obturación de resina:";
            if(isset($pat["trabajo2"]) && $pat["trabajo2"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".............................";
            }
            ?>
          </div>
          <div class="" align="left">

            <?php
            $name="Incrustaciones:";
            if(isset($pat["trabajo3"]) && $pat["trabajo3"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".......................................";
            }
            ?>
          </div>
        </div>
      </div>

      <div class="">

          <div class="w50" align="left">
            <?php
            $name="Autorizado por el Dr. (a):";
            if(isset($pat["teacher"]) && $pat["teacher"]){
              $tea=DBUserInfo($pat['teacher']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tea["userfullname"];
              echo $name;
            }else{
              echo $name.".............................................";
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
              echo $name."................................................";
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
              <th>Pieza</th>
              <th>Clase</th>
              <th>Caries</th>
              <th>Fecha de Inicio</th>
              <th>Vo.Bo. Preparación</th>
              <th>Vo.Bo. base cavitaria</th>
              <th>Obturación</th>
              <th>Pulido</th>
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
                $content.="<td>".$pat['tableprocedures']['caries'][$i]."</td>";
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
              $content.="<td width=\"10%\"><br><br></td><td width=\"10%\"></td><td width=\"20%\"></td><td width=\"10%\"></td><td width=\"10%\"></td><td width=\"10%\"></td><td width=\"20%\"></td><td width=\"10%\"></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
              $content.="</tr>";
              $content.="<tr>";
              $content.="<td><br><br></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
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
            $name.=".........................................................................................................";
          }
          echo $name;
          ?>
        </div>
        <div class="">
          <div class="w50" align="left">
            <?php
            $name="Fecha: ";
            if(isset($pat['treatmentdate'])&&$pat['treatmentdate']){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat['treatmentdate']);
            }else{
              $name.="..............................................................";
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
              $name.=".................................";
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
      <b>ODONTOGRAMA INICIAL</b>
    </div>
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
        width: 10px;
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
      .piezap{
        display: inline-block;
        position: relative;
        width: 35px;
      }
      .pdiente{
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
      .number2{
        margin-left: 10px;
        margin-top: 60px;
        clear:float;
        float: left;
      }
    </style>
    <br>
    <div style="clear:both;"></div>
    <?php
    $a= array();
    $a['st18']='t';$a['sl18']='l';$a['sb18']='b';$a['sr18']='r';$a['sc18']='c';
    $a['st17']='t';$a['sl17']='l';$a['sb17']='b';$a['sr17']='r';$a['sc17']='c';
    $a['st16']='t';$a['sl16']='l';$a['sb16']='b';$a['sr16']='r';$a['sc16']='c';
    $a['st15']='t';$a['sl15']='l';$a['sb15']='b';$a['sr15']='r';$a['sc15']='c';
    $a['st14']='t';$a['sl14']='l';$a['sb14']='b';$a['sr14']='r';$a['sc14']='c';
    $a['st13']='t';$a['sl13']='l';$a['sb13']='b';$a['sr13']='r';$a['sc13']='c';
    $a['st12']='t';$a['sl12']='l';$a['sb12']='b';$a['sr12']='r';$a['sc12']='c';
    $a['st11']='t';$a['sl11']='l';$a['sb11']='b';$a['sr11']='r';$a['sc11']='c';

    $a['st21']='t';$a['sl21']='l';$a['sb21']='b';$a['sr21']='r';$a['sc21']='c';
    $a['st22']='t';$a['sl22']='l';$a['sb22']='b';$a['sr22']='r';$a['sc22']='c';
    $a['st23']='t';$a['sl23']='l';$a['sb23']='b';$a['sr23']='r';$a['sc23']='c';
    $a['st24']='t';$a['sl24']='l';$a['sb24']='b';$a['sr24']='r';$a['sc24']='c';
    $a['st25']='t';$a['sl25']='l';$a['sb25']='b';$a['sr25']='r';$a['sc25']='c';
    $a['st26']='t';$a['sl26']='l';$a['sb26']='b';$a['sr26']='r';$a['sc26']='c';
    $a['st27']='t';$a['sl27']='l';$a['sb27']='b';$a['sr27']='r';$a['sc27']='c';
    $a['st28']='t';$a['sl28']='l';$a['sb28']='b';$a['sr28']='r';$a['sc28']='c';

    $a['st48']='t';$a['sl48']='l';$a['sb48']='b';$a['sr48']='r';$a['sc48']='c';
    $a['st47']='t';$a['sl47']='l';$a['sb47']='b';$a['sr47']='r';$a['sc47']='c';
    $a['st46']='t';$a['sl46']='l';$a['sb46']='b';$a['sr46']='r';$a['sc46']='c';
    $a['st45']='t';$a['sl45']='l';$a['sb45']='b';$a['sr45']='r';$a['sc45']='c';
    $a['st44']='t';$a['sl44']='l';$a['sb44']='b';$a['sr44']='r';$a['sc44']='c';
    $a['st43']='t';$a['sl43']='l';$a['sb43']='b';$a['sr43']='r';$a['sc43']='c';
    $a['st42']='t';$a['sl42']='l';$a['sb42']='b';$a['sr42']='r';$a['sc42']='c';
    $a['st41']='t';$a['sl41']='l';$a['sb41']='b';$a['sr41']='r';$a['sc41']='c';

    $a['st31']='t';$a['sl31']='l';$a['sb31']='b';$a['sr31']='r';$a['sc31']='c';
    $a['st32']='t';$a['sl32']='l';$a['sb32']='b';$a['sr32']='r';$a['sc32']='c';
    $a['st33']='t';$a['sl33']='l';$a['sb33']='b';$a['sr33']='r';$a['sc33']='c';
    $a['st34']='t';$a['sl34']='l';$a['sb34']='b';$a['sr34']='r';$a['sc34']='c';
    $a['st35']='t';$a['sl35']='l';$a['sb35']='b';$a['sr35']='r';$a['sc35']='c';
    $a['st36']='t';$a['sl36']='l';$a['sb36']='b';$a['sr36']='r';$a['sc36']='c';
    $a['st37']='t';$a['sl37']='l';$a['sb37']='b';$a['sr37']='r';$a['sc37']='c';
    $a['st38']='t';$a['sl38']='l';$a['sb38']='b';$a['sr38']='r';$a['sc38']='c';



    $a['et18']='t';$a['el18']='l';$a['eb18']='b';$a['er18']='r';$a['ec18']='c';
    $a['et17']='t';$a['el17']='l';$a['eb17']='b';$a['er17']='r';$a['ec17']='c';
    $a['et16']='t';$a['el16']='l';$a['eb16']='b';$a['er16']='r';$a['ec16']='c';
    $a['et15']='t';$a['el15']='l';$a['eb15']='b';$a['er15']='r';$a['ec15']='c';
    $a['et14']='t';$a['el14']='l';$a['eb14']='b';$a['er14']='r';$a['ec14']='c';
    $a['et13']='t';$a['el13']='l';$a['eb13']='b';$a['er13']='r';$a['ec13']='c';
    $a['et12']='t';$a['el12']='l';$a['eb12']='b';$a['er12']='r';$a['ec12']='c';
    $a['et11']='t';$a['el11']='l';$a['eb11']='b';$a['er11']='r';$a['ec11']='c';

    $a['et21']='t';$a['el21']='l';$a['eb21']='b';$a['er21']='r';$a['ec21']='c';
    $a['et22']='t';$a['el22']='l';$a['eb22']='b';$a['er22']='r';$a['ec22']='c';
    $a['et23']='t';$a['el23']='l';$a['eb23']='b';$a['er23']='r';$a['ec23']='c';
    $a['et24']='t';$a['el24']='l';$a['eb24']='b';$a['er24']='r';$a['ec24']='c';
    $a['et25']='t';$a['el25']='l';$a['eb25']='b';$a['er25']='r';$a['ec25']='c';
    $a['et26']='t';$a['el26']='l';$a['eb26']='b';$a['er26']='r';$a['ec26']='c';
    $a['et27']='t';$a['el27']='l';$a['eb27']='b';$a['er27']='r';$a['ec27']='c';
    $a['et28']='t';$a['el28']='l';$a['eb28']='b';$a['er28']='r';$a['ec28']='c';

    $a['et48']='t';$a['el48']='l';$a['eb48']='b';$a['er48']='r';$a['ec48']='c';
    $a['et47']='t';$a['el47']='l';$a['eb47']='b';$a['er47']='r';$a['ec47']='c';
    $a['et46']='t';$a['el46']='l';$a['eb46']='b';$a['er46']='r';$a['ec46']='c';
    $a['et45']='t';$a['el45']='l';$a['eb45']='b';$a['er45']='r';$a['ec45']='c';
    $a['et44']='t';$a['el44']='l';$a['eb44']='b';$a['er44']='r';$a['ec44']='c';
    $a['et43']='t';$a['el43']='l';$a['eb43']='b';$a['er43']='r';$a['ec43']='c';
    $a['et42']='t';$a['el42']='l';$a['eb42']='b';$a['er42']='r';$a['ec42']='c';
    $a['et41']='t';$a['el41']='l';$a['eb41']='b';$a['er41']='r';$a['ec41']='c';

    $a['et31']='t';$a['el31']='l';$a['eb31']='b';$a['er31']='r';$a['ec31']='c';
    $a['et32']='t';$a['el32']='l';$a['eb32']='b';$a['er32']='r';$a['ec32']='c';
    $a['et33']='t';$a['el33']='l';$a['eb33']='b';$a['er33']='r';$a['ec33']='c';
    $a['et34']='t';$a['el34']='l';$a['eb34']='b';$a['er34']='r';$a['ec34']='c';
    $a['et35']='t';$a['el35']='l';$a['eb35']='b';$a['er35']='r';$a['ec35']='c';
    $a['et36']='t';$a['el36']='l';$a['eb36']='b';$a['er36']='r';$a['ec36']='c';
    $a['et37']='t';$a['el37']='l';$a['eb37']='b';$a['er37']='r';$a['ec37']='c';
    $a['et38']='t';$a['el38']='l';$a['eb38']='b';$a['er38']='r';$a['ec38']='c';

    if(isset($pat['operativeodontogram'])&&$pat['operativeodontogram']!=''){
      $gramdata=explode(']', $pat['operativeodontogram']);
      $n=count($gramdata);
      for($i=0;$i<$n-1;$i++){
        $data=explode('[',$gramdata[$i]);
        $data=explode('=',$data[1]);

        if(trim($data[1])==''){
          $a[$data[0]]=substr($data[0],1,1);
        }elseif (trim($data[1])=='click-red') {
          $a[$data[0]]=substr($data[0],1,1).'caries';
        }elseif (trim($data[1])=='click-blue') {
          $a[$data[0]]=substr($data[0],1,1).'obturado';
        }elseif (trim($data[1])=='click-yellow') {
          $a[$data[0]]=substr($data[0],1,1).'yellow';//otro
        }elseif (trim($data[1])=='gra') {
          $a[substr($data[0],0,1).substr($data[0],2,2)]='exodonciaindicada';
        }else{
          echo $data[0].' : '.$data[1];
        }
      }

    }

    echo "<div style=\"clear:both;\"></div>";
    //medio para dientes inicio
    for ($i=1; $i <= 2 ; $i++) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezapp\">";
          $jj=$j;
          if($i==1)
            echo "  <span class=\"number\">".$i.$j."</span>";
          else{
            echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }
          //echo "  <img class=\"t\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
          echo "  <img class=\"t\" src=\"".getPieza($a['st'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['sl'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['sc'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['sr'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['sb'.$i.$jj].".png")."\" alt=\"\">";
          if(isset($a['s'.$i.$jj])&&$a['s'.$i.$jj]=='exodonciaindicada')
            echo "  <img class=\"f\" src=\"".getPieza("exodonciaindicada.png")."\" alt=\"\">";

          echo "</div>\n";

      }
      echo "<div class=\"sep\"></div>";
    }

    echo "<div style=\"clear:both;\"></div>";

    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezapp\">";
          $jj=$j;
          if($i!=4)
            $jj=(($j-9)*(-1));

          echo "  <img class=\"t\" src=\"".getPieza($a['st'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['sl'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['sc'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['sr'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['sb'.$i.$jj].".png")."\" alt=\"\">";
          if(isset($a['s'.$i.$jj])&&$a['s'.$i.$jj]=='exodonciaindicada')
            echo "  <img class=\"f\" src=\"".getPieza("exodonciaindicada.png")."\" alt=\"\">";
          echo "  <span class=\"number2\">$i$jj</span>";
          echo "</div>\n";
      }
      echo "<div class=\"sep\"></div>";
    }

    echo "<div style=\"clear:both;\"></div>";
    echo "<br>";
    echo "<div align=\"center\" class=\"\">";
    echo "  <b>ODONTOGRAMA FINAL</b>";
    echo "</div>";
    echo "<br>";
    echo "<div style=\"clear:both;\"></div>";
    //medio para dientes inicio
    for ($i=1; $i <= 2 ; $i++) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezapp\">";
          $jj=$j;
          if($i==1)
            echo "  <span class=\"number\">".$i.$j."</span>";
          else{
            echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }
          //echo "  <img class=\"t\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
          echo "  <img class=\"t\" src=\"".getPieza($a['et'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['el'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['ec'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['er'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['eb'.$i.$jj].".png")."\" alt=\"\">";
          if(isset($a['e'.$i.$jj])&&$a['e'.$i.$jj]=='exodonciaindicada')
            echo "  <img class=\"f\" src=\"".getPieza("exodonciaindicada.png")."\" alt=\"\">";

          echo "</div>\n";

      }
      echo "<div class=\"sep\"></div>";
    }

    echo "<div style=\"clear:both;\"></div>";

    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezapp\">";
          $jj=$j;
          if($i!=4)
            $jj=(($j-9)*(-1));

          echo "  <img class=\"t\" src=\"".getPieza($a['et'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['el'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['ec'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['er'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['eb'.$i.$jj].".png")."\" alt=\"\">";
          if(isset($a['e'.$i.$jj])&&$a['e'.$i.$jj]=='exodonciaindicada')
            echo "  <img class=\"f\" src=\"".getPieza("exodonciaindicada.png")."\" alt=\"\">";
          echo "  <span class=\"number2\">$i$jj</span>";
          echo "</div>\n";
      }
      echo "<div class=\"sep\"></div>";
    }
    echo "<div style=\"clear:both;\"></div>";
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
              if(isset($pat["operativematerial"])&& $pat["operativematerial"]){
                $pat["operativematerial"] = str_replace("\n", "*", $pat["operativematerial"]);
                $datad=explode('*',$pat["operativematerial"]);
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
