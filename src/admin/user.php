<?php
require('header.php');
if (isset($_GET["user"]) && is_numeric($_GET["user"]) &&
    isset($_GET["logout"]) && $_GET["logout"] == 1) {
    //realizar un update al la tabla usertable campos userssion='' usersessionextra='' y otros si es
    //admin verifica el tiempo y realizar un
    //update si es menor a -600 el clocktime y limpia la carpeta problemtmp
	  DBLogOut($_GET["user"]);
    ForceLoad("user.php");
}

if (isset($_GET["usernumber"]) &&
    is_numeric($_GET["usernumber"]) && isset($_GET["confirmation"])) {
    if($_GET["confirmation"]=="active"){
        if(!enabledUser($_GET["usernumber"]))
            MSGError("no se puede activar el usuario");
    }
    //DBDeleteUser si es el mismo retorna false, hace update a usertable userenabled='f' y algunos
    //campos si existe en runtable status a deleted nueva tarea old tasktable answertable problemtable
    if($_GET["confirmation"]=="delete"){
        //para eliminar el usuario
        if (!DBDeleteUser($_GET["usernumber"]))
    		MSGError("El usuario no pudo eliminar.");//La usuario no pudo ser eliminada.
    }
    ForceLoad("user.php");
}




if (isset($_POST["username"]) && isset($_POST["userci"]) && isset($_POST["userfullname"]) && isset($_POST["userdesc"]) && isset($_POST["userip"]) &&
    isset($_POST["usernumber"]) && isset($_POST["userenabled"]) &&
    isset($_POST["usermultilogin"]) && isset($_POST["usertype"]) && isset($_POST["confirmation"]) &&
    isset($_POST["passwordn1"]) && isset($_POST["passwordn2"]) && isset($_POST["passwordo"]) && $_POST["confirmation"] == "confirm") {


	$param['user'] = htmlspecialchars($_POST["usernumber"]);
	$param['userci'] = htmlspecialchars($_POST["userci"]);//userci
	$param['username'] = htmlspecialchars($_POST["username"]);

	$param['enabled'] = htmlspecialchars($_POST["userenabled"]);
	$param['multilogin'] = htmlspecialchars($_POST["usermultilogin"]);
	$param['userfull'] = htmlspecialchars($_POST["userfullname"]);
	//$param['useremail'] = htmlspecialchars($_POST["useremail"]);
	$param['userdesc'] = htmlspecialchars($_POST["userdesc"]);
	$param['type'] = htmlspecialchars($_POST["usertype"]);
	$param['permitip'] = htmlspecialchars($_POST["userip"]);


	  $param['changepass']='t';
	  if(isset($_POST['changepass']) && $_POST['changepass'] != 't') $param['changepass']='f';

    $passcheck = $_POST["passwordo"];
    ////esta funcion retorna el registro de usuario y tambien si cambio o no hashpass = true
    $a = DBUserInfo($_SESSION["usertable"]["usernumber"], null, false);

    if(myhash($a['userpassword'] . session_id()) != $passcheck) {
        MSGError('Admin password is incorrect');
    } else {
        if ($_POST["passwordn1"] == $_POST["passwordn2"]) {
            //si son iguales retorna 0 si no retorna sub en resto de dos str.
            //pasa nuevopass1 datapass2
            $param['pass'] = bighexsub($_POST["passwordn1"],$a['userpassword']);
            while(strlen($param['pass']) < strlen($a['userpassword']))
                $param['pass'] = '0' . $param['pass'];
            if($param['user'] != 0)
                DBNewUser($param);//funcion para actulizar o insertar un nuevo usuario segun los datos que pasa
        } else MSGError ("Passwords don't match.");

    }
    ForceLoad("user.php");

}else if (isset($_FILES["importfile"]) && isset($_POST["Submit"]) && $_FILES["importfile"]["name"]!="") {

    if ($_POST["confirmation"] == "confirm") {
        $type=myhtmlspecialchars($_FILES["importfile"]["type"]);
        $size=myhtmlspecialchars($_FILES["importfile"]["size"]);
        $name=myhtmlspecialchars($_FILES["importfile"]["name"]);
        $temp=myhtmlspecialchars($_FILES["importfile"]["tmp_name"]);
        if (!is_uploaded_file($temp)) {
            IntrusionNotify("problema de carga de archivos.");
            ForceLoad("../user.php");
        }
        if (($ar = file($temp)) === false) {
            IntrusionNotify("No se puede abrir el archivo cargado.");
            ForceLoad("user.php");
        }
				$userlist=array();
				if(strtolower(substr($name,-4))==".tsv") {
          echo "en desarrollo";

				} else if(strtolower(substr($name,-4))==".tab") {
          echo "en desarrollo";
				} else {

					for ($i=0; $i < count($ar) && strpos($ar[$i], "[user]") === false; $i++) ;
					if($i >= count($ar)) MSGError('Formato de archivo no reconocido');
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
									case "userfullname":      $param['userfull']=trim($tmp[1]); break;
									case "userdesc":          $param['userdesc']=trim($tmp[1]); break;
									case "usertype":          $param['type']=trim($tmp[1]); break;
									case "userenabled":       $param['enabled']=trim($tmp[1]); break;
									case "usermultilogin":    $param['multilogin']=trim($tmp[1]); break;
									case "userpassword":      $param['pass']=myhash(trim($tmp[1])); break;
									case "userchangepassword": $param['changepass']=trim($tmp[1]); break;
									case "userip":            $param['permitip']=trim($tmp[1]); break;
                  case "userspecialtydessigned":            $param['specialtydessigned']=trim($tmp[1]); break;

								}
								$i++;
								if ($i>=count($ar)) break;
								$x = trim($ar[$i]);
						  }

							if($_SESSION["usertable"]["usertype"] == 'admin')
								if($param['usernumber'] != 0){
                  $usr=DBNewUser($param,null, true);
                  if($usr!=1&&$usr!=2)
                    $param['usernumber']=$usr;
                }

              if(isset($param['usernumber'])&& is_numeric($param['usernumber'])&&
               isset($param['specialtydessigned'])&& $param['specialtydessigned']!=''){
                  $asp=explode(',', $param['specialtydessigned']);
                  $size2=count($asp);
                  for ($j=0; $j < $size2; $j++) {
                    $data['user']=$param['usernumber'];
                    $data['clinical']=trim($asp[$j]);
                    $data['enabled']='t';
                    //$data['year']= date('Y',time());
                    DBNewSpecialty($data);
                  }
              }
            }
					}
				}
				if(count($userlist) > 0) {
?>
<center>
<br><u><b>Tomar nota de los usuarios y contraseñas y mantenerlos en secreto.</b></u><br><br>
<table border=1>
 <tr>
  <td nowrap><b>Sit</b></td><td><b>User #</b></td>
  <td><b>Password</b></td>
 </tr>
<?php
				  foreach($userlist as $user => $pass) {
						$x = explode('-',$user);
						echo "<tr><td>" . $x[0] . "</td><td>" . $x[1] . "</td><td>$pass</td></tr>\n";
					}
?>
</table><br><br><u><b>Tomar nota de los usuarios y contraseñas y mantenerlos en secreto.</b></u></center></body></html>
<?php
	         exit;
				}
    }
    ForceLoad("user.php");
}

