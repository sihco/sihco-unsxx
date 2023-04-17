<?php

require_once('db.php');
define("dbcompat_1_4_1",true);


// sanitization
//desinfeccion
function sanitizeVariables(&$item, $key)
{
    if (!is_array($item))
    {
        // undoing 'magic_quotes_gpc = On' directive
        //haciendo directiva
        if (get_magic_quotes_gpc())
            $item = stripcslashes($item);

        $item = sanitizeText($item);
    }
}
//devuelve la cadena condifica, primero codifica a base64 y luego remplaza algunos caracteres especiales
//% a delimitadores de urul especiales
function myrawurlencode($txt) {
    //base64_encode — Codifica datos con MIME base64
    //Devuelve una cadena en donde todos los caracteres no-alfanuméricos, excepto -_.~,
    //son reemplazados con un signo de porcentaje (%) seguido de dos dígitos hexadecimales.
    //Este es el tipo de codificación descrito en el » RFC 3986 para evitar que caracteres
    //literales sean interpretados como delimitadores de URL especiales, y para evitar que las
    //URLs sean modificadas por medios de transmisión con conversiones de caracteres (como algunos
    //sistemas de correo electrónico).
    return(rawurlencode(base64_encode($txt)));
}
//funcion devuelve decodificado primero decodifica signos de porcentaje url y luego base_64
function myrawurldecode($txt){
    //Devuelve los datos decodificados o false en caso de error. Los datos devueltos
    //pueden estar en formato binario.string
    //Devuelve una cadena en donde las con secuencias con signos de porcentaje (%)
    //seguidos de dos dígitos hexadecimales, son reemplazados con caracteres literales.
    return base64_decode(rawurldecode($txt));
}
//funcion para encriptar datos enviados devuelve dato encriptado tipo url &file=
function filedownload($oid,$fname,$msg='') {

	$cf = globalconf();
    //myrawurlencode devuelve la cadena condifica, primero codifica a base64 y luego remplaza algunos caracteres especiales
    //% a delimitadores de urul especiales
    ////CONTENIDO , FfHf7nMddw33E9fEzcWw, 2
    //encripta el dato con key
	$if = myrawurlencode(encryptData($fname, session_id() . $cf['key'],false));

    $p = myhash($oid . $fname . $msg . session_id() . $cf["key"]);
	$str = "oid=". $oid . "&filename=". $if . "&check=" . $p."#toolbar=0";//editado
	if($msg != '') $str .= "&msg=" . myrawurlencode($msg);
	return $str;
}
////funcion para mofigicar algunos caracteres especiales para htmlentities sin &
function myhtmlspecialchars($text, $nhtml=false){
    if($nhtml){
      $text=sanitizeTextNHTML($text);
    }
    return sanitizeText($text,false);
}
//para capturar imagen pieza
function getPieza($img, $url='../images/pieza/'){
  $dir=$url;
  //$cdir = $dir."c.png";
  $dir.=$img;
  $c = "data:image/png;base64," . base64_encode(file_get_contents($dir));

  return $c;
}
//funcion para encriptar metodo fabian numero html
function sanitizeTextNHTML($text){
  $text = str_replace("[", "&#61;", $text);
  $text = str_replace("]", "&#63;", $text);
  return $text;
}
function unsanitizeTextNHTML($text) {
  $text = str_replace("&#61;", "[", $text);
  $text = str_replace("&#63;", "]", $text);
	return $text;
}
function sanitizeText($text, $doamp=true)
{
	if($doamp)
		$text = str_replace("&", "&amp;", $text);
    $text = str_replace("<", "&lt;", $text);
    $text = str_replace(">", "&gt;", $text);
    $text = str_replace("\"", "&quot;", $text);
    $text = str_replace("'", "&#39;", $text);
    $text = str_replace("`", "&#96;", $text);
    //$text = escape_string($text);
    $text = addslashes($text);
    return $text;
}

function sanitizeFilename($text)
{
  $text = preg_replace('/[^[:print:]]/', '',$text);
  $text = str_replace(" ", "_", $text);
  $text = str_replace("*", "_", $text);
  $text = str_replace("$", "_", $text);
  $text = str_replace(")", "_", $text);
  $text = str_replace("(", "_", $text);
  $text = str_replace(";", "_", $text);
  $text = str_replace("&", "_", $text);
  $text = str_replace("<", "_", $text);
  $text = str_replace(">", "_", $text);
  $text = str_replace("\"", "_", $text);
  $text = str_replace("'", "_", $text);
  $text = str_replace("`", "_", $text);
  $text = addslashes($text);
  return $text;
}

