<?php
//eliminar la tabla de usuarios...
function DBDropUserTable() {
    //conexcion de la base de datos..
	 $c = DBConnect();

	 $r = DBExec($c, "drop table \"usertable\"", "DBDropUserTable(drop table)");

}
function DBCreateUserTable() {
	 $c = DBConnect();
	 $conf = globalconf();
	 if($conf["dbuser"]=="") $conf["dbuser"]="sihcouser";
	 $r = DBExec($c, "
CREATE TABLE \"usertable\" (
				\"usernumber\" int4 NOT NULL,                     -- (id de usuario)
				\"userci\" int4 NOT NULL,													-- (ci de usuario)
				\"username\" varchar(20) NOT NULL,                -- (nombre de usuario)
        \"userfullname\" varchar(200) NOT NULL,           -- (nombre completo de usuario)
        \"userdesc\" varchar(300),                        -- (descripcion del usuario etc)
        \"usertype\" varchar(20) NOT NULL,                -- (admin, admission, teacher, student)
        \"userenabled\" bool DEFAULT 't' NOT NULL,        -- (usuario activo)
				\"userpermitlogin\" bool DEFAULT 't' NOT NULL,		-- (usuario esta permitido logueos)
        \"usermultilogin\" bool DEFAULT 'f' NOT NULL,     -- (usuario puede loguearse multiples veces)
        \"userpassword\" varchar(200) DEFAULT '',         -- (password)
        \"userip\" varchar(300),                          -- (ip de ult accesso)
        \"userlastlogin\" int4,                           -- (ultima session)
        \"usersession\" varchar(50) DEFAULT '',           -- (session de usuario)
        \"usersessionextra\" varchar(50) DEFAULT '',      -- (dos session de usuario)
        \"userlastlogout\" int4,                          -- (ultima vez logout)
        \"userpermitip\" varchar(300),                    -- (acceso de ip permitido)
        \"userinfo\" varchar(300) DEFAULT '',
        \"updatetime\" int4 DEFAULT EXTRACT(EPOCH FROM now()) NOT NULL, -- (indica la ultima actualizacion del registro)
        CONSTRAINT \"user_pkey\" PRIMARY KEY (\"usernumber\")
)", "DBCreateUserTable(create table)");
	$r = DBExec($c, "REVOKE ALL ON \"usertable\" FROM PUBLIC", "DBCreateUserTable(revoke public)");
	$r = DBExec($c, "GRANT ALL ON \"usertable\" TO \"".$conf["dbuser"]."\"", "DBCreateUserTable(grant sihcouser)");
	$r = DBExec($c, "CREATE UNIQUE INDEX \"user_index\" ON \"usertable\" USING btree ".
	     "(\"usernumber\" int4_ops)",
	     "DBCreateUserTable(create user_index)");
	$r = DBExec($c, "CREATE INDEX \"user_indexci\" ON \"usertable\" USING btree ".
	     "(\"userci\" int4_ops)",
	     "DBCreateUserTable(create user_indexci)");
	$r = DBExec($c, "CREATE INDEX \"user_indexname\" ON \"usertable\" USING btree ".
	     "(\"username\" varchar_ops)",
	     "DBCreateUserTable(create user_indexname)");
}

