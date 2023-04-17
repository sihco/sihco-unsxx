<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
//funcion para actualizar datos
if(isset($_POST['idupdate'])&&is_numeric($_POST['idupdate'])){
  $data=DBSurgeryTokenInfo($_POST['idupdate']);
  header('Content-type: application/json; charset=utf-8');
  echo json_encode($data);
}

if(isset($_POST['fileid'])&&is_numeric($_POST['fileid'])&&
  isset($_POST['token'])&&$_POST['token']&&
  isset($_POST['start'])&&$_POST['start']&&
  isset($_POST['proces'])&&$_POST['proces']&&
  isset($_POST['end'])&&$_POST['end']&&
  isset($_POST['obsintra'])&&$_POST['obsintra']&&
  isset($_POST['obspost'])&&$_POST['obspost']){
  $file=htmlspecialchars(trim($_POST['fileid']));
  $data=DBAllSurgeryTokenInfo($file);
  $size1=count($data);
  $token=explode(',',$_POST['token']);
  $start=explode(',',$_POST['start']);
  $proces=explode(',',$_POST['proces']);
  $end=explode(',',$_POST['end']);
  $intra=explode(',',$_POST['obspost']);
  $post=explode(',',$_POST['obspost']);
  $size2=count($token)-1;
  if($size1==$size2){
    for ($i=0; $i < $size1; $i++) {

      if ($start[$i]=='true') {
        $start[$i]=$_SESSION['usertable']['usernumber'];
      }elseif($start[$i]=='false'){
        $start[$i]='true';
      }else{
        $start[$i]=$data[$i]['tokenauthorization'];
      }
      if ($proces[$i]=='true') {
        $proces[$i]=$_SESSION['usertable']['usernumber'];
      }elseif($proces[$i]=='true'){
        $proces[$i]='true';
      }else{
        $proces[$i]=$data[$i]['tokentracing'];
      }
      if ($end[$i]=='true') {
        $end[$i]=$_SESSION['usertable']['usernumber'];
      }elseif($end[$i]=='false'){
        $end[$i]='true';
      }else{
        $end[$i]=$data[$i]['tokenending'];
      }
      DBUpdateSurgeryToken($file, $token[$i], $start[$i], $proces[$i], $end[$i], $intra[$i], $post[$i]);
    }
    echo "yes";
  }else{
    echo "Error en guardar datos";
  }
  exit;
}
if(isset($_POST['id'])&&is_numeric($_POST['id'])){
  $data=DBSurgeryTokenInfo($_POST['id']);
  if(DBDeleteSurgeryToken($_POST['id'])===true){
    if($data!=null&&$data['fileid']!=''){//e
      $a=DBAllSurgeryTokenInfo($data['fileid'], true);
      echo $a;
    }else{
      echo "No";
    }
  }else{
    echo "No";
  }
}


?>
