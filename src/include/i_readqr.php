<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST['content'])&& isset($_POST['anesthesia'])&& isset($_POST['remission'])&& is_numeric($_POST['remission'])&&
 $_POST['content']!=''&& $_POST['anesthesia']!=''){
  $conf=globalconf();
  $data=decryptData($_POST['content'], $conf["key"]);
  $anesthesia=htmlspecialchars(trim($_POST['anesthesia']));

  $remission=htmlspecialchars(trim($_POST['remission']));

  $ret=DBSurgeryiiInfo($remission, true);
  if($ret==null){
    echo 3;
    exit;
  }
  $file=$ret['surgeryiiid'];
  $adata = explode(']', $data);
  if(is_array($adata)&& count($adata)==3){
    $user=explode('[',$adata[0]);
    $user=trim($user[1]);
    $time=explode('[',$adata[1]);
    $time=trim($time[1]);
    $arrayanesthesia = array('spix' => 1, 'mentoniana' => 2, 'local' => 3, 'infraorbitaria' => 4, 'tuberositaria' => 5, 'carrea' => 6);
    if(isset($arrayanesthesia[$anesthesia])){
       if(($ret=DBAuthorizationAnesthesia($user, $time, $arrayanesthesia[$anesthesia], $file))!==false){
         $infouser=DBUserInfo($user);
         $info=explode(',', $ret);
         if($infouser['usertype']=='teacher'){
           $time=explode('*', $info[0]);
           $time=trim($time[1]);
           $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
            data-bs-target="#'.$anesthesia.'_infoteacher" aria-expanded="true" aria-controls="'.$anesthesia.'_infoteacher">Autorizado Por Docente</span>';
           $msg.='<div id="'.$anesthesia.'_infoteacher" class="accordion-collapse collapse" aria-labelledby="'.$anesthesia.'_infoteacher">'.
           '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
           echo $msg;
           exit;
         }elseif ($infouser['usertype']=='nursing') {
           $time=explode('*', $info[1]);
           $time=trim($time[1]);
           $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
            data-bs-target="#'.$anesthesia.'_infonursing" aria-expanded="true" aria-controls="'.$anesthesia.'_infonursing">Despachado</span>';
           $msg.='<div id="'.$anesthesia.'_infonursing" class="accordion-collapse collapse" aria-labelledby="'.$anesthesia.'_infonursing">'.
           '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
           echo $msg;
           //echo "('#a_spixnursing').html($msg)";
           exit;
         }else{
           echo 3;//"Tipo de usuario invalido";
           exit;
         }

       }else{
         echo 2;//"No se realizo la autorización";
         exit;
       }
    }else{
      echo 1;//"Tecnica de anestesia no encontrado";
      exit;
    }
  }else{
    echo 0;//"QR Invalido";
    exit;
  }

}

if(isset($_POST['anesthesia'])&& isset($_POST['remission'])&& is_numeric($_POST['remission'])&&
 $_POST['anesthesia']!=''){
  $anesthesia=htmlspecialchars(trim($_POST['anesthesia']));

  $remission=htmlspecialchars(trim($_POST['remission']));

  $ret=DBSurgeryiiInfo($remission, true);
  if($ret==null){
    echo 3;
    exit;
  }
  $file=$ret['surgeryiiid'];
  $arrayanesthesia = array('spix' => 1, 'mentoniana' => 2, 'local' => 3, 'infraorbitaria' => 4, 'tuberositaria' => 5, 'carrea' => 6);
  $user=$_SESSION['usertable']['usernumber'];
  if(isset($arrayanesthesia[$anesthesia])){
       if(($ret=DBAuthorizationAnesthesia($user, null, $arrayanesthesia[$anesthesia], $file))!==false){
         $infouser=DBUserInfo($user);
         $info=explode(',', $ret);

         if($infouser['usertype']=='teacher'){
           $time=explode('*', $info[0]);
           $time=trim($time[1]);
           $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
            data-bs-target="#'.$anesthesia.'_infoteacher" aria-expanded="true" aria-controls="'.$anesthesia.'_infoteacher">Autorizado Por Docente</span>';
           $msg.='<div id="'.$anesthesia.'_infoteacher" class="accordion-collapse collapse" aria-labelledby="'.$anesthesia.'_infoteacher">'.
           '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
           echo $msg;
           exit;
         }elseif ($infouser['usertype']=='nursing') {
           $time=explode('*', $info[1]);
           $time=trim($time[1]);
           $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-success fst-italic" data-bs-toggle="collapse"
            data-bs-target="#'.$anesthesia.'_infonursing" aria-expanded="true" aria-controls="'.$anesthesia.'_infonursing">Despachado</span>';
           $msg.='<div id="'.$anesthesia.'_infonursing" class="accordion-collapse collapse" aria-labelledby="'.$anesthesia.'_infonursing">'.
           '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
           echo $msg;
           //echo "('#a_spixnursing').html($msg)";
           exit;
         }else{
           echo 3;//"Tipo de usuario invalido";
           exit;
         }

       }else{
         echo 2;//"No se realizo la autorización";
         exit;
       }
  }else{
      echo 1;//"Tecnica de anestesia no encontrado";
      exit;
  }

}
?>