//////////////////////////////funciones de usuarios///////////////////////////////////////
function DBFakeUser() {
	$c = DBConnect();
	DBExec($c, "begin work");

	$cf = globalconf();
	$pass = myhash($cf["basepass"]);
	DBExec($c, "insert into usertable (usernumber, userci, username, userfullname, ".
		"userdesc, usertype, userenabled, userpermitlogin, usermultilogin, userpassword, userip, userlastlogin, usersession, ".
		"userlastlogout, userpermitip) ".
		"values (0, 8, 'admin', 'Administrador', NULL, 'admin', 't', 't', ".
           "'t', '$pass', NULL, NULL, '', NULL, NULL)", "DBFakeContest(insert admin user)");

	DBExec($c, "insert into usertable (usernumber, userci, username, userfullname, ".
		"userdesc, usertype, userenabled, userpermitlogin, usermultilogin, userpassword, userip, userlastlogin, usersession, ".
		"userlastlogout, userpermitip) ".
		"values (1, 9, 'fabian', 'fabian sierra', NULL, 'admission', 't', 't', ".
           "'t', '$pass', NULL, NULL, '', NULL, NULL)", "DBFakeContest(insert admission user)");

	DBExec($c, "insert into usertable (usernumber, userci, username, userfullname, ".
		"userdesc, usertype, userenabled, userpermitlogin, usermultilogin, userpassword, userip, userlastlogin, usersession, ".
		"userlastlogout, userpermitip) ".
		"values (2, 10, 'maria', 'maria cuizara', NULL, 'student', 't', 't', ".
           "'t', '$pass', NULL, NULL, '', NULL, NULL)", "DBFakeContest(insert student user)");

	DBExec($c, "insert into usertable (usernumber, userci, username, userfullname, ".
		"userdesc, usertype, userenabled, userpermitlogin, usermultilogin, userpassword, userip, userlastlogin, usersession, ".
		"userlastlogout, userpermitip) ".
		"values (3, 11, 'liz', 'liz mamani', NULL, 'student', 't', 't', ".
           "'t', '$pass', NULL, NULL, '', NULL, NULL)", "DBFakeContest(insert student user)");
	DBExec($c, "insert into usertable (usernumber, userci, username, userfullname, ".
		"userdesc, usertype, userenabled, userpermitlogin, usermultilogin, userpassword, userip, userlastlogin, usersession, ".
		"userlastlogout, userpermitip) ".
		"values (4, 11, 'dora', 'dora flores', NULL, 'teacher', 't', 't', ".
           "'t', '$pass', NULL, NULL, '', NULL, NULL)", "DBFakeContest(insert teacher user)");

	insertclinical($c);
	insertspecialty($c);

	DBExec($c, "commit work");
}

//funcion para actulizar usuario y modificacion de password
//ac1
function DBUserUpdate($user, $username, $userfull, $userdesc, $passo, $passn){
    $a = DBUserInfo($user, null, false);//esta funcion retorna el registro de usuario y tambien si cambio o no hashpass = true
    $p = myhash($a["userpassword"].session_id());
    if($a["userpassword"] != "" && $p != $passo){
        LOGLevel("User ".$_SESSION["usertable"]["username"].
            "tried to change settings, but password was incorrect. ",2);
            //intentó cambiar la configuración, pero la contraseña era incorrecta.
        MSGError("Incorrect password");
    }else{
        if(!$a['changepassword']){
            //El cambio de contraseña está DESHABILITADO
            MSGError('Password change is DISABLED'); return;
        }
        if($a["userpassword"] == "") $temp = myhash("");
        else $temp=$a["userpassword"];
        $lentmp = strlen($temp);//para saber el tamano de la cadena
        $temp = bighexsub($passn, $temp);///si son iguales retorna 0 si no retorna sub en resto de dos str.

        if($lentmp>strlen($temp)){//esperar...
            $newpass='0'.$temp;
            while(strlen($newpass)<$lentmp) $newpass='0'.$newpass;
        }else{
            $newpass=substr($temp,strlen($temp)-$lentmp);
        }
        $c=DBConnect();
        DBExec($c,"begin work");
        DBExec($c,"lock table usertable");
        $r=DBExec($c,"select *from usertable where username='$username' and usernumber!=$user");
        $n=DBnlines($r);
        if($n == 0){
						if($userfull!='') $userfull=strtolower($userfull);
            $sql="update usertable set username='$username', userdesc='$userdesc', userfullname='$userfull', updatetime=".time();
            if($newpass !=myhash("")) $sql.=", userpassword='$newpass'";
            $sql .= " where usernumber=$user";
            $r=DBExec($c,$sql);
            DBExec($c,"commit work");
            LOGLevel("User ".$_SESSION["usertable"]["username"]." changed his settings (newname=$username) ",2);

            $_SESSION["usertable"]["userfullname"]=$userfull;//para cambiar el session de userfull
            MSGError("Data updated.");
            //ForceLoad("index.php");//index.php
        }else{
            DBExec($c,"rollback work");
            //no pudo cambiar su configuración
            LOGLevel("User ".$_SESSION["usertable"]["username"]." couldn't change his settings ",2);
            MSGError("Update problem (maybe username already in use). No data was changed.");
        }
    }

}




