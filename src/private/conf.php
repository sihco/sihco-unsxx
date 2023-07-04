<?php

//configuracion global
function globalconf() {
  $conf["dbencoding"]="UTF8";
  $conf["dbclientenc"]="UTF8";
  $conf['doenc']=false;

  $conf["dblocal"]="false"; // usar unix socket para conectar?
  $conf["dbhost"]="localhost";
  $conf["dbport"]="5432";

  $conf["dbname"]="sihcodb"; // nombre de db de sihco

  $conf["dbuser"]="sihcouser"; // nombre de usuario de sihco
  $conf["dbpass"]="evelyn123";

  $conf["dbsuperuser"]="sihcouser"; // privelegio de usuario de sihco
  $conf["dbsuperpass"]="evelyn123";

// tenga en cuenta que está bien usar el mismo usuario

  // contraseña inicial que se usa para el administrador del usuario: configúrela
  // a algo difícil de adivinar si el servidor está disponible

  $conf["basepass"]="sihco";

  $conf["key"]="GG56KFJtNDBGjJprR6ex";//tambien se utiliza para QR


  $conf["ip"]='local';

  return $conf;
}
?>
