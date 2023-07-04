<?php
session_start();
require_once('../version.php');
require_once('../globals.php');
require_once('../db.php');
// Incluir la biblioteca QR Code
require_once('../assets/phpqrcode/qrlib.php');


require('../fpdf/fpdf.php');

class PDF extends FPDF{
  //page header


  //Page footer
  function Footer(){
    //position at 1.5 cm from bottom
    $this->SetY(-8);
    $this->SetFont('Arial','I',7);
    //text color in gray
    $this->SetTextColor(128);
    //Page number
    $this->Cell(0,10,'Sistema de historial clinico odontologico - UNSXX',0,0,'C');
  }
  function ChapterTitle($name){
    //Arial 12
    $this->SetY(1);
    $this->SetX(1);
    $this->SetFont('Arial','',9);
    //background color
    $this->SetFillColor(200,220,255);
    //title
    $this->Cell(58,5,$name, 0,1,'C',true);
    //Line break
    $this->Ln();
  }
  function ChapterBody($content, $image){
    $this->Image($image,0,7,60,0,'PNG');
  }
  function PrintChapter($name, $content, $image){
    $this->AddPage();
    //$this->SetPageSize(100,100);
    $this->ChapterTitle($name);
    $this->ChapterBody($content,$image);
  }
}

if(!isset($_SESSION['usertable']['usernumber'])&& !is_numeric($_SESSION['usertable']['usernumber']))
  exit;

$userinfo=DBUserInfo($_SESSION['usertable']['usernumber']);


$pdf = new PDF('P','mm',array(60,70));
$title='';
if($userinfo['usertype']=='teacher'){
  $title='Dr(a). '.$userinfo['userfullname'];
}else{
  $title=$userinfo['userfullname'];
}
$text='';
$pdf->SetTitle($title);
$pdf->SetAuthor('Fabian Sierra');

$data = '['.$userinfo['usernumber'].']['.$userinfo['userinfo'].']';
$conf=globalconf();
$dataenc= encryptData($data, $conf["key"], false);

$temp_qr_file=tempnam(sys_get_temp_dir(), 'qr').'.png';
QRcode::png($dataenc, $temp_qr_file,QR_ECLEVEL_L, 10);
// Generar el QR en memoria
//$qrCode = QRcode::png($dataenc, false, QR_ECLEVEL_L, 10);


$pdf->PrintChapter($title,$text,$temp_qr_file);

unlink($temp_qr_file);

$pdf->Output();

?>