//funcion para sacar la informacion de usuario
function DBUserInfo($user, $c=null,$hashpass=true) {

	$sql = "select * from usertable where usernumber=$user";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		MSGError("Unable to find the user in the database. Contact an admin now!");
	}
	$a['changepassword']=true;
	if(substr($a['userpassword'],0,1)=='!') {
		$a['userpassword'] = substr($a['userpassword'],1);
		$a['changepassword']=false;
	}
	if($a['userfullname']!=''){
		$a['userfullname']=ucwords($a['userfullname']);
	}
	if($hashpass)
		$a['userpassword'] = myhash($a['userpassword'] . $a['usersessionextra']);
	return cleanuserdesc($a);
}
//funcion para sacar la informacion de usuario
function DBUserInfoFullname($fullname, $c=null,$hashpass=true, $usertypediff=null) {
	if($fullname!=''){
		$fullname=strtolower($fullname);
	}
	$sql = "select * from usertable where userfullname='$fullname'";
	if($usertypediff!=null){
		$sql.=" and usertype!='$usertypediff'";
	}
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}
	$a['changepassword']=true;
	if(substr($a['userpassword'],0,1)=='!') {
		$a['userpassword'] = substr($a['userpassword'],1);
		$a['changepassword']=false;
	}
	if($a['userfullname']!=''){
		$a['userfullname']=ucwords($a['userfullname']);
	}
	if($hashpass)
		$a['userpassword'] = myhash($a['userpassword'] . $a['usersessionextra']);
	/* $inst = explode(']',$a['userfullname']); */
	/* if(isset($inst[1])) { */
	/* 	$a['userfullname'] = trim($inst[1]); */
	/* 	$inst = explode('[',$inst[0]); */
	/* 	if(isset($inst[1])) */
	/* 	   $a['usershortname'] = trim($inst[1]); */
	/* } */
	return cleanuserdesc($a);
}
//funcion para sacar la informacion de usuario designado
function DBUserDesignedInfoFullname($fullname, $designed, $c=null,$hashpass=true) {
	if($fullname!=''){
		$fullname=strtolower($fullname);
	}
	$sql = "select u.usernumber as user, s.clinicalid as clinical from usertable as u, specialtytable s ".
					"where u.userfullname='$fullname' and s.userid=u.usernumber and clinicalid=$designed and u.usertype='student'";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database from designed. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}

	return $a;
}
//funcion para buscar un usuario en la designacion de la especilidad por id
function DBUserDesignedInfo($userid, $designed, $usertype=null, $c=null,$hashpass=true) {
	$sql = "select u.usernumber as user, s.clinicalid as clinical from usertable as u, specialtytable s ".
					"where u.usernumber=$userid and s.userid=u.usernumber and clinicalid=$designed";
	if($usertype != null){
		$sql.="  and u.usertype='$usertype'";
	}
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database from designed. SQL=(" . $sql . ")");

		//MSGError("Unable to find the user in the database. Contact an admin now!");
		return null;
	}

	return $a;
}
//funcion para buscar usuarios
function DBUserSearchInfo($search, $c=null) {
	if($search!=''){
		$search=strtolower($search);
	}
	$sql = "select usernumber as user, userfullname as fullname, usertype as type from usertable where userfullname LIKE '%$search%' and userenabled!='f' and usernumber!=0 and usertype!='admission' order by usernumber";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBUserSearchInfo(get users)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find Patient in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find patient in the database!");

		exit;
	}
	if($n>9)
		$n=10;
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$id=$a[$i]["user"];
		$fullname=ucwords($a[$i]["fullname"]);
		echo "<a class=\"dropdown-item text-primary click_write\" href=\"decide.php?name=$fullname\">$fullname - ".$a[$i]['type']."</a>";
	}

	return $a;
}
//retorna la informacion de userfullname
function DBSearchUserFullName($search, $c=null) {
	if($search!=''){
		$search=strtolower($search);
	}
	$sql = "select usernumber, username, userfullname, usertype, updatetime from usertable where userfullname LIKE '%$search%'";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBUserSearchInfo(get users)");
	$n = DBnlines($r);
	if ($n == 0) {
		//echo "Unable to find Patient in the database. SQL=(" . $sql . ")";
		//LOGError("Unable to find Patient in the database. SQL=(" . $sql . ")");
		//MSGError("Unable to find patient in the database!");

		return array();
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}

	return $a;
}
//funcion para obtener informacion de usuario designado a una specialidad
//funcion para buscar usuarios con especialidad
function DBSpecialtyUserInfo($user, $clinical, $c=null) {

	$sql = "select * from specialtytable where userid=$user and clinicalid=$clinical";
	//funcion para capturar la fila del usuario
	$a = DBGetRow ($sql, 0, $c);

	return $a;
}
//para actualizar la informacion
function DBUpdateSpecialtyEnabled($user, $clinical, $status, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateSpecialtyEnabled(begin)");
		}
		DBExec($c, "lock table specialtytable", "DBUpdateSpecialtyEnabled(lock)");

		$ret=2;
		$time=time();
		if(is_numeric($user)&& is_numeric($clinical)&&$status){
				$sql="update specialtytable set specialtyenabled='$status', updatetime=$time where userid=$user and clinicalid=$clinical";
				DBExec($c, $sql, "DBUpdateSpecialtyEnabled(update specialtytable)");
		}else{
			$ret=1;
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//actualizar la informacion del paciente
function DBUpdateInfoUser($user, $data, $c=null){
		$cw = false;
		if($c == null) {
			$cw = true;
			$c = DBConnect();
			DBExec($c, "begin work", "DBUpdateInfoUser(begin)");
		}
		DBExec($c, "lock table usertable", "DBUpdateInfoUser(lock)");

		$ret=2;
		$time=time();
		if(is_numeric($user)){
				$sql="update usertable set userinfo='$data', updatetime=$time where usernumber=$user";
				DBExec($c, $sql, "DBUpdateInfoUser(update usertable)");
		}else{
			$ret=1;
		}
		if($cw) {
				DBExec ($c, "commit work");
		}
		return $ret;
}
//funcion para buscar usuarios con especialidad
function DBSpecialtySearchInfo($search1, $search2, $type, $t=null, $c=null) {

	$c = DBConnect();
	if($search1!=''){
		$search1=strtolower($search1);
	}
	if(!is_numeric($search2))
		return 0;
	$sql3 = "select u.usernumber as user, u.userfullname as fullname, u.usertype as type, ".
					"s.stdatetime as stdatetime, s.specialtyenabled as enabled, s.stdatetime, s.updatetime, s.clinicalid as clinical, ".
					"c.clinicalspecialty as specialty from usertable as u, ".
					"specialtytable as s, clinicaltable as c where (u.userfullname LIKE '%$search1%') ".
					"and s.userid=u.usernumber and c.clinicalid=s.clinicalid ";
	if($search2==-1){
		if($t!=null)
			$sql3.="and u.usertype='$t' and s.specialtyenabled='t' and u.usernumber!=0 order by u.usernumber";
		else
			$sql3.="and u.usernumber!=0 order by u.usernumber";
	}else{
		if($t!=null)
			$sql3.="and u.usertype='$t' and s.specialtyenabled='t' and c.clinicalid=$search2 and u.usernumber!=0 order by usernumber";
		else
			$sql3.="and c.clinicalid=$search2 and u.usernumber!=0 order by u.usernumber";
	}

	$r = DBExec ($c, $sql3, "DBSpecialtySearchInfo(get users)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find Patient in the database. SQL=(" . $sql3 . ")");
		//MSGError("Unable to find patient in the database!");
		exit;
	}
	if($n>9)
		$n=10;
	$a = array();
	if ($type=='tab') {
		for ($i=0; $i <$n ; $i++) {
			$a[$i] = DBRow($r,$i);
			echo " <tr>\n";
			echo "	<td>$j</td>\n";
			echo "  <td>" . ucwords($a[$i]["fullname"]) . "</td>\n";
			echo "  <td>" . $a[$i]["type"] . "</td>\n";
			echo "  <td>" . $a[$i]["specialty"] . "</td>\n";//$a[$i]["specialty"]
			echo "  <td>" . datetimeconv($a[$i]["stdatetime"]) ."</td>\n";
			if($a[$i]['enabled']=='f'){
				echo "  <td>" . datetimeconv($a[$i]["updatetime"]) ."</td>\n";
			}else{
				echo "  <td></td>\n";
			}


			echo "<td>";
			if($a[$i]['enabled']=='t'){
					echo "<button type=\"button\" onclick=\"save(".$a[$i]["user"].",".$a[$i]["clinical"].")\" class=\"btn btn-danger\" name=\"".$a[$i]["user"]."\" id=\"".$a[$i]["user"]."".$a[$i]["clinical"]."\">Inactivar</button>";
			}else{
					echo "<button type=\"button\" onclick=\"save(".$a[$i]["user"].",".$a[$i]["clinical"].")\" class=\"btn btn-warning\" name=\"".$a[$i]["user"]."\" id=\"".$a[$i]["user"]."".$a[$i]["clinical"]."\">Activar</button>";
			}
			echo "</td>";
			echo "</tr>";
		}
	}else{
		for ($i=0;$i<$n;$i++) {
			$a[$i] = DBRow($r,$i);
			echo "<a class=\"dropdown-item text-primary\" onClick=\"insert(".$a[$i]["user"].",'".ucwords($a[$i]["fullname"])."')\" href=\"\">".ucwords($a[$i]["fullname"])."</a>";
		}
	}

	return $a;
}
//analizar despues.....
function cleanuserdesc($a) {
	$inst = explode(']',$a['userdesc']);
	$a['userflag']='';
	$a['usershortinstitution']='';
	$a['usersitename']='';
	if(isset($inst[1])) {
		$inst2 = explode('[',$inst[0]);
		if(isset($inst2[1]))
			$a['usershortinstitution'] = trim($inst2[1]);
		if(isset($inst[2])) {
			$a['userdesc']=trim($inst[2]);
			$inst = explode('[',$inst[1]);
			if(isset($inst[1])) {
			  $inst2 = explode(',',trim($inst[1]));
			  $a['userflag'] = strtolower($inst2[0]);
			  if(isset($inst2[1])) $a['usersitename']=strtoupper(trim($inst2[1]));
			}
		} else {
			$a['userdesc']=trim($inst[1]);
		}
	}
	return $a;
}
//si es el mismo retorna false, hace update a usertable userenabled='f' y algunos
//campos si existe en runtable status a deleted nueva tarea old tasktable answertable problemtable
function DBDeleteUser($user){

  if ($user==$_SESSION["usertable"]["usernumber"]) return false;
	$c = DBConnect();
	DBExec($c, "begin work");
	DBExec($c, "lock table usertable");
	$sql = "select * from usertable where usernumber=$user for update";
	$a = DBGetRow ($sql, 0, $c);
	if ($a != null) {

        $sql = "update usertable set userenabled='f', userlastlogin=NULL, usersessionextra='', usersession='', updatetime=".time(). " where usernumber=$user";
		//		$sql = "delete from usertable where usernumber=$user and usersitenumber=$site and " .
		//     "contestnumber=$contest";
		DBExec ($c, $sql);
		/*
		$r = DBExec($c,"select runnumber as number, contestnumber as contest from runtable where usernumber=$user for update");
		$n = DBnlines($r);

		for ($i=0;$i<$n;$i++) {
		  $a = DBRow($r,$i);
          //DBRunDelete actualizar la tabla runtable a status =deleted y guarda una nueva tarea en tasktable
          //obtenido datos de tabla problemtable y answertable del mismo usuario
		  if(DBRunDelete($a["number"],$a["contest"],$_SESSION["usertable"]["usernumber"],$c) === false) {
		    DBExec($c, "rollback work");
		    LOGLevel("User $user (contest=".$a["contest"].") could not be removed (run delete error).", 1);
		    return false;
		  }
		}*/

		DBExec($c, "commit work");
		LOGLevel("User $user marked as inactive.", 1);

    return true;
	} else {
		DBExec($c, "rollback work");
		LOGLevel("User $user could not be removed.", 1);
		return false;
	}
}
//seleccion la todos los usuario de la base de datos si pasa sitio de ese
function DBAllUserInfo() {

	$sql = "select * from usertable where usernumber!=0 ";

	$sql .= "order by usernumber";
	$c = DBConnect();
	$r = DBExec ($c, $sql, "DBAllUserInfo(get users)");
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find users in the database. SQL=(" . $sql . ")");
		MSGError("¡No se pueden encontrar usuarios en la base de datos!");
	}

	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
		$a[$i]['changepassword']=true;
		$a[$i]['userfullname']=ucwords($a[$i]['userfullname']);
		if(substr($a[$i]['userpassword'],0,1)=='!') {
			$a[$i]['userpassword'] = substr($a[$i]['userpassword'],1);
			$a[$i]['changepassword']=false;
		}
		$a[$i]['userpassword'] = myhash($a[$i]['userpassword'] . $a[$i]['usersessionextra']);
	}
	return $a;
}
//funcion para actulizar o insertar un nuevo usuario segun los datos que pasa
//actualizado1
function DBNewUser($param, $c=null, $import=false){

    //if(isset($param['contestnumber']) && !isset($param['contest'])) $param['contest']=$param['contestnumber'];
	//if(isset($param['sitenumber']) && !isset($param['site'])) $param['site']=$param['sitenumber'];
	//if(isset($param['usersitenumber']) && !isset($param['site'])) $param['site']=$param['usersitenumber'];
	if(isset($param['usernumber']) && !isset($param['user'])) $param['user']=$param['usernumber'];
	if(isset($param['number']) && !isset($param['user'])) $param['user']=$param['number'];

	if(isset($param['userpassword']) && !isset($param['pass'])) $param['pass']=$param['userpassword'];
	if(isset($param['userenabled']) && !isset($param['enabled'])) $param['enabled']=$param['userenabled'];
	if(isset($param['usermultilogin']) && !isset($param['multilogin'])) $param['multilogin']=$param['usermultilogin'];
	if(isset($param['userpermitip']) && !isset($param['permitip'])) $param['permitip']=$param['userpermitip'];
	if(isset($param['userfullname']) && !isset($param['userfull'])) $param['userfull']=$param['userfullname'];
	if(isset($param['usertype']) && !isset($param['type'])) $param['type']=$param['usertype'];
	if(isset($param['userpermitip']) && !isset($param['permitip'])) $param['permitip']=$param['userpermitip'];
	if(isset($param['userpermitip']) && !isset($param['permitip'])) $param['permitip']=$param['userpermitip'];

	$ac=array('user');
	//$ac=array('contest','site','user');
	$ac1=array('updatetime','userci','username','userfull','userdesc','type','enabled','multilogin','pass','permitip','changepass',
			   'userip','userlastlogin','userlastlogout','usersession','usersessionextra');

	//$typei['contest']=1;
	$typei['updatetime']=1;
	//$typei['site']=1;
	$typei['user']=1;
	foreach($ac as $key) {
		if(!isset($param[$key]) || $param[$key]=="") {
			MSGError("DBNewUser param error: $key not found");
			return false;
		}
		if(isset($typei[$key]) && !is_numeric($param[$key])) {
			MSGError("DBNewUser param error: $key is not numeric");
			return false;
		}
		$$key = myhtmlspecialchars($param[$key]);
	}
	$userci=0;
	$username= "team" . $user;
	$updatetime=-1;
	$pass = null;

	$userfull='';
	$userdesc='';
	$type='team';
	$enabled='f';
	$changepass='f';
	$multilogin='f';
	$permitip='';
	$usersession=null;
	$usersessionextra=null;
	$userip=null;
	$userlastlogin=null;
	$userlastlogout=null;
	foreach($ac1 as $key) {
		if(isset($param[$key])) {
			$$key = myhtmlspecialchars($param[$key]);
			if(isset($typei[$key]) && !is_numeric($param[$key])) {
				MSGError("DBNewUser param error: $key is not numeric");
				return false;
			}
		}
	}
	$t = time();
	if($updatetime <= 0)
		$updatetime=$t;

	if ($type != "admin" && $type != "teacher" && $type != "admission" && $type != "chiefclinics" && $type != "nursing")
		$type = "student";
	if ($type == "admin") $changepass = "t";
	if ($enabled != "f") $enabled = "t";
	if ($multilogin != "t") $multilogin = "f";
	if ($changepass != "t") $changepass = "f";
	$userfull=strtolower($userfull);
	$cw = false;
	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewUser(begin)");
	}
	DBExec($c, "lock table usertable", "DBNewUser(lock)");

	if($pass != myhash("") && $type != "admin" && $changepass != "t" && substr($pass,0,1) != "!") $pass='!'.$pass;
	$r = DBExec($c, "select * from usertable where (username='$username') and usernumber!=$user", "DBNewUser(get user)");

	$n = DBnlines ($r);
	$ret=1;

	if ($n == 0) {

		$sql = "select * from usertable where usernumber=$user";
		$a = DBGetRow ($sql, 0, $c);
        //para insercion o actulizacion
		if ($a == null) {
			  	$ret=2;

    		 	$sql = "insert into usertable (usernumber, userci, username, userfullname, " .
    				"userdesc, usertype, userenabled, usermultilogin, userpassword, userpermitip) values " .
    				"($user, $userci,'$username', '$userfull', '$userdesc', '$type', '$enabled', " .
    				"'$multilogin', '$pass', '$permitip')";
    			DBExec ($c, $sql, "DBNewUser(insert)");
					if($type=='admission'){
						DBExec($c, "insert into specialtytable (userid, clinicalid, coursenumber) values ".
								"($user,1,3)","DBFakeUser(insert specialty)");
					}
					if($cw) {
    				DBExec ($c, "commit work");
    			}
    			LOGLevel ("Usuario $user registrado.",2);
		} else {
			if($updatetime > $a['updatetime']) {
				$ret=2;
				$sql = "update usertable set userci=$userci, username='$username', userdesc='$userdesc', updatetime=$updatetime, " .
					"userfullname='$userfull', usertype='$type', userpermitip='$permitip', ";

                //if($useremail!='') $sql .= "useremail='$useremail', ";
                if($pass != null && $pass != myhash("")) $sql .= "userpassword='$pass', ";
				if($usersession != null) $sql .= "usersession='$usersession', ";
				if($usersessionextra != null) $sql .= "usersessionextra='$usersessionextra', ";
				if($userip != null) $sql .= "userip='$userip', ";
				if($userlastlogin != null) $sql .= "userlastlogin='$userlastlogin', ";
				if($userlastlogout != null) $sql .= "userlastlogout='$userlastlogout', ";
				$sql .= "userenabled='$enabled', usermultilogin='$multilogin'";
				$sql .=	" where usernumber=$user";
				$r = DBExec ($c, $sql, "DBNewUser(update)");
				if($cw) {
					DBExec ($c, "commit work");
				}
				LOGLevel("Usuario $user actualizado.",2);
			}
		}
	} else {
	  if($cw)
	     DBExec ($c, "rollback work");
	  LOGLevel ("Problema de actualizacion para el usuario  $user (tal vez el nombre de usuario ya esté en uso).",1);
//Problema de actualización para el usuario $ usuario, sitio $ sitio (tal vez el nombre de usuario ya esté en uso).
      MSGError ("Problema de actualizacion para el usuario  $user, (tal vez el nombre de usuario ya esté en uso).");
		if($import){
			$a= DBRow($r,0);
			return $a['usernumber'];
		}else{
			return false;
		}
	}
	if($cw) DBExec($c, "commit work");
	return $ret;
}
//funcion para habilitar usuarios
function enabledUser($user,$c=null){
  $cw = false;

	if($c == null) {
		$cw = true;
		$c = DBConnect();
		DBExec($c, "begin work", "DBNewUser(begin)");
	}
    $t=time();
    $sql="update usertable set userenabled='t', updatetime=".$t." where usernumber=".$user;
    DBExec($c,$sql);
    if($cw) DBExec($c, "commit work");
    return true;
}

