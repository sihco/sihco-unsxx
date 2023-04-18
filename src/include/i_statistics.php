<?php
session_start();
require_once('../db.php');
require_once('../globals.php');
if(isset($_POST['start'])&&$_POST['start']&&isset($_POST['end'])&&$_POST['end']&&isset($_POST['year'])&&$_POST['year']){

    if(!ValidDate($_POST['start'])&&!ValidDate($_POST['end'])){
      echo "Error de fechas enviadas";
      exit;
    }
    $a = array();
    $i=0;
    if(isset($_POST['removible2'])&&$_POST['removible2']=='true'){
      $a[$i]=2;
      $i++;
    }
    if(isset($_POST['fija2'])&&$_POST['fija2']=='true'){
      $a[$i]=3;
      $i++;
    }
    if(isset($_POST['operatoria2'])&&$_POST['operatoria2']=='true'){
      $a[$i]=4;
      $i++;
    }
    if(isset($_POST['endodoncia1'])&&$_POST['endodoncia1']=='true'){
      $a[$i]=5;
      $i++;
    }
    if(isset($_POST['cirugia2'])&&$_POST['cirugia2']=='true'){
      $a[$i]=6;
      $i++;
    }
    if(isset($_POST['periodoncia2'])&&$_POST['periodoncia2']=='true'){
      $a[$i]=7;
      $i++;
    }
    if(isset($_POST['odontopediatria1'])&&$_POST['odontopediatria1']=='true'){
      $a[$i]=8;
      $i++;
    }
    if(isset($_POST['ortodoncia1'])&&$_POST['ortodoncia1']=='true'){
      $a[$i]=9;
      $i++;
    }
    if(isset($_POST['removible3'])&&$_POST['removible3']=='true'){
      $a[$i]=10;
      $i++;
    }
    if(isset($_POST['fija2'])&&$_POST['fija2']=='true'){
      $a[$i]=11;
      $i++;
    }
    if(isset($_POST['operatoria3'])&&$_POST['operatoria3']=='true'){
      $a[$i]=12;
      $i++;
    }
    if(isset($_POST['endodoncia2'])&&$_POST['endodoncia2']=='true'){
      $a[$i]=13;
      $i++;
    }
    if(isset($_POST['cirugia3'])&&$_POST['cirugia3']=='true'){
      $a[$i]=14;
      $i++;
    }
    if(isset($_POST['periodoncia3'])&&$_POST['periodoncia3']=='true'){
      $a[$i]=15;
      $i++;
    }
    if(isset($_POST['odontopediatria2'])&&$_POST['odontopediatria2']=='true'){
      $a[$i]=16;
      $i++;
    }
    if(isset($_POST['ortodoncia2'])&&$_POST['ortodoncia2']=='true'){
      $a[$i]=17;
      $i++;
    }

    $year=date('Y',time());
    if(is_numeric($_POST['year'])){
        $year=$_POST['year'];
    }
    $mes='#';
    $userid=null;
    $usertype=null;
    if($_SESSION['usertable']['usertype']=='student'){
      $userid=$_SESSION['usertable']['usernumber'];
      $usertype=$_SESSION['usertable']['usertype'];
    }
    for ($i=0; $i <12 ; $i++) {
      $day=getMonthDays($i+1, $year);
      $sd=strtotime($year.'-'.($i+1).'-01');
      $ed=strtotime($year.'-'.($i+1).'-'.$day)+86400;
      $dyear=DBClinicalStatisticsInfo($sd, $ed, $a, $userid, $usertype);
      $total=$dyear['new']+$dyear['process']+$dyear['end']+$dyear['fail']+$dyear['canceled'];
      $mes.=$total.',';
    }
    $start=strtotime($_POST['start']);
    $end=strtotime($_POST['end'])+86400;//fecha de finalizacion
    $data=DBClinicalStatisticsInfo($start, $end, $a, $userid, $usertype);
    //echo $data['new'];
    $max=max($data['new'],$data['process'],$data['end'],$data['fail'],$data['canceled'])+1;


    echo $data['new'].','.$data['process'].','.$data['end'].','.$data['fail'].','.$data['canceled'].','.$max.''.$mes;
}
?>
