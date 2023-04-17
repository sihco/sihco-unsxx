<?php
session_start();
require_once('../db.php');
require_once('../globals.php');

if(isset($_POST["userid"]) && isset($_POST["userfullname"]) && isset($_POST["clinical"])) {
    //funcion para mofigicar algunos caracteres especiales para htmlentities sin &
    $param['user'] = myhtmlspecialchars($_POST["userid"]);
    $param['fullname'] = myhtmlspecialchars($_POST["userfullname"]);
    $a;
    if($_POST["userid"]==""){
      //$c=null,$hashpass=true, $usertypediff=null
      //$a=DBUserInfoFullname($param["fullname"]);
      $a=DBUserInfoFullname($param["fullname"], null, true, 'admission');
      if($a==null){
        echo "Usuario no encotrado en la base de datos";
        exit;
      }
      $param['user']=$a["usernumber"];

    }
    $param['clinical'] = myhtmlspecialchars($_POST["clinical"]);
    $a=DBNewSpecialty($param);
    if ($a==2) {
      echo "Usuario Designado";
    }else{
      echo "El usuario ".$param['user']." ya esta designado a especialidad ".$param["clinical"];
    }
    exit;
}
if(isset($_POST['userid'])&&is_numeric($_POST['userid'])&&
isset($_POST['clinicalid'])&&is_numeric($_POST['clinicalid'])&&
isset($_POST['status'])){
  $usinfo=DBSpecialtyUserInfo(myhtmlspecialchars($_POST["userid"]), myhtmlspecialchars($_POST["clinicalid"]));
  if($usinfo==null){
    echo "Usuario no encontrado";
    exit;
  }
  $status=myhtmlspecialchars($_POST["status"]);

  if($status=='f'){
    $status='f';
  }else{
    $status='t';
  }
  if(!isset($_SESSION['usertable'])){
    echo "Se cerro la sesión";
    exit;
  }
  if($_SESSION['usertable']['usertype'] == 'student'){
    $status='f';
  }
  $r=DBUpdateSpecialtyEnabled($usinfo['userid'],$usinfo['clinicalid'],$status);
  if($r==2){
    if($status=='f'){
      echo "Se inactivó la designación";
    }elseif ($status=='t') {
      echo "Se activó la designación";
    }else{
      echo "No registrado";
    }
  }else{
    echo "Error, no se guardó los cambios";
  }
  exit;
}
?>
