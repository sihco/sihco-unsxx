<?php
ob_start();
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');

if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  if(($pat=DBPatientRemissionSurgeryiiInfo($id))==null){
    ForceLoad("surgeryii.php");
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

.row{
  width: 100%;
  height: auto;
}
.col-1{
  width: 7.825%;
  height: auto;
  display: inline-block;
}
.col-2{
  width: 16.2%;
  height: auto;
  display: inline-block;
}
.col-3{
  width: 24.58%;
  height: auto;
  display: inline-block;
}
.col-4{
  width: 32.96%;
  height: auto;
  display: inline-block;
}
.col-5{
  width: 41.34%;
  height: auto;
  display: inline-block;
}
.col-6{
  width: 49.7%;
  height: auto;
  display: inline-block;
}
.col-7{
  width: 58.1%;
  height: auto;
  display: inline-block;
}
.col-8{
  width: 66.48%;
  height: auto;
  display: inline-block;
}
.col-9{
  width: 74.8%;
  height: auto;
  display: inline-block;
}
.col-10{
  width: 83.2%;
  height: auto;
  display: inline-block;
}
.col-11{
  width: 91.6%;
  height: auto;
  display: inline-block;
}
.col-12{
  width: 100%;
  height: auto;
  display: inline-block;
}
.table-info{
  background-color: #ccf2f5;
}
.text-secondary{
  color: #646B6C;
}

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
    <div class="row">
      <div class="col-6" align="left">
        <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
      </div>
      <div class="col-6" align="right">
        <i>UNIVERSIDAD NACIONAL "SIGLO XX"</i>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12" align="center">
        <b>FICHA CLINICA DE CIRUGIA BUCAL II</b>
      </div>
    </div>
    <div class="row">
      <div class="col-12" align="right">
        N. DE FICHA: <?php
        if(isset($pat) && $pat["surgeryiiid"]!="")
          echo $pat["surgeryiiid"];
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-8">
        <?php
        $name="Nombres y Apellidos:";
        $size=0;
        if(isset($pat) && $pat["patientname"]){
            $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["patientname"]." ".$pat["patientfirstname"]." ".$pat["patientlastname"];
            echo $name;
        }else{
          echo $name."...................................................................................................";
        }
        ?>
      </div>
      <div class="col-4">
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
    </div>
    <div class="row">
      <div class="col-12">
        <ol start="1">
          <li>
            Estado general del paciente:
            <?php
            $msg="";
            if(isset($pat["generalstatus"])&& trim($pat["generalstatus"])!='') $msg .= $pat["generalstatus"];
            else $msg.="...................................................................................................";
            echo ucfirst($msg);
            ?>
          </li>
          <li>
            Antecedentes psicotraumáticos del paciente:
            <?php
            $msg="";
            if(isset($pat["surgeryiidisease"])&& trim($pat["surgeryiidisease"])!='') $msg .= $pat["surgeryiidisease"].'</span>';
            else $msg.="...................................................................................................";
            echo ucfirst($msg);
            ?>
          </li>
        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <b>I. EXAMEN CLINICO</b>
      </div>
      <div class="col-12">
        <b>EXTRAORAL</b>
      </div>
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
              $name.="Saburral";
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
            if($pat["dentalpiso"]=='frenillo')
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
    <br>
    <div class="row">
      <div class="col-12">
        <b>II. EXAMENES COMPLEMENTARIOS</b>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <?php
        $msg="";
        if($pat["exam"] == 'periapical'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX PERIAPICAL</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX PERIAPICAL&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        if($pat["exam"] == 'oclusal'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX OCLUSAL</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX OCLUSAL&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        if($pat["exam"] == 'panoramico'){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>RX PANORAMICO</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])&& $pat['pieza']!='') $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "RX PANORAMICO&nbsp;Pieza:&nbsp;...........&nbsp;";
        $msg.="&nbsp;";
        /*
        if($pat["exam"] == 'otros'&& $pat['pieza']!=''){
          $msg.='<span class="text-secondary">';
          $msg.= "<u>Otros</u>&nbsp;Pieza:";
          if(isset($pat['pieza'])) $msg.= '&nbsp;'.$pat['pieza'].'&nbsp;';
          else $msg.= '&nbsp;...........&nbsp;';
          $msg.='</span>';
        } else $msg.= "Otros&nbsp;Pieza:&nbsp;...........&nbsp;";*/

        echo $msg;
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-12">
        <b>III. DIAGNOSTICO DEFINITIVO</b>
        <br>
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
    </div>
    <hr>
    <div class="row">
      <div class="col-12">
        <b>IV. TRATAMIENTO</b>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <ol type="a">
          <li>
            QUIRURGICO:&nbsp;&nbsp;&nbsp;
            <?php
            if(isset($pat['treatment']['quirurgico'])&& $pat['treatment']['quirurgico']=='true') echo "Si";
            elseif (isset($pat['treatment']['quirurgico'])&& $pat['treatment']['quirurgico']=='false') echo "No";
            else echo 'Si ()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No ()';
            ?>
          </li>
          <li>
            MEDICO FARMACOLOGICO:&nbsp;&nbsp;&nbsp;
            <?php
            if(isset($pat['treatment']['farmacologico'])&& $pat['treatment']['farmacologico']=='true') echo "Si";
            elseif(isset($pat['treatment']['farmacologico'])&& $pat['treatment']['farmacologico']=='false') echo "No";
            else echo 'Si ()&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; No ()';
            ?>
          </li>

        </ol>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <font size="2">
        <table border="1">
          <thead>
             <th scope="col">Tecnica Anestesia</th>
             <th scope="col">Autorizado</th>
             <th scope="col">Despachado</th>
          </thead>
          <tbody>
              <?php
              $msg="";
              if(isset($pat['anestesia']['spix'])&& $pat['anestesia']['spix']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>SPIX</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['spixteacher'])&&$pat['anestesia']['spixteacher']!='*'){
                $data=explode('*', $pat['anestesia']['spixteacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['spixnursing'])&&$pat['anestesia']['spixnursing']!='*'){
                $data=explode('*', $pat['anestesia']['spixnursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';

              if(isset($pat['anestesia']['mentoniana'])&& $pat['anestesia']['mentoniana']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>MENTONIANA</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['mentonianateacher'])&&$pat['anestesia']['mentonianateacher']!='*'){
                $data=explode('*', $pat['anestesia']['mentonianateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['mentoniananursing'])&&$pat['anestesia']['mentoniananursing']!='*'){
                $data=explode('*', $pat['anestesia']['mentoniananursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';

              if(isset($pat['anestesia']['local'])&& $pat['anestesia']['local']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>LOCAL</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['localteacher'])&&$pat['anestesia']['localteacher']!='*'){
                $data=explode('*', $pat['anestesia']['localteacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['localnursing'])&&$pat['anestesia']['localnursing']!='*'){
                $data=explode('*', $pat['anestesia']['localnursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';

              if(isset($pat['anestesia']['infraorbitaria'])&& $pat['anestesia']['infraorbitaria']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>INFRAORBITARIA</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['infraorbitariateacher'])&&$pat['anestesia']['infraorbitariateacher']!='*'){
                $data=explode('*', $pat['anestesia']['infraorbitariateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['infraorbitarianursing'])&&$pat['anestesia']['infraorbitarianursing']!='*'){
                $data=explode('*', $pat['anestesia']['infraorbitarianursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';

              if(isset($pat['anestesia']['tuberositaria'])&& $pat['anestesia']['tuberositaria']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>TUBEROSITARIA</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['tuberositariateacher'])&&$pat['anestesia']['tuberositariateacher']!='*'){
                $data=explode('*', $pat['anestesia']['tuberositariateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['tuberositarianursing'])&&$pat['anestesia']['tuberositarianursing']!='*'){
                $data=explode('*', $pat['anestesia']['tuberositarianursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';

              if(isset($pat['anestesia']['carrea'])&& $pat['anestesia']['carrea']=='true'){
                $msg.='<tr class="table-info text-secondary">';
              }else{
                $msg.='<tr>';
              }
              $msg.='<td>CARREA</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['carreateacher'])&&$pat['anestesia']['carreateacher']!='*'){
                $data=explode('*', $pat['anestesia']['carreateacher']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='<td>';
              if(isset($pat['anestesia']['carreanursing'])&&$pat['anestesia']['carreanursing']!='*'){
                $data=explode('*', $pat['anestesia']['carreanursing']);
                $infouser=DBUserInfo($data[0]);
                $time=trim($data[1]);
                $msg.=$infouser['userfullname'].'<br>';
                $msg.=datetimeconv($time);
              }
              $msg.='</td>';
              $msg.='</tr>';


              echo $msg;
              ?>
          </tbody>
        </table>
        </font>
      </div>
    </div>


    <!--pagina 2-->
    <div style="page-break-before: always;"></div>

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

      if(isset($pat) && isset($pat['areviewteacher']) && $pat['areviewteacher']!=""){
        $size=count($pat['areviewteacher']);
        $it=DBUserInfo($pat['areviewteacher'][$size-1]['teacher']);
        $name.=ucfirst($pat['areviewteacher'][$size-1]['obsdesc']);
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
    <div class="row">
      <div class="col-6">
        <?php
        $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";

        if(isset($pat) && $pat['teacherid']!=0){
          $teacher=DBUserInfo($pat['teacherid']);
          $name.=$teacher['userfullname'].'<br>Fecha Inicio:&nbsp;&nbsp;&nbsp;&nbsp;';
          if($pat['stdatetime']!=-1){
            $name.=datetimeconv($pat['stdatetime']);
          }
        }else{
          $name.="<br>Fecha Inicio:";
        }
        echo $name;
        ?>
      </div>

      <div class="col-6">
        <?php

        $name="Docente:&nbsp;&nbsp;&nbsp;&nbsp;";

        if(isset($it['userfullname']) && $it['userfullname']!="" && $pat['endatetime']!=-1){
          $name.=$it['userfullname'].'<br>Fecha Conclusión:&nbsp;&nbsp;&nbsp;&nbsp;';
          $name.=datetimeconv($pat['endatetime']);
        }else{
          $name.="<br>Fecha Conclusión:";
        }
        echo $name;
        ?>
      </div>
    </div>
    <br>
    <div class="row">
      <div class="col-6">
        <?php
        $name="";
        if(isset($pat['studentid']) && $pat["studentid"]){
          $sinfo=DBUserInfo($pat['studentid']);
          $name.=$sinfo["userfullname"];

          echo $name;
        }else{
          echo $name;
        }

        ?>
      </div>
      <div class="col-6">
        <?php
        $name="";
        if(isset($sinfo["userci"]) && $sinfo["userci"]){
          $name.=$sinfo["userci"];
          echo $name;
        }else{
          echo $name;
        }
        ?>
      </div>
      <div class="col-12" style="margin-top:-15px;">
        ...............................................................................................................................
      </div>
      <div class="col-6">
        Apellidos y Nombres del Alumno
      </div>
      <div class="col-6">
        C.I.
      </div>
    </div>
<!--PAGINA 1 FIN-->


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
