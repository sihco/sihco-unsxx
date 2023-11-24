<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");
if(isset($_POST['idfilepageteacher'])&&is_numeric($_POST['idfilepageteacher'])){
  $param['ficha']=htmlspecialchars(trim($_POST['idfilepageteacher']));
  $info=DBSurgeryiiInfo(htmlspecialchars(trim($_POST["idfilepageteacher"])));//informacion de ficha clinica de cirugia bucal iii
  $idteacher=$_SESSION['usertable']['usernumber'];
  $param['complementaryexam']='{'.
  '['.(isset($_POST['laboratorio1'])&&$_POST['laboratorio1']=='true'?$idteacher:(isset($info['laboratorio1'])?$info['laboratorio1']:'')).']'.
  '['.(isset($_POST['laboratorio2'])&&$_POST['laboratorio2']=='true'?$idteacher:(isset($info['laboratorio2'])?$info['laboratorio2']:'')).']'.
  '['.(isset($_POST['laboratorio3'])&&$_POST['laboratorio3']=='true'?$idteacher:(isset($info['laboratorio3'])?$info['laboratorio3']:'')).']'.
  '['.(isset($_POST['laboratorio4'])&&$_POST['laboratorio4']=='true'?$idteacher:(isset($info['laboratorio4'])?$info['laboratorio4']:'')).']'.
  '['.(isset($_POST['laboratorio5'])&&$_POST['laboratorio5']=='true'?$idteacher:(isset($info['laboratorio5'])?$info['laboratorio5']:'')).']}'.

  '{['.(isset($_POST['histopatologico1'])&&$_POST['histopatologico1']=='true'?$idteacher:(isset($info['histopatologico1'])?$info['histopatologico1']:'')).']'.
  '['.(isset($_POST['histopatologico2'])&&$_POST['histopatologico2']=='true'?$idteacher:(isset($info['histopatologico2'])?$info['histopatologico2']:'')).']'.
  '['.(isset($_POST['histopatologico3'])&&$_POST['histopatologico3']=='true'?$idteacher:(isset($info['histopatologico3'])?$info['histopatologico3']:'')).']'.
  '['.(isset($_POST['histopatologico4'])&&$_POST['histopatologico4']=='true'?$idteacher:(isset($info['histopatologico4'])?$info['histopatologico4']:'')).']}'.

  '{['.(isset($_POST['diagenologia1'])&&$_POST['diagenologia1']=='true'?$idteacher:(isset($info['diagenologia1'])?$info['diagenologia1']:'')).']'.
  '['.(isset($_POST['diagenologia2'])&&$_POST['diagenologia2']=='true'?$idteacher:(isset($info['diagenologia2'])?$info['diagenologia2']:'')).']'.
  '['.(isset($_POST['diagenologia3'])&&$_POST['diagenologia3']=='true'?$idteacher:(isset($info['diagenologia3'])?$info['diagenologia3']:'')).']'.
  '['.(isset($_POST['diagenologia4'])&&$_POST['diagenologia4']=='true'?$idteacher:(isset($info['diagenologia4'])?$info['diagenologia4']:'')).']'.
  '['.(isset($_POST['diagenologia5'])&&$_POST['diagenologia5']=='true'?$idteacher:(isset($info['diagenologia5'])?$info['diagenologia5']:'')).']'.
  '['.(isset($_POST['diagenologia6'])&&$_POST['diagenologia6']=='true'?$idteacher:(isset($info['diagenologia6'])?$info['diagenologia6']:'')).']}'.
  '{['.(isset($_POST['fotografia1'])&&$_POST['fotografia1']=='true'?$idteacher:(isset($info['fotografia1'])?$info['fotografia1']:'')).']'.
  '['.(isset($_POST['fotografia2'])&&$_POST['fotografia2']=='true'?$idteacher:(isset($info['fotografia2'])?$info['fotografia2']:'')).']'.
  '['.(isset($_POST['fotografia3'])&&$_POST['fotografia3']=='true'?$idteacher:(isset($info['fotografia3'])?$info['fotografia3']:'')).']'.
  '['.(isset($_POST['fotografia4'])&&$_POST['fotografia4']=='true'?$idteacher:(isset($info['fotografia4'])?$info['fotografia4']:'')).']'.
  '['.(isset($_POST['fotografia5'])&&$_POST['fotografia5']=='true'?$idteacher:(isset($info['fotografia5'])?$info['fotografia5']:'')).']}'.

  '{['.(isset($_POST['impresiones1'])&&$_POST['impresiones1']=='true'?$idteacher:(isset($info['impresiones1'])?$info['impresiones1']:'')).']'.
  '['.(isset($_POST['impresiones2'])&&$_POST['impresiones2']=='true'?$idteacher:(isset($info['impresiones2'])?$info['impresiones2']:'')).']}';
  $param['file'] = $info['surgeryiiid'];//id of clinical
  DBUpdateComplementaryExam($param);//para actualizar examenes complementario
  echo "yes";
  exit;
}
//sentencia para registrar datos de la ficha clinica surgery iii
if(isset($_POST['ficha'])&& isset($_POST['remission'])&& isset($_POST['practice'])&&  isset($_POST['motconsult'])&&
isset($_POST['historiaconsulta'])&&  isset($_POST['anamnesisfamiliar'])&&
isset($_POST['remota1'])&&  isset($_POST['obsremota1'])&&  isset($_POST['remota2'])&&
isset($_POST['obsremota2'])&&  isset($_POST['remota3'])&&  isset($_POST['obsremota3'])&&
isset($_POST['remota4a'])&&  isset($_POST['remota4b1'])&&  isset($_POST['remota4b2'])&&
isset($_POST['remota4b3'])&&  isset($_POST['remota4b4'])&&  isset($_POST['remota4b5'])&&
isset($_POST['remota4c'])&&  isset($_POST['remota4d'])&&  isset($_POST['remota4e'])&&
isset($_POST['remota4f1'])&&  isset($_POST['remota4f2'])&&  isset($_POST['remota4f3'])&&
isset($_POST['remota4g'])&&  isset($_POST['remota4h'])&&  isset($_POST['remota4i'])&&
isset($_POST['remota4j'])&&  isset($_POST['remota4k'])&&  isset($_POST['remota4l'])&&
isset($_POST['remota4m'])&&  isset($_POST['remota4n'])&&  isset($_POST['remota51'])&&
isset($_POST['remota52'])&&  isset($_POST['remota53'])&&  isset($_POST['obsremota53'])&&
isset($_POST['remota6'])&&  isset($_POST['remota7'])&&  isset($_POST['remota81'])&&
isset($_POST['remota82'])&&  isset($_POST['remota83'])&&  isset($_POST['remota84'])&&
isset($_POST['remota85'])&&  isset($_POST['remota86'])&&  isset($_POST['remota87'])&&
isset($_POST['remota88'])&&  isset($_POST['remota89'])&&  isset($_POST['remota810'])&&
isset($_POST['remota811'])&&  isset($_POST['remota812'])&&  isset($_POST['remota9'])&&
isset($_POST['obsremota9'])&&  isset($_POST['remota10'])&&
isset($_POST['remota12'])&&  isset($_POST['obsremota12'])&&
isset($_POST['historia1'])&&  isset($_POST['obshistoria1'])&&  isset($_POST['historia2'])&&
isset($_POST['historia3'])&&  isset($_POST['historia4'])&&  isset($_POST['historia5'])&&
isset($_POST['historia6'])&&  isset($_POST['historia7'])&&  isset($_POST['historia8'])&&
isset($_POST['obshistoria8'])&&  isset($_POST['arterial'])&&  isset($_POST['cardiaca'])&&
isset($_POST['respiratoria'])&&  isset($_POST['torax'])&&  isset($_POST['abdomen'])&&
isset($_POST['extremidades'])&&  isset($_POST['faneras'])&&  isset($_POST['neurologico'])&&
isset($_POST['cuello'])&&  isset($_POST['craneo'])&&  isset($_POST['cara'])&&  isset($_POST['musculos'])&&
isset($_POST['linfaticos'])&&  isset($_POST['atm'])&&  isset($_POST['salivales'])&&
isset($_POST['vestibulo'])&&  isset($_POST['anterior'])&&  isset($_POST['superior'])&&
isset($_POST['posterior'])&&  isset($_POST['inferior'])&&  isset($_POST['laterales'])&& isset($_POST['language'])&&
isset($_POST['encias'])&& isset($_POST['draw'])&&  isset($_POST['asa'])&& isset($_POST['nivelansiedad1'])&& isset($_POST['nivelansiedad2'])&& isset($_POST['nivelansiedad3'])&& isset($_POST['nivelansiedad4'])&&
isset($_POST['hipotesisdiagnostica'])&& isset($_POST['complementaryexam'])&& isset($_POST['finaldiagnostica'])&&
isset($_POST['gradodificultad1'])&&  isset($_POST['gradodificultad2'])&&  isset($_POST['gradodificultad3'])&&
isset($_POST['inmediato'])&&  isset($_POST['mediato'])){

$param['ficha']=htmlspecialchars(trim($_POST['ficha']));
$info_r=DBRemissionhistoryInfo2(htmlspecialchars(trim($_POST["remission"])));//informacion de ficha clinica de cirugia bucal iii
if(!empty($_POST["ficha"]))
  $info=DBSurgeryiiInfo(htmlspecialchars(trim($_POST["ficha"])));//informacion de ficha clinica de cirugia bucal iii

$param['practice']=htmlspecialchars(trim($_POST['practice']));
$param['motconsult']='['.htmlspecialchars(trim($_POST['motconsult'])).']'.
'['.htmlspecialchars(trim($_POST['historiaconsulta'])).']['.htmlspecialchars(trim($_POST['anamnesisfamiliar'])).']';

$param['personalremote']='['.htmlspecialchars(trim($_POST['remota1'])).'='.htmlspecialchars(trim($_POST['obsremota1'])).']'.
  '['.htmlspecialchars(trim($_POST['remota2'])).'='.htmlspecialchars(trim($_POST['obsremota2'])).']'.
  '['.htmlspecialchars(trim($_POST['remota3'])).'='.htmlspecialchars(trim($_POST['obsremota3'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4a'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4b1'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4b2'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4b3'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4b4'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4b5'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4c'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4d'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4e'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4f1'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4f2'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4f3'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4g'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4h'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4i'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4j'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4k'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4l'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4m'])).']'.
  '['.htmlspecialchars(trim($_POST['remota4n'])).']'.
  '['.htmlspecialchars(trim($_POST['remota51'])).']'.
  '['.htmlspecialchars(trim($_POST['remota52'])).']'.
  '['.htmlspecialchars(trim($_POST['remota53'])).'='.htmlspecialchars(trim($_POST['obsremota53'])).']'.
  '['.htmlspecialchars(trim($_POST['remota6'])).']'.
  '['.htmlspecialchars(trim($_POST['remota7'])).']'.
  '['.htmlspecialchars(trim($_POST['remota81'])).']'.
  '['.htmlspecialchars(trim($_POST['remota82'])).']'.
  '['.htmlspecialchars(trim($_POST['remota83'])).']'.
  '['.htmlspecialchars(trim($_POST['remota84'])).']'.
  '['.htmlspecialchars(trim($_POST['remota85'])).']'.
  '['.htmlspecialchars(trim($_POST['remota86'])).']'.
  '['.htmlspecialchars(trim($_POST['remota87'])).']'.
  '['.htmlspecialchars(trim($_POST['remota88'])).']'.
  '['.htmlspecialchars(trim($_POST['remota89'])).']'.
  '['.htmlspecialchars(trim($_POST['remota810'])).']'.
  '['.htmlspecialchars(trim($_POST['remota811'])).']'.
  '['.htmlspecialchars(trim($_POST['remota812'])).']'.
  '['.htmlspecialchars(trim($_POST['remota9'])).'='.htmlspecialchars(trim($_POST['obsremota9'])).']'.
  '['.htmlspecialchars(trim($_POST['remota10'])).']';
  $datap='';
  if(isset($_POST['remota111'])&&isset($_POST['remota112'])){
    $datap.='['.htmlspecialchars(trim($_POST['remota111'])).']['.htmlspecialchars(trim($_POST['remota112'])).']';
  }else{
    $datap.='[][]';
  }

  $param['personalremote'].=$datap.'['.htmlspecialchars(trim($_POST['remota12'])).'='.htmlspecialchars(trim($_POST['obsremota12'])).']';

  $param['dentalhistory']='['.htmlspecialchars(trim($_POST['historia1'])).'='.htmlspecialchars(trim($_POST['obshistoria1'])).']'.
  '['.htmlspecialchars(trim($_POST['historia2'])).']'.
  '['.htmlspecialchars(trim($_POST['historia3'])).']'.
  '['.htmlspecialchars(trim($_POST['historia4'])).']'.
  '['.htmlspecialchars(trim($_POST['historia5'])).']'.
  '['.htmlspecialchars(trim($_POST['historia6'])).']'.
  '['.htmlspecialchars(trim($_POST['historia7'])).']'.
  '['.htmlspecialchars(trim($_POST['historia8'])).'='.htmlspecialchars(trim($_POST['obshistoria8'])).']';
  $param['physicalexam']='['.htmlspecialchars(trim($_POST['arterial'])).']'.
  '['.htmlspecialchars(trim($_POST['cardiaca'])).']'.
  '['.htmlspecialchars(trim($_POST['respiratoria'])).']'.
  '['.htmlspecialchars(trim($_POST['torax'])).']'.
  '['.htmlspecialchars(trim($_POST['abdomen'])).']'.
  '['.htmlspecialchars(trim($_POST['extremidades'])).']'.
  '['.htmlspecialchars(trim($_POST['faneras'])).']'.
  '['.htmlspecialchars(trim($_POST['neurologico'])).']'.
  '['.htmlspecialchars(trim($_POST['cuello'])).']'.
  '['.htmlspecialchars(trim($_POST['craneo'])).']'.
  '['.htmlspecialchars(trim($_POST['cara'])).']'.
  '['.htmlspecialchars(trim($_POST['musculos'])).']'.
  '['.htmlspecialchars(trim($_POST['linfaticos'])).']'.
  '['.htmlspecialchars(trim($_POST['atm'])).']'.
  '['.htmlspecialchars(trim($_POST['salivales'])).']'.
  '['.htmlspecialchars(trim($_POST['vestibulo'])).']'.
  '['.htmlspecialchars(trim($_POST['anterior'])).']'.
  '['.htmlspecialchars(trim($_POST['superior'])).']'.
  '['.htmlspecialchars(trim($_POST['posterior'])).']'.
  '['.htmlspecialchars(trim($_POST['inferior'])).']'.
  '['.htmlspecialchars(trim($_POST['laterales'])).']'.
  '['.htmlspecialchars(trim($_POST['language'])).']'.
  '['.htmlspecialchars(trim($_POST['encias'])).']';//23
  $conf=globalconf();
  $param['odontogram'] = encryptData(trim($_POST["draw"]), $conf["key"], false);
  $param['asa']=htmlspecialchars(trim($_POST['asa']));
  $param['anxiety']='['.htmlspecialchars(trim($_POST['nivelansiedad1'])).']['.htmlspecialchars(trim($_POST['nivelansiedad2'])).']'.
                    '['.htmlspecialchars(trim($_POST['nivelansiedad3'])).']['.htmlspecialchars(trim($_POST['nivelansiedad4'])).']';
  $param['diagnosishypothesis']=htmlspecialchars(trim($_POST['hipotesisdiagnostica']));

  //examenes compl. inicio
  $param['complementaryexam'] = explode('-', htmlspecialchars($_POST['complementaryexam']));
  if(count($param['complementaryexam'])==22&& strIsBool($param['complementaryexam'][0])&&
    strIsBool($param['complementaryexam'][1])&& strIsBool($param['complementaryexam'][2])&&
    strIsBool($param['complementaryexam'][3])&& strIsBool($param['complementaryexam'][4])&&
    strIsBool($param['complementaryexam'][5])&& strIsBool($param['complementaryexam'][6])&&
    strIsBool($param['complementaryexam'][7])&& strIsBool($param['complementaryexam'][8])&&
    strIsBool($param['complementaryexam'][9])&& strIsBool($param['complementaryexam'][10])&&
    strIsBool($param['complementaryexam'][11])&& strIsBool($param['complementaryexam'][12])&&
    strIsBool($param['complementaryexam'][13])&& strIsBool($param['complementaryexam'][14])&&
    strIsBool($param['complementaryexam'][15])&& strIsBool($param['complementaryexam'][16])&&
    strIsBool($param['complementaryexam'][17])&& strIsBool($param['complementaryexam'][18])&&
    strIsBool($param['complementaryexam'][19])&& strIsBool($param['complementaryexam'][20])&&
    strIsBool($param['complementaryexam'][21])){
      $param['complementaryexam'] = $param['complementaryexam'][0].'-'.$param['complementaryexam'][1].'-'.
      $param['complementaryexam'][2].'-'.$param['complementaryexam'][3].'-'.$param['complementaryexam'][4].'-'.
      $param['complementaryexam'][5].'-'.$param['complementaryexam'][6].'-'.$param['complementaryexam'][7].'-'.
      $param['complementaryexam'][8].'-'.$param['complementaryexam'][9].'-'.$param['complementaryexam'][10].'-'.
      $param['complementaryexam'][11].'-'.$param['complementaryexam'][12].'-'.$param['complementaryexam'][13].'-'.
      $param['complementaryexam'][14].'-'.$param['complementaryexam'][15].'-'.$param['complementaryexam'][16].'-'.
      $param['complementaryexam'][17].'-'.$param['complementaryexam'][18].'-'.$param['complementaryexam'][19].'-'.
      $param['complementaryexam'][20].'-'.$param['complementaryexam'][21];
  }else{
    echo "No se envió todos los valores necesarias para guardar datos firmas";
    exit;
  }
  $param['complementaryexam']='['.htmlspecialchars($param['complementaryexam'],true).']';

  $ret=DBSurgeryiiInfo($info_r['remissionid'], true);
  if($ret!=null&& isset($ret['surgeryiicomplementaryexam'])&& $ret['surgeryiicomplementaryexam']!=''){
    $arr=explode(']', $ret['surgeryiicomplementaryexam']);
    if(count($arr)==3&& $arr[1]!=''){
      $param['complementaryexam']=$param['complementaryexam'].$arr[1].']';
    }else{
      $param['complementaryexam']=$param['complementaryexam'].'[(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)]';//(*,*)
    }
  }else{
    $param['complementaryexam']=$param['complementaryexam'].'[(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)(*)]';
  }

  //examenes compl. fin
  /*$param['complementaryexam']='{'.
  '['.(isset($_POST['laboratorio1'])?$_POST['laboratorio1']:(isset($info['laboratorio1'])?$info['laboratorio1']:'')).']'.
  '['.(isset($_POST['laboratorio2'])?$_POST['laboratorio2']:(isset($info['laboratorio2'])?$info['laboratorio2']:'')).']'.
  '['.(isset($_POST['laboratorio3'])?$_POST['laboratorio3']:(isset($info['laboratorio3'])?$info['laboratorio3']:'')).']'.
  '['.(isset($_POST['laboratorio4'])?$_POST['laboratorio4']:(isset($info['laboratorio4'])?$info['laboratorio4']:'')).']'.
  '['.(isset($_POST['laboratorio5'])?$_POST['laboratorio5']:(isset($info['laboratorio5'])?$info['laboratorio5']:'')).']}'.

  '{['.(isset($_POST['histopatologico1'])?$_POST['histopatologico1']:(isset($info['histopatologico1'])?$info['histopatologico1']:'')).']'.
  '['.(isset($_POST['histopatologico2'])?$_POST['histopatologico2']:(isset($info['histopatologico2'])?$info['histopatologico2']:'')).']'.
  '['.(isset($_POST['histopatologico3'])?$_POST['histopatologico3']:(isset($info['histopatologico3'])?$info['histopatologico3']:'')).']'.
  '['.(isset($_POST['histopatologico4'])?$_POST['histopatologico4']:(isset($info['histopatologico4'])?$info['histopatologico4']:'')).']}'.
  '{['.(isset($_POST['diagenologia1'])?$_POST['diagenologia1']:(isset($info['diagenologia1'])?$info['diagenologia1']:'')).']'.
  '['.(isset($_POST['diagenologia2'])?$_POST['diagenologia2']:(isset($info['diagenologia2'])?$info['diagenologia2']:'')).']'.
  '['.(isset($_POST['diagenologia3'])?$_POST['diagenologia3']:(isset($info['diagenologia3'])?$info['diagenologia3']:'')).']'.
  '['.(isset($_POST['diagenologia4'])?$_POST['diagenologia4']:(isset($info['diagenologia4'])?$info['diagenologia4']:'')).']'.
  '['.(isset($_POST['diagenologia5'])?$_POST['diagenologia5']:(isset($info['diagenologia5'])?$info['diagenologia5']:'')).']'.
  '['.(isset($_POST['diagenologia6'])?$_POST['diagenologia6']:(isset($info['diagenologia6'])?$info['diagenologia6']:'')).']}'.
  '{['.(isset($_POST['fotografia1'])?$_POST['fotografia1']:(isset($info['fotografia1'])?$info['fotografia1']:'')).']'.
  '['.(isset($_POST['fotografia2'])?$_POST['fotografia2']:(isset($info['fotografia2'])?$info['fotografia2']:'')).']'.
  '['.(isset($_POST['fotografia3'])?$_POST['fotografia3']:(isset($info['fotografia3'])?$info['fotografia3']:'')).']'.
  '['.(isset($_POST['fotografia4'])?$_POST['fotografia4']:(isset($info['fotografia4'])?$info['fotografia4']:'')).']'.
  '['.(isset($_POST['fotografia5'])?$_POST['fotografia5']:(isset($info['fotografia5'])?$info['fotografia5']:'')).']}'.
  '{['.(isset($_POST['impresiones1'])?$_POST['impresiones1']:(isset($info['impresiones1'])?$info['impresiones1']:'')).']'.
  '['.(isset($_POST['impresiones2'])?$_POST['impresiones2']:(isset($info['impresiones2'])?$info['impresiones2']:'')).']}';*/

  $param['diagnosis']=htmlspecialchars(trim($_POST['finaldiagnostica']));
  $param['surgicaldifficulty']='['.htmlspecialchars(trim($_POST['gradodificultad1'])).']'.
  '['.htmlspecialchars(trim($_POST['gradodificultad2'])).']'.
  '['.htmlspecialchars(trim($_POST['gradodificultad3'])).']';

  $param['treatmentplan']='['.htmlspecialchars(trim($_POST['inmediato'])).']'.
  '['.htmlspecialchars(trim($_POST['mediato'])).']';


  //$param['patientid'] = $info_r['patientid'];
  //$param['studentid'] = $info_r['student'];
  $param['remissionid'] = $info_r['remissionid'];
  $param['clinicalid'] = $info_r['clinicalid'];
  //$param['teacherid'] = $info_r['teacher'];//id of teacher
  //$param['clinicalid'] = $info_r['clinicalid'];//id of clinical
  $param['status'] = 'process';

  DBUpdateReviewStatus($param['remissionid'], false);
  $ret=DBNewSurgeryii($param);
  if($ret==2){
    echo "yes";
  }else{
    echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
  }

  exit;
}

//para validar si existe o no...
if (isset($_POST["patientid"]) && isset($_POST["periodraw"]) && isset($_POST["bucal"]) && isset($_POST["gingival"]) && isset($_POST["sondeo"]) &&
 isset($_POST["tartaro"]) && isset($_POST["diagnostico"]) && isset($_POST["treatment"]) && isset($_POST["ficha"])&& isset($_POST["brushed"])&& isset($_POST["comment"])&& isset($_POST["olygram"])) {
   $param=array();
   $info=DBPeriodonticsiiInfo(htmlspecialchars(trim($_POST["ficha"])));
   $param["patientid"]=htmlspecialchars(trim($_POST["patientid"]));
   $conf=globalconf();
   $param['gram'] = encryptData(trim($_POST["periodraw"]), $conf["key"], false);
   $param['exam'] = '['.htmlspecialchars(trim($_POST["bucal"])).']['.htmlspecialchars(trim($_POST["gingival"])).']['.htmlspecialchars(trim($_POST["sondeo"])).']['.htmlspecialchars(trim($_POST["tartaro"])).']';

   $param['diagnosis'] = htmlspecialchars(trim($_POST["diagnostico"]));
   $param['brushed'] = htmlspecialchars(trim($_POST["brushed"]));
   $param['comment'] = htmlspecialchars(trim($_POST["comment"]));
   $param['oleary'] = encryptData(trim($_POST["olygram"]), $conf["key"], false);

   $param['treatment'] = htmlspecialchars(trim($_POST["treatment"]));
   $param['patientid'] = $info['patientid'];
   $param['studentid'] = $info['student'];
   $param['remissionid'] = $info['remissionid'];
   $param['teacherid'] = $info['teacher'];//id of teacher
   $param['clinicalid'] = $info['clinicalid'];//id of clinical
   $param['file'] = $info['periodonticsiiid'];//id of clinical
   $param['status'] = 'process';

   $ret=DBNewPeriodonticsii($param);
   //una nueva observacion
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
    exit;
}
//para validar datos de periodoncia III
if (isset($_POST["patientid"])&&isset($_POST['patientresident'])&&
isset($_POST['patientstreet'])&&isset($_POST['rotation'])&&isset($_POST['motconsult'])&&
isset($_POST['question1'])&&isset($_POST['obsquestion1'])&&isset($_POST['question2'])&&
isset($_POST['obsquestion2'])&&isset($_POST['question3'])&&isset($_POST['obsquestion3'])&&
isset($_POST['question4'])&&isset($_POST['obsquestion4'])&&isset($_POST['question5'])&&
isset($_POST['obsquestion5'])&&isset($_POST['question6'])&&isset($_POST['obsquestion6'])&&
isset($_POST['question7'])&&isset($_POST['obsquestion7'])&&isset($_POST['question8'])&&
isset($_POST['obsquestion8'])&&isset($_POST['question9'])&&isset($_POST['obsquestion9'])&&
isset($_POST['question10'])&&isset($_POST['obsquestion10'])&&isset($_POST['question11'])&&
isset($_POST['obsquestion11'])&&isset($_POST['question12'])&&
isset($_POST['question13'])&&isset($_POST['question14'])&&
isset($_POST['obsquestion14'])&&isset($_POST['question15'])&&isset($_POST['obsquestion15'])&&
isset($_POST['question16'])&&isset($_POST['obsquestion16'])&&isset($_POST['question17'])&&
isset($_POST['obsquestion17'])&&isset($_POST['question18'])&&isset($_POST['obsquestion18'])&&
isset($_POST['question19'])&&isset($_POST['obsquestion19'])&&
isset($_POST["medicine"]) &&isset($_POST["diagnostico"]) &&isset($_POST["treatment"]) &&
isset($_POST["ficha"])) {
   $param=array();
   $info=DBPeriodonticsiiInfo(htmlspecialchars(trim($_POST["ficha"])));
   $param["patientid"]=htmlspecialchars(trim($_POST["patientid"]));
   //$param['patientdatebirth'] = htmlspecialchars($_POST["patientdatebirth"]);
   //$param['patientplacebirth'] = htmlspecialchars($_POST["patientplacebirth"]);

   $param["patientstreet"]=htmlspecialchars(trim($_POST["patientstreet"]));
   $param["patientresident"]=htmlspecialchars(trim($_POST["patientresident"]));
   //$param["patientprovince"]=htmlspecialchars(trim($_POST["patientprovince"]));
   $param["rotation"]=htmlspecialchars(trim($_POST["rotation"]));
   $param["motconsult"]=htmlspecialchars(trim($_POST["motconsult"]));

   $conf=globalconf();
   $param['poll']="[".$_POST['question1']."=".$_POST['obsquestion1']."]".
    "[".$_POST['question2']."=".$_POST['obsquestion2']."]".
    "[".$_POST['question3']."=".$_POST['obsquestion3']."]".
    "[".$_POST['question4']."=".$_POST['obsquestion4']."]".
    "[".$_POST['question5']."=".$_POST['obsquestion5']."]".
    "[".$_POST['question6']."=".$_POST['obsquestion6']."]".
    "[".$_POST['question7']."=".$_POST['obsquestion7']."]".
    "[".$_POST['question8']."=".$_POST['obsquestion8']."]".
    "[".$_POST['question9']."=".$_POST['obsquestion9']."]".
    "[".$_POST['question10']."=".$_POST['obsquestion10']."]".
    "[".$_POST['question11']."=".$_POST['obsquestion11']."]".
    "[".$_POST['question12']."]".
    "[".$_POST['question13']."]".
    "[".$_POST['question14']."=".$_POST['obsquestion14']."]".
    "[".$_POST['question15']."=".$_POST['obsquestion15']."]".
    "[".$_POST['question16']."=".$_POST['obsquestion16']."]".
    "[".$_POST['question17']."=".$_POST['obsquestion17']."]".
    "[".$_POST['question18']."=".$_POST['obsquestion18']."]".
    "[".$_POST['question19']."=".$_POST['obsquestion19']."]";
   //$param['gram'] = encryptData(trim($_POST["periodraw"]), $conf["key"], false);
   //$param['exam'] = '['.htmlspecialchars(trim($_POST["bucal"])).']['.htmlspecialchars(trim($_POST["gingival"])).']['.htmlspecialchars(trim($_POST["sondeo"])).']['.htmlspecialchars(trim($_POST["tartaro"])).']';

   $param['diagnosis'] = htmlspecialchars(trim($_POST["diagnostico"]));

   $param['treatment'] = htmlspecialchars(trim($_POST["treatment"]));
   $param['medicine'] = htmlspecialchars(trim($_POST["medicine"]));
   $param['patientid'] = $info['patientid'];
   $param['studentid'] = $info['student'];
   $param['remissionid'] = $info['remissionid'];
   $param['teacherid'] = $info['teacher'];//id of teacher
   $param['clinicalid'] = $info['clinicalid'];//id of clinical
   $param['file'] = $info['periodonticsiiid'];//id of clinical
   $param['status'] = 'process';

   $inforemission=DBPatientRemissionInfo($info['remissionid']);
   $param['patientadmissionid']=$inforemission['patientadmissionid'];

   DBUpdatePatientSurgery($param);//funcion para asignar datos de fecha de nacimiento y lugar de nacimiento.

   //DBUpdatePatientPediatrics
   $ret=DBNewPeriodonticsii($param);
   //una nueva observacion
   if($ret==2){
     DBNewObservation($param);
     echo "yes";
   }else{
     echo "No se gurdaron los datos, el tiempo actual debe ser mayor al tiempo de registro";
   }
    exit;
}
if(isset($_POST['remission'])&&is_numeric($_POST['remission'])&&isset($_POST['token'])&&isset($_POST['preoperatorio1'])&&isset($_POST['preoperatorio2'])&&isset($_POST['preoperatorio3'])&&
isset($_POST['preoperatorio4'])&&isset($_POST['diagnosisquirurjico'])&&isset($_POST['premedication1'])&&
isset($_POST['premedication2'])&&isset($_POST['premedication3'])&&isset($_POST['premedication4'])&&
isset($_POST['dosis'])&&isset($_POST['intrafecha'])&&isset($_POST['intrahora1'])&&
isset($_POST['intrahora2'])&&isset($_POST['asistente'])&&isset($_POST['anestesico'])&&
isset($_POST['tecnica'])&&isset($_POST['obsintra'])&&isset($_POST['sensibilidad1'])&&
isset($_POST['sensibilidad2'])&&isset($_POST['sensibilidad3'])&&isset($_POST['sensibilidad4'])&&
isset($_POST['edema1'])&&isset($_POST['edema2'])&&isset($_POST['edema3'])&&isset($_POST['edema4'])&&
isset($_POST['buccalmucosa1'])&&isset($_POST['buccalmucosa2'])&&isset($_POST['obspost'])){
  $param=array();
  $info=DBSurgeryiiInfo(htmlspecialchars(trim($_POST["remission"])), true);
  if(empty(trim($_POST['token']))||!is_numeric(trim($_POST['token']))){
    $param['id']=-1;
  }else{
    $param['id']=htmlspecialchars(trim($_POST['token']));
  }
  $data=DBSurgeryTokenInfo(htmlspecialchars(trim($param['id'])));

  $param['area'] = '['.htmlspecialchars(trim($_POST['preoperatorio1'])).']['.
  htmlspecialchars(trim($_POST['preoperatorio2'])).']['.htmlspecialchars(trim($_POST['preoperatorio3'])).']['.
  htmlspecialchars(trim($_POST['preoperatorio4'])).']';
  $param['diagnosis'] = htmlspecialchars(trim($_POST['diagnosisquirurjico']));
  $param['premedication'] = '['.htmlspecialchars(trim($_POST['premedication1'])).']['.
  htmlspecialchars(trim($_POST['premedication2'])).']['.htmlspecialchars(trim($_POST['premedication3'])).']['.
  htmlspecialchars(trim($_POST['premedication4'])).']';

  $param['dose'] = htmlspecialchars(trim($_POST['dosis']));
  $param['date'] = htmlspecialchars(trim($_POST['intrafecha']));
  $param['hourstart'] = htmlspecialchars(trim($_POST['intrahora1']));
  $param['hourend'] = htmlspecialchars(trim($_POST['intrahora2']));
  $param['attendee'] = htmlspecialchars(trim($_POST['asistente']));
  $param['anesthetic'] = htmlspecialchars(trim($_POST['anestesico']));
  $param['technique'] = htmlspecialchars(trim($_POST['tecnica']));


  if(isset($_POST['autorizacion'])){
    $param['authorization'] = htmlspecialchars(trim($_POST['autorizacion']));
  }else{
    if(isset($data['authorization'])){
      $param['authorization'] = $data['authorization'];
    }else{
      $param['authorization'] = '';
    }
  }
  if(isset($_POST['seguimiento'])){
    $param['tracing'] = htmlspecialchars(trim($_POST['seguimiento']));
  }else{
      if(isset($data['tracing'])){
        $param['tracing'] = $data['tracing'];
      }else{
        $param['tracing'] ='';
      }
  }
  if(isset($_POST['finalizacion'])){
    $param['ending'] = htmlspecialchars(trim($_POST['finalizacion']));
  }else{
    if(isset($param['ending'])){
      $param['ending'] = $data['ending'];
    }else{
      $param['ending'] = '';
    }
  }


  $param['obsintra'] = htmlspecialchars(trim($_POST['obsintra']));
  $param['sensitivity'] = '['.htmlspecialchars(trim($_POST['sensibilidad1'])).']['.
  htmlspecialchars(trim($_POST['sensibilidad2'])).']['.htmlspecialchars(trim($_POST['sensibilidad3'])).']['.
  htmlspecialchars(trim($_POST['sensibilidad4'])).']';
  $param['edema'] = '['.htmlspecialchars(trim($_POST['edema1'])).']['.
  htmlspecialchars(trim($_POST['edema2'])).']['.htmlspecialchars(trim($_POST['edema3'])).']['.
  htmlspecialchars(trim($_POST['edema4'])).']';
  $param['buccalmucosa'] = '['.htmlspecialchars(trim($_POST['buccalmucosa1'])).']['.htmlspecialchars(trim($_POST['buccalmucosa2'])).']';
  $param['obspost'] = htmlspecialchars(trim($_POST['obspost']));

  $param['remission'] = $info['remissionid'];//id of clinical

  DBNewSurgeryToken($param);
  $a=DBAllSurgeryTokenInfo($info['remissionid'], true );
  if($a==null){
    echo 'No';
  }else{
    echo $a;
  }

  exit;
}
//firma del paciente
if(isset($_POST['fichafirma'])&&  isset($_POST['firma'])){

  $info=DBSurgeryiiInfo(htmlspecialchars(trim($_POST["fichafirma"])), true);//fichafirma es remission
  if($info==null){
    echo "No Registrado";
    exit;
  }
  $param=array();
  $param['file'] = $info['surgeryiiid'];//id of clinical

  //$conf=globalconf();
  $param['firm'] = $_POST["firma"];//encryptData($_POST["imggram"], $conf["key"], false);

  DBUpdateSurgeryiiFirm($param);
  echo "yes";
  exit;
}

?>
