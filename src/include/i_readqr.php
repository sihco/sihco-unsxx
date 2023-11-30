<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
//para autorizacion de firmas en cirugia bucal iii
if(isset($_POST['content'])&& isset($_POST['complementaryexam'])&& isset($_POST['remission'])&& is_numeric($_POST['remission'])&&
 $_POST['content']!=''&& $_POST['complementaryexam']!=''){
  $complementaryexam=htmlspecialchars(trim($_POST['complementaryexam']));

  $remission=htmlspecialchars(trim($_POST['remission']));

  $ret=DBSurgeryiiInfo($remission, true);
  if($ret==null){
    echo 3;
    exit;
  }
  $file=$ret['surgeryiiid'];
  /*$conf=globalconf();
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
        //aqui va la descripcion
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
  }*/
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
        //aqui va la descripcion
        $arraycomplementaryexam = array('laboratorio1' => 1,'laboratorio2' => 2,'laboratorio3' => 3,'laboratorio4' => 4,'laboratorio5' => 5,
        'histopatologico1' => 6,'histopatologico2' => 7,'histopatologico3' => 8,'histopatologico4' => 9,'diagenologia1' => 10,
        'diagenologia2' => 11,'diagenologia3' => 12,'diagenologia4' => 13,'diagenologia5' => 14,'diagenologia6' => 15,'fotografia1' => 16,
        'fotografia2' => 17,'fotografia3' => 18,'fotografia4' => 19,'fotografia5' => 20,'impresiones1' => 21,'impresiones2' => 22);
        if(isset($arraycomplementaryexam[$complementaryexam])){
           if(($ret=DBAuthorizationComplementaryexam($user, $time, $arraycomplementaryexam[$complementaryexam], $file))!==false){
             $infouser=DBUserInfo($user);
             $info=$ret;//explode(',', $ret);
             if($infouser['usertype']=='teacher'){
               $time=explode('*', $info);
               $time=trim($time[1]);
               $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                data-bs-target="#'.$complementaryexam.'_infoteacher" aria-expanded="true" aria-controls="'.$complementaryexam.'_infoteacher">Autorizado Por Docente</span>';
               $msg.='<div id="'.$complementaryexam.'_infoteacher" class="accordion-collapse collapse" aria-labelledby="'.$complementaryexam.'_infoteacher">'.
               '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
               echo $msg;
               exit;
             }else{
               echo 3;//"Tipo de usuario invalido";
               exit;
             }

           }else{
             echo 2;//"No se realizo la autorización"; 2
             exit;
           }
        }else{
          echo 1;//"Tecnica de anestesia no encontrado";
          exit;
        }


      }else{
        echo 5;
        exit;
      }
    }else{
      echo 4;
      exit;
    }

  }else{
    echo 0;
    exit;
  }



  $file=$ret['surgeryiiid'];
  $adata = explode(']', $data);
  if(is_array($adata)&& count($adata)==3){

    $user=explode('[',$adata[0]);
    $user=trim($user[1]);
    $time=explode('[',$adata[1]);
    $time=trim($time[1]);


  }else{
    echo 0;//"QR Invalido";
    exit;
  }

}

//para autorizacion de firmas para pre intra y post
if(isset($_POST['content'])&& isset($_POST['typefirm'])&& isset($_POST['remission'])&& isset($_POST['token'])&& is_numeric($_POST['remission'])&&
 $_POST['content']!=''&& $_POST['typefirm']!=''&& is_numeric($_POST['token'])){
  $conf=globalconf();
  $data=decryptData($_POST['content'], $conf["key"]);
  $typefirm=htmlspecialchars(trim($_POST['typefirm']));

  $remission=htmlspecialchars(trim($_POST['remission']));
  $token=htmlspecialchars(trim($_POST['token']));

  $ret=DBSurgeryiiInfo($remission, true);
  if($ret==null){
    echo 3;
    exit;
  }
  $file=$ret['remissionid'];
  $adata = explode(']', $data);

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
        //aqui va la descripcion
        $arraytypefirm = array('autorizacion' => 'authorization','seguimiento' => 'tracing','finalizacion'=>'ending');

        if(isset($arraytypefirm[$typefirm])){
           if(($ret=DBAuthorizationTypefirm($user, $time, $arraytypefirm[$typefirm], $file, $token))!==false){
             $infouser=DBUserInfo($user);
             $info=$ret;//explode(',', $ret);

             if($infouser['usertype']=='teacher'){
               $time=explode('*', $info);
               $time=trim($time[1]);
               $msg=$infouser['usertype'].'***<span style="cursor: pointer;"class="text-primary fst-italic" data-bs-toggle="collapse"
                data-bs-target="#'.$typefirm.'_infoteacher" aria-expanded="true" aria-controls="'.$typefirm.'_infoteacher">Autorizado Por Docente</span>';
               $msg.='<div id="'.$typefirm.'_infoteacher" class="accordion-collapse collapse" aria-labelledby="'.$typefirm.'_infoteacher">'.
               '<div class="accordion-body"><div class="row"><div class="col-12">'.$infouser['userfullname'].'</div><div class="col-12">'.datetimeconv($time).'</div></div></div></div>';
               echo $msg;
               exit;
             }else{
               echo 3;//"Tipo de usuario invalido";
               exit;
             }
           }else{
             echo 2;//"No se realizo la autorización"; 2
             exit;
           }
        }else{
          echo 1;//"Tecnica de anestesia no encontrado";
          exit;
        }
      }else{
        echo 5;
        exit;
      }
    }else{
      echo 4;
      exit;
    }
  }else{
    echo 0;
    exit;
  }

}
//para autorizacion de anestesia
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
