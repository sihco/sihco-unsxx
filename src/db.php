<?php
////////////////////////////////////////////////////////////////////////////////

if(isset($_SESSION["locr"]) && isset($_SESSION["loc"]) && !is_readable($_SESSION["locr"] . '/private/conf.php')) {
	MSGError('Problemas de permisos en ' . $_SESSION["locr"] . '/private/conf.php - el archivo debe ser legible para el usuario que ejecuta el servidor web');
	exit;
}
require_once('hex.php');
require_once('globals.php');
require_once('private/conf.php');



//para compatibidad con versioes antiguas y nuevas de php, varias de las funciones han sido
//colocados qui para garantizar la portabilidad.Desafortunadamente algunos cambios de nombre
//y los parametros ocurrieron con la 4.2.0 de php.
//pg_lo_open () abre un objeto grande en la base de datos y devuelve un recurso
// de objeto grande para que pueda ser manipulado. pude ser w r rw el $mode
function DB_lo_open($conn,$file,$mode){
    if(strcmp(phpversion(),'4.2.0')<0)
        return pg_loopen($conn,$file,$mode);
    else
        return pg_lo_open($conn,$file,$mode);
}
//funcion para imprimir el contenido de oid inviado y retona true
function DB_lo_read_tobrowser($contest,$id,$c=null) {
    //pg_lo_read () lee como máximo lenbytes de un objeto grande y lo devuelve como una cadena .
    //Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
    $str = DB_lo_read($id,-1,$c);
    echo $str;
    return true;
}
//pg_lo_read () lee como máximo lenbytes de un objeto grande y lo devuelve como una cadena .
//Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
function DB_lo_read($id,$s=-1,$c=null) {

	if (strcmp(phpversion(),'4.2.0')<0) {
		if($s<0) {
			$str='';
			while (($buf = pg_loread ($id, 1000000)) != false) $str .= $buf;
		} else
			$str = pg_loread ($id, $s);
	}else {
		if($s<0) {
			$str='';
			while (($buf = pg_lo_read ($id, 1000000)) != false) $str .= $buf;
		} else
			$str = pg_lo_read ($id, $s);
	}

	return $str;
}

//pg_lo_import () crea un nuevo objeto grande en la base de datos usando un
//archivo en el sistema de archivos como fuente de datos. devuelve el oid. dependiendo de la version 7.2 o < 4.2.0
function DB_lo_import($conn,$file){
    if(strcmp(phpversion(),'4.2.0')<0)
        return pg_loimport($file,$conn);
    else
        return pg_lo_import($conn,$file);
}
//importa un texto a un archivo creado en la base de datos y devuelve el oid del archivo
function DB_lo_import_text($conn,$text){
    if(($oid=DB_lo_create($conn))===false) return false;
    if(($handle=DB_lo_open($conn,$oid,"w"))===false) return false;
    if(DB_lo_write($handle,$text)===false) $oid=false;
    DB_lo_close($handle);
    return $oid;
}
//pg_lo_export () toma un objeto grande en una base de datos PostgreSQL y guarda
//su contenido en un archivo en el sistema de archivos local.
function DB_lo_export($conn, $oid, $file) {
	if (strcmp(phpversion(),'4.2.0')<0)
		$stat= pg_loexport ($oid, $file, $conn);
	else
		$stat= pg_lo_export ($oid, $file, $conn);
	if($stat===false) return false;//
	if(!is_readable($file)) return false;//

	return 1;
}
//pg_lo_close () cierra un objeto grande. large_object es un recurso para el objeto
//grande de pg_lo_open () . devuelve true en caso de exito o false en caso de error
function DB_lo_close($id){
    if(strcmp(phpversion(),'4.2.0')<0)
        return pg_loclose($id);
    else
        return pg_lo_close($id);
}

//pg_lo_create () crea un objeto grande y devuelve el OID del objeto grande. y devuelve el oid
function DB_lo_create($conn){
    if(strcmp(phpversion(),'4.2.0')<0)
        return pg_locreate($conn);
    else
        return pg_lo_create($conn);
}
//pg_lo_write () escribe datos en un objeto grande en la posición de búsqueda actual.
//devuelve El número de bytes escritos en el objeto grande o false en caso de error.
function DB_lo_write($fp,$data){
    if(strcmp(phpversion(),'4.2.0')<0)
        return pg_lowrite($fp,$data);
    else
        return pg_lo_write($pf,$data);
}
//pg_lo_unlink () elimina un objeto grande con la oid . Rendimientos true en caso de éxito o false fracaso.
//Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
function DB_lo_unlink($conn, $data) {
	if(($fp = DB_lo_open ($conn, $data, "r"))===false) return false;
	DB_lo_close($fp);
	if (strcmp(phpversion(),'4.2.0')<0)
		return pg_lounlink ($conn, $data);
	else
		return pg_lo_unlink ($conn, $data);
}

