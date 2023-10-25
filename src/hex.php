<?php
function myhash9($k) {
	return strtoupper(substr(myhash($k), 0, 9));
}
function myshorthash($k) {
	return hash('sha1',$k);
}
function myhash($k) {
	return hash('sha256',$k);
}
function myhmac($k,$d) {
	return hash_hmac('sha256',$k,$d);
}

function encryptData($text,$key,$compress=true) {
	if(!function_exists('openssl_cipher_iv_length')) {
		//Error de cifrado: php openssl no instalado: comuníquese con un administrador
		MSGError("Encryption error -- php openssl not installed -- contact an admin (" . getFunctionName() .")");
		LogError("Encryption error -- php openssl not installed -- contact an admin (" . getFunctionName() .")");
		return "";
	}

	$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
	$key = myhash($key . "123456789012345678901234567890"); // . myhash($key);
	$grade='##';
	if($compress) {
		$text = zipstr($text);
		$grade = '@#';
	}
	$crypttext = openssl_encrypt($text . myshorthash($text) . $grade, 'aes-256-cbc', substr(pack("H*", $key),0,32), OPENSSL_RAW_DATA, $iv);
	return base64_encode($crypttext . $iv);
}

function decryptData($crypttext,$key,$txt='') {
	if(!function_exists('openssl_cipher_iv_length')) {
		MSGError("Encryption error -- php openssl not installed -- contact an admin (" . getFunctionName() .")");
		LogError("Encryption error -- php openssl not installed -- contact an admin (" . getFunctionName() .")");
		return "";
	}
	$crypttext = base64_decode($crypttext);
	$iv_size = openssl_cipher_iv_length('aes-256-cbc');
	$iv = openssl_random_pseudo_bytes($iv_size);
	$test1='';
	$test2='x';
	$clen = strlen($crypttext);
	if($clen > $iv_size) {
		$iv = substr($crypttext, $clen-$iv_size, $iv_size);
		$crypttext = substr($crypttext, 0, $clen-$iv_size);
		$key = myhash($key . "123456789012345678901234567890"); // . myhash($key);

		$decrypttext = openssl_decrypt($crypttext, 'aes-256-cbc', substr(pack("H*", $key),0,32), OPENSSL_RAW_DATA, $iv);
		$pos = strrpos($decrypttext,"#");
		$iscompressed=false;
		if(substr($decrypttext,$pos-1,1)=='@') $iscompressed=true;
		$ll=strlen(myshorthash("x"));
		$test2 = substr($decrypttext,$pos-1-$ll, $ll);
		$decrypttext = substr($decrypttext,0,$pos-1-$ll);
		$test1 = myshorthash($decrypttext);
	}
	if($test1 != $test2) {
		if($txt=='')
			MSGError("Decryption error -- contact an admin now (" . getFunctionName() .")");
		else
		    LogError("Decryption error (" . getFunctionName() .",$txt)");
		return "";
	}
	if($iscompressed) return unzipstr($decrypttext);
	return $decrypttext;
}

//hex1 e hex2 sao strings hexa
//devolve a soma das duas
function bighexsoma ($hex1, $hex2){
	if (strlen($hex1) > strlen($hex2)) {
		$a = $hex2;
		$hex2 = $hex1;
		$hex1 = $a;
	}
	while (strlen($hex1) < strlen($hex2))
		$hex1 = '0' . $hex1;

	$sobra = 0;
	$resultado = '';
	for($x = strlen($hex1)-1; $x>=0; $x--){

		$op1 = (int) hexdec(substr($hex1,$x,1));
		$op2 = (int) hexdec(substr($hex2,$x,1));

		$r = $op1 + $op2 + $sobra;
		if ($r > 15) {
			$r -= 16;
			$sobra = 1;
		} else $sobra = 0;

		$resultado = dechex($r) . $resultado;
	}
	if ($sobra == 1)
		$resultado = '1' . $resultado;
	return $resultado;
}
//hex1 e hex2 sao strings hexa
//devolve a string que representa hex1 - hex2
function bighexsub ($hex1, $hex2) {
	$h1 = strlen($hex1);
	$h2 = strlen($hex2);
	while ($h1 < $h2) {
		$hex1 = '0' . $hex1;
		$h1++;
	}
	while ($h2 < $h1) {
		$hex2 = '0' . $hex2;
		$h2++;
	}

	$i=0;
	while ($hex1[$i] == $hex2[$i] && $i<$h1) $i++;
	if ($i>=$h1) return '0';

	if ($hex1[$i] > $hex2[$i]) {
		$sinal='';
	} else {
		$sinal = '-';
		$a = $hex2;
		$hex2 = $hex1;
		$hex1 = $a;
	}

	$sobra = 0;
	$resultado = '';
	for($x = $h1-1; $x>=0; $x--) {
		$op1 = (int) hexdec(substr($hex1,$x,1));
		$op2 = (int) hexdec(substr($hex2,$x,1));

		$r = $op1 - $op2 - $sobra;
		if ($r < 0) {
			$r += 16;
			$sobra = 1;
		} else $sobra = 0;
		if($x > 0 || dechex($r) != '0')
			$resultado = dechex($r) . $resultado;
	}
	return $sinal . $resultado;
}
// eof
?>
