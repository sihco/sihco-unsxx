<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST['rh'])&& is_numeric($_POST['rh'])){

  $param['remissionid']=htmlspecialchars($_POST['rh']);
  $r=DBRemissionHistoryInfo2($param['remissionid']);
  if($r==null){
    echo "No Encontrado Historial Clínico";
    exit;
  }
  $param['patientid']=$r['patientid'];
  $param['patientadmissionid']=$r['patientadmissionid'];
  $param['clinicalid']=$r['clinicalid'];
  $param['studentid']=$r['studentid'];
  $param['studentclinicalid']=$r['studentclinicalid'];

  //es para qr del estudiante para que autorize
  if(isset($_POST['content'])&& trim($_POST['content'])!=''){
    $conf=globalconf();
    $data=decryptData($_POST['content'], $conf["key"]);
    $adata = explode(']', $data);
    if(is_array($adata)&& count($adata)==3){
      $user=explode('[',$adata[0]);
      $user=trim($user[1]);
      $time=explode('[',$adata[1]);
      $time=trim($time[1]);
      if(is_numeric($user)&& is_numeric($time)){
        $userinfo=DBUserInfo($user);
        if($userinfo['usertype']=='teacher'&& $time==$userinfo['userinfo']){
          $param['teacherid']=$userinfo['usernumber'];
          $param['status']='process';
        }else{
          echo "Qr no tiene permisos de autorización";
          exit;
        }
      }else{
        echo "Valor de Qr invalido";
        exit;
      }

    }else{
      echo "QR invalido";
      exit;
    }
  }else{
    if($_SESSION['usertable']['usertype']=='teacher'&& is_numeric($_SESSION['usertable']['usernumber'])){
      $param['teacherid']=$_SESSION['usertable']['usernumber'];
      $param['status']='process';
    }else{
      $param['teacherid']=$r['teacherid'];
      $param['teacherclinicalid']=$r['teacherclinicalid'];
    }
  }

  $acourse=array(3, 4,4,4,4,4,4,4,4, 5,5,5,5,5,5,5,5);
  $r=DBSpecialtyInfo($param['teacherid'] , $r['clinicalid'], $acourse[$r['clinicalid']-1]);
  if($r==null){
    echo "Docente no encotrado en la especialidad";
    exit;
  }
  $param['teacherid']=$r['userid'];
  $param['teacherclinicalid']=$r['clinicalid'];
  if(isset($_POST['endch'])&&$_POST['endch']=='true'){
    $teacher=$param['teacherid'];
    $param = array();
    $param['remissionid']=htmlspecialchars($_POST['ch']);
    $r=DBClinicHistoryInfo($param['remissionid']);
    if($r==null){
      echo "No Encontrado Historial Clínico";
      exit;
    }

    $param['reviewany']='t';
    $param['status']='end';
    $param['reviewteacher']=$r['reviewteacher'].'['.$teacher.'::=::::=::'.time().']';
    $param['reviewstatus']='t';
    DBUpdateExamClinichistory($param);//para finalizar ficha clinica
  }elseif (isset($_POST['canceledch'])&&$_POST['canceledch']=='true') {
    $teacher=$param['teacherid'];
    $param = array();
    $param['remissionid']=htmlspecialchars($_POST['ch']);
    $r=DBClinicHistoryInfo($param['remissionid']);
    if($r==null){
      echo "No Encontrado Historial Clínico";
      exit;
    }

    $param['reviewany']='t';
    $param['status']='canceled';
    $param['reviewteacher']=$r['reviewteacher'].'['.$teacher.'::=::::=::'.time().']';
    $param['reviewstatus']='t';
    DBUpdateExamClinichistory($param);//para finalizar ficha clinica
  }else{
    $param['authorized']='t';
    DBNewRemissionhistory($param, null, true);
  }
  echo 'yes';
  exit;
}
if (isset($_POST["clinical"]) && is_numeric($_POST["clinical"]) && isset($_POST["examinedid"]) &&
  isset($_POST["studentfullname"]) && isset($_POST["rem"]) && is_numeric($_POST["rem"])) {

   $param = array();
   $param['clinical'] = htmlspecialchars($_POST["clinical"]);
   $param['remissionid'] = htmlspecialchars($_POST["rem"]);
   $re=DBRemissionInfo(null, null, $param['remissionid']);
   if($re==null){
     echo "Remisión no encontrado";
     exit;
   }
   $param['remissionid']=$re['remissionid'];
   $param['patientadmissionid']=$re['patientadmissionid'];
   $param['patientid']=$re['patientid'];

   if(isset($_POST['studentfullname'])&&trim($_POST['studentfullname'])!="")
     $param['examined'] = htmlspecialchars($_POST["studentfullname"]);
   if(isset($_POST['examinedid'])&&is_numeric($_POST['examinedid']))
     $param['examinedid'] = htmlspecialchars($_POST["examinedid"]);
   //$param['admission']=$_SESSION["usertable"]["usernumber"];
   if(!isset($param['examinedid'])&&
   isset($param['clinical'])&& isset($param['examined'])){
     $a=DBUserDesignedInfoFullname($param['examined'],$param["clinical"]);
     if($a==null){
       echo "Estudiante no encontrado";
       exit;
     }
     $param["examined"]=$a["user"];
   }else{
     if(isset($param['examinedid']) && is_numeric($param['examinedid']) && isset($param['clinical'])){
         $a=DBUserDesignedInfo($param['examinedid'], $param['clinical']);
         if($a==null){
           echo "Estudiante no encontrado";
           exit;
         }
         $param["examined"]=$a["user"];
     }
   }

   if(trim($param['examined'])==null || !is_numeric($param['examined'])){
     echo "Estudiante no encontrado";
     exit;
   }
   $param['studentid']=$param['examined'];
   $param['studentclinicalid']=$param['clinical'];
   $param['teacherid']=$_SESSION['usertable']['usernumber'];
   $param['teacherclinicalid']=$param['clinical'];
   $param['status']='process';

   DBNewClinichistory($param, null, true);
   echo "yes";

   exit;
}

