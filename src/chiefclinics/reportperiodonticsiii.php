<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPeriodonticsiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=14)
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
    <title>Periodonticia III</title>
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
        <b>FICHA CLINICA DE PERIODONCIA III</b>
      </div>
      <br>
      <style media="screen">
      .w100{
        width: 100%;
        display: inline-block;
        float: left;
      }
      .w90{
        width: 90%;
        display: inline-block;
        float: left;
      }
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
        <div align="left" class="w60">
          <?php
          $name="Nombre paciente:";
          if(isset($pat["patientfullname"]) && $pat["patientfullname"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientfullname"];
              echo $name;
          }else{
            echo $name.".....................................................................................................";
          }
          ?>
        </div>
        <div align="left" class="w15">
          <?php
          $name="Edad:";
          if(isset($pat['patientage']) && $pat["patientage"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientage'];
              echo $name;
          }else{
            echo $name.".....................";
          }
          ?>
        </div>
        <div align="left" class="w25">
          <?php
          $name="Sexo:";
          if(isset($pat['patientgender']) && $pat["patientgender"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat['patientgender']);
              echo $name;
          }else{
            echo $name."......................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Procedencia:";
          if(isset($pat['patientprovenance']) && $pat["patientprovenance"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientprovenance'];
              echo $name;
          }else{
            echo $name.".....................................................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="Residente en:";
          if(isset($pat['patientresident']) && $pat["patientresident"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientresident'];
              echo $name;
          }else{
            echo $name."................................................................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Calle:";
          if(isset($pat['patientstreet']) && $pat["patientstreet"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientstreet'];
              echo $name;
          }else{
            echo $name."................................................................................................";
          }
          ?>
        </div>
        <div class="w50" align="left">
          <?php
          $name="Número de Celular:";
          if(isset($pat['patientphone']) && $pat["patientphone"]){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['patientphone'];
              echo $name;
          }else{
            echo $name."......................................................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w50" align="left">
          <?php
          $name="Estudiante Operador:";
          if(isset($pat) && $pat["student"]){
              $student=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$student['userfullname'];
              echo $name;
          }else{
            echo $name.".......................................................................";
          }
          ?>
        </div>
        <div class="">
          <div class="w50" align="left">
            <?php
            $name="Fecha de Inicio:";
            if(isset($pat["startdatetime"]) && $pat["startdatetime"]!=-1){
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".datetimeconv($pat["startdatetime"]);
              echo $name;
            }else{
              echo $name."............................................................................";
            }
            ?>
          </div>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="w25" align="left">
          <?php
          $name="Rotación:";
          if(isset($pat['periodonticsiirotation']) && $pat["periodonticsiirotation"]){
              $name.="&nbsp;&nbsp;&nbsp;".$pat['periodonticsiirotation'];
              echo $name;
          }else{
            echo $name."...................................";
          }
          ?>
        </div>
        <div class="w25" align="left">
          <?php
          $name="Curso:&nbsp;&nbsp;&nbsp;5to Año";
          echo $name;
          ?>
        </div>
        <div class="w25" align="left">
          <?php
          $name="Gestión:&nbsp;&nbsp;&nbsp;";
          if(isset($pat['startdatetime'])&&$pat['startdatetime']!=-1){
            $name.=date('Y', $pat["startdatetime"]);
          }else{
            $name.=".......................";
          }

          echo $name;
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <br>
      <div class="">
        <div class="w100" align="left">
          <?php
          $name="Motivo de Consulta:";
          if(isset($pat["periodonticsiimotconsult"]) && $pat["periodonticsiimotconsult"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodonticsiimotconsult"];
            echo $name;
          }else{
            echo $name."..................................................................................................................................................................................";
          }
          ?>
        </div>
      </div>
      <div style=" clear: both;"></div>
      <br>

      <style media="screen">
        .px-5{
          padding-left: 25px;
          padding-right: 25px;
        }
        .border{
          border: 2px solid #d0d0d0;
        }
      </style>
      <div class="px-5">
        <div class="border">
          <table border="0" width="100%">
            <tr>
              <td><b>¿Ha sufrido o sufre de las siguientes alteraciones o enfermedades?</b></td>
              <td><b>Especificar</b></td>
            </tr>
          </table>
          <br>
          <table border=0 width="100%">
            <tr>
              <td width="70%" align="left">1)Enfermedades del aparato respiratorio</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question1"]) && $pat["question1"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question1"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion1"]) && $pat["obsquestion1"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion1"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">2) Enfermedades del corazón</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question2"]) && $pat["question2"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question2"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion2"]) && $pat["obsquestion2"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion2"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">3) Enfermedades del aparato digestivo</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question3"]) && $pat["question3"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question3"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion3"]) && $pat["obsquestion3"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion3"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">4) Enfermedades del aparato genito urinario</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question4"]) && $pat["question4"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question4"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion4"]) && $pat["obsquestion4"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion4"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">5) Diabetes</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question5"]) && $pat["question5"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question5"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion5"]) && $pat["obsquestion5"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion5"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">6) Hemorragias</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question6"]) && $pat["question6"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question6"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion6"]) && $pat["obsquestion6"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion6"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">7) Enfermedades alérgicas</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question7"]) && $pat["question7"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question7"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion7"]) && $pat["obsquestion7"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion7"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">8) Hepatitis</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question8"]) && $pat["question8"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question8"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion8"]) && $pat["obsquestion8"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion8"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">9) Enfermedades de sistema nervioso</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question9"]) && $pat["question9"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question9"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion9"]) && $pat["obsquestion9"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion9"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">10) Enfermedades psiquiatricas (excitamiento nervioso, etc.)</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question10"]) && $pat["question10"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question10"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion10"]) && $pat["obsquestion10"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion10"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">11) Accidentes en el curso de la anestesia</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question11"]) && $pat["question11"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question11"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion11"]) && $pat["obsquestion11"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion11"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">12) Valores de la presión arterial</td>
              <td width="30%" align="left" colspan="2">
                <?php
                $name="";
                if(isset($pat["question12"]) && $pat["question12"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question12"]);
                  echo $name;
                }else{
                  echo $name.".....................................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">13) ¿Que fármacos está tomando?</td>
              <td width="30%" align="left" colspan="2">
                <?php
                $name="";
                if(isset($pat["question13"]) && $pat["question13"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question13"]);
                  echo $name;
                }else{
                  echo $name.".....................................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">14) ¿Esta embarazada?</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question14"]) && $pat["question14"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question14"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion14"]) && $pat["obsquestion14"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion14"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">15) ¿Fuma?</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question15"]) && $pat["question15"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question15"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion15"]) && $pat["obsquestion15"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion15"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">16) ¿Toma alcohol?</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question16"]) && $pat["question16"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question16"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion16"]) && $pat["obsquestion16"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion16"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">17) ¿Consume drogas?</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question17"]) && $pat["question17"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question17"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion17"]) && $pat["obsquestion17"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion17"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">18) Hábitos de alimentación</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question18"]) && $pat["question18"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question18"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion18"]) && $pat["obsquestion18"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion18"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="70%" align="left">19) Higiene bucal</td>
              <td width="10%" align="left">
                <?php
                $name="";
                if(isset($pat["question19"]) && $pat["question19"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".ucfirst($pat["question19"]);
                  echo $name;
                }else{
                  echo $name."No&nbsp;&nbsp;&nbsp;Si";
                }
                ?>
              </td>
              <td width="20%" align="left">
                <?php
                $name="";
                if(isset($pat["obsquestion19"]) && $pat["obsquestion19"]){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["obsquestion19"];
                  echo $name;
                }else{
                  echo ".................................";
                }
                ?>
              </td>
            </tr>
          </table>
        </div>
      </div>
      <br>
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
      <div class="" align="left">
        <?php
        $name="Diagnóstico:";
        if(isset($pat["periodonticsiidiagnosis"]) && $pat["periodonticsiidiagnosis"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodonticsiidiagnosis"];
          echo $name;
        }else{
          echo $name."..............................................................................................................................................................................................<br>";
          echo "..................................................................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Tratamiento:";
        if(isset($pat["periodonticsiitreatment"]) && $pat["periodonticsiitreatment"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat["periodonticsiitreatment"]);
          echo $name;
        }else{
          echo $name."..............................................................................................................................................................................................<br>";
          echo "..................................................................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <div class="" align="left">
        <?php
        $name="Medicamentos Prescritos:";
        if(isset($pat["periodonticsiimedicine"]) && $pat["periodonticsiimedicine"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodonticsiimedicine"];
          echo $name;
        }else{
          echo $name."............................................................................................................................................................................<br>";
          echo "..................................................................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <style media="screen">
        .tablet{
          margin-left: 10%;
          width: 80%;
          /*background-color: #ff0000;*/
        }
      </style>
      <br>
      <div class="">
        <!--TABLE CONTROL INICIO-->
        <?php if(isset($pat['periodonticsiitreatment'])&&$pat['periodonticsiitreatment']=='despigmentacion'){?>
        <div class="tablet">
          <table width="100%" border=1>
            <tr>
              <td width="50%">
                Inicio de sesión
                <br>
                <br>
                <?php
                $name="Fecha:";
                if(isset($pat["session2date0"]) && $pat["session2date0"]!=''){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session2date0'];
                  echo $name;
                }else{
                  echo $name;
                }
                if(isset($pat["session2evalued0"]) && $pat["session2evalued0"]=='correcto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                }
                if(isset($pat["session2evalued0"]) && $pat["session2evalued0"]=='incorrecto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                }
                ?>

              </td>
              <td width="50%">
                1.- Control
                <br>
                <br>
                <?php
                $name="Fecha:";
                if(isset($pat["session2date1"]) && $pat["session2date1"]!=''){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session2date1'];
                  echo $name;
                }else{
                  echo $name;
                }
                if(isset($pat["session2evalued1"]) && $pat["session2evalued1"]=='correcto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                }
                if(isset($pat["session2evalued1"]) && $pat["session2evalued1"]=='incorrecto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                }
                ?>
              </td>
            </tr>
            <tr>
              <td width="50%">
                2.- Control
                <br>
                <br>
                <?php
                $name="Fecha:";
                if(isset($pat["session2date2"]) && $pat["session2date2"]!=''){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session2date2'];
                  echo $name;
                }else{
                  echo $name;
                }
                if(isset($pat["session2evalued2"]) && $pat["session2evalued2"]=='correcto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                }
                if(isset($pat["session2evalued2"]) && $pat["session2evalued2"]=='incorrecto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                }
                ?>
              </td>
              <td width="50%">
                3.- Control
                <br>
                <br>
                <?php
                $name="Fecha:";
                if(isset($pat["session2date3"]) && $pat["session2date3"]!=''){
                  $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session2date3'];
                  echo $name;
                }else{
                  echo $name;
                }
                if(isset($pat["session2evalued3"]) && $pat["session2evalued3"]=='correcto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                }
                if(isset($pat["session2evalued3"]) && $pat["session2evalued3"]=='incorrecto'){
                  echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                }
                ?>
              </td>

            </tr>
          </table>
        <?php }else{ ?>
          <!--INICIO DE TABLE SESSION-->
          <div class="tablet">
            <table width="100%" border=1>
              <tr>
                <td width="50%">
                  Inicio de sesión
                  <br>
                  <br>
                  <?php
                  $name="Fecha:";
                  if(isset($pat["session1date0"]) && $pat["session1date0"]!=''){
                    $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session1date0'];
                    echo $name;
                  }else{
                    echo $name;
                  }
                  if(isset($pat["session1evalued0"]) && $pat["session1evalued0"]=='correcto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                  }
                  if(isset($pat["session1evalued0"]) && $pat["session1evalued0"]=='incorrecto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                  }
                  ?>

                </td>
                <td width="50%">
                  1.- Control
                  <br>
                  <br>
                  <?php
                  $name="Fecha:";
                  if(isset($pat["session1date1"]) && $pat["session1date1"]!=''){
                    $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session1date1'];
                    echo $name;
                  }else{
                    echo $name;
                  }
                  if(isset($pat["session1evalued1"]) && $pat["session1evalued1"]=='correcto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                  }
                  if(isset($pat["session1evalued1"]) && $pat["session1evalued1"]=='incorrecto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                  }
                  ?>
                </td>
              </tr>
              <tr>
                <td width="50%">
                  2.- Control
                  <br>
                  <br>
                  <?php
                  $name="Fecha:";
                  if(isset($pat["session1date2"]) && $pat["session1date2"]!=''){
                    $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session1date2'];
                    echo $name;
                  }else{
                    echo $name;
                  }
                  if(isset($pat["session1evalued2"]) && $pat["session1evalued2"]=='correcto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                  }
                  if(isset($pat["session1evalued2"]) && $pat["session1evalued2"]=='incorrecto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                  }
                  ?>
                </td>
                <td width="50%">
                  3.- Control
                  <br>
                  <br>
                  <?php
                  $name="Fecha:";
                  if(isset($pat["session1date3"]) && $pat["session1date3"]!=''){
                    $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat['session1date3'];
                    echo $name;
                  }else{
                    echo $name;
                  }
                  if(isset($pat["session1evalued3"]) && $pat["session1evalued3"]=='correcto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("list.png",'../images/')."\" alt=\"\">";
                  }
                  if(isset($pat["session1evalued3"]) && $pat["session1evalued3"]=='incorrecto'){
                    echo "  <img class=\"pdiente\" src=\"".getPieza("fail.png",'../images/')."\" alt=\"\">";
                  }
                  ?>
                </td>

              </tr>
            </table>
          <!--FIN DE TABLE SESSION-->
        <?php } ?>
        </div>

      </div>

    </div>
    <br><br><br>
    <div class="" align="left">
      <?php
      $name="Fecha de Conclusión:&nbsp;&nbsp;&nbsp;&nbsp;";
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
          echo "..................................................................................................................................................................................................................<br>";
          echo "..................................................................................................................................................................................................................<br>";
        }
      }else{
        echo "..................................................................................................................................................................................................................<br>";
        echo "..................................................................................................................................................................................................................<br>";
      }
      ?>
    </div>

    <!--PAGINA 1 FIN-->

    <!--PAGINA 2 INICIO-->
    <div style="page-break-before: always;"></div>



    <!--PAGINA 2 FIN-->
    <div align="center">
      <b>LISTA DE INSUMOS Y CONTROL DE CLINICA PERIODONCIA III</b>
    </div>
    <br>
    <br>
    <br>
    <div class="">
      <table class="table-new" border="1" width="100%">
        <tr>
          <td class="td-new">INSUMOS PERIODONTALES</td>
          <td class="td-new">Vo. Bo. DOCENTE</td>
          <td class="td-new">Vo. Bo. ENFERMERIA</td>
          <td class="td-new">OBSERVACIONES</td>
        </tr>
        <tr>
          <td class="td-new"><br><br><br><br><br><br></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
        </tr>
        <tr>
          <td class="td-new"><br><br><br><br><br><br></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
        </tr>
        <tr>
          <td class="td-new"><br><br><br><br><br><br></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
        </tr>
        <tr>
          <td class="td-new"><br><br><br><br><br><br></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
          <td class="td-new"></td>
        </tr>
      </table>
    </div>
    <br><br>
    <div class="tablet">
      <table class="table-new" width="100%">
        <tr>
          <td width="50%" class="td-new">Inicio de sesión <br>Fecha:....................................................................<br>
            <br><br>..............................................................................<br><br>
          </td>
          <td width="50%" class="td-new">1. Sesión <br>Fecha:....................................................................<br>
            <br><br>..............................................................................<br><br>
          </td>
        </tr>
        <tr>
          <td width="50%" class="td-new">2. Sesión <br>Fecha:....................................................................<br>
            <br><br>..............................................................................<br><br>
          </td>
          <td width="50%" class="td-new">3. Sesión <br>Fecha:....................................................................<br>
            <br><br>..............................................................................<br><br>
          </td>
        </tr>
      </table>
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
