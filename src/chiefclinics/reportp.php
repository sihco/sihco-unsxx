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
  if($pat["clinicalid"]!=6)
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
        <div class="">
          <div class="left">
            <?php
            $name="CODIGO ESTUDIANTE:";

            if(isset($pat['student']) && $pat['student']!=''){

                $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat['student'];

                echo $name;
            }else{
              echo $name."...................................................................................................";
            }
            ?>
          </div>
        </div>
        <div style="clear:both;"></div>
        <font SIZE=4><b>FICHA CLINICA DE PERIODONCIA II</b></font>
      </div>

      <div style="clear:both;"></div>

      <br>
      <div class="">
        <div class="left">
          <?php
          $name="Alumno:";
          if(isset($pat) && $pat["student"]){
              $if=DBUserInfo($pat['student']);
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$if['userfullname'];
              echo $name;
          }else{
            echo $name."...................................................................................................";
          }
          ?>
        </div>
      </div>
      <div style="clear:both;"></div>
      <div class="">
        <div class="left">
          <?php
          $name="Paciente:";
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


    <div style=" clear: both;"></div>


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
      .piezap{
        display: inline-block;
        position: relative;
        width: 40px;
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
    $a['diente18b-a']='';$a['diente17b-a']='';$a['diente16b-a']='';$a['diente15b-a']='';$a['diente14b-a']='';$a['diente13b-a']='';$a['diente12b-a']='';$a['diente11b-a']='';
    $a['diente21b-a']='';$a['diente22b-a']='';$a['diente23b-a']='';$a['diente24b-a']='';$a['diente25b-a']='';$a['diente26b-a']='';$a['diente27b-a']='';$a['diente28b-a']='';
    $a['diente41-a']='';$a['diente42-a']='';$a['diente43-a']='';$a['diente44-a']='';$a['diente45-a']='';$a['diente46-a']='';$a['diente47-a']='';$a['diente48-a']='';
    $a['diente31-a']='';$a['diente32-a']='';$a['diente33-a']='';$a['diente34-a']='';$a['diente35-a']='';$a['diente36-a']='';$a['diente37-a']='';$a['diente38-a']='';
    $a['diente41b-a']='';$a['diente42b-a']='';$a['diente43b-a']='';$a['diente44b-a']='';$a['diente45b-a']='';$a['diente46b-a']='';$a['diente47b-a']='';$a['diente48b-a']='';
    $a['diente31b-a']='';$a['diente32b-a']='';$a['diente33b-a']='';$a['diente34b-a']='';$a['diente35b-a']='';$a['diente36b-a']='';$a['diente37b-a']='';$a['diente38b-a']='';

    $a['t18']='';$a['l18']='';$a['b18']='';$a['r18']='';$a['c18']='';
    $a['t17']='';$a['l17']='';$a['b17']='';$a['r17']='';$a['c17']='';
    $a['t16']='';$a['l16']='';$a['b16']='';$a['r16']='';$a['c16']='';
    $a['t15']='';$a['l15']='';$a['b15']='';$a['r15']='';$a['c15']='';
    $a['t14']='';$a['l14']='';$a['b14']='';$a['r14']='';$a['c14']='';
    $a['t13']='';$a['l13']='';$a['b13']='';$a['r13']='';$a['c13']='';
    $a['t12']='';$a['l12']='';$a['b12']='';$a['r12']='';$a['c12']='';
    $a['t11']='';$a['l11']='';$a['b11']='';$a['r11']='';$a['c11']='';

    $a['t21']='';$a['l21']='';$a['b21']='';$a['r21']='';$a['c21']='';
    $a['t22']='';$a['l22']='';$a['b22']='';$a['r22']='';$a['c22']='';
    $a['t23']='';$a['l23']='';$a['b23']='';$a['r23']='';$a['c23']='';
    $a['t24']='';$a['l24']='';$a['b24']='';$a['r24']='';$a['c24']='';
    $a['t25']='';$a['l25']='';$a['b25']='';$a['r25']='';$a['c25']='';
    $a['t26']='';$a['l26']='';$a['b26']='';$a['r26']='';$a['c26']='';
    $a['t27']='';$a['l27']='';$a['b27']='';$a['r27']='';$a['c27']='';
    $a['t28']='';$a['l28']='';$a['b28']='';$a['r28']='';$a['c28']='';

    $a['t48']='';$a['l48']='';$a['b48']='';$a['r48']='';$a['c48']='';
    $a['t47']='';$a['l47']='';$a['b47']='';$a['r47']='';$a['c47']='';
    $a['t46']='';$a['l46']='';$a['b46']='';$a['r46']='';$a['c46']='';
    $a['t45']='';$a['l45']='';$a['b45']='';$a['r45']='';$a['c45']='';
    $a['t44']='';$a['l44']='';$a['b44']='';$a['r44']='';$a['c44']='';
    $a['t43']='';$a['l43']='';$a['b43']='';$a['r43']='';$a['c43']='';
    $a['t42']='';$a['l42']='';$a['b42']='';$a['r42']='';$a['c42']='';
    $a['t41']='';$a['l41']='';$a['b41']='';$a['r41']='';$a['c41']='';

    $a['t31']='';$a['l31']='';$a['b31']='';$a['r31']='';$a['c31']='';
    $a['t32']='';$a['l32']='';$a['b32']='';$a['r32']='';$a['c32']='';
    $a['t33']='';$a['l33']='';$a['b33']='';$a['r33']='';$a['c33']='';
    $a['t34']='';$a['l34']='';$a['b34']='';$a['r34']='';$a['c34']='';
    $a['t35']='';$a['l35']='';$a['b35']='';$a['r35']='';$a['c35']='';
    $a['t36']='';$a['l36']='';$a['b36']='';$a['r36']='';$a['c36']='';
    $a['t37']='';$a['l37']='';$a['b37']='';$a['r37']='';$a['c37']='';
    $a['t38']='';$a['l38']='';$a['b38']='';$a['r38']='';$a['c38']='';
    //echo $pat['periodonticsiigram'];
    $pos=strpos($pat['periodonticsiigram'],'[t18=');
    $periodgram=substr($pat['periodonticsiigram'], 0, $pos);
    $gram=substr($pat['periodonticsiigram'], $pos);
    //echo $gram;
    $dir='../images/img/reportp/';
    for ($i=1; $i <= 2 ; $i++) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezap\">";
          $jj=$j;
          if($i==1){

              //echo "  <span class=\"number\">".$i.$j."</span>";
          }
          else{
            //echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }


          echo "  <img class=\"pdiente\" src=\"".getPieza("diente".$i.$jj."-a.png",$dir)."\" alt=\"\">";
          //echo "  <img class=\"t\" src=\"".getPieza($matriz[$i][$jj][0].".png")."\" alt=\"\">";
          //echo "  <img class=\"l\" src=\"".getPieza($matriz[$i][$jj][1].".png")."\" alt=\"\">";
          //echo "  <img class=\"c\" src=\"".getPieza($matriz[$i][$jj][2].".png")."\" alt=\"\">";
          //echo "  <img class=\"r\" src=\"".getPieza($matriz[$i][$jj][3].".png")."\" alt=\"\">";
          //echo "  <img class=\"b\" src=\"".getPieza($matriz[$i][$jj][4].".png")."\" alt=\"\">";
          //if($matriz[$i][$jj][5]!='f')
          //  echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";

    echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";echo "<br>";

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

        $matriz[$r][$c][0]=$data[0];
        $matriz[$r][$c][1]=$data[1];
        $matriz[$r][$c][2]=$data[2];
        $matriz[$r][$c][3]=$data[3];
        $matriz[$r][$c][4]=$data[4];
        $matriz[$r][$c][5]=$data[5];
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
      <b>EXAMENES COMPLEMENTARIOS/b>
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