function unsanitizeText($text) {
  $text = str_replace("&lt;", "<", $text);
  $text = str_replace("&gt;", ">", $text);
    $text = str_replace("&#39;", "'", $text);
    $text = str_replace("&#96;", "`", $text);
    $text = str_replace("&quot;", "\"", $text);
    $text = str_replace("&amp;", "&", $text);
	return $text;
}

array_walk_recursive($_FILES, 'sanitizeVariables');
array_walk_recursive($_POST, 'sanitizeVariables');
array_walk_recursive($_GET, 'sanitizeVariables');
array_walk_recursive($_COOKIE, 'sanitizeVariables');

//name of calling function
function getFunctionName($num=2) {
        if(strcmp(phpversion(),'5.3.6')<0) {
                $backtrace = debug_backtrace();
        } else {
                if(strcmp(phpversion(),'5.4.0')<0)
                        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT);
                else
                        $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT,$num+5);
        }
        $ret = '';
        for($i=0; $i<$num; $i++)
                if(isset($backtrace[$i]) && isset($backtrace[$i]['function']))
                        $ret .= " " . $backtrace[$i]['function'];
        if($ret =='') $ret='undef';
        return $ret;
}
//funcion
function getIP() {
	if (getenv("REMOTE_ADDR"))
		$ip = getenv("REMOTE_ADDR");
	else
		return "UNKNOWN";
	if(defined("dbcompat_1_4_1") && dbcompat_1_4_1==true) return $ip;

	$ip1='';
	if (getenv("HTTP_X_FORWARDED_FOR")) {
		$ip1 = getenv("HTTP_X_FORWARDED_FOR");
		$ip1 = strtok ($ip1, ",");
		if($ip1 != $ip) $ip .= ';' . $ip1;
	}
	if (getenv("HTTP_X_CLIENTIP")) {
		$ip1a = getenv("HTTP_X_CLIENTIP");
		$ip1a = strtok ($ip1a, ",");
		if($ip1a != $ip1 && $ip1a != getenv("REMOTE_ADDR")) $ip .= ';' . $ip1a;
	}
	if (getenv("HTTP_CLIENT_IP")) {
		$ip2 = getenv("HTTP_CLIENT_IP");
		$ip2 = strtok ($ip2, ",");
		if($ip2 != $ip1a && $ip1 != $ip2 && $ip2 != getenv("REMOTE_ADDR")) $ip .= ';' . $ip2;
	} else {
		if (getenv('HTTP_X_FORWARDED')) {
			$ip .= ';' . getenv('HTTP_X_FORWARDED');
		} else {
			if (getenv('HTTP_FORWARDED')) {
				$ip .= ';' . getenv('HTTP_FORWARDED');
			}
		}
	}
	return sanitizeText($ip);
}
//retorna ip e hostname do cliente
function getIPHost() {
	$ips = explode(';',getIP());
	$s='';
	for($ipn=0;$ipn<count($ips);$ipn++) {
		$ip = $ips[$ipn];
//next lines where suggested to be removed by
//Mario Sanchez (Ing. de Sistemas y Computacion, Universidad de los Andes, Bogota, Colombia)
//because they are very slow to run depending on the network
//		$host = @gethostbyaddr($ip);
//		if ($host != $ip && $host != "")
//			$s .= $ip . "(" . $host . ") ";
//		else
			$s .= $ip . ' ';
	}
	return $s;
}
//trata o caso de sessao invalida
function InvalidSession($where) {
	$msg = "Session expired on $where";
	LOGLevel($msg,3);
	unset($_SESSION["usertable"]);
	MSGError("Session expired. You must log in again.");
}
//trata o caso de tentativa de burlar as regras
function IntrusionNotify($where) {
	$msg = "Security Violation: $where";
	if (isset($_SESSION["usertable"]["username"]))
		$msg .= " (" . $_SESSION["usertable"]["username"] . ")";
	unset($_SESSION["usertable"]);
	LOGLevel($msg,1);
	MSGError("Violation ($where). Admin warned.");
}
// verifica se a sessao esta aberta e ok
//verifica si esta validado el usurio ok
function ValidSession() {
  //si no existe usertable en session false
  if (!isset($_SESSION["usertable"])) return(FALSE);
  //funcion getIP captura el ip de la maquina
	$gip = getIP();
	// cassiopc: sites that use multiple IP addresses to go out create a serious problem to check IPs...
//	if(substr($_SESSION["usertable"]["userip"],0,6) != '157.92') {
//	if ($_SESSION["usertable"]["userip"] != $gip ||
//		$_SESSION["usertable"]["usersession"] != session_id()) return(FALSE);
  //      } else {
	if($_SESSION["usertable"]["usersession"] != session_id()) return(FALSE);
    //    }
  //informacion de usuario a veficar...
	$tmp = DBUserInfo($_SESSION["usertable"]["usernumber"]);

	if($tmp['usersession']=='') return(FALSE);
	if($_SESSION["usertable"]["usermultilogin"] == 't') return(TRUE);

	if ($tmp["userip"] != $gip) return(FALSE);
	return(TRUE);
}
function ValidSession2() {
  //si no existe usertable en session false
  if (!isset($_SESSION["usertable2"])) return(FALSE);
  //funcion getIP captura el ip de la maquina
	$gip = getIP();
	// cassiopc: sites that use multiple IP addresses to go out create a serious problem to check IPs...
//	if(substr($_SESSION["usertable"]["userip"],0,6) != '157.92') {
//	if ($_SESSION["usertable"]["userip"] != $gip ||
//		$_SESSION["usertable"]["usersession"] != session_id()) return(FALSE);
  //      } else {
	if($_SESSION["usertable2"]["usersession"] != session_id()) return(FALSE);
    //    }
  //informacion de usuario a veficar...
	$tmp = DBUserInfo($_SESSION["usertable2"]["usernumber"]);

	if($tmp['usersession']=='') return(FALSE);
	if($_SESSION["usertable2"]["usermultilogin"] == 't') return(TRUE);

	if ($tmp["userip"] != $gip) return(FALSE);
	return(TRUE);
}
// grava erro no arquivo de log
function LOGError($msg) {
	LOGLevel($msg,0,false);
}
function LOGInfo($msg) {
	LOGLevel($msg,2,false);
}
// grava linha no arquivo de log com o nivel especificado
function LOGLevel($msg,$level,$dodb=true) {
	$msga = sanitizeText(str_replace("\n", " ", $msg));
	$msg = now() . ": ";
    // if php version arrives to 5.10 then this will not work!!
	if(strcmp(phpversion(),'5.4.0')<0) define_syslog_variables ();
	$prior = LOG_CRIT;
	switch ($level) {
		case 0: $msg .= "ERROR: ";
			$type = "error";
			$prior = LOG_ERR;
			break;
		case 1: $msg .= "WARN: ";
			$type = "warn";
			$prior = LOG_WARNING;
			break;
		case 2: $msg .= "INFO: ";
			$type = "info";
			$prior = LOG_INFO;
			break;
		case 3: $msg .= "DEBUG: ";
			$type = "debug";
			$prior = LOG_DEBUG;
			break;
	}
	$msg .= getIPHost() . ": " . $msga;

	openlog ("SIHCO", LOG_ODELAY, LOG_USER);
	syslog ($prior, $msg);
	closelog();

  if ($dodb && isset($_SESSION["usertable"]))
		DBNewLog($_SESSION["usertable"]["usernumber"], $type, getIP(), $msga, "");

}
function mytime() {
  return time();
}
function mymtime() {
  return microtime(true);
}
function myunique($val=0) {
  return (((int)(100*microtime(true))) % 10000000)*100 + ($val % 100);
}
//retorna data e hora atuais
function now () {
	return date('H\:i:s T \- d/M/Y');
}
//retorna data e hora em seg convertida para padrao
function dateconv ($d) {
	return date('H\:i:s T \- d/M/Y', $d);
}
//retorna data e hora em seg convertida para padrao simples
function dateconvsimple ($d) {
	return date('H\:i', $d);
}
//El formato "m-d-Y h:i:s a" especifica la date devuelta con valor de mes, día y año de 4 dígitos, y el tiempo en horas, minutos y segundos.
function datetimeconv($d, $r=false){
  if($r){
    return date ('Y-m-d\TH:i:s', $d);//strtotime($d)
  }else{
    return date('d-m-Y h:i:s a', $d);
  }
}

