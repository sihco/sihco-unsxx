<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");

if(isset($_POST['ficha'])&&isset($_POST['protesisfecha'])){
  $info=DBRemovableInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['removableid'];//id of clinical

  $protesisfecha=$_POST['protesisfecha'];
  $apoyos='';
  $retencion='';
  $reciprocidad='';
  $conector='';
  $indirecta='';
  $planos='';
  $base='';
  $contornear='';
  if(isset($info['apoyos'])){
    $apoyos=$info['apoyos'];
  }
  if(isset($info['retencion'])){
    $retencion=$info['retencion'];
  }
  if(isset($info['reciprocidad'])){
    $reciprocidad=$info['reciprocidad'];
  }
  if(isset($info['conector'])){
    $conector=$info['conector'];
  }
  if(isset($info['indirecta'])){
    $indirecta=$info['indirecta'];
  }
  if(isset($info['planos'])){
    $planos=$info['planos'];
  }
  if(isset($info['base'])){
    $base=$info['base'];
  }
  if(isset($info['contornear'])){
    $contornear=$info['contornear'];
  }
  $idteacher=$_SESSION['usertable']['usernumber'];
  $param['specs']='['.$apoyos.']'.
  '['.$retencion.']'.
  '['.$reciprocidad.']'.
  '['.$conector.']'.
  '['.$indirecta.']'.
  '['.$planos.']'.
  '['.$base.']'.
  '['.$contornear.']'.
  '['.(isset($_POST['protesis'])&&$_POST['protesis']=='true'?$idteacher:(isset($info['protesis'])?$info['protesis']:'')).']'.
  '['.$protesisfecha.']';

  DBUpdateRemovableSpecs($param);
  echo "yes";
  exit;
}

if(isset($_POST['ficha'])&&  isset($_POST['imggram'])){

  $info=DBRemovableInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();

  $param['student'] = $info['student'];
  $param['teacher'] = $info['teacher'];
  $param['file'] = $info['removableid'];//id of clinical

  //$conf=globalconf();
  $param['gram'] = $_POST["imggram"];//encryptData($_POST["imggram"], $conf["key"], false);

  DBUpdateRemovableGram($param);
  echo "yes";
  exit;
}

