<?php
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');
// Incluir la biblioteca QR Code
require_once('../assets/phpqrcode/qrlib.php');
// Texto o datos para generar el QR
$userinfo=DBUserInfo($_SESSION['usertable']['usernumber']);
$data = '['.$userinfo['usernumber'].']['.$userinfo['userinfo'].']';
$conf=globalconf();
$dataenc= encryptData($data, $conf["key"], false);
// Generar el QR en memoria
$qrCode = QRcode::png($dataenc, false, QR_ECLEVEL_L, 10);

// Mostrar el QR en la página HTML
echo '<img src="data:image/png;base64,'.base64_encode($qrCode).'">';
?>
