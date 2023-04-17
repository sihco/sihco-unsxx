<?php
session_start();//para iniciar session_sta
require_once("../globals.php");
require_once("../db.php");


if (isset($_POST['namecontrol2'])&&isset($_POST["s2desc"]) && isset($_POST["s2evalued1"])&&isset($_POST["s2evalued2"])&&isset($_POST["s2evalued3"]) && isset($_POST["ficha"]) && isset($_POST["s2date1"]) && isset($_POST["s2date2"]) && isset($_POST["s2date3"])) {

   $param=array();
   $param['ficha']=htmlspecialchars(trim($_POST["ficha"]));
   $param['tartarectomy']='['.trim($_POST["s2date1"]).'='.trim($_POST['s2evalued1']).']'.
   '['.trim($_POST["s2date2"]).'='.trim($_POST['s2evalued2']).']'.
   '['.trim($_POST["s2date3"]).'='.trim($_POST['s2evalued3']).']';
   if(isset($_POST['s2date0'])&&isset($_POST['s2evalued0'])){
     $param['tartrectomia'].='['.trim($_POST["s2date0"]).'='.trim($_POST['s2evalued0']).']';
   }
   $param['treatment']=$_POST['namecontrol2'];
   DBUpdateSessionPeriodonticsii($param);
   $info=DBPeriodonticsiiInfo($param['ficha']);
   $param['student']=$info['student'];
   $param['teacher']=$info['teacher'];
   $param['file']=$info['periodonticsiiid'];
   $param['sessiondesc']=htmlspecialchars(trim($_POST['s2desc']));
   $param['sessionevaluated']='t';
   $param['type']=$_POST['namecontrol2'];
   DBNewSessionPeriodonticsii($param, false);

   echo "yes";
    exit;
}
if (isset($_POST['namecontrol1'])&&isset($_POST["s1desc"])&&isset($_POST["s1evalued1"])&&isset($_POST["s1evalued2"])&&isset($_POST["s1evalued3"])&&isset($_POST["ficha"]) && isset($_POST["s1date1"]) && isset($_POST["s1date2"]) && isset($_POST["s1date3"])) {

   if(($se=DBSessionPeriodonticsiiInfo($_POST['ficha']))==null){
     echo "Error de Guardar Session";
     exit;
   }
   $param=array();
   $param['ficha']=htmlspecialchars(trim($_POST["ficha"]));
   $param['prophylaxis']='['.trim($_POST["s1date1"]).'='.trim($_POST['s1evalued1']).']'.
   '['.trim($_POST["s1date2"]).'='.trim($_POST['s1evalued2']).']'.
   '['.trim($_POST["s1date3"]).'='.trim($_POST['s1evalued3']).']';
   if(isset($_POST['s1date0'])&&isset($_POST['s1evalued0'])){
     $param['prophylaxis'].='['.trim($_POST["s1date0"]).'='.trim($_POST['s1evalued0']).']';
   }
   $param['treatment']=$_POST['namecontrol1'];
   DBUpdateSessionPeriodonticsii($param);
   $info=DBPeriodonticsiiInfo($param['ficha']);
   $param['student']=$info['student'];
   $param['teacher']=$info['teacher'];
   $param['file']=$info['periodonticsiiid'];
   $param['sessiondesc']=htmlspecialchars(trim($_POST['s1desc']));
   $param['sessionevaluated']='t';
   $param['type']=$_POST['namecontrol1'];
   $param['fluor']=$se['sessionfluor'];
   DBNewSessionPeriodonticsii($param, false);
   echo "yes";
   exit;
}


//para validar si existe o no...
if (isset($_POST['namecontrol2'])&&isset($_POST["s2evalued1"])&&isset($_POST["s2evalued2"])&&isset($_POST["s2evalued3"])&&isset($_POST["treatment"])&&isset($_POST["ficha"]) && isset($_POST["s2date1"]) && isset($_POST["s2date2"]) && isset($_POST["s2date3"])) {

   $param=array();
   $param['ficha']=htmlspecialchars(trim($_POST["ficha"]));
   $param['tartarectomy']='['.trim($_POST["s2date1"]).'='.trim($_POST['s2evalued1']).']'.
   '['.trim($_POST["s2date2"]).'='.trim($_POST['s2evalued2']).']'.
   '['.trim($_POST["s2date3"]).'='.trim($_POST['s2evalued3']).']';
   if(isset($_POST['s2date0'])&&isset($_POST['s2evalued0'])){
     $param['tartarectomy'].='['.trim($_POST["s2date0"]).'='.trim($_POST['s2evalued0']).']';
   }
   $param['treatment']=htmlspecialchars(trim($_POST["treatment"]));
   DBUpdateSessionPeriodonticsii($param);
   $info=DBPeriodonticsiiInfo($param['ficha']);
   $param['student']=$info['student'];
   $param['teacher']=$info['teacher'];
   $param['file']=$info['periodonticsiiid'];
   $param['type']=$_POST['namecontrol2'];
   DBNewSessionPeriodonticsii($param);
   echo "yes";
    exit;
}
if (isset($_POST['namecontrol1'])&&isset($_POST["s1evalued1"])&&isset($_POST["s1evalued2"])&&
isset($_POST["s1evalued3"]) && isset($_POST["treatment"])&&isset($_POST["ficha"]) &&
isset($_POST["s1date1"]) && isset($_POST["s1date2"]) && isset($_POST["s1date3"])) {

   $param=array();
   $param['ficha']=htmlspecialchars(trim($_POST["ficha"]));
   $param['prophylaxis']='['.trim($_POST["s1date1"]).'='.trim($_POST['s1evalued1']).']'.
   '['.trim($_POST["s1date2"]).'='.trim($_POST['s1evalued2']).']'.
   '['.trim($_POST["s1date3"]).'='.trim($_POST['s1evalued3']).']';
   if(isset($_POST['s1date0'])&&isset($_POST['s1evalued0'])){
     $param['prophylaxis'].='['.trim($_POST["s1date0"]).'='.trim($_POST['s1evalued0']).']';
   }
   $param['treatment']=htmlspecialchars(trim($_POST["treatment"]));
   DBUpdateSessionPeriodonticsii($param);
   $info=DBPeriodonticsiiInfo($param['ficha']);
   $param['student']=$info['student'];
   $param['teacher']=$info['teacher'];
   $param['file']=$info['periodonticsiiid'];
   $param['type']=$_POST['namecontrol1'];
   if(isset($_POST['fluor'])){
     $param['fluor']=$_POST['fluor'];
   }
   DBNewSessionPeriodonticsii($param);
   echo "yes";
   exit;
}

?>