if (isset($_POST["formch"]) && is_numeric($_POST["formch"]) && isset($_FILES["finalinput"]["name"]) &&
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
  $param['idre'] = $_POST["formch"];
  $param['inputfilename'] = $name;
  $param['inputfilepath'] = $temp;

  $r=DBClinicHistoryInfo($param['idre']);
  if($r==null){
    echo "No Encontrado Historial Clínico";
    exit;
  }
  // actuliza un archivo el importa un archivo a base de datos y devuelve oid
  $ret=DBNewEndInputData ($_SESSION["usertable"]["usernumber"], $param);
  DBUpdateReviewStatus($param['idre'], false);
  echo "Yes";//exito
  exit;
}
if(isset($_POST['formch'])&& is_numeric($_POST['formch'])&&
  isset($_POST['status'])&& isset($_POST['obsdesc'])){
    $param = array();
    $param['remissionid']=htmlspecialchars($_POST['formch']);
    $r=DBRemissionHistoryInfo2($param['remissionid']);
    if($r==null){
      echo "No Encontrado Historial Clínico";
      exit;
    }

    if(isset($_POST['evaluated'])&&trim($_POST['evaluated'])!=''){
      $param['reviewany']=htmlspecialchars($_POST['evaluated']);
    }else{
      $param['reviewany']=$r['reviewany'];
    }

    if(($_POST['status'])!='')
      $param['status']=htmlspecialchars($_POST['status']);
    $teacher=$_SESSION['usertable']['usernumber'];
    $param['reviewteacher']=$r['reviewteacher'].'['.$teacher.'::=::'.htmlspecialchars($_POST['obsdesc']).'::=::'.time().']';
    $param['reviewstatus']='t';
    DBUpdateExamClinichistory($param);
    echo "yes";
    exit;
}

?>