//---para importacion de datos

//DBAllUserInfo seleccion la todos los usuario de la base de datos si pasa sitio de ese
//if $msite

$usr = DBAllUserInfo();

//else
//	$usr = DBAllUserInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"]);

?>

<div class="container-fluid px-4">

<br>
<a href="user.php#form_user" class="btn btn-success">Crear Usuario</a>

  <script language="javascript">
    function conf2(url) {
      if (confirm("Are you sure?")) {
        document.location=url;
      } else {
        document.location='user.php';
      }
    }
  </script>
<br>

<!--formulario de importacion de usuarios inicio-->
<center><b>
Para importar los usuarios, simplemente complete el campo de archivo de importación.<br>
El archivo debe tener el formato definido en el manual del administrador.</b></center>
<form name="form1" enctype="multipart/form-data" method="post" action="user.php">
  <input type=hidden name="confirmation" value="noconfirm" />
  <center>
    <table border="0">
      <tr>
        <td width="25%" align=right>Import file:</td>
        <td width="75%">
          <input type="file" class="form-control" name="importfile" size="40">
        </td>
      </tr>
    </table>
  </center>
  <script language="javascript">
    function conf() {
      if (confirm("Confirm?")) {
        document.form1.confirmation.value='confirm';
      }
    }
  </script>
  <center>
      <input type="submit" name="Submit" class="btn btn-primary" value="Import" onClick="conf()">
      <input type="reset" name="Submit2" class="btn btn-secondary" value="Clear">
  </center>