//transforma segundos para minutos
function dateconvminutes ($d) {
	return (int)($d/60);
}
//alerta mensagem via javascript
function MSGError($msg) {
	$msg = str_replace("\n", " ", $msg);
        echo "<script language=\"JavaScript\">\n";
        echo "alert('". $msg . "');\n";
        echo "</script>\n";
}
//gera script para voltar aa tela dada
function ForceLoad($where) {
        echo "<script language=\"JavaScript\">\n";
	echo "document.location='" . $where . "';\n";
	echo "</script></html>\n";
	exit;
}
function ForceClose() {
        echo "<script language=\"JavaScript\">\n";
	echo "window.close;\n";
	echo "</script></html>\n";
	exit;
}

/**
 * Compare an IP address to network(s)
 *
 * The network(s) argument may be a string or an array. A negative network
 * match must start with a "!". Depending on the 3rd parameter, it will
 * return true or false on the first match, or any negative rule will have
 * absolute priority (default).
 *
 * Samples:
 * match_network ("192.168.1.0/24", "192.168.1.1") -> true
 *
 * match_network (array ("192.168.1.0/24",  "!192.168.1.1"), "192.168.1.1")       -> false
 * match_network (array ("192.168.1.0/24",  "!192.168.1.1"), "192.168.1.1", true) -> true
 * match_network (array ("!192.168.1.0/24", "192.168.1.1"),  "192.168.1.1")       -> false
 * match_network (array ("!192.168.1.0/24", "192.168.1.1"),  "192.168.1.1", true) -> false
 *
 * @param mixed  Network to match
 * @param string IP address
 * @param bool   true: first match will return / false: priority to negative rules (default)
 * @see http://php.benscom.com/manual/en/function.ip2long.php#56373
 */