//abrir conexion a base de datos
//Tenemos un problema de seguridad aquí. La contraseña/usuario para acceder a postgresql
// se almacena en texto sin formato en un archivo con permiso de acceso para todos los que tienen shell
//en la máquina. Lo mejor que puede hacer es configurar postgres para permitir el acceso a la base de datos.
//datos de boca del usuario propietario de estos archivos php. Estos problemas no existen cuando
//shell en el servidor boca+postgres está restringido.
function DBConnect($forcenew=false) {
  // busca el archivo con la configuración. si no lo encuentras, usa patrones
	$conf = globalconf();
	if($conf["dblocal"]=="true") {
		if($forcenew)
			$conn = @pg_connect ("connect_timeout=10 dbname=".$conf["dbname"]." user=".$conf["dbuser"].
								 " password=".$conf["dbpass"],PGSQL_CONNECT_FORCE_NEW);
		else
			$conn = @pg_connect ("connect_timeout=10 dbname=".$conf["dbname"]." user=".$conf["dbuser"].
								 " password=".$conf["dbpass"]);
	} else {
		if($forcenew)
			$conn = @pg_connect ("connect_timeout=10 host=".$conf["dbhost"]." port=".$conf["dbport"]." dbname=".$conf["dbname"].
								 " user=".$conf["dbuser"]." password=".$conf["dbpass"],PGSQL_CONNECT_FORCE_NEW);
		else
			$conn = @pg_connect ("connect_timeout=10 host=".$conf["dbhost"]." port=".$conf["dbport"]." dbname=".$conf["dbname"].
								 " user=".$conf["dbuser"]." password=".$conf["dbpass"]);
	}
	if (!$conn) {
		LOGError("Unable to connect to database (${conf["dbhost"]},${conf["dbname"]},${conf["dbuser"]}).");
		MSGError("Unable to connect to database (${conf["dbhost"]}:${conf["dbport"]},${conf["dbname"]},${conf["dbuser"]}). ".
			"Is it running? Is the DB password in conf.php correct?");
		exit;
	}
	if(isset($conf["dbclientenc"]))
		DBExecNonStop($conn,"SET NAMES '${conf["dbclientenc"]}'","set client encoding");
	return $conn;
}

//cierra la conexión con la base de datos (esto no es realmente necesario, ya que php/Apache se encarga del servicio)
function DBClose($c) {
	pg_close($c);
}
//ejecutar declaración en la base de datos, sin terminar la ejecución de php
// en caso de error (pero con una llamada a la función LOGLevel)
//$conn es la conexión con el banco
//$sql es la instrucción sql
//$txt es un pequeño texto que describe lo que se está haciendo en sql
function DBExecNonStop($conn,$sql,$txt='') {
	if($txt=='') $txt='unknown at '. getFunctionName();
	$result = @DB_pg_exec ($conn, $sql);
	if (!$result) {
		LOGError("Unable to exec SQL in the database ($txt). " .
                         " Error=(" . pg_errormessage($conn) . ")");
	}
	return $result;
}
//ejecutar la instrucción en la base de datos, finalizando la ejecución de php
// en caso de error (además de la llamada a la función LOGLevel y alerta en pantalla)
//$conn es la conexión con el banco
//$sql es la instrucción sql
//$txt es un pequeño texto que describe lo que se está haciendo en sql
function DBExec($conn,$sql,$txt='') {
	if($txt=='') $txt='unknown at '. getFunctionName();
//	LOGLevel("DBExec: " . $sql, 3, false);
	$result = DB_pg_exec ($conn, $sql);
	if (!$result) {
		LOGError("Unable to exec SQL in the database ($txt). " .
				 " SQL=(" . sanitizeText(str_replace("\n", " ",$sql)) . "Error=(" . sanitizeText(str_replace("\n", " ",pg_errormessage($conn))) . ")");
		MSGError("Unable to exec SQL in the database ($txt). Aborting.");
		exit;
	}
	return $result;
}


function DB_pg_exec($conn, $data) {
	if (strcmp(phpversion(),'4.2.0')<0)
		return pg_exec ($conn, $data);
	else
		return pg_query ($conn, $data);
}