</form>

<!--formulario de importacion de usuarios fin-->


<div class="table-responsive">
<table class="table table-sm table-hover" id="table_users" style="width:100%">
    <thead>
        <tr>
            <th scope="col">ID #</th>
            <th scope="col">Usuario</th>
            <th scope="col">Tipo</th>
            <th scope="col">IP</th>
            <th scope="col">UltimoLogin</th>
            <th scope="col">UltimoLogout</th>
            <th scope="col">Activa</th>
            <th scope="col">Multi</th>
            <th scope="col">Nombre Completo</th>
            <th scope="col">Descripcion</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>


<?php
for ($i=0; $i < count($usr); $i++) {
      echo " <tr>\n";
      if($usr[$i]["usernumber"] != 0)
	      echo "  <td><a href=\"user.php?user=" .
		  $usr[$i]["usernumber"] . "\">" . $usr[$i]["usernumber"] . "</a>";
      else
	     echo "  <td>" . $usr[$i]["usernumber"];//para el admin
      if($usr[$i]['userenabled'] != 't' && $usr[$i]['userlastlogin'] < 1) echo "(inactive)";
      echo "</td>\n";

      //echo "  <td>" . $usr[$i]["usersitenumber"] . "</td>\n";
      echo "  <td>" . $usr[$i]["username"] . "&nbsp;</td>\n";

      echo "  <td>" . $usr[$i]["usertype"] . "&nbsp;</td>\n";
      if ($usr[$i]["userpermitip"]!="")
        echo "  <td>" . $usr[$i]["userpermitip"] . "*&nbsp;</td>\n";
      else
        echo "  <td>" . $usr[$i]["userip"] . "&nbsp;</td>\n";
      if ($usr[$i]["userlastlogin"] < 1)
        echo "  <td>never</td>\n";
      else
        echo "  <td>" . dateconv($usr[$i]["userlastlogin"]) . "</td>\n";
      if ($usr[$i]["usersession"] != "")
        echo "  <td><a href=\"javascript: conf2('user.php?logout=1&user=" .
             $usr[$i]["usernumber"] . "')\">Force Logout</a></td>\n";
      else {
        if ($usr[$i]["userlastlogout"] < 1)
          echo "  <td>never</td>\n";
        else//dateconv date — Dar formato a la fecha/hora del parametro pasado
          echo "  <td>" . dateconv($usr[$i]["userlastlogout"]) . "</td>\n";
      }
      if ($usr[$i]["userenabled"] == "t")
        echo "  <td>Yes</td>\n";
      else
        echo "  <td>No</td>\n";
      if ($usr[$i]["usermultilogin"] == "t")
        echo "  <td>Yes</td>\n";
      else
        echo "  <td>No</td>\n";
      echo "  <td>" . $usr[$i]["userfullname"] . "&nbsp;</td>\n";
      echo "  <td>" . $usr[$i]["userdesc"] . "&nbsp;</td>\n";

       if($usr[$i]["usernumber"] !=0 ){

            if($usr[$i]['userenabled'] != 't' && $usr[$i]['userlastlogin'] < 1){
                 echo " <td><div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\"><a onClick=\"conf7(".$usr[$i]["usernumber"].")\"" .
                       "')\" class=\"btn btn-warning\">Activar</a>";
                 echo "<a class=\"btn btn-secondary\" name=\"\" style=\"pointer-events: none; cursor: default; \">Actualizar</a></div>";
            }else{
                 echo " <td><div class=\"btn-group btn-group-toggle\" data-toggle=\"buttons\"><a " .
                     "')\" class=\"btn btn-danger\" onClick=\"conf4(".$usr[$i]["usernumber"].")\">Eliminar</a>";
                 echo "<a href=\"user.php?user=" .
        		  $usr[$i]["usernumber"] . "#form_user\" class=\"btn btn-primary\" name=\"\" >Actualizar</a></div>";
            }
            echo "<script language=\"javascript\">    function conf4(user) {\n";
            echo "      if (confirm('ADVERTENCIA: eliminar un usuario eliminará por completo TODO lo relacionado con él (incluidas las ejecuciones, aclaraciones, etc.).?')) {\n";
            //echo "            document.location='https://www.google.com/?hl=es'\n";
            echo "            document.location='user.php?usernumber='+user+'&confirmation=delete';\n";
            echo "      }\n";
            echo "    }</script>\n";
            echo "<script language=\"javascript\">    function conf7(user) {\n";
            echo "      if (confirm('ESTAS SEGURO DE ACTIVAR USUARIO?')) {\n";
            //echo "            document.location='https://www.google.com/?hl=es'\n";
            echo "            document.location='user.php?usernumber='+user+'&confirmation=active';\n";
            echo "      }\n";
            echo "    }</script>\n";
          //echo "  <td><a href=\"user.php?site=" . $usr[$i]["usersitenumber"] . "&user=" .
 		  //$usr[$i]["usernumber"] . "#form_user\">" . "ACTUALIZAR" . "</a>";

       }else{
 	      echo "  <td>" . $usr[$i]["usernumber"];//para el admin
       }
       //f($usr[$i]['userenabled'] != 't' && $usr[$i]['userlastlogin'] < 1) echo "(inactive)";
          echo "</td>\n";



      echo "</tr>";
}
echo "</tbody></table>\n";