if(isset($_POST['ficha'])&&isset($_POST['obstrabajo'])&&isset($_POST['notatrabajo'])){
  $param=array();
  $info=DBRemovableInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }

  $obstrabajo=htmlspecialchars($_POST['obstrabajo']);
  $notatrabajo=htmlspecialchars($_POST['notatrabajo']);
  $valortrabajo='';
  if(isset($info['valortrabajo'])){
    $valortrabajo=$info['valortrabajo'];
  }
  $trabajo='';
  if(isset($info['trabajo'])){
    $trabajo=$info['trabajo'];
  }
  $param['procedures']='['.$valortrabajo.']['.$trabajo.']';
  $remopro1=procedureremovable((isset($_POST['remopro1'])?$_POST['remopro1']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 1, 1, 2);//$post, $info, $user, $n, $row, $col
  $remopro2=procedureremovable((isset($_POST['remopro2'])?$_POST['remopro2']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 2, 1, 2);
  $remopro3=procedureremovable((isset($_POST['remopro3'])?$_POST['remopro3']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 3, 1, 2);
  $remopro4=procedureremovable((isset($_POST['remopro4'])?$_POST['remopro4']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 4, 1, 2);
  $remopro5=procedureremovable((isset($_POST['remopro5'])?$_POST['remopro5']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 5, 1, 2);
  $remopro6=procedureremovable((isset($_POST['remopro6'])?$_POST['remopro6']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 6, 1, 2);
  $remopro7=procedureremovable((isset($_POST['remopro7'])?$_POST['remopro7']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 7, 1, 2);
  $remopro8=procedureremovable((isset($_POST['remopro8'])?$_POST['remopro8']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 8, 1, 2);
  $remopro9=procedureremovable((isset($_POST['remopro9'])?$_POST['remopro9']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 9, 1, 2);
  $remopro10=procedureremovable((isset($_POST['remopro10'])?$_POST['remopro10']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 10, 1, 2);
  $remopro11=procedureremovable((isset($_POST['remopro11'])?$_POST['remopro11']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 11, 1, 2);
  $remopro12=procedureremovable((isset($_POST['remopro12'])?$_POST['remopro12']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 12, 1, 2);
  $remopro13=procedureremovable((isset($_POST['remopro13'])?$_POST['remopro13']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 13, 1, 2);
  $remopro14=procedureremovable((isset($_POST['remopro14'])?$_POST['remopro14']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 14, 1, 2);
  $remopro15=procedureremovable((isset($_POST['remopro15'])?$_POST['remopro15']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 15, 1, 2);
  $remopro16=procedureremovable((isset($_POST['remopro16'])?$_POST['remopro16']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 16, 1, 2);
  $remopro17=procedureremovable((isset($_POST['remopro17'])?$_POST['remopro17']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 17, 1, 2);
  $remopro18=procedureremovable((isset($_POST['remopro18'])?$_POST['remopro18']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 18, 1, 2);
  $remopro19=procedureremovable((isset($_POST['remopro19'])?$_POST['remopro19']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 19, 1, 2);
  $remopro20=procedureremovable((isset($_POST['remopro20'])?$_POST['remopro20']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 20, 1, 2);
  $remopro21=procedureremovable((isset($_POST['remopro21'])?$_POST['remopro21']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 21, 1, 2);
  $remopro22=procedureremovable((isset($_POST['remopro22'])?$_POST['remopro22']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 22, 1, 2);
  $remopro23=procedureremovable((isset($_POST['remopro23'])?$_POST['remopro23']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 23, 1, 2);
  $remopro24=procedureremovable((isset($_POST['remopro24'])?$_POST['remopro24']:'NULL'), $info, $_SESSION['usertable']['usernumber'], 24, 1, 2);
  /*$remopro1='';
  if(!isset($_POST['remopro1'])||(isset($_POST['remopro1'])&&$_POST['remopro1']=='')){
      if(isset($info['selremopro1'])&&isset($info['tearemopro1'])){
        if($info['tearemopro1']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro1']!=$info['selremopro1']){
              $userinf=DBUserInfo($info['tearemopro1']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname']." fila 1 columna 2";
              $remopro1=$info['selremopro1'].'='.$info['tearemopro1'];
          }else{
            $remopro1=$_POST['remopro1'].'='.$info['tearemopro1'];
          }
        }else{
          $remopro1=$_POST['remopro1'].'='.$info['tearemopro1'];
        }
      }else{
        if(isset($_POST['remopro1'])) $remopro1='true';
        else $remopro1='false';
      }
  }elseif(isset($_POST['remopro1'])&&$_POST['remopro1']!=''){
    if(isset($info['selremopro1'])&&isset($info['tearemopro1'])){
      if($info['tearemopro1']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro1']!=$info['selremopro1']){
            $remopro1=$_POST['remopro1'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro1=$_POST['remopro1'].'='.$info['tearemopro1'];
        }
      }else{
        $remopro1=$_POST['remopro1'].'='.$info['tearemopro1'];
      }
    }else{
      $remopro1=$_POST['remopro1'].'='.$_SESSION['usertable']['usernumber'];
    }
  }

  $remopro2='';
  if(!isset($_POST['remopro2'])||(isset($_POST['remopro2'])&&$_POST['remopro2']=='')){
      if(isset($info['selremopro2'])&&isset($info['tearemopro2'])){
        if($info['tearemopro2']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro2']!=$info['selremopro2']){
              $userinf=DBUserInfo($info['tearemopro2']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro2=$_POST['remopro2'].'='.$info['tearemopro2'];
          }
        }else{
          $remopro2=$_POST['remopro2'].'='.$info['tearemopro2'];
        }
      }else{
        $remopro2=$_POST['remopro2'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro2'])&&$_POST['remopro2']!=''){
    if(isset($info['selremopro2'])&&isset($info['tearemopro2'])){
      if($info['tearemopro2']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro2']!=$info['selremopro2']){
            $remopro2=$_POST['remopro2'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro2=$_POST['remopro2'].'='.$info['tearemopro2'];
        }
      }else{
        $remopro2=$_POST['remopro2'].'='.$info['tearemopro2'];
      }
    }else{
      $remopro2=$_POST['remopro2'].'='.$_SESSION['usertable']['usernumber'];
    }
  }

  $remopro3='';
  if(!isset($_POST['remopro3'])||(isset($_POST['remopro3'])&&$_POST['remopro3']=='')){
      if(isset($info['selremopro3'])&&isset($info['tearemopro3'])){
        if($info['tearemopro3']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro3']!=$info['selremopro3']){
              $userinf=DBUserInfo($info['tearemopro3']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro3=$_POST['remopro3'].'='.$info['tearemopro3'];
          }
        }else{
          $remopro3=$_POST['remopro3'].'='.$info['tearemopro3'];
        }
      }else{
        $remopro3=$_POST['remopro3'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro3'])&&$_POST['remopro3']!=''){
    if(isset($info['selremopro3'])&&isset($info['tearemopro3'])){
      if($info['tearemopro3']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro3']!=$info['selremopro3']){
            $remopro3=$_POST['remopro3'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro3=$_POST['remopro3'].'='.$info['tearemopro3'];
        }
      }else{
        $remopro3=$_POST['remopro3'].'='.$info['tearemopro3'];
      }
    }else{
      $remopro3=$_POST['remopro3'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro4='';
  if(!isset($_POST['remopro4'])||(isset($_POST['remopro4'])&&$_POST['remopro4']=='')){
      if(isset($info['selremopro4'])&&isset($info['tearemopro4'])){
        if($info['tearemopro4']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro4']!=$info['selremopro4']){
              $userinf=DBUserInfo($info['tearemopro4']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro4=$_POST['remopro4'].'='.$info['tearemopro4'];
          }
        }else{
          $remopro4=$_POST['remopro4'].'='.$info['tearemopro4'];
        }
      }else{
        $remopro4=$_POST['remopro4'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro4'])&&$_POST['remopro4']!=''){
    if(isset($info['selremopro4'])&&isset($info['tearemopro4'])){
      if($info['tearemopro4']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro4']!=$info['selremopro4']){
            $remopro4=$_POST['remopro4'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro4=$_POST['remopro4'].'='.$info['tearemopro4'];
        }
      }else{
        $remopro4=$_POST['remopro4'].'='.$info['tearemopro4'];
      }
    }else{
      $remopro4=$_POST['remopro4'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro5='';
  if(!isset($_POST['remopro5'])||(isset($_POST['remopro5'])&&$_POST['remopro5']=='')){
      if(isset($info['selremopro5'])&&isset($info['tearemopro5'])){
        if($info['tearemopro5']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro5']!=$info['selremopro5']){
              $userinf=DBUserInfo($info['tearemopro5']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro5=$_POST['remopro5'].'='.$info['tearemopro5'];
          }
        }else{
          $remopro5=$_POST['remopro5'].'='.$info['tearemopro5'];
        }
      }else{
        $remopro5=$_POST['remopro5'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro5'])&&$_POST['remopro5']!=''){
    if(isset($info['selremopro5'])&&isset($info['tearemopro5'])){
      if($info['tearemopro5']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro5']!=$info['selremopro5']){
            $remopro5=$_POST['remopro5'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro5=$_POST['remopro5'].'='.$info['tearemopro5'];
        }
      }else{
        $remopro5=$_POST['remopro5'].'='.$info['tearemopro5'];
      }
    }else{
      $remopro5=$_POST['remopro5'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro6='';
  if(!isset($_POST['remopro6'])||(isset($_POST['remopro6'])&&$_POST['remopro6']=='')){
      if(isset($info['selremopro6'])&&isset($info['tearemopro6'])){
        if($info['tearemopro6']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro6']!=$info['selremopro6']){
              $userinf=DBUserInfo($info['tearemopro6']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro6=$_POST['remopro6'].'='.$info['tearemopro6'];
          }
        }else{
          $remopro6=$_POST['remopro6'].'='.$info['tearemopro6'];
        }
      }else{
        $remopro6=$_POST['remopro6'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro6'])&&$_POST['remopro6']!=''){
    if(isset($info['selremopro6'])&&isset($info['tearemopro6'])){
      if($info['tearemopro6']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro6']!=$info['selremopro6']){
            $remopro6=$_POST['remopro6'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro6=$_POST['remopro6'].'='.$info['tearemopro6'];
        }
      }else{
        $remopro6=$_POST['remopro6'].'='.$info['tearemopro6'];
      }
    }else{
      $remopro6=$_POST['remopro6'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro7='';
  if(!isset($_POST['remopro7'])||(isset($_POST['remopro7'])&&$_POST['remopro7']=='')){
      if(isset($info['selremopro7'])&&isset($info['tearemopro7'])){
        if($info['tearemopro7']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro7']!=$info['selremopro7']){
              $userinf=DBUserInfo($info['tearemopro7']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro7=$_POST['remopro7'].'='.$info['tearemopro7'];
          }
        }else{
          $remopro7=$_POST['remopro7'].'='.$info['tearemopro7'];
        }
      }else{
        $remopro7=$_POST['remopro7'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro7'])&&$_POST['remopro7']!=''){
    if(isset($info['selremopro7'])&&isset($info['tearemopro7'])){
      if($info['tearemopro7']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro7']!=$info['selremopro7']){
            $remopro7=$_POST['remopro7'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro7=$_POST['remopro7'].'='.$info['tearemopro7'];
        }
      }else{
        $remopro7=$_POST['remopro7'].'='.$info['tearemopro7'];
      }
    }else{
      $remopro7=$_POST['remopro7'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro8='';
  if(!isset($_POST['remopro8'])||(isset($_POST['remopro8'])&&$_POST['remopro8']=='')){
      if(isset($info['selremopro8'])&&isset($info['tearemopro8'])){
        if($info['tearemopro8']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro8']!=$info['selremopro8']){
              $userinf=DBUserInfo($info['tearemopro8']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro8=$_POST['remopro8'].'='.$info['tearemopro8'];
          }
        }else{
          $remopro8=$_POST['remopro8'].'='.$info['tearemopro8'];
        }
      }else{
        $remopro8=$_POST['remopro8'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro8'])&&$_POST['remopro8']!=''){
    if(isset($info['selremopro8'])&&isset($info['tearemopro8'])){
      if($info['tearemopro8']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro8']!=$info['selremopro8']){
            $remopro8=$_POST['remopro8'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro8=$_POST['remopro8'].'='.$info['tearemopro8'];
        }
      }else{
        $remopro8=$_POST['remopro8'].'='.$info['tearemopro8'];
      }
    }else{
      $remopro8=$_POST['remopro8'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro9='';
  if(!isset($_POST['remopro9'])||(isset($_POST['remopro9'])&&$_POST['remopro9']=='')){
      if(isset($info['selremopro9'])&&isset($info['tearemopro9'])){
        if($info['tearemopro9']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro9']!=$info['selremopro9']){
              $userinf=DBUserInfo($info['tearemopro9']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro9=$_POST['remopro9'].'='.$info['tearemopro9'];
          }
        }else{
          $remopro9=$_POST['remopro9'].'='.$info['tearemopro9'];
        }
      }else{
        $remopro9=$_POST['remopro9'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro9'])&&$_POST['remopro9']!=''){
    if(isset($info['selremopro9'])&&isset($info['tearemopro9'])){
      if($info['tearemopro9']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro9']!=$info['selremopro9']){
            $remopro9=$_POST['remopro9'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro9=$_POST['remopro9'].'='.$info['tearemopro9'];
        }
      }else{
        $remopro9=$_POST['remopro9'].'='.$info['tearemopro9'];
      }
    }else{
      $remopro9=$_POST['remopro9'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro10='';
  if(!isset($_POST['remopro10'])||(isset($_POST['remopro10'])&&$_POST['remopro10']=='')){
      if(isset($info['selremopro10'])&&isset($info['tearemopro10'])){
        if($info['tearemopro10']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro10']!=$info['selremopro10']){
              $userinf=DBUserInfo($info['tearemopro10']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro10=$_POST['remopro10'].'='.$info['tearemopro10'];
          }
        }else{
          $remopro10=$_POST['remopro10'].'='.$info['tearemopro10'];
        }
      }else{
        $remopro10=$_POST['remopro10'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro10'])&&$_POST['remopro10']!=''){
    if(isset($info['selremopro10'])&&isset($info['tearemopro10'])){
      if($info['tearemopro10']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro10']!=$info['selremopro10']){
            $remopro10=$_POST['remopro10'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro10=$_POST['remopro10'].'='.$info['tearemopro10'];
        }
      }else{
        $remopro10=$_POST['remopro10'].'='.$info['tearemopro10'];
      }
    }else{
      $remopro10=$_POST['remopro10'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro11='';
  if(!isset($_POST['remopro11'])||(isset($_POST['remopro11'])&&$_POST['remopro11']=='')){
      if(isset($info['selremopro11'])&&isset($info['tearemopro11'])){
        if($info['tearemopro11']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro11']!=$info['selremopro11']){
              $userinf=DBUserInfo($info['tearemopro11']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro11=$_POST['remopro11'].'='.$info['tearemopro11'];
          }
        }else{
          $remopro11=$_POST['remopro11'].'='.$info['tearemopro11'];
        }
      }else{
        $remopro11=$_POST['remopro11'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro11'])&&$_POST['remopro11']!=''){
    if(isset($info['selremopro11'])&&isset($info['tearemopro11'])){
      if($info['tearemopro11']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro11']!=$info['selremopro11']){
            $remopro11=$_POST['remopro11'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro11=$_POST['remopro11'].'='.$info['tearemopro11'];
        }
      }else{
        $remopro11=$_POST['remopro11'].'='.$info['tearemopro11'];
      }
    }else{
      $remopro11=$_POST['remopro11'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro12='';
  if(!isset($_POST['remopro12'])||(isset($_POST['remopro12'])&&$_POST['remopro12']=='')){
      if(isset($info['selremopro12'])&&isset($info['tearemopro12'])){
        if($info['tearemopro12']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro12']!=$info['selremopro12']){
              $userinf=DBUserInfo($info['tearemopro12']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro12=$_POST['remopro12'].'='.$info['tearemopro12'];
          }
        }else{
          $remopro12=$_POST['remopro12'].'='.$info['tearemopro12'];
        }
      }else{
        $remopro12=$_POST['remopro12'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro12'])&&$_POST['remopro12']!=''){
    if(isset($info['selremopro12'])&&isset($info['tearemopro12'])){
      if($info['tearemopro12']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro12']!=$info['selremopro12']){
            $remopro12=$_POST['remopro12'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro12=$_POST['remopro12'].'='.$info['tearemopro12'];
        }
      }else{
        $remopro12=$_POST['remopro12'].'='.$info['tearemopro12'];
      }
    }else{
      $remopro12=$_POST['remopro12'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro13='';
  if(!isset($_POST['remopro13'])||(isset($_POST['remopro13'])&&$_POST['remopro13']=='')){
      if(isset($info['selremopro13'])&&isset($info['tearemopro13'])){
        if($info['tearemopro13']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro13']!=$info['selremopro13']){
              $userinf=DBUserInfo($info['tearemopro13']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro13=$_POST['remopro13'].'='.$info['tearemopro13'];
          }
        }else{
          $remopro13=$_POST['remopro13'].'='.$info['tearemopro13'];
        }
      }else{
        $remopro13=$_POST['remopro13'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro13'])&&$_POST['remopro13']!=''){
    if(isset($info['selremopro13'])&&isset($info['tearemopro13'])){
      if($info['tearemopro13']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro13']!=$info['selremopro13']){
            $remopro13=$_POST['remopro13'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro13=$_POST['remopro13'].'='.$info['tearemopro13'];
        }
      }else{
        $remopro13=$_POST['remopro13'].'='.$info['tearemopro13'];
      }
    }else{
      $remopro13=$_POST['remopro13'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro14='';
  if(!isset($_POST['remopro14'])||(isset($_POST['remopro14'])&&$_POST['remopro14']=='')){
      if(isset($info['selremopro14'])&&isset($info['tearemopro14'])){
        if($info['tearemopro14']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro14']!=$info['selremopro14']){
              $userinf=DBUserInfo($info['tearemopro14']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro14=$_POST['remopro14'].'='.$info['tearemopro14'];
          }
        }else{
          $remopro14=$_POST['remopro14'].'='.$info['tearemopro14'];
        }
      }else{
        $remopro14=$_POST['remopro14'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro14'])&&$_POST['remopro14']!=''){
    if(isset($info['selremopro14'])&&isset($info['tearemopro14'])){
      if($info['tearemopro14']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro14']!=$info['selremopro14']){
            $remopro14=$_POST['remopro14'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro14=$_POST['remopro14'].'='.$info['tearemopro14'];
        }
      }else{
        $remopro14=$_POST['remopro14'].'='.$info['tearemopro14'];
      }
    }else{
      $remopro14=$_POST['remopro14'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro15='';
  if(!isset($_POST['remopro15'])||(isset($_POST['remopro15'])&&$_POST['remopro15']=='')){
      if(isset($info['selremopro15'])&&isset($info['tearemopro15'])){
        if($info['tearemopro15']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro15']!=$info['selremopro15']){
              $userinf=DBUserInfo($info['tearemopro15']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro15=$_POST['remopro15'].'='.$info['tearemopro15'];
          }
        }else{
          $remopro15=$_POST['remopro15'].'='.$info['tearemopro15'];
        }
      }else{
        $remopro15=$_POST['remopro15'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro15'])&&$_POST['remopro15']!=''){
    if(isset($info['selremopro15'])&&isset($info['tearemopro15'])){
      if($info['tearemopro15']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro15']!=$info['selremopro15']){
            $remopro15=$_POST['remopro15'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro15=$_POST['remopro15'].'='.$info['tearemopro15'];
        }
      }else{
        $remopro15=$_POST['remopro15'].'='.$info['tearemopro15'];
      }
    }else{
      $remopro15=$_POST['remopro15'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro16='';
  if(!isset($_POST['remopro16'])||(isset($_POST['remopro16'])&&$_POST['remopro16']=='')){
      if(isset($info['selremopro16'])&&isset($info['tearemopro16'])){
        if($info['tearemopro16']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro16']!=$info['selremopro16']){
              $userinf=DBUserInfo($info['tearemopro16']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro16=$_POST['remopro16'].'='.$info['tearemopro16'];
          }
        }else{
          $remopro16=$_POST['remopro16'].'='.$info['tearemopro16'];
        }
      }else{
        $remopro16=$_POST['remopro16'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro16'])&&$_POST['remopro16']!=''){
    if(isset($info['selremopro16'])&&isset($info['tearemopro16'])){
      if($info['tearemopro16']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro16']!=$info['selremopro16']){
            $remopro16=$_POST['remopro16'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro16=$_POST['remopro16'].'='.$info['tearemopro16'];
        }
      }else{
        $remopro16=$_POST['remopro16'].'='.$info['tearemopro16'];
      }
    }else{
      $remopro16=$_POST['remopro16'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro17='';
  if(!isset($_POST['remopro17'])||(isset($_POST['remopro17'])&&$_POST['remopro17']=='')){
      if(isset($info['selremopro17'])&&isset($info['tearemopro17'])){
        if($info['tearemopro17']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro17']!=$info['selremopro17']){
              $userinf=DBUserInfo($info['tearemopro17']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro17=$_POST['remopro17'].'='.$info['tearemopro17'];
          }
        }else{
          $remopro17=$_POST['remopro17'].'='.$info['tearemopro17'];
        }
      }else{
        $remopro17=$_POST['remopro17'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro17'])&&$_POST['remopro17']!=''){
    if(isset($info['selremopro17'])&&isset($info['tearemopro17'])){
      if($info['tearemopro17']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro17']!=$info['selremopro17']){
            $remopro17=$_POST['remopro17'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro17=$_POST['remopro17'].'='.$info['tearemopro17'];
        }
      }else{
        $remopro17=$_POST['remopro17'].'='.$info['tearemopro17'];
      }
    }else{
      $remopro17=$_POST['remopro17'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro18='';
  if(!isset($_POST['remopro18'])||(isset($_POST['remopro18'])&&$_POST['remopro18']=='')){
      if(isset($info['selremopro18'])&&isset($info['tearemopro18'])){
        if($info['tearemopro18']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro18']!=$info['selremopro18']){
              $userinf=DBUserInfo($info['tearemopro18']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro18=$_POST['remopro18'].'='.$info['tearemopro18'];
          }
        }else{
          $remopro18=$_POST['remopro18'].'='.$info['tearemopro18'];
        }
      }else{
        $remopro18=$_POST['remopro18'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro18'])&&$_POST['remopro18']!=''){
    if(isset($info['selremopro18'])&&isset($info['tearemopro18'])){
      if($info['tearemopro18']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro18']!=$info['selremopro18']){
            $remopro18=$_POST['remopro18'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro18=$_POST['remopro18'].'='.$info['tearemopro18'];
        }
      }else{
        $remopro18=$_POST['remopro18'].'='.$info['tearemopro18'];
      }
    }else{
      $remopro18=$_POST['remopro18'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro19='';
  if(!isset($_POST['remopro19'])||(isset($_POST['remopro19'])&&$_POST['remopro19']=='')){
      if(isset($info['selremopro19'])&&isset($info['tearemopro19'])){
        if($info['tearemopro19']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro19']!=$info['selremopro19']){
              $userinf=DBUserInfo($info['tearemopro19']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro19=$_POST['remopro19'].'='.$info['tearemopro19'];
          }
        }else{
          $remopro19=$_POST['remopro19'].'='.$info['tearemopro19'];
        }
      }else{
        $remopro19=$_POST['remopro19'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro19'])&&$_POST['remopro19']!=''){
    if(isset($info['selremopro19'])&&isset($info['tearemopro19'])){
      if($info['tearemopro19']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro19']!=$info['selremopro19']){
            $remopro19=$_POST['remopro19'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro19=$_POST['remopro19'].'='.$info['tearemopro19'];
        }
      }else{
        $remopro19=$_POST['remopro19'].'='.$info['tearemopro19'];
      }
    }else{
      $remopro19=$_POST['remopro19'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro20='';
  if(!isset($_POST['remopro20'])||(isset($_POST['remopro20'])&&$_POST['remopro20']=='')){
      if(isset($info['selremopro20'])&&isset($info['tearemopro20'])){
        if($info['tearemopro20']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro20']!=$info['selremopro20']){
              $userinf=DBUserInfo($info['tearemopro20']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro20=$_POST['remopro20'].'='.$info['tearemopro20'];
          }
        }else{
          $remopro20=$_POST['remopro20'].'='.$info['tearemopro20'];
        }
      }else{
        $remopro20=$_POST['remopro20'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro20'])&&$_POST['remopro20']!=''){
    if(isset($info['selremopro20'])&&isset($info['tearemopro20'])){
      if($info['tearemopro20']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro20']!=$info['selremopro20']){
            $remopro20=$_POST['remopro20'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro20=$_POST['remopro20'].'='.$info['tearemopro20'];
        }
      }else{
        $remopro20=$_POST['remopro20'].'='.$info['tearemopro20'];
      }
    }else{
      $remopro20=$_POST['remopro20'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro21='';
  if(!isset($_POST['remopro21'])||(isset($_POST['remopro21'])&&$_POST['remopro21']=='')){
      if(isset($info['selremopro21'])&&isset($info['tearemopro21'])){
        if($info['tearemopro21']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro21']!=$info['selremopro21']){
              $userinf=DBUserInfo($info['tearemopro21']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro21=$_POST['remopro21'].'='.$info['tearemopro21'];
          }
        }else{
          $remopro21=$_POST['remopro21'].'='.$info['tearemopro21'];
        }
      }else{
        $remopro21=$_POST['remopro21'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro21'])&&$_POST['remopro21']!=''){
    if(isset($info['selremopro21'])&&isset($info['tearemopro21'])){
      if($info['tearemopro21']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro21']!=$info['selremopro21']){
            $remopro21=$_POST['remopro21'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro21=$_POST['remopro21'].'='.$info['tearemopro21'];
        }
      }else{
        $remopro21=$_POST['remopro21'].'='.$info['tearemopro21'];
      }
    }else{
      $remopro21=$_POST['remopro21'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro22='';
  if(!isset($_POST['remopro22'])||(isset($_POST['remopro22'])&&$_POST['remopro22']=='')){
      if(isset($info['selremopro22'])&&isset($info['tearemopro22'])){
        if($info['tearemopro22']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro22']!=$info['selremopro22']){
              $userinf=DBUserInfo($info['tearemopro22']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro22=$_POST['remopro22'].'='.$info['tearemopro22'];
          }
        }else{
          $remopro22=$_POST['remopro22'].'='.$info['tearemopro22'];
        }
      }else{
        $remopro22=$_POST['remopro22'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro22'])&&$_POST['remopro22']!=''){
    if(isset($info['selremopro22'])&&isset($info['tearemopro22'])){
      if($info['tearemopro22']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro22']!=$info['selremopro22']){
            $remopro22=$_POST['remopro22'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro22=$_POST['remopro22'].'='.$info['tearemopro22'];
        }
      }else{
        $remopro22=$_POST['remopro22'].'='.$info['tearemopro22'];
      }
    }else{
      $remopro22=$_POST['remopro22'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro23='';
  if(!isset($_POST['remopro23'])||(isset($_POST['remopro23'])&&$_POST['remopro23']=='')){
      if(isset($info['selremopro23'])&&isset($info['tearemopro23'])){
        if($info['tearemopro23']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro23']!=$info['selremopro23']){
              $userinf=DBUserInfo($info['tearemopro23']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro23=$_POST['remopro23'].'='.$info['tearemopro23'];
          }
        }else{
          $remopro23=$_POST['remopro23'].'='.$info['tearemopro23'];
        }
      }else{
        $remopro23=$_POST['remopro23'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro23'])&&$_POST['remopro23']!=''){
    if(isset($info['selremopro23'])&&isset($info['tearemopro23'])){
      if($info['tearemopro23']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro23']!=$info['selremopro23']){
            $remopro23=$_POST['remopro23'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro23=$_POST['remopro23'].'='.$info['tearemopro23'];
        }
      }else{
        $remopro23=$_POST['remopro23'].'='.$info['tearemopro23'];
      }
    }else{
      $remopro23=$_POST['remopro23'].'='.$_SESSION['usertable']['usernumber'];
    }
  }
  $remopro24='';
  if(!isset($_POST['remopro24'])||(isset($_POST['remopro24'])&&$_POST['remopro24']=='')){
      if(isset($info['selremopro24'])&&isset($info['tearemopro24'])){
        if($info['tearemopro24']!=$_SESSION['usertable']['usernumber']){
          if($_POST['remopro24']!=$info['selremopro24']){
              $userinf=DBUserInfo($info['tearemopro24']);
              echo "No se puede anular ya se revisó por Dr(a): ".$userinf['userfullname'];
          }else{
            $remopro24=$_POST['remopro24'].'='.$info['tearemopro24'];
          }
        }else{
          $remopro24=$_POST['remopro24'].'='.$info['tearemopro24'];
        }
      }else{
        $remopro24=$_POST['remopro24'].'='.$_SESSION['usertable']['usernumber'];
      }
  }elseif(isset($_POST['remopro24'])&&$_POST['remopro24']!=''){
    if(isset($info['selremopro24'])&&isset($info['tearemopro24'])){
      if($info['tearemopro24']!=$_SESSION['usertable']['usernumber']){
        if($_POST['remopro24']!=$info['selremopro24']){
            $remopro24=$_POST['remopro24'].'='.$_SESSION['usertable']['usernumber'];
        }else{
          $remopro24=$_POST['remopro24'].'='.$info['tearemopro24'];
        }
      }else{
        $remopro24=$_POST['remopro24'].'='.$info['tearemopro24'];
      }
    }else{
      $remopro24=$_POST['remopro24'].'='.$_SESSION['usertable']['usernumber'];
    }
  }*/

  $idteacher=$_SESSION['usertable']['usernumber'];
  $param['procedures'].="[$remopro1][$remopro2]".
  "[$remopro3][$remopro4][$remopro5][$remopro6][$remopro7][$remopro8][$remopro9][$remopro10]".
  "[$remopro11][$remopro12][$remopro13][$remopro14][$remopro15][$remopro16][$remopro17][$remopro18]".
  "[$remopro19][$remopro20][$remopro21][$remopro22][$remopro23][$remopro24]".
  "[$obstrabajo][$notatrabajo]".
  '['.(isset($_POST['firmtrabajo'])&&$_POST['firmtrabajo']=='true'?$idteacher:(isset($info['firmtrabajo'])?$info['firmtrabajo']:'')).']';

  $param['file']=$info['removableid'];

  DBRemovableUpdateProcedure($param);
  echo "yes";
  exit;
}


if(isset($_POST['ficha'])&&isset($_POST['valortrabajo'])&&isset($_POST['trabajo'])){
  $param=array();
  $info=DBRemovableInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $valortrabajo=htmlspecialchars($_POST['valortrabajo']);
  $trabajo=htmlspecialchars($_POST['trabajo']);
  $param['procedures']='['.$valortrabajo.']['.$trabajo.']'.
  '['.(isset($_POST['remopro1'])?$_POST['remopro1']:(isset($info['remopro1'])?$info['remopro1']:'')).']'.
  '['.(isset($_POST['remopro2'])?$_POST['remopro2']:(isset($info['remopro2'])?$info['remopro2']:'')).']'.
  '['.(isset($_POST['remopro3'])?$_POST['remopro3']:(isset($info['remopro3'])?$info['remopro3']:'')).']'.
  '['.(isset($_POST['remopro4'])?$_POST['remopro4']:(isset($info['remopro4'])?$info['remopro4']:'')).']'.
  '['.(isset($_POST['remopro5'])?$_POST['remopro5']:(isset($info['remopro5'])?$info['remopro5']:'')).']'.
  '['.(isset($_POST['remopro6'])?$_POST['remopro6']:(isset($info['remopro6'])?$info['remopro6']:'')).']'.
  '['.(isset($_POST['remopro7'])?$_POST['remopro7']:(isset($info['remopro7'])?$info['remopro7']:'')).']'.
  '['.(isset($_POST['remopro8'])?$_POST['remopro8']:(isset($info['remopro8'])?$info['remopro8']:'')).']'.
  '['.(isset($_POST['remopro9'])?$_POST['remopro9']:(isset($info['remopro9'])?$info['remopro9']:'')).']'.
  '['.(isset($_POST['remopro10'])?$_POST['remopro10']:(isset($info['remopro10'])?$info['remopro10']:'')).']'.
  '['.(isset($_POST['remopro11'])?$_POST['remopro11']:(isset($info['remopro11'])?$info['remopro11']:'')).']'.
  '['.(isset($_POST['remopro12'])?$_POST['remopro12']:(isset($info['remopro12'])?$info['remopro12']:'')).']'.
  '['.(isset($_POST['remopro13'])?$_POST['remopro13']:(isset($info['remopro13'])?$info['remopro13']:'')).']'.
  '['.(isset($_POST['remopro14'])?$_POST['remopro14']:(isset($info['remopro14'])?$info['remopro14']:'')).']'.
  '['.(isset($_POST['remopro15'])?$_POST['remopro15']:(isset($info['remopro15'])?$info['remopro15']:'')).']'.
  '['.(isset($_POST['remopro16'])?$_POST['remopro16']:(isset($info['remopro16'])?$info['remopro16']:'')).']'.
  '['.(isset($_POST['remopro17'])?$_POST['remopro17']:(isset($info['remopro17'])?$info['remopro17']:'')).']'.
  '['.(isset($_POST['remopro18'])?$_POST['remopro18']:(isset($info['remopro18'])?$info['remopro18']:'')).']'.
  '['.(isset($_POST['remopro19'])?$_POST['remopro19']:(isset($info['remopro19'])?$info['remopro19']:'')).']'.
  '['.(isset($_POST['remopro20'])?$_POST['remopro20']:(isset($info['remopro20'])?$info['remopro20']:'')).']'.
  '['.(isset($_POST['remopro21'])?$_POST['remopro21']:(isset($info['remopro21'])?$info['remopro21']:'')).']'.
  '['.(isset($_POST['remopro22'])?$_POST['remopro22']:(isset($info['remopro22'])?$info['remopro22']:'')).']'.
  '['.(isset($_POST['remopro23'])?$_POST['remopro23']:(isset($info['remopro23'])?$info['remopro23']:'')).']'.
  '['.(isset($_POST['remopro24'])?$_POST['remopro24']:(isset($info['remopro24'])?$info['remopro24']:'')).']';
  $obstrabajo='';
  $notatrabajo='';
  if(isset($info['obstrabajo'])){
    $obstrabajo=$info['obstrabajo'];
  }
  if(isset($info['notatrabajo'])){
    $notatrabajo=$info['notatrabajo'];
  }
  $param['procedures'].="[$obstrabajo][$notatrabajo]";
  $param['procedures'].='['.(isset($_POST['firmtrabajo'])?$_POST['firmtrabajo']:(isset($info['firmtrabajo'])?$info['firmtrabajo']:'')).']';



  $param['file']=$info['removableid'];
  DBRemovableUpdateProcedure($param);
  echo "yes";
  exit;
}

if (isset($_POST["idfile"]) && is_numeric($_POST["idfile"]) && isset($_FILES["finalinput"]["name"]) &&
$_FILES["finalinput"]["name"]!="") {

    $type=myhtmlspecialchars($_FILES["finalinput"]["type"]);
    $size=myhtmlspecialchars($_FILES["finalinput"]["size"]);
    $name=myhtmlspecialchars($_FILES["finalinput"]["name"]);
    $temp=myhtmlspecialchars($_FILES["finalinput"]["tmp_name"]);
    if (!is_uploaded_file($temp)) {
      IntrusionNotify("problema al cargar el archivo.");
      echo "no";
      //ForceLoad("../index.php");//index.php
    }

  $param = array();
  $param['file'] = $_POST["idfile"];
  $param['inputfilename'] = $name;
  $param['inputfilepath'] = $temp;
  // actuliza un archivo el importa un archivo a base de datos y devuelve oid
  DBNewFinalInput ($_SESSION["usertable"]["usernumber"], $param);
  echo "Yes";//exito
  exit;
}
//para
if(isset($_POST['ficha'])&&isset($_POST['year'])&&isset($_POST['diagnosis'])&&isset($_POST['draw'])&&
isset($_POST['etiology'])&&isset($_POST['forecast'])&&isset($_POST['treatment'])&&
isset($_POST['radfecha'])&&isset($_POST['radvobo'])&&isset($_POST['radmaterial'])&&
isset($_POST['prefecha'])&&isset($_POST['prevobo'])&&isset($_POST['prematerial'])&&
isset($_POST['impfecha'])&&isset($_POST['impvobo'])&&isset($_POST['impmaterial'])&&
isset($_POST['modfecha'])&&isset($_POST['modvobo'])&&isset($_POST['modmaterial'])&&
isset($_POST['tomfecha'])&&isset($_POST['tomvobo'])&&isset($_POST['tommaterial'])&&
isset($_POST['monfecha'])&&isset($_POST['monvobo'])&&isset($_POST['monmaterial'])&&
isset($_POST['corfecha'])&&isset($_POST['corvobo'])&&isset($_POST['cormaterial'])&&
isset($_POST['talfecha'])&&isset($_POST['talvobo'])&&isset($_POST['talmaterial'])&&
isset($_POST['profecha'])&&isset($_POST['provobo'])&&isset($_POST['promaterial'])&&
isset($_POST['prufecha'])&&isset($_POST['pruvobo'])&&isset($_POST['prumaterial'])&&
isset($_POST['cemfecha'])&&isset($_POST['cemvobo'])&&isset($_POST['cemmaterial'])){


   $param=array();
   $info=DBFixedInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }
   $param['patientid'] = htmlspecialchars($_POST["patientid"]);
   $param['grade'] = '';
   if(isset($info['clinicalid'])&&$info['clinicalid']==10){
     $param['grade'] = htmlspecialchars("5to. Año");
   }elseif(isset($info['clinicalid'])&&$info['clinicalid']==2){
     $param['grade'] = htmlspecialchars("4to. Año");
   }

   $param['year'] = htmlspecialchars($_POST["year"]);
   $param['diagnosis'] = htmlspecialchars($_POST["diagnosis"]);
   $param['etiology'] = htmlspecialchars($_POST["etiology"]);
   $param['forecast'] = htmlspecialchars($_POST["forecast"]);
   $param['treatment'] = htmlspecialchars($_POST["treatment"]);

   $param['procedures']='radfecha<=>'.$_POST['radfecha'].':<=>:'.'radvobo<=>'.$_POST['radvobo'].':<=>:'.'radmaterial<=>'.$_POST['radmaterial'].'[-]'.
   'prefecha<=>'.$_POST['prefecha'].':<=>:'.'prevobo<=>'.$_POST['prevobo'].':<=>:'.'prematerial<=>'.$_POST['prematerial'].'[-]'.
   'impfecha<=>'.$_POST['impfecha'].':<=>:'.'impvobo<=>'.$_POST['impvobo'].':<=>:'.'impmaterial<=>'.$_POST['impmaterial'].'[-]'.
   'modfecha<=>'.$_POST['modfecha'].':<=>:'.'modvobo<=>'.$_POST['modvobo'].':<=>:'.'modmaterial<=>'.$_POST['modmaterial'].'[-]'.
   'tomfecha<=>'.$_POST['tomfecha'].':<=>:'.'tomvobo<=>'.$_POST['tomvobo'].':<=>:'.'tommaterial<=>'.$_POST['tommaterial'].'[-]'.
   'monfecha<=>'.$_POST['monfecha'].':<=>:'.'monvobo<=>'.$_POST['monvobo'].':<=>:'.'monmaterial<=>'.$_POST['monmaterial'].'[-]'.
   'corfecha<=>'.$_POST['corfecha'].':<=>:'.'corvobo<=>'.$_POST['corvobo'].':<=>:'.'cormaterial<=>'.$_POST['cormaterial'].'[-]'.
   'talfecha<=>'.$_POST['talfecha'].':<=>:'.'talvobo<=>'.$_POST['talvobo'].':<=>:'.'talmaterial<=>'.$_POST['talmaterial'].'[-]'.
   'profecha<=>'.$_POST['profecha'].':<=>:'.'provobo<=>'.$_POST['provobo'].':<=>:'.'promaterial<=>'.$_POST['promaterial'].'[-]'.
   'prufecha<=>'.$_POST['prufecha'].':<=>:'.'pruvobo<=>'.$_POST['pruvobo'].':<=>:'.'prumaterial<=>'.$_POST['prumaterial'].'[-]'.
   'cemfecha<=>'.$_POST['cemfecha'].':<=>:'.'cemvobo<=>'.$_POST['cemvobo'].':<=>:'.'cemmaterial<=>'.$_POST['cemmaterial'].'[-]';
   $conf=globalconf();
   $param['procedures'] = encryptData($param["procedures"], $conf["key"], false);
   $param['odontogram'] = encryptData($_POST["draw"], $conf["key"], false);


   $param['status'] = 'process';

   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['fixedid'];//id of clinical



   $ret=DBNewFixed($param);
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
   //echo "yes";
   exit;
}

if(isset($_POST['ficha'])&&
isset($_POST['radfecha'])&&isset($_POST['radvobo'])&&isset($_POST['radmaterial'])&&
isset($_POST['prefecha'])&&isset($_POST['prevobo'])&&isset($_POST['prematerial'])&&
isset($_POST['impfecha'])&&isset($_POST['impvobo'])&&isset($_POST['impmaterial'])&&
isset($_POST['modfecha'])&&isset($_POST['modvobo'])&&isset($_POST['modmaterial'])&&
isset($_POST['tomfecha'])&&isset($_POST['tomvobo'])&&isset($_POST['tommaterial'])&&
isset($_POST['monfecha'])&&isset($_POST['monvobo'])&&isset($_POST['monmaterial'])&&
isset($_POST['corfecha'])&&isset($_POST['corvobo'])&&isset($_POST['cormaterial'])&&
isset($_POST['talfecha'])&&isset($_POST['talvobo'])&&isset($_POST['talmaterial'])&&
isset($_POST['profecha'])&&isset($_POST['provobo'])&&isset($_POST['promaterial'])&&
isset($_POST['prufecha'])&&isset($_POST['pruvobo'])&&isset($_POST['prumaterial'])&&
isset($_POST['cemfecha'])&&isset($_POST['cemvobo'])&&isset($_POST['cemmaterial'])){


   $param=array();
   $info=DBFixedInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }

   $param['procedures']='radfecha<=>'.$_POST['radfecha'].':<=>:'.'radvobo<=>'.$_POST['radvobo'].':<=>:'.'radmaterial<=>'.$_POST['radmaterial'].'[-]'.
   'prefecha<=>'.$_POST['prefecha'].':<=>:'.'prevobo<=>'.$_POST['prevobo'].':<=>:'.'prematerial<=>'.$_POST['prematerial'].'[-]'.
   'impfecha<=>'.$_POST['impfecha'].':<=>:'.'impvobo<=>'.$_POST['impvobo'].':<=>:'.'impmaterial<=>'.$_POST['impmaterial'].'[-]'.
   'modfecha<=>'.$_POST['modfecha'].':<=>:'.'modvobo<=>'.$_POST['modvobo'].':<=>:'.'modmaterial<=>'.$_POST['modmaterial'].'[-]'.
   'tomfecha<=>'.$_POST['tomfecha'].':<=>:'.'tomvobo<=>'.$_POST['tomvobo'].':<=>:'.'tommaterial<=>'.$_POST['tommaterial'].'[-]'.
   'monfecha<=>'.$_POST['monfecha'].':<=>:'.'monvobo<=>'.$_POST['monvobo'].':<=>:'.'monmaterial<=>'.$_POST['monmaterial'].'[-]'.
   'corfecha<=>'.$_POST['corfecha'].':<=>:'.'corvobo<=>'.$_POST['corvobo'].':<=>:'.'cormaterial<=>'.$_POST['cormaterial'].'[-]'.
   'talfecha<=>'.$_POST['talfecha'].':<=>:'.'talvobo<=>'.$_POST['talvobo'].':<=>:'.'talmaterial<=>'.$_POST['talmaterial'].'[-]'.
   'profecha<=>'.$_POST['profecha'].':<=>:'.'provobo<=>'.$_POST['provobo'].':<=>:'.'promaterial<=>'.$_POST['promaterial'].'[-]'.
   'prufecha<=>'.$_POST['prufecha'].':<=>:'.'pruvobo<=>'.$_POST['pruvobo'].':<=>:'.'prumaterial<=>'.$_POST['prumaterial'].'[-]'.
   'cemfecha<=>'.$_POST['cemfecha'].':<=>:'.'cemvobo<=>'.$_POST['cemvobo'].':<=>:'.'cemmaterial<=>'.$_POST['cemmaterial'].'[-]';

   $conf=globalconf();
   $param['procedures'] = encryptData($param["procedures"], $conf["key"], false);
   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['fixedid'];//id of clinical

    DBFixedUpdateProcedure($param);
    echo "yes";
    exit;
}
if(isset($_POST['patientid'])&&isset($_POST['ficha'])&&
isset($_POST['hereditary'])&&isset($_POST['personal'])&&isset($_POST['psychological'])&&
isset($_POST['toothless'])&&isset($_POST['kenedysc'])&&isset($_POST['kenedysm'])&&
isset($_POST['kenedyic'])&&isset($_POST['kenedyim'])&&
isset($_POST['diagnosticobucal'])&&
isset($_POST['diagnosticodeque'])&&isset($_POST['diagnosticoduracion'])&&isset($_POST['diagnosticoresultado'])&&
isset($_POST['diagnosticoproblema'])&&isset($_POST['diagnosticodiente'])&&isset($_POST['hygiene'])&&
isset($_POST['cavities'])&&isset($_POST['central'])&&isset($_POST['bracesoption'])&&isset($_POST['bracesobs'])&&
isset($_POST['salivaoption'])&&isset($_POST['salivaobs'])&&isset($_POST['milohoideadesc'])&&
isset($_POST['milohoideaobs'])&&isset($_POST['alveolaresdesc'])&&isset($_POST['alveolaresobs'])&&
isset($_POST['tuberosidaddesc'])&&isset($_POST['tuberosidadobs'])&&isset($_POST['alveolardesc'])&&
isset($_POST['alveolarobs'])&&isset($_POST['palateoption'])&&isset($_POST['palateobs'])&&
isset($_POST['residual'])&&isset($_POST['faces'])&&isset($_POST['tez'])&&isset($_POST['profile'])&&
isset($_POST['prosthesis'])&&isset($_POST['interocclusal'])&&isset($_POST['planeocclusal'])&&
isset($_POST['anomaliesoption'])&&isset($_POST['anomaliesobs'])&&isset($_POST['parpilar1'])&&
isset($_POST['parpilar2'])&&isset($_POST['parpilar3'])&&isset($_POST['parpilar4'])&&
isset($_POST['parotros'])&&isset($_POST['parfavorable'])&&isset($_POST['parprobables'])&&
isset($_POST['paralteraciones'])&&isset($_POST['parobs'])&&isset($_POST['radpilar1'])&&
isset($_POST['radpilar2'])&&isset($_POST['radpilar3'])&&isset($_POST['radpilar4'])&&isset($_POST['radhueso'])&&
isset($_POST['apoyos'])&&isset($_POST['retencion'])&&isset($_POST['reciprocidad'])&&
isset($_POST['conector'])&&isset($_POST['indirecta'])&&isset($_POST['planos'])&&
isset($_POST['base'])&&isset($_POST['contornear'])){


   $param=array();
   $info=DBRemovableInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }
   $param['patientid'] = htmlspecialchars($_POST["patientid"]);

   $param['grade'] = '';
   if(isset($info['clinicalid'])&&$info['clinicalid']==9){
     $param['grade'] = htmlspecialchars("5to. Año");
   }elseif(isset($info['clinicalid'])&&$info['clinicalid']==1){
     $param['grade'] = htmlspecialchars("4to. Año");
   }

   $param['hereditary'] = htmlspecialchars($_POST['hereditary']);
   $param['personal'] = htmlspecialchars($_POST['personal']);
   $param['psychological'] = htmlspecialchars($_POST['psychological']);
   $param['toothless'] = htmlspecialchars($_POST['toothless']);
   $param['kenedy'] = '['.htmlspecialchars($_POST['kenedysc']).']'.
   '['.htmlspecialchars($_POST['kenedysm']).']'.
   '['.htmlspecialchars($_POST['kenedyic']).']'.
   '['.htmlspecialchars($_POST['kenedyim']).']';

   $param['diagnosis'] = '['.htmlspecialchars($_POST['diagnosticobucal']).']['.htmlspecialchars($_POST['diagnosticodeque']).']['.
   htmlspecialchars($_POST['diagnosticoduracion']).']['.htmlspecialchars($_POST['diagnosticoresultado']).']['.htmlspecialchars($_POST['diagnosticoproblema']).']['.htmlspecialchars($_POST['diagnosticodiente']).']';

   $param['hygiene'] = htmlspecialchars($_POST['hygiene']);//dentaltable

   $param['cavities'] = htmlspecialchars($_POST['cavities']);
   $param['central'] = htmlspecialchars($_POST['central']);
   $param['braces'] = '['.htmlspecialchars($_POST['bracesoption']).']['.htmlspecialchars($_POST['bracesobs']).']';
   $param['saliva'] = '['.htmlspecialchars($_POST['salivaoption']).']['.htmlspecialchars($_POST['salivaobs']).']';
   $param['interference'] = '['.htmlspecialchars($_POST['milohoideadesc']).']['.htmlspecialchars($_POST['milohoideaobs']).']['.
   htmlspecialchars($_POST['alveolaresdesc']).']['.htmlspecialchars($_POST['alveolaresdesc']).']['.
   htmlspecialchars($_POST['alveolaresobs']).']['.htmlspecialchars($_POST['tuberosidaddesc']).']['.htmlspecialchars($_POST['tuberosidadobs']).']['.
   htmlspecialchars($_POST['alveolardesc']).']['.htmlspecialchars($_POST['alveolarobs']).']';
   $param['palate'] = '['.htmlspecialchars($_POST['palateoption']).']['.htmlspecialchars($_POST['palateobs']).']';
   $param['residual'] = htmlspecialchars($_POST['residual']);

   $param['faces'] = htmlspecialchars($_POST['faces']);
   $param['tez'] = htmlspecialchars($_POST['tez']);
   $param['profile'] = htmlspecialchars($_POST['profile']);

   $param['prosthesis'] = htmlspecialchars($_POST['prosthesis']);
   $param['interocclusal'] = htmlspecialchars($_POST['interocclusal']);
   $param['planeocclusal'] = htmlspecialchars($_POST['planeocclusal']);

   $protesisfecha='';
   if(isset($info['protesisfecha'])){
     $protesisfecha=$info['protesisfecha'];
   }

   $param['specs'] = '['.htmlspecialchars($_POST['apoyos']).']'.
    '['.htmlspecialchars($_POST['retencion']).']'.
    '['.htmlspecialchars($_POST['reciprocidad']).']'.
    '['.htmlspecialchars($_POST['conector']).']'.
    '['.htmlspecialchars($_POST['indirecta']).']'.
    '['.htmlspecialchars($_POST['planos']).']'.
    '['.htmlspecialchars($_POST['base']).']'.
    '['.htmlspecialchars($_POST['contornear']).']'.
    '['.(isset($_POST['protesis'])?$_POST['protesis']:(isset($info['protesis'])?$info['protesis']:'')).']'.
    '['.$protesisfecha.']';

   $param['anomalies'] = '['.htmlspecialchars($_POST['anomaliesoption']).']['.htmlspecialchars($_POST['anomaliesobs']).']';
   $param['paralyzer'] = '['.htmlspecialchars($_POST['parpilar1']).']['.htmlspecialchars($_POST['parpilar2']).']['.
   htmlspecialchars($_POST['parpilar3']).']['.htmlspecialchars($_POST['parpilar4']).']['.htmlspecialchars($_POST['parotros']).']['.
   htmlspecialchars($_POST['parfavorable']).']['.htmlspecialchars($_POST['parprobables']).']['.htmlspecialchars($_POST['paralteraciones']).']['.
   htmlspecialchars($_POST['parobs']).']';
   $param['radiographic'] = '['.htmlspecialchars($_POST['radpilar1']).']['.htmlspecialchars($_POST['radpilar2']).']['.
   htmlspecialchars($_POST['radpilar3']).']['.htmlspecialchars($_POST['radpilar4']).']['.htmlspecialchars($_POST['radhueso']).']';

   $param['status'] = 'process';

   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['removableid'];//id of clinical

   $inforemission=DBPatientRemissionInfo($info['remissionid']);
   $param['dentalid']=$inforemission['patientdentalid'];

   DBUpdateDentalExamRemovible($param);//funcion para asignar examinacion de buco dental intra oral extra oral

   $ret=DBNewRemovable($param);
   //DBNewObservation($param);//registra una nueva observacion en una tabla aislado
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
   //echo "yes";
   exit;
}



?>
