#!/usr/bin/php
<?php
//FABIAN SIERRA ACARAPI
$ds = DIRECTORY_SEPARATOR;
if($ds=="") $ds = "/";

if(is_readable('/etc/sihco.conf')) {
	$pif=parse_ini_file('/etc/sihco.conf');
	$sihcodir = trim($pif['sihcodir']) . $ds . 'src';
} else {
	$sihcodir = getcwd();
}

if(is_readable($sihcodir . $ds . '..' .$ds . 'db.php')) {
	require_once($sihcodir . $ds . '..' .$ds . 'db.php');
	@include_once($sihcodir . $ds . '..' .$ds . 'version.php');
} else {
  if(is_readable($sihcodir . $ds . 'db.php')) {
	require_once($sihcodir . $ds . 'db.php');
	@include_once($sihcodir . $ds . 'version.php');
  } else {
	  echo "no encontrado archivo db.php";
	  exit;
  }
}
if (getIP()!="UNKNOWN" || php_sapi_name()!=="cli") exit;
ini_set('memory_limit','600M');
ini_set('output_buffering','off');
ini_set('implicit_flush','on');
@ob_end_flush();

if(system('test "`id -u`" -eq "0"',$retval)===false || $retval!=0) {
	echo "Debe ejecutar como root\n";
	exit;
}
echo "\nINICIANDO SCRIPT...\n";




$url='../../doc/userdecide.txt';
//$type='txt';//myhtmlspecialchars($_FILES["importfile"]["type"]);
//$size=myhtmlspecialchars($_FILES["importfile"]["size"]);
$name='userdecide';//myhtmlspecialchars($_FILES["importfile"]["name"]);
$temp=myhtmlspecialchars($url);//myhtmlspecialchars($_FILES["importfile"]["tmp_name"]);

if (($ar = file($temp)) === false) {
    echo "No se puede abrir el archivo cargado.";
    exit;
}

for ($i=0; $i < count($ar) && strpos($ar[$i], "[user]") === false; $i++) ;
if($i >= count($ar)) echo 'Formato de archivo no reconocido';

for ($i++; $i < count($ar) && $ar[$i][0] != "["; $i++) {

  $x = trim($ar[$i]);
  if (strpos($x, "user") !== false && strpos($x, "user") == 0) {
    $param = array();
    $param['changepass']='t';//cambio de password
    $param['usernumber']=DBUserNumberMax();//maximo id de usuario
    while (strpos($x, "user") !== false && strpos($x, "user") == 0) {
      $tmp = explode ("=", $x, 2);
      switch (trim($tmp[0])) {
        case "userci":    $param['userci']=trim($tmp[1]); break;
        case "username":          $param['username']=trim($tmp[1]); break;
        case "userfullname":      $param['userfull']=strtolower(trim($tmp[1])); break;
        case "userdesc":          $param['userdesc']=trim($tmp[1]); break;
        case "usertype":          $param['type']=trim($tmp[1]); break;
        case "userenabled":       $param['enabled']=trim($tmp[1]); break;
        case "usermultilogin":    $param['multilogin']=trim($tmp[1]); break;
        case "userpassword":      $param['pass']=myhash(trim($tmp[1])); break;
        case "userchangepassword": $param['changepass']=trim($tmp[1]); break;
        case "userip":            $param['permitip']=trim($tmp[1]); break;

        case "userclinical":          $param['clinical']=trim($tmp[1]); break;
        case "userupdatetime":        $tmp[1]=strtotime($tmp[1])+3600*9;
				$param['updatetime']=trim($tmp[1]);
				$param['year']=date('Y',trim($tmp[1])); break;

      }
      $i++;
      if ($i>=count($ar)) break;
      $x = trim($ar[$i]);
    }
    if($param['usernumber'] != 0){

      $ufl=DBSearchUserFullName($param['userfull']);

      $nufl=count($ufl);
    	echo "usernumber\t username\t userfullname\t usertype\t updatetime\n";
    	for ($ii=0;$ii<$nufl;$ii++) {
    		echo $ufl[$ii]["usernumber"]."\t".$ufl[$ii]["username"]."\t".$ufl[$ii]["userfullname"]."\t".
        $ufl[$ii]["usertype"]."\t".$ufl[$ii]["updatetime"]."\n";
    	}
      echo "\n******Para Insertar(0) Actualizar(1) Terminar(2)*******=";
      $resp = strtoupper(trim(fgets(STDIN)));

      if($resp==0){
        $ret=DBNewUser($param);
        echo $ret."\n iduser=".$param['usernumber']."\n";

      }elseif($resp==1){
        echo "Actualizar, No Guardo los Datos del Usuario\n";
				echo "\n****** USER ID *******=";
	      $param["usernumber"] = strtoupper(trim(fgets(STDIN)));
      }else{
				exit;
			}
			if($param['clinical']!=''){
				echo DBNewSpecialty($param);
				echo "\nAsignado a ".$param['clinical']."\n";
			}

    }

  }
}

?>
