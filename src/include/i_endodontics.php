<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST['idficha'])&&isset($_POST['obturacion'])&&
  isset($_POST['treatmentdesc'])&&isset($_POST['treatmentdate'])){
    $size=0;
    $treat='';
    $treat='['.trim($_POST['treatmentdesc']).']['.trim($_POST['treatmentdate']).']';
    if(!empty($_POST['treatmentfirm'])){
      $treat.="[t]";
    }else{
      $treat.='[]';
    }
    $treatment="";
    //print_r($_POST['preparacion']);
    $data=DBEndodonticsInfo($_POST['idficha']);

    if(isset($data['tableprocedures']['pieza']))
      $size=count($data['tableprocedures']['pieza']);//tamaño de la tabla
    if($size<=0)
      exit;
    for ($i=0; $i < $size; $i++) {
      $treatment.="{";
      if(isset($data["tableprocedures"]['pieza'][$i])){
        $treatment.="[".$data["tableprocedures"]['pieza'][$i]."]";
      }else{
        $treatment.="[]";
      }
      if(isset($data["tableprocedures"]['clase'][$i])){
        $treatment.="[".$data["tableprocedures"]['clase'][$i]."]";
      }else{
        $treatment.="[]";
      }
      if(!empty($_POST['caries'])&&array_search($i, $_POST['caries'])!==false){
        $log=explode('=',$data['tableprocedures']['caries'][$i]);
        if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
          $treatment.="[".$data['tableprocedures']['caries'][$i]."]";
        }else{
          $treatment.="[t=".time().']';
        }
      }else{
        if(isset($data["tableprocedures"]['caries'][$i])){
          $log=explode('=',$data['tableprocedures']['caries'][$i]);
          if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
            $treatment.="[f]";
          }else{
            $treatment.="[".$data['tableprocedures']['caries'][$i]."]";
          }
        }else{
          $treatment.="[]";
        }
      }

      if(!empty($_POST['inicio'])&&array_search($i, $_POST['inicio'])!==false){
        $log=explode('=',$data['tableprocedures']['inicio'][$i]);
        if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
          $treatment.="[".$data['tableprocedures']['inicio'][$i]."]";
        }else{
          $treatment.="[t=".time().']';
        }
      }else{
        if(isset($data["tableprocedures"]['inicio'][$i])){
          $log=explode('=',$data['tableprocedures']['inicio'][$i]);
          if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
            $treatment.="[f]";
          }else{
            $treatment.="[".$data['tableprocedures']['inicio'][$i]."]";
          }
        }else{
          $treatment.="[]";
        }
      }
      if(!empty($_POST['preparacion'])&&array_search($i, $_POST['preparacion'])!==false){
        $log=explode('=',$data['tableprocedures']['preparacion'][$i]);
        if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
          $treatment.="[".$data['tableprocedures']['preparacion'][$i]."]";
        }else{
          $treatment.="[t=".time().']';
        }
      }else{
        if(isset($data["tableprocedures"]['preparacion'][$i])){
          $log=explode('=',$data['tableprocedures']['preparacion'][$i]);
          if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
            $treatment.="[f]";
          }else{
            $treatment.="[".$data['tableprocedures']['preparacion'][$i]."]";
          }
        }else{
          $treatment.="[]";
        }
      }
      if(!empty($_POST['cavitaria'])&&array_search($i, $_POST['cavitaria'])!==false){
        $log=explode('=',$data['tableprocedures']['cavitaria'][$i]);
        if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
          $treatment.="[".$data['tableprocedures']['cavitaria'][$i]."]";
        }else{
          $treatment.="[t=".time().']';
        }
      }else{
        if(isset($data["tableprocedures"]['cavitaria'][$i])){
          $log=explode('=',$data['tableprocedures']['cavitaria'][$i]);
          if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
            $treatment.="[f]";
          }else{
            $treatment.="[".$data['tableprocedures']['cavitaria'][$i]."]";
          }
        }else{
          $treatment.="[]";
        }
      }



      $treatment.="[".$_POST['obturacion'][$i]."]";
      if(!empty($_POST['pulido'])&&array_search($i, $_POST['pulido'])!==false){
        $log=explode('=',$data['tableprocedures']['pulido'][$i]);
        if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
          $treatment.="[".$data['tableprocedures']['pulido'][$i]."]";
        }else{
          $treatment.="[t=".time().']';
        }
      }else{
        if(isset($data["tableprocedures"]['pulido'][$i])){
          $log=explode('=',$data['tableprocedures']['pulido'][$i]);
          if($log[0]=='t'&&isset($log[1])&&is_numeric($log[1])){
            $treatment.="[f]";
          }else{
            $treatment.="[".$data['tableprocedures']['pulido'][$i]."]";
          }
        }else{
          $treatment.="[]";
        }
      }

      $treatment.="}";
    }

    DBUpdateEndodonticsTreament($data['endodonticsid'],$treatment, $treat);
    //echo $treatment;
    echo "yes";
  exit;
}
if(isset($_POST['idficha'])&&isset($_POST['pieza'])&&isset($_POST['clase'])){
  $size=count($_POST['pieza']);
  $treatment="";
  //print_r($_POST['preparacion']);
  $data=DBEndodonticsInfo($_POST['idficha']);

  $sw=false;
  if(isset($data["tableprocedures"]['pieza']))
    $sw=true;
  for ($i=0; $i < $size; $i++) {
    $treatment.="{";
    $treatment.="[".$_POST['pieza'][$i]."]";
    $treatment.="[".$_POST['clase'][$i]."]";
    $sw=false;
    if(!empty($_POST['caries'])&&array_search($i, $_POST['caries'])!==false){
      $treatment.="[f]";
    }else{
      if(isset($data["tableprocedures"]['caries'][$i])){
        $log=explode('=',$data['tableprocedures']['caries'][$i]);
        if($log[0]=='f'){
          $treatment.="[]";
        }else{
          $treatment.="[".$data['tableprocedures']['caries'][$i]."]";
        }
      }else{
        $treatment.="[]";
      }
    }
    if(!empty($_POST['inicio'])&&array_search($i, $_POST['inicio'])!==false){
      $treatment.="[f]";
    }else{
      if(isset($data["tableprocedures"]['inicio'][$i])){
        $log=explode('=',$data['tableprocedures']['inicio'][$i]);
        if($log[0]=='f'){
          $treatment.="[]";
        }else{
          $treatment.="[".$data['tableprocedures']['inicio'][$i]."]";
        }
      }else{
        $treatment.="[]";
      }
    }
    if(!empty($_POST['preparacion'])&&array_search($i, $_POST['preparacion'])!==false){
      $treatment.="[f]";
    }else{
      if(isset($data["tableprocedures"]['preparacion'][$i])){
        $log=explode('=',$data['tableprocedures']['preparacion'][$i]);
        if($log[0]=='f'){
          $treatment.="[]";
        }else{
          $treatment.="[".$data['tableprocedures']['preparacion'][$i]."]";
        }
      }else{
        $treatment.="[]";
      }
    }
    if(!empty($_POST['cavitaria'])&&array_search($i, $_POST['cavitaria'])!==false){
      $treatment.="[f]";
    }else{
      if(isset($data["tableprocedures"]['cavitaria'][$i])){
        $log=explode('=',$data['tableprocedures']['cavitaria'][$i]);
        if($log[0]=='f'){
          $treatment.="[]";
        }else{
          $treatment.="[".$data['tableprocedures']['cavitaria'][$i]."]";
        }
      }else{
        $treatment.="[]";
      }
    }
    if(isset($data["tableprocedures"]['obturacion'][$i])){
      $treatment.="[".$data['tableprocedures']['obturacion'][$i]."]";
    }else{
      $treatment.="[]";
    }
    if(!empty($_POST['pulido'])&&array_search($i, $_POST['pulido'])!==false){
      $treatment.="[f]";
    }else{
      if(isset($data["tableprocedures"]['pulido'][$i])){
        $log=explode('=',$data['tableprocedures']['pulido'][$i]);
        if($log[0]=='f'){
          $treatment.="[]";
        }else{
          $treatment.="[".$data['tableprocedures']['pulido'][$i]."]";
        }
      }else{
        $treatment.="[]";
      }
    }
    $treatment.="}";
  }
  DBUpdateEndodonticsTreament($data['endodonticsid'],$treatment);
  //echo $treatment;
  echo "yes";
  exit;
}
if(isset($_POST['ficha'])&&isset($_POST['patientid'])&&isset($_POST['year'])&&
  isset($_POST['jobs'])&&isset($_POST['draw'])){

   $param=array();
   $info=DBEndodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
   if($info==null){
     echo "No Registrado";
     exit;
   }
   $param['patientid'] = htmlspecialchars($_POST["patientid"]);
   $param['grade'] = htmlspecialchars("4to. Año");
   if(isset($info['clinicalid'])==12){
     $param['grade'] = htmlspecialchars("5to. Año");
   }
   $param['year'] = htmlspecialchars($_POST["year"]);
   $param['jobs'] = htmlspecialchars($_POST["jobs"]);
   $conf=globalconf();
   $param['odontogram'] = encryptData($_POST["draw"], $conf["key"], false);


   $param['status'] = 'process';

   $param['student'] = $info['student'];
   $param['teacher'] = $info['teacher'];
   $param['clinical'] = $info['clinicalid'];
   $param['remissionid'] = $info['remissionid'];
   $param['file'] = $info['endodonticsid'];//id of clinical



   $ret=DBNewEndodontics($param);
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
if(isset($_POST['ficha'])&&is_numeric($_POST['ficha'])&&isset($_POST['materials'])){
  $info=DBEndodonticsInfo(htmlspecialchars(trim($_POST["ficha"])));
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $materials=htmlspecialchars(trim($_POST['materials']));
  DBUpdateEndodonticsMaterial($info['endodonticsid'],$materials);
  echo "yes";
  exit;
}

?>