//funcion para sacar todos las clinicas
function DBAllClinicalInfo() {
	$sql = "select * from clinicaltable";
	$c = DBConnect();
	$r = DBExec ($c, $sql);
	$n = DBnlines($r);
	if ($n == 0) {
		LOGError("Unable to find clinical in the database. SQL=(" . $sql . ")");
		MSGError("Unable to find clinical in the database!");
	}
	$a = array();
	for ($i=0;$i<$n;$i++) {
		$a[$i] = DBRow($r,$i);
	}
	return $a;
}
//funcion para sacar una clinicas
function DBClinicalInfo($id, $c=null) {
	$sql = "select * from clinicaltable where clinicalid=$id";
	$a = DBGetRow ($sql, 0, $c);
	if ($a == null) {
		LOGError("Unable to find the user in the database. SQL=(" . $sql . ")");
		MSGError("Unable to find the user in the database. Contact an admin now!");
	}

	return $a;
}
//para sacar el maximo valor de user
function DBUserNumberMax($c=null){
    $cw=false;
    if($c==null){
        $cw=true;
        $c=DBConnect();
        DBExec($c,"begin work","DBUserNumberMax(begin)");
    }
    //no retorna un array asociativo el primer resultado
    $a=DBGetRow("select max(usernumber) as n from usertable",0,$c,
        "DBuserNumberMax(max(n))");
		if($a==null)
			$a["n"]=-1;
		if($cw){
        DBExec($c,"commit work", "DBUserNumberMax(commit)");
    }
    $n=$a["n"]+1;
    return $n;
}



?>
