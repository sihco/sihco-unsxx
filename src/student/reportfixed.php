<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBFixedInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=2&&$pat["clinicalid"]!=10)
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
        <font SIZE=4><b>FICHA CLINICA DE PROSTODONCIA FIJA II</b></font>
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
          $name="Curso:";
          if(isset($pat['fixedgrade']) && $pat["fixedgrade"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['fixedgrade'];
              echo $name;
          }else{
            echo $name."..............................";
          }
          ?>
        </div>
        <div align="left" class="gestion">
          <?php
          $name="Gestión:";
          if(isset($pat['fixedyear']) && $pat["fixedyear"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['fixedyear'];
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
            echo $name.".........................................................................";
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
            echo $name."...............................";
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
            echo $name."..........................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <style media="screen">
          .w50{
            float: left;
            display: inline-block;
            width: 48%;
          }
        </style>
        <div class="w50" align="left">
          <?php
          $name="Procedencia:";
          if(isset($pat['patientprovenance']) && $pat["patientprovenance"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientprovenance'];
              echo $name;
          }else{
            echo $name."................................................................";
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
            echo $name."................................................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Domicilio:";
          if(isset($pat['patientdirection']) && $pat["patientdirection"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientdirection'];
              echo $name;
          }else{
            echo $name."...................................................................";
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
            echo $name."...........................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <div class="" align="left">
        <?php
        $name="Diagnóstico:";
        if(isset($pat["fixeddiagnosis"]) && $pat["fixeddiagnosis"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["fixeddiagnosis"];
          echo $name;
        }else{
          echo $name.".....................................................................................................................................................<br>";
          echo ".........................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Etiología:";
        if(isset($pat["fixedetiology"]) && $pat["fixedetiology"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["fixedetiology"];
          echo $name;
        }else{
          echo $name.".........................................................................................................................................................<br>";

        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Pronóstico:";
        if(isset($pat["fixedforecast"]) && $pat["fixedforecast"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["fixedforecast"];
          echo $name;
        }else{
          echo $name.".......................................................................................................................................................<br>";

        }
        ?>
      </div>
      <br>
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
            PLAN DE TRATAMIENTO
          </div>
          <br>

        </div>
        <div class="option">
          <?php if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){ ?>
          <div class="" align="left">
            <?php
            $name="Puente Ant:";
            if(isset($pat["tratamiento1"]) && $pat["tratamiento1"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Póntico:";
            if(isset($pat["tratamiento2"]) && $pat["tratamiento2"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."...................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Puente Post:";
            if(isset($pat["tratamiento3"]) && $pat["tratamiento3"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."......................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Póntico:";
            if(isset($pat["tratamiento4"]) && $pat["tratamiento4"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".....................................................";
            }
            ?>
          </div>
          <?php
          }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
          ?>
          <div class="" align="left">
            <?php
            $name="Corona Metálica:";
            if(isset($pat["tratamiento1"]) && $pat["tratamiento1"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Veneer:";
            if(isset($pat["tratamiento2"]) && $pat["tratamiento2"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."...................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Pivot:";
            if(isset($pat["tratamiento3"]) && $pat["tratamiento3"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."......................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Jacket:";
            if(isset($pat["tratamiento4"]) && $pat["tratamiento4"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".....................................................";
            }
            ?>
          </div>

          <?php
        }else{
          ?>
          <div class="" align="left">
            <?php
            $name="Corona Metálica:";
            if(isset($pat["tratamiento1"]) && $pat["tratamiento1"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Veneer:";
            if(isset($pat["tratamiento2"]) && $pat["tratamiento2"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."...................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Pivot:";
            if(isset($pat["tratamiento3"]) && $pat["tratamiento3"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name."......................................................";
            }
            ?>
          </div>
          <div class="" align="left">
            <?php
            $name="Corona Jacket:";
            if(isset($pat["tratamiento4"]) && $pat["tratamiento4"]=='t'){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Si";
              echo $name;
            }else{
              echo $name.".....................................................";
            }
            ?>
          </div>
          <?php
          }
          ?>
        </div>
      </div>

      <div class="">
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
          <div class="w50" align="left">
            <?php
            $name="Autorizado Dr. (a):";
            if(isset($pat["teacher"]) && $pat["teacher"]){
              $tea=DBUserInfo($pat['teacher']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tea["userfullname"];
              echo $name;
            }else{
              echo $name."....................................................";
            }
            ?>
          </div>
      </div>

      <div style=" clear: both;"></div>
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
        <table width="100%" border=1>
          <tr align="center">
            <td width="10%">
              FECHA
            </td>
            <td width="22%">
              PROCEDIMIENTO
            </td>
            <td width="10%">
              Vo. Bo. DOCENTE
            </td>
            <td width="13%">
              MATERIALES
            </td>
            <td width="10%">
              DESPACHADO
            </td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['radfecha'])&&$pat['radfecha']){
                $name=$pat['radfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Radiografía
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['radvobo'])&&$pat['radvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['radmaterial'])&&$pat['radmaterial']!='f'){
                $name=$pat['radmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['prefecha'])&&$pat['prefecha']){
                $name=$pat['prefecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Preparación Dentaria
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['prevobo'])&&$pat['prevobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['prematerial'])&&$pat['prematerial']!='f'){
                $name=$pat['prematerial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['impfecha'])&&$pat['impfecha']){
                $name=$pat['impfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Impresión
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['impvobo'])&&$pat['impvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['impmaterial'])&&$pat['impmaterial']!='f'){
                $name=$pat['impmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['modfecha'])&&$pat['modfecha']){
                $name=$pat['modfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Modelo de trabajo y Antagonista
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['modvobo'])&&$pat['modvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['modmaterial'])&&$pat['modmaterial']!='f'){
                $name=$pat['modmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['tomfecha'])&&$pat['tomfecha']){
                $name=$pat['tomfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Toma de mordida
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['tomvobo'])&&$pat['tomvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['tommaterial'])&&$pat['tommaterial']!='f'){
                $name=$pat['tommaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['monfecha'])&&$pat['monfecha']){
                $name=$pat['monfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Montaje de modelo en Oclusor
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['monvobo'])&&$pat['monvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['monmaterial'])&&$pat['monmaterial']!='f'){
                $name=$pat['monmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['corfecha'])&&$pat['corfecha']){
                $name=$pat['corfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                echo "Puente Provisional";
              }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
                echo "Coronas Provisionales";
              }else{
                echo "Coronas Provisionales";
              }
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['corvobo'])&&$pat['corvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['cormaterial'])&&$pat['cormaterial']!='f'){
                $name=$pat['cormaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['talfecha'])&&$pat['talfecha']){
                $name=$pat['talfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                echo "Tallado patrón de cera";
              }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
                echo "Tallado patrón de cera de la corona";
              }else{
                echo "Tallado patrón de cera de la corona";
              }
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['talvobo'])&&$pat['talvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['talmaterial'])&&$pat['talmaterial']!='f'){
                $name=$pat['talmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['profecha'])&&$pat['profecha']){
                $name=$pat['profecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                echo "Procesador del puente";
              }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
                echo "Procesado de la corona";
              }else{
                echo "Procesado de la corona";
              }
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['provobo'])&&$pat['provobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['promaterial'])&&$pat['promaterial']!='f'){
                $name=$pat['promaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['prufecha'])&&$pat['prufecha']){
                $name=$pat['prufecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              Prueba en boca
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['pruvobo'])&&$pat['pruvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['prumaterial'])&&$pat['prumaterial']!='f'){
                $name=$pat['prumaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <?php
              $name="";
              if(isset($pat['cemfecha'])&&$pat['cemfecha']){
                $name=$pat['cemfecha'];
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
                echo "Cementado del puente protético";
              }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
                echo "Cementado de la corona";
              }else{
                echo "Cementado de la corona";
              }
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['cemvobo'])&&$pat['cemvobo']=='t'){
                $name='Si';
              }
              echo $name;
              ?>
            </td>
            <td>
              <?php
              $name="";
              if(isset($pat['cemmaterial'])&&$pat['cemmaterial']!='f'){
                $name=$pat['cemmaterial'];
              }
              echo $name;
              ?>
            </td>
            <td></td>
          </tr>
        </table>
      </div>
      <!--fin de table-->



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
        width: 3.3%;
      }
      .piezacaja{
        /*background-color: #ff0000;*/
        display: inline-block;
        padding-left: 10px;
        /*position: relative;
        width: 35px;
        height: 7%;
        width: 3.3%;*/
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
    <div style="clear:both;"></div>
    <?php
    $a= array();
    $a['diente18-a']='';$a['diente17-a']='';$a['diente16-a']='';$a['diente15-a']='';$a['diente14-a']='';$a['diente13-a']='';$a['diente12-a']='';$a['diente11-a']='';
    $a['diente21-a']='';$a['diente22-a']='';$a['diente23-a']='';$a['diente24-a']='';$a['diente25-a']='';$a['diente26-a']='';$a['diente27-a']='';$a['diente28-a']='';

    $a['diente41b-a']='';$a['diente42b-a']='';$a['diente43b-a']='';$a['diente44b-a']='';$a['diente45b-a']='';$a['diente46b-a']='';$a['diente47b-a']='';$a['diente48b-a']='';
    $a['diente31b-a']='';$a['diente32b-a']='';$a['diente33b-a']='';$a['diente34b-a']='';$a['diente35b-a']='';$a['diente36b-a']='';$a['diente37b-a']='';$a['diente38b-a']='';


    //echo $pat['periodonticsiigram'];
    //echo $pat['periodonticsiioleary'];
    if(isset($pat['fixedodontogram'])&&$pat['fixedodontogram']!=''){
      //echo $pat['fixedodontogram'];

      $gramdata=explode(']', $pat['fixedodontogram']);
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
              echo "  <span><font size=\"2\">".$i.$j."</font></span>";
              $dir2=$dir1."tabla1/";
          }
          else{
            echo "  <span><font size=\"2\">".$i.(($j-9)*(-1))."</font></span>";
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

    if(isset($pat['clinicalid'])&&$pat['clinicalid']==10){
      echo "<div class=\"piezacaja\"><font size=\"1\">Representación gráfica de los trabajos realizados:<br>".
      "Retenedores: Azul<br>".
      "Póntico: Amarilla<br>".
      "Conectores: Rojo<br>".
      "</font></div>";
    }elseif(isset($pat['clinicalid'])&&$pat['clinicalid']==2){
      echo "<div class=\"piezacaja\"><font size=\"1\">Representación gráfica de los trabajos realizados:<br>".
      "Corona Pivot: Perno Azul - Corona amarillo<br>".
      "Corona Jacket: Amarilla<br>".
      "Corona Veneer: Metal azul - Acrilico amarillo<br>".
      "Corona Metalica: </font></div>";
    }else{
      echo "<div class=\"piezacaja\"><font size=\"1\">Representación gráfica de los trabajos realizados:<br>".
      "Corona Pivot: Perno Azul - Corona amarillo<br>".
      "Corona Jacket: Amarilla<br>".
      "Corona Veneer: Metal azul - Acrilico amarillo<br>".
      "Corona Metalica: </font></div>";
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
            echo "  <span><font size=\"2\">".$i.$j."</font></span>";
          }else{
            echo "  <span><font size=\"2\">".$i.(($j-9)*(-1))."</font></span>";
          }

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    ?>

    <div style="clear:both;"></div>
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
        $len=count($datad);
        if($len!=0){
          for($i=0;$i<$len;$i++){
            echo "&nbsp;&nbsp;".$datad[$i]."<br>";
          }
        }else{
          echo ".........................................................................................................................................................................<br>";
        }
      }else{
        echo ".........................................................................................................................................................................<br>";
      }
      ?>
    </div>
    <div style="page-break-before: always;"></div>
    <style media="screen">
      .table-new {
         border: 1px solid #000;
         border-collapse: collapse;
      }
      .td-new {
         border: 1px solid #000;
         padding: 0.1em;
      }
    </style>
    <div class="">

      <table class="table-new" width="100%">
        <tr>
          <td class="td-new" align="center" width="40%">OBSERVACIONES</td>
          <td colspan="4" align="center" class="td-new">CAJA</td>
        </tr>
        <tr>
          <td class="td-new" align="center"></td>
          <td class="td-new" align="center">Recibo N.</td>
          <td class="td-new" align="center">Abonos</td>
          <td class="td-new" align="center">Fecha</td>
          <td class="td-new" align="center">Firma</td>
        </tr>
        <tr>
          <td class="td-new">
            <br><br><br><br><br><br><br><br><br><br><br><br>
          </td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
        </tr>
      </table>
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