function match_network ($nets, $ip) {
    if (!is_array ($nets)) $nets = explode(",",$nets);

    foreach ($nets as $net) {
	$net = trim($net);
        $rev = (preg_match ("/^\!/", $net)) ? true : false;
        $net = preg_replace ("/^\!/", "", $net);

        $ip_arr   = explode('/', $net);
        $net_long = ip2long(trim($ip_arr[0]));
		if(count($ip_arr) > 1 && trim($ip_arr[1]) != '') {
			$x        = ip2long(trim($ip_arr[1]));
			$mask     = long2ip($x) == ((int) trim($ip_arr[1])) ? $x : 0xffffffff << (32 - ((int) trim($ip_arr[1])));
        } else {
			$mask=0xffffffff;
		}
		$ip_long  = ip2long($ip);

        if ($rev) {
            if (($ip_long & $mask) != ($net_long & $mask)) return true;
        } else {
            if (($ip_long & $mask) == ($net_long & $mask)) return true;
        }
    }
    return false;
}
//validar fecha 2022-03-04
function ValidDate($date){
  $valid=false;
  $a=explode('-', $date);
  $size=count($a);
  if(is_numeric($a[0])&&is_numeric($a[1])&&is_numeric($a[2])&&$size==3){
    return true;
  }else{
    return false;
  }
}
//funcion para obtener el todal de dias
function getMonthDays($Month, $Year)
{
   //Si la extensión de calendario está instalada, usamos esa.
   if( is_callable("cal_days_in_month")){
      return cal_days_in_month(CAL_GREGORIAN, $Month, $Year);
   }
   else{
      return date("d",mktime(0,0,0,$Month+1,0,$Year));
   }
}
//algoritmo de ordenamiento merge sort
//para array bibimensional ordenado por un campo llamado time
function mergesort($theArray){
    if (count($theArray) <= 1) {
        return $theArray;
    } else {
        $middlePos = count($theArray) / 2;
        $U = mergesort(array_slice($theArray, 0, $middlePos));
        $V = mergesort(array_slice($theArray, $middlePos, count($theArray) + 1 - $middlePos));
        return Fussion($U, $V);
    }
}
function Fussion($U, $V){
    $i = $j = 0;
    $finalArray = array();
    while (count($U) > 0 and count($V) > 0) {
        if ($U[0]['time'] > $V[0]['time']) {
            $finalArray[] = array_shift($U);
        } else {
            $finalArray[] = array_shift($V);
        }
    }
    if (count($U) > 0) {
        $finalArray = array_merge($finalArray, $U);
    } else {
        $finalArray = array_merge($finalArray, $V);
    }
    return $finalArray;
}
// eof
?>
