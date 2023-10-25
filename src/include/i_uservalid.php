<?php
session_start();
require_once('../db.php');
require_once('../globals.php');

if(isset($_POST["name"]) && $_POST["name"] != "" ) {

    $name = $_POST["name"];
    $password = $_POST["pass"];
    //para login ... log....
    $usertable = DBLogIn3($name, $password, false);

    if($usertable){
      echo 'true';
    }else {
      echo 'false';
    }
    exit;
}
?>