//ejecutar declaración en la base de datos, sin terminar la ejecución de php
//incluso en caso de error (solo se intentará mostrar una ventana de advertencia al usuario)
//$conn es la conexión con el banco
//$sql es la instrucción sql
//$txt es un pequeño texto que describe lo que se está haciendo en sql
function DBExecNoSQLLog($sql,$txt='') {
	if($txt=='') $txt='unknown at '.getFunctionName();
	$conn = DBConnect(true);
	$result = DB_pg_exec ($conn, $sql);
	pg_close($conn);
	if (!$result) {
		MSGError("No se puede ejecutar SQL en la base de datos($txt).");
	}
	return $result;
}

//devuelve el numero de filas de la consulta
function DBnlines ($result) {
	return pg_numrows ($result);
}
// obtener una fila de la consulta en formato de matriz
function DBRow ($r, $i) {
	return pg_fetch_array ($r, $i, PGSQL_ASSOC);
}
//hacer la consulta y obtener una fila de la consulta en formato de matriz
//$sql es la consulta sql
//$i es la línea deseada, comenzando desde cero
//$txt es una descripción de la consulta que se está realizando
function DBGetRow ($sql,$i,$c=null,$txt='') {
	if($txt=='') $txt='unknown at '.getFunctionName();
	if($c==null)
		$c = DBConnect();
	$r = DBExec($c,$sql,$txt);
	if (DBnlines($r) < $i+1) return null;
	$a = DBRow ($r, $i);
	if (!$a) {
	  DBClose($c);
	  LOGError("Unable to get row $i from a query ($txt). SQL=(" . $sql . ")");
	  MSGError("Unable to get row from query ($txt).");
	  exit;
	}
	return $a;
}

//funcion para eliminar la base de datos
function DBDropDatabase() {
	$conf = globalconf();
	if($conf["dblocal"]=="true")
		$conn = pg_connect ("connect_timeout=10 dbname=template1 user=".$conf["dbsuperuser"]." password=".$conf["dbsuperpass"]);
	else
		$conn = pg_connect ("connect_timeout=10 host=".$conf["dbhost"]." port=".$conf["dbport"]." dbname=template1 user=".$conf["dbsuperuser"].
				   " password=".$conf["dbsuperpass"]);
	 if(!$conn) {
		 MSGError("Unable to connect to template1 as ".$conf["dbsuperuser"]);
		 exit;
	 }
	 $r = DBExecNonStop($conn, "drop database ${conf["dbname"]}", "DBDropDatabase(drop)");
}
//para crear la base de datos....
// pg_connect ("options='--client_encoding=UTF8' dbname=template1 ... ????
function DBCreateDatabase() {
	$conf = globalconf();
	if($conf["dblocal"]=="true")
		$conn = pg_connect ("connect_timeout=10 dbname=template1 user=".$conf["dbsuperuser"]." password=".$conf["dbsuperpass"]);
	else
		$conn = pg_connect ("connect_timeout=10 host=".$conf["dbhost"]." port=".$conf["dbport"]." dbname=template1 user=".$conf["dbsuperuser"].
				   " password=".$conf["dbsuperpass"]);

	 if(!$conn) {
		 MSGError("Unable to connect to template1 as ".$conf["dbsuperuser"]);
		 exit;
	 }
	 if(isset($conf["dbencoding"]))
		 $r = DBExec($conn, "create database ${conf["dbname"]} with encoding = '${conf["dbencoding"]}'", "DBCreateDatabase(create)");
	 else
		 $r = DBExec($conn, "create database ${conf["dbname"]} with encoding = 'UTF8'", "DBCreateDatabase(create)");
}




//funcion devuelve la informacion de oid enviado pg_lo_read en hash
function DBcrc($id, $c=null) {
	$docommit=false;
	if($c == null) {
		$docommit=true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBcrc(begin)");
	}
    //pg_lo_open () abre un objeto grande en la base de datos y devuelve un recurso
    // de objeto grande para que pueda ser manipulado. pude ser w r rw el $mode
	if(($f = DB_lo_open($c, $id, "r")) === false) {
		if($docommit)
			DBExec($c, "commit work", "DBcrc(commit)");
        // just to return a unique string that will not match any other...
		return "no-HASH-" . rand() . "-" . rand() . "-" . time();
	}
    //pg_lo_read () lee como máximo lenbytes de un objeto grande y lo devuelve como una cadena .
    //Para utilizar la interfaz de objetos grandes, es necesario encerrarla dentro de un bloque de transacciones.
	$str = DB_lo_read($f,-1,$c);
	DB_lo_close($f);
	if($docommit)
		DBExec($c, "commit work", "DBcrc(commit)");
	return myshorthash($str);
}
































require_once('flog.php');
require_once('fuser.php');
require_once('fpatient.php');
require_once('fsurgery.php');
require_once('fpediatrics.php');
require_once('fprosthodontics.php');
require_once('foperative.php');
require_once('fclinichistory.php');

// eof
?>