unset($u);//pero aun no existe para seguridad
if (isset($_GET["user"]) && is_numeric($_GET["user"]))
  $u = DBUserInfo($_GET["user"]);
////esta funcion retorna el registro de usuario y tambien si cambio o no hashpass = true
?>
</div>

<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script language="JavaScript">
function computeHASH()
{
	document.form3.passwordn1.value = bighexsoma(js_myhash(document.form3.passwordn1.value),js_myhash(document.form3.passwordo.value));
	document.form3.passwordn2.value = bighexsoma(js_myhash(document.form3.passwordn2.value),js_myhash(document.form3.passwordo.value));
	document.form3.passwordo.value = js_myhash(js_myhash(document.form3.passwordo.value)+'<?php echo session_id(); ?>');
//	document.form3.passwordn1.value = js_myhash(document.form3.passwordn1.value);
//	document.form3.passwordn2.value = js_myhash(document.form3.passwordn2.value);
}
</script>


<div class="container">


    <!--FORMULARIO IMPORT OTRO FORMULARIO-->

      <br><br>
      <center>
    <!--To create/edit one user, enter the data below.<br>
    Note that any changes will overwrite the already defined data.<br>
    (Specially care if you use a user number that is already existent.)-->
    <a id="form_user"></a>
    <!--<b>Para crear / editar un usuario, ingrese los datos a continuación. <br>
    Tenga en cuenta que cualquier cambio sobrescribirá los datos ya definidos. <br>
    (Tenga especial cuidado si usa un número de usuario que ya existe).<br>
    <br>-->
    </b></center>

    <form name="form3" action="user.php" method="post">
      <input type=hidden name="confirmation" value="noconfirm" />
      <script language="javascript">
        function conf3() {
          computeHASH();
          if (confirm("Confirm?")) {
            document.form3.confirmation.value='confirm';
          }
        }

        function conf5() {
          document.form3.confirmation.value='noconfirm';
        }
      </script>

      <div class="mb-3 row">
          <!--<label for="usernumber" class="col-sm-4 col-form-label">Usuario Id:</label>-->
          <div class="col-sm-8">
              <input type="hidden" name="usernumber" id="usernumber" class="form-control" value="<?php if(isset($u)) echo $u["usernumber"]; else echo DBUserNumberMax(); ?>" maxlength="20" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="userci" class="col-sm-4 col-form-label">Usuario CI:</label>
          <div class="col-sm-8">
              <input type="text" name="userci" id="userci" class="form-control" value="<?php if(isset($u)) echo $u["userci"]; ?>" maxlength="20" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="username" class="col-sm-4 col-form-label">Usuario Nombre:</label>
          <div class="col-sm-8">
              <input type="text" name="username" id="username" class="form-control" value="<?php if(isset($u)) echo $u["username"]; ?>" maxlength="20" />
          </div>
      </div>
      <!--ICPC ID-->
      <div class="mb-3 row">
          <label for="" class="col-sm-4 col-form-label">Tipo:</label>
          <div class="col-sm-4">
                <select name="usertype" class="form-select" aria-label="Default select example">
          		<option <?php if(!isset($u) || $u["usertype"] == "admission") echo "selected"; ?> value="admission">Admision</option>

          		<option <?php if(isset($u)) if($u["usertype"] == "teacher") echo "selected"; ?> value="teacher">Docente</option>
          		<option <?php if(isset($u)) if($u["usertype"] == "student") echo "selected"; ?> value="student">Estudiante</option>
          		<option <?php if(isset($u)) if($u["usertype"] == "chiefclinics") echo "selected"; ?> value="chiefclinics">Jefe de Clínicas</option>


          		  </select>
          </div>
      </div>
      <div class="mb-3 row">
          <label for="" class="col-sm-4 col-form-label">Activo:</label>
          <div class="col-sm-2">
              <select name="userenabled" class="form-select" aria-label="Default select example">
      		  <option <?php if(!isset($u) || $u["userenabled"] != "f") echo "selected"; ?> value="t">Yes</option>
      		  <option <?php if(isset($u) && $u["userenabled"] == "f") echo "selected"; ?> value="f">No</option>
      		  </select>
        </div>
      </div>
      <!--MultiLogins (los equipos locales deben establecerse en <b> No </b>):-->
      <div class="mb-3 row">
          <label for="" class="col-sm-4 col-form-label">MultiLogins (Loguearse multiples Veces):</label>
          <div class="col-sm-2">
              <select name="usermultilogin" class="form-select" aria-label="Default select example">
      		<option <?php if(isset($u) && $u["usermultilogin"] == "t") echo "selected"; ?> value="t">Yes</option>
      		<option <?php if(!isset($u) || $u["usermultilogin"] != "t") echo "selected"; ?> value="f">No</option>
      		</select>
        </div>
      </div>
      <div class="mb-3 row">
          <label for="userfullname" class="col-sm-4 col-form-label">Nombre Completo del Usuario:</label>
          <div class="col-sm-8">
              <input type="text" name="userfullname" id="userfullname" class="form-control" value="<?php if(isset($u)) echo $u["userfullname"]; ?>" maxlength="200" />
          </div>
      </div>


      <div class="mb-3 row">
          <label for="userdesc" class="col-sm-4 col-form-label">Descripcion Usuario:</label>
          <div class="col-sm-8">
              <input type="text" name="userdesc" id="userdesc" class="form-control" value="<?php if(isset($u)) {
              if($u['usershortinstitution']!='')
                  echo '[' . $u['usershortinstitution'] .']';
              if($u['userflag']!='') {
                  echo '[' . $u['userflag'];
                  if($u['usersitename']!='') echo ',' . $u['usersitename'];
                  echo ']';
              }
              echo $u["userdesc"]; } ?>" maxlength="300" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="userip" class="col-sm-4 col-form-label">IP Usuario:</label>
          <div class="col-sm-8">
              <input type="text" name="userip" id="userip" class="form-control" value="<?php if(isset($u)) echo $u["userpermitip"]; ?>" size="20" maxlength="20" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="passwordn1" class="col-sm-4 col-form-label">Contraseña:</label>
          <div class="col-sm-8">
              <input type="password" name="passwordn1" id="passwordn1" class="form-control" value="" size="20" maxlength="200" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="passwordn2" class="col-sm-4 col-form-label">Repitir Contraseña:</label>
          <div class="col-sm-8">
              <input type="password" name="passwordn2" id="passwordn2" class="form-control" value="" size="20" maxlength="200" />
          </div>
      </div>
      <div class="mb-3 row">
          <label for="" class="col-sm-4 col-form-label">Permitir cambio de Contraseña:</label>
          <div class="col-sm-2">
              <select name="changepass" class="form-select" aria-label="Default select example">
      		  <option <?php if(isset($u) && $u["changepassword"]) echo "selected"; ?> value="t">Yes</option>
      		  <option <?php if(!isset($u) || !$u["changepassword"]) echo "selected"; ?> value="f">No</option>
      		  </select>
        </div>
      </div>
      <div class="mb-3 row">
          <label for="passwordo" class="col-sm-4 col-form-label">Contraseña del admin:</label>
          <div class="col-sm-8">
              <input type="password" name="passwordo" id="passwordo" class="form-control" value="" size="20" maxlength="200" />
        </div>
      </div>

      <div class="mb-3 row">
        <div class="col-6">
          <input type="submit" class="btn btn-primary"name="Submit" value="Send" onClick="conf3()">&nbsp;
          <input type="submit" class="btn btn-primary"name="Cancel" value="Cancel" onClick="conf5()">
        </div>
      </div>
    </form>

</div>
</div>

<?php
require('footer.php');
?>
