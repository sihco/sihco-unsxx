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

    <div class="left">
      <div align="center"class="">
        <b>EXAMEN DEL PERIODONTO</b>
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

    $a['t18']='t';$a['l18']='l';$a['b18']='b';$a['r18']='r';$a['c18']='c';
    $a['t17']='t';$a['l17']='l';$a['b17']='b';$a['r17']='r';$a['c17']='c';
    $a['t16']='t';$a['l16']='l';$a['b16']='b';$a['r16']='r';$a['c16']='c';
    $a['t15']='t';$a['l15']='l';$a['b15']='b';$a['r15']='r';$a['c15']='c';
    $a['t14']='t';$a['l14']='l';$a['b14']='b';$a['r14']='r';$a['c14']='c';
    $a['t13']='t';$a['l13']='l';$a['b13']='b';$a['r13']='r';$a['c13']='c';
    $a['t12']='t';$a['l12']='l';$a['b12']='b';$a['r12']='r';$a['c12']='c';
    $a['t11']='t';$a['l11']='l';$a['b11']='b';$a['r11']='r';$a['c11']='c';

    $a['t21']='t';$a['l21']='l';$a['b21']='b';$a['r21']='r';$a['c21']='c';
    $a['t22']='t';$a['l22']='l';$a['b22']='b';$a['r22']='r';$a['c22']='c';
    $a['t23']='t';$a['l23']='l';$a['b23']='b';$a['r23']='r';$a['c23']='c';
    $a['t24']='t';$a['l24']='l';$a['b24']='b';$a['r24']='r';$a['c24']='c';
    $a['t25']='t';$a['l25']='l';$a['b25']='b';$a['r25']='r';$a['c25']='c';
    $a['t26']='t';$a['l26']='l';$a['b26']='b';$a['r26']='r';$a['c26']='c';
    $a['t27']='t';$a['l27']='l';$a['b27']='b';$a['r27']='r';$a['c27']='c';
    $a['t28']='t';$a['l28']='l';$a['b28']='b';$a['r28']='r';$a['c28']='c';

    $a['t48']='t';$a['l48']='l';$a['b48']='b';$a['r48']='r';$a['c48']='c';
    $a['t47']='t';$a['l47']='l';$a['b47']='b';$a['r47']='r';$a['c47']='c';
    $a['t46']='t';$a['l46']='l';$a['b46']='b';$a['r46']='r';$a['c46']='c';
    $a['t45']='t';$a['l45']='l';$a['b45']='b';$a['r45']='r';$a['c45']='c';
    $a['t44']='t';$a['l44']='l';$a['b44']='b';$a['r44']='r';$a['c44']='c';
    $a['t43']='t';$a['l43']='l';$a['b43']='b';$a['r43']='r';$a['c43']='c';
    $a['t42']='t';$a['l42']='l';$a['b42']='b';$a['r42']='r';$a['c42']='c';
    $a['t41']='t';$a['l41']='l';$a['b41']='b';$a['r41']='r';$a['c41']='c';

    $a['t31']='t';$a['l31']='l';$a['b31']='b';$a['r31']='r';$a['c31']='c';
    $a['t32']='t';$a['l32']='l';$a['b32']='b';$a['r32']='r';$a['c32']='c';
    $a['t33']='t';$a['l33']='l';$a['b33']='b';$a['r33']='r';$a['c33']='c';
    $a['t34']='t';$a['l34']='l';$a['b34']='b';$a['r34']='r';$a['c34']='c';
    $a['t35']='t';$a['l35']='l';$a['b35']='b';$a['r35']='r';$a['c35']='c';
    $a['t36']='t';$a['l36']='l';$a['b36']='b';$a['r36']='r';$a['c36']='c';
    $a['t37']='t';$a['l37']='l';$a['b37']='b';$a['r37']='r';$a['c37']='c';
    $a['t38']='t';$a['l38']='l';$a['b38']='b';$a['r38']='r';$a['c38']='c';

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



    //echo $pat['periodonticsiigram'];
    //echo $pat['periodonticsiioleary'];
    if(isset($pat['periodonticsiigram'])&&$pat['periodonticsiigram']!=''){
      $pos=strpos($pat['periodonticsiigram'],'[t18=');
      $periodgram=substr($pat['periodonticsiigram'], 0, $pos);
      $gram=substr($pat['periodonticsiigram'], $pos);
      //echo $periodgram;
      $gramdata=explode(']', $gram);
      $n=count($gramdata);
      for($i=0;$i<$n-1;$i++){
        $data=explode('[',$gramdata[$i]);
        $data=explode('=',$data[1]);

        if(trim($data[1])==''){
          $a[$data[0]]=substr($data[0],0,1);
        }elseif (trim($data[1])=='click-red') {
          $a[$data[0]]=substr($data[0],0,1).'caries';

        }else{
          echo $data[0].' : '.$data[1];
        }
      }

      $pdata=explode(']', $periodgram);
      $n=count($pdata);
      for($i=0;$i<$n-1;$i++){
        $data=explode('[',$pdata[$i]);
        $data=explode('=',$data[1]);

        if(trim($data[1])==''){
          $a[$data[0]]='';
        }elseif (trim($data[1])=='bg-danger') {
          $a[$data[0]]='bg-danger';

        }else{
          echo $data[0].' : '.$data[1];
        }
      }
    }
    if(isset($pat['periodonticsiioleary'])&&$pat['periodonticsiioleary']!=''){

      $gramdata=explode(']', $pat['periodonticsiioleary']);
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
    //echo $gram;
    echo "<div class=\"sep\"></div>";
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


          echo "  <img class=\"pdiente\" src=\"".getPieza("diente".$i.$jj."-a".$a['diente'.$i.$jj.'-a'].".png",$dir)."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";



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
          echo "  <img class=\"t\" src=\"".getPieza($a['t'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['l'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['c'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['r'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['b'.$i.$jj].".png")."\" alt=\"\">";
          //if($matriz[$i][$jj][5]!='f')
          //  echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    echo "<div class=\"sep\"></div>";
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


          echo "  <img class=\"pdiente\" src=\"".getPieza("diente".$i.$jj."b-a".$a['diente'.$i.$jj.'b-a'].".png",$dir)."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    //inferior
    echo "<div class=\"sep\"></div>";
    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezap\">";
          $jj=$j;
          if($i==4){
            //echo "  <span class=\"number\">".$i.$j."</span>";
          }else{
            //echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }
          echo "  <img class=\"pdiente\" src=\"".getPieza("diente".$i.$jj."-a".$a['diente'.$i.$jj.'-a'].".png",$dir)."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";

    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezapp\">";
          $jj=$j;
          if($i==4)
            echo "  <span class=\"number\">".$i.$j."</span>";
          else{
            echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }

          echo "  <img class=\"t\" src=\"".getPieza($a['t'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"l\" src=\"".getPieza($a['l'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"c\" src=\"".getPieza($a['c'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"r\" src=\"".getPieza($a['r'.$i.$jj].".png")."\" alt=\"\">";
          echo "  <img class=\"b\" src=\"".getPieza($a['b'.$i.$jj].".png")."\" alt=\"\">";
          //if($matriz[$i][$jj][5]!='f')
            //echo "  <img class=\"f\" src=\"".getPieza($matriz[$i][$jj][5].".png")."\" alt=\"\">";
          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    //inferior
    echo "<div class=\"sep\"></div>";
    for ($i=4; $i >= 3 ; $i--) {
      for ($j=8; $j >= 1 ; $j--) {
          echo "<div class=\"piezap\">";
          $jj=$j;
          if($i==4){
            //echo "  <span class=\"number\">".$i.$j."</span>";
          }else{
            //echo "  <span class=\"number\">".$i.(($j-9)*(-1))."</span>";
            $jj=(($j-9)*(-1));
          }
          echo "  <img class=\"pdiente\" src=\"".getPieza("diente".$i.$jj."b-a".$a['diente'.$i.$jj.'b-a'].".png",$dir)."\" alt=\"\">";

          echo "</div>\n";
      }
    }
    echo "<div style=\"clear:both;\"></div>";
    echo "<br>";


    ?>
    <div style="clear:both;"></div>

    <div class="">
      <style media="screen">
        .vc{
          width: 24%;
          /*background-color: #FF0000;*/
          display: inline-block;
        }
        .uu{
          width: 15%;
          /*background-color: #FF0000;*/
          display: inline-block;
        }
        .ut{
          width: 30%;
          /*background-color: #FF0000;*/
          display: inline-block;
        }
      </style>
      <div class="vc">
        HIGIENE BUCAL
        <br>

        <?php
        if(isset($pat['bucal'])&&$pat['bucal']!=''){
          echo ucfirst($pat['bucal']).'<br>';
        }else{
          echo "Buena<br>";
          echo "Regular<br>";
          echo "Mala<br>";
        }

        ?>
      </div>
      <div class="vc">
        MUCOSA GINGIVAL
        <br>
        <?php
        if(isset($pat['gingival'])&&$pat['gingival']!=''){
          echo ucfirst($pat['gingival']).'<br>';
        }else{
          echo "Sana<br>";
          echo "Alterada<br>";
          echo "Gingivorragia<br>";
        }

        ?>
      </div>
      <div class="uu">
        SONDEO
        <br>
        <?php
        if(isset($pat['sondeo'])&&$pat['sondeo']!=''){
          echo ucfirst(substr($pat['sondeo'],0,3).'.'.substr($pat['sondeo'],3)).'<br>';
        }else{
          echo "Cod.1<br>";
          echo "Cod.2<br>";
          echo "Cod.3<br>";
          echo "Cod.4<br>";
          echo "Cod.5<br>";
        }

        ?>
      </div>
      <div class="ut">
        PRESENCIA DE TÁRTARO
        <br>
        <?php
        if(isset($pat['tartaro'])&&$pat['tartaro']!=''){
          echo ucfirst($pat['tartaro']).'<br>';
        }else{
          echo "Leve<br>";
          echo "Moderado<br>";
          echo "Grave<br>";
          echo "Supragingival<br>";
          echo "Subgingival<br>";
        }

        ?>

      </div>
    </div>
    <br>
    <div class="">
      <?php
      $name="Diagnostico:";
      if(isset($pat["periodonticsiidiagnosis"]) && $pat["periodonticsiidiagnosis"]!=''){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$pat["periodonticsiidiagnosis"];
        echo $name;
      }else{
        echo $name."............................................................................................................................<br>";
        echo ".................................................................................................................................................<br>";
      }
      ?>
    </div>
    <div class="">
      <?php
      $name="Tratamiento:";
      if(isset($pat["periodonticsiitreatment"]) && $pat["periodonticsiitreatment"]!=''){
        $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". ucfirst($pat["periodonticsiitreatment"]);
        echo $name;
      }else{
        echo $name."............................................................................................................................<br>";
        echo ".................................................................................................................................................<br>";
      }
      ?>
    </div>
    <br>
    <div class="">
      PROFILAXIS Y FLUORIZACIÓN:
      <br>
    </div>
    <style media="screen">
      .tablet{
        margin-left: 10%;
        width: 80%;
        /*background-color: #ff0000;*/
      }
    </style>
    <br>
    <div class="tablet">
      <table width="100%" border=1>
        <tr>
          <td width="50%">
            1.- Sesión
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
          <td width="50%">
            1.- Sesión
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
        </tr>
        <tr>
          <td width="50%">
            1.- Sesión
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
          <td width="50%">

            <?php
            if(isset($pat['periodonticsiiid'])){
              $obs=DBSessionPeriodonticsiiInfo($pat['periodonticsiiid']);
            }

            $name="Observación:";
            if(isset($obs) && isset($obs["sessiondesc"]) && $obs["sessiondesc"]!=''){
              echo "<br>";
              $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $obs['sessiondesc'];
              echo $name;

            }else{
              echo $name.'<br>';
              echo ".............................................................<br>";
              echo ".............................................................";
            }
            ?>
          </td>
        </tr>
      </table>
    </div>
    <br>


    <div class="">
      <div class="">
        TARTRECTOMIA:
      </div>
      <br>
      <div class="tablet">
        <table width="100%" border=1>
          <tr>
            <td width="50%">
              1.- Sesión
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
            <td width="50%">
              1.- Sesión
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
          </tr>
          <tr>
            <td width="50%">
              1.- Sesión
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
            <td width="50%">

              <?php

              $name="Observación:";
              if(isset($obs) && isset($obs["sessiondesc"]) && $obs["sessiondesc"]!=''){
                echo "<br>";
                $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $obs['sessiondesc'];
                echo $name;

              }else{
                echo $name.'<br>';
                echo ".............................................................<br>";
                echo ".............................................................";
              }
              ?>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="">
      <div class="">
        DETECCIÓN DE LA PLACA BACTERIANA
      </div>
      <br>
      <div class="">
        Indice de O'leary
      </div>

      <br>
      <div class="">
        <table width="100%" border=1>
          <tr>
            <td width="50%">
              Indice de primera consulta
            </td>
            <td width="15%">
              <?php
              if(isset($pat['info1'])) echo $pat['info1'];
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
              Indice Alta
            </td>
            <td width="15%">
              <?php
              if(isset($pat['info2'])) echo $pat['info2'];
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
      <br>
      <div class="">
        <?php

        $name="INSTRUCCION TECNICA DE CEPILLADO:";
        if(isset($pat["periodonticsiibrushed"]) && $pat["periodonticsiibrushed"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["periodonticsiibrushed"];
          echo $name;
        }else{
          echo $name."...........................................................................................<br>";
          echo ".......................................................................................................................................................................<br>";
        }
        ?>
      </div>
      <br>
      <div class="">
        <?php

        $name="COMENTARIO:";
        if(isset($pat["periodonticsiicomment"]) && $pat["periodonticsiicomment"]!=''){
          $name.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;". $pat["periodonticsiicomment"];
          echo $name;
        }else{
          echo $name."...........................................................................................................................................<br>";
          echo ".......................................................................................................................................................................<br>";
        }
        ?>
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
