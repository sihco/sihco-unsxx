<?php
require('header.php');
if(isset($_GET["id"]) && $_GET["id"]!=null && is_numeric($_GET["id"])){
  $id=htmlspecialchars(trim($_GET["id"]));
  $r=DBPeriodonticsiiInfo($id);
  if($r==null){
    ForceLoad("index.php");
  }
  if(($pat=DBPatientRemissionInfo($r['remissionid']))==null){
    ForceLoad("index.php");
  }
  if($pat["clinicalid"]!=6)
    ForceLoad("index.php");
}else{
  ForceLoad("index.php");
}
$pat2=$r;
$pat=array_merge($pat, $pat2);
$s=DBSessionPeriodonticsiiInfo($_GET['id']);
?>
<a id="personales"></a>
            <!--inicio de div contenido-->
            <div id="layoutSidenav_content">
              <!--inicio de main-->

                <main>

                    <div class="container-fluid px-4">
                        <h2 align="center" class="mt-4">Ficha Clinica de Periodoncia II</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
                        <!--notificaciones inicio-->
                        <?php
                        if(isset($pat['observationevaluated'])&&$pat['observationevaluated']=='f'){
                          echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica aun no esta revisado.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica tiene observaciones:<b>".$pat['observationdesc']."</b>".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='t'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'){
                          echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Se concluyó tu ficha clinica".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }
                        if(isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f'&&isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t'&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']=='fail'){
                          echo "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">".
                            "<strong>Hola ".$_SESSION['usertable']['username']."!</strong> Tu ficha clinica está en un estado de Abandono.".
                            "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">".
                            "  <span aria-hidden=\"true\">&times;</span>".
                            "</button>".
                            "</div>";
                        }

                        ?>

                        <!--notificaciones fin-->
<!--<div class="container">-->
  <div class="row">
    <div class="col-6 text-primary">

      <a href="periodonticsii.php?id=<?php echo $_GET['id']; ?>#personales"><b> <u>Datos Personales & Examen del Periodonto</u> </b></a>
    </div>
    <div class="col-6 text-success">
      <a href="periodonticsii.php?id=<?php echo $_GET['id']; ?>#bacteriana" class="text-success"><b> <u>Deteccion de Placa Bacteriana</u> <i class="fa fa-share"></i></b></a>
    </div>
  </div>
<!--formulario para paciente inicio-->
<!--id para paciente-->
<input type="hidden" name="patientid" id="patientid" value="<?php if(isset($pat["patientid"])) echo $pat["patientid"];  ?>">
<input type="hidden" name="ficha" id="ficha" value="<?php echo $_GET['id']; ?>">
<div class="from-group">
<div class="border border-primary">


<div class="row">
  <label for="patientfullname"><b>Paciente:&nbsp;&nbsp;&nbsp;&nbsp;</b><?php if(isset($pat["patientfullname"])) echo $pat["patientfullname"]; ?></label><br>
</div>
<div class="row">
<div class="col-lg-6 col-md-6 col-sm-6 col-6">
  <label for="patientlocation"><b>Domicilio:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientlocation"])) echo $pat["patientlocation"];  ?></label>
</div>
<div class="col-lg-3 col-md-3 col-sm-6 col-6">
  <label for="patientage"><b>Edad:</b>&nbsp;&nbsp;&nbsp;&nbsp;<?php if(isset($pat["patientage"])) echo $pat["patientage"];  ?></label>
</div>
<div class="col-lg-3 col-md-3 col-sm-4 col-6">
  <label for="patientgender"><b>Género:</b>&nbsp;&nbsp;&nbsp;&nbsp;
    <?php
    if(!isset($pat) || $pat["patientgender"] == '--') echo "indefinido";
    if(isset($pat) && $pat["patientgender"] == 'masculino') echo "Masculino";
    if(isset($pat) && $pat["patientgender"] == 'femenino') echo "Femenino";
    ?>
  </label>
</div>

</div>
</div>
<hr>
<div align="center"class="">
<b>EXAMEN DEL PERIODONTO</b>
</div>
<div class="">

<div class="contenido"><!--inicio contenido-->
  <!--inicio wrapper-->
  <div id="wrapper">
  <input type="hidden" name="draw" id="draw" value="<?php if(isset($pat['periodonticsiigram'])) echo $pat['periodonticsiigram']; ?>">
  <table id="separador">
    <tbody>
      <tr>
        <td>SUPERIOR</td>
      </tr>
    </tbody>
  </table>

  <table id="tabla-superior">
    <tbody>
      <tr>
        <td>
          <table id="tabla-1">
            <tbody>
        <tr>
          <td class="titulo">Vestibular</td>
          <td class="noborde">
            <div id="lineas-gr"></div>
            <div id="visualization18a">
            </div>
            <div class="click" id="diente18-a">
              <div class="linelingualt"></div><div id="furca18"></div>
            </div>
          </td>
          <td class="noborde">
            <div id="visualization17a"></div>
            <div class="click" id="diente17-a">
              <div class="linelingualt"></div><div id="furca17"></div>
            </div>
          </td>
          <td class="noborde">
            <div id="visualization16a"></div>
            <div class="click" id="diente16-a">
              <div class="linelingualt"></div><div id="furca16"></div>
            </div>
          </td>
          <td class="noborde">
            <div id="visualization15a"></div>
            <div class="click" id="diente15-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization14a"></div>
            <div class="click" id="diente14-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization13a"></div>
            <div class="click" id="diente13-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization12a"></div>
            <div class="click" id="diente12-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization11a"></div>
            <div class="click" id="diente11-a"><div class="linelingualu"></div></div></td>
          </tr>
        </tbody>
      </table>
    </td>
    <td>
      <table id="tabla-2">
        <tbody>

        <tr>
          <td class="noborde">
            <div id="lineas-gr"></div>
            <div id="visualization21a"></div>
            <div class="click" id="diente21-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization22a"></div>
            <div class="click" id="diente22-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization23a"></div>
            <div class="click" id="diente23-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization24a"></div>
            <div class="click" id="diente24-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization25a"></div>
            <div class="click" id="diente25-a"><div class="linelingualu"></div></div>
          </td>
          <td class="noborde">
            <div id="visualization26a">
            </div>
            <div class="click" id="diente26-a">
              <div class="linelingualt"></div><div id="furca26"></div>
            </div>
          </td>
          <td class="noborde">
            <div id="visualization27a" ></div>
            <div class="click" id="diente27-a">
              <div class="linelingualt"></div><div id="furca27">
              </div>
            </div>
          </td>
          <td class="noborde">
            <div id="visualization28a" ></div>
            <div class="click" id="diente28-a">
              <div class="linelingualt"></div><div id="furca28"></div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </td>
  </tr>
  <tr>
    <td>
      <div id="trr" style="background-color:#FF0080;">
        <div data-name="value" id="diente18" class="dientep">
            <div id="t18" class="cuadro click"></div>
            <div id="l18" class="cuadro izquierdo click"></div>
            <div id="b18" class="cuadro debajo click"></div>
            <div id="r18" class="cuadro derecha click click"></div>
            <div id="c18" class="centro click"></div>
        </div>
        <div data-name="value" id="diente17" class="dientep">
            <div id="t17" class="cuadro click"></div>
            <div id="l17" class="cuadro izquierdo click"></div>
            <div id="b17" class="cuadro debajo click"></div>
            <div id="r17" class="cuadro derecha click click"></div>
            <div id="c17" class="centro click"></div>
        </div>
        <div data-name="value" id="diente16" class="dientep">
            <div id="t16" class="cuadro click"></div>
            <div id="l16" class="cuadro izquierdo click"></div>
            <div id="b16" class="cuadro debajo click"></div>
            <div id="r16" class="cuadro derecha click click"></div>
            <div id="c16" class="centro click"></div>
        </div>
        <div data-name="value" id="diente15" class="dientep">
            <div id="t15" class="cuadro click"></div>
            <div id="l15" class="cuadro izquierdo click"></div>
            <div id="b15" class="cuadro debajo click"></div>
            <div id="r15" class="cuadro derecha click click"></div>
            <div id="c15" class="centro click"></div>
        </div>
        <div data-name="value" id="diente14" class="dientep">
            <div id="t14" class="cuadro click"></div>
            <div id="l14" class="cuadro izquierdo click"></div>
            <div id="b14" class="cuadro debajo click"></div>
            <div id="r14" class="cuadro derecha click click"></div>
            <div id="c14" class="centro click"></div>
        </div>
        <div data-name="value" id="diente13" class="dientep">
            <div id="t13" class="cuadro click"></div>
            <div id="l13" class="cuadro izquierdo click"></div>
            <div id="b13" class="cuadro debajo click"></div>
            <div id="r13" class="cuadro derecha click click"></div>
            <div id="c13" class="centro click"></div>
        </div>
        <div data-name="value" id="diente12" class="dientep">
            <div id="t12" class="cuadro click"></div>
            <div id="l12" class="cuadro izquierdo click"></div>
            <div id="b12" class="cuadro debajo click"></div>
            <div id="r12" class="cuadro derecha click click"></div>
            <div id="c12" class="centro click"></div>
        </div>
        <div data-name="value" id="diente11" class="dientep">
            <div id="t11" class="cuadro click"></div>
            <div id="l11" class="cuadro izquierdo click"></div>
            <div id="b11" class="cuadro debajo click"></div>
            <div id="r11" class="cuadro derecha click click"></div>
            <div id="c11" class="centro click"></div>
        </div>

      </div>
    </td>
    <td>
      <div id="tff" style="background-color:#FF0080;">
        <div data-name="value" id="diente21" class="dientepp">
            <div id="t21" class="cuadropp click"></div>
            <div id="l21" class="cuadropp izquierdopp click"></div>
            <div id="b21" class="cuadropp debajopp click"></div>
            <div id="r21" class="cuadropp derechapp click click"></div>
            <div id="c21" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente22" class="dientep">
            <div id="t22" class="cuadropp click"></div>
            <div id="l22" class="cuadropp izquierdopp click"></div>
            <div id="b22" class="cuadropp debajopp click"></div>
            <div id="r22" class="cuadropp derechapp click click"></div>
            <div id="c22" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente23" class="dientep">
            <div id="t23" class="cuadropp click"></div>
            <div id="l23" class="cuadropp izquierdopp click"></div>
            <div id="b23" class="cuadropp debajopp click"></div>
            <div id="r23" class="cuadropp derechapp click click"></div>
            <div id="c23" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente24" class="dientep">
            <div id="t24" class="cuadropp click"></div>
            <div id="l24" class="cuadropp izquierdopp click"></div>
            <div id="b24" class="cuadropp debajopp click"></div>
            <div id="r24" class="cuadropp derechapp click click"></div>
            <div id="c24" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente25" class="dientep">
            <div id="t25" class="cuadropp click"></div>
            <div id="l25" class="cuadropp izquierdopp click"></div>
            <div id="b25" class="cuadropp debajopp click"></div>
            <div id="r25" class="cuadropp derechapp click click"></div>
            <div id="c25" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente26" class="dientep">
            <div id="t26" class="cuadropp click"></div>
            <div id="l26" class="cuadropp izquierdopp click"></div>
            <div id="b26" class="cuadropp debajopp click"></div>
            <div id="r26" class="cuadropp derechapp click click"></div>
            <div id="c26" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente27" class="dientep">
            <div id="t27" class="cuadropp click"></div>
            <div id="l27" class="cuadropp izquierdopp click"></div>
            <div id="b27" class="cuadropp debajopp click"></div>
            <div id="r27" class="cuadropp derechapp click click"></div>
            <div id="c27" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente28" class="dientep">
            <div id="t28" class="cuadropp click"></div>
            <div id="l28" class="cuadropp izquierdopp click"></div>
            <div id="b28" class="cuadropp debajopp click"></div>
            <div id="r28" class="cuadropp derechapp click click"></div>
            <div id="c28" class="centropp click"></div>
        </div>

      </div>
    </td>
  </tr>
  <tr>
    <td>
      <table id="tabla-3">
        <tbody>
          <tr>
            <td class="titulo" >Palatino</td>
            <td class="noborde">
              <div id="lineas-gr-inf"></div>
              <div id="visualization18b"></div>
              <div class="click" id="diente18b-a">
                <div class="linet"></div><div id="furca18-a"></div>
                <div id="furca18-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization17b"></div>
              <div class="click" id="diente17b-a">
                <div class="linet"></div><div id="furca17-a"></div>
                <div id="furca17-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization16b"></div>
                <div class="click" id="diente16b-a">
                  <div class="linet"></div><div id="furca16-a"></div>
                  <div id="furca16-b"></div>
                </div>
            </td>
            <td class="noborde">
            <div id="visualization15b"></div>
              <div class="click" id="diente15b-a">	<div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization14b"></div>
              <div class="click" id="diente14b-a">
                <div class="lineu"></div><div id="furca14-a"></div>
                <div id="furca14-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization13b"></div>
              <div class="click" id="diente13b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization12b"></div>
              <div class="click" id="diente12b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization11b"></div>
              <div class="click" id="diente11b-a"><div class="lineu"></div></div>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
    <td>
      <table id="tabla-4">
        <tbody>
          <tr>
            <td class="noborde">
              <div id="lineas-gr-inf"></div>
              <div id="visualization21b"></div>
              <div class="click" id="diente21b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization22b"></div>
              <div class="click" id="diente22b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization23b"></div>
              <div class="click" id="diente23b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization24b"></div>
              <div class="click" id="diente24b-a">
                <div class="lineu"></div><div id="furca24-a"></div>
                <div id="furca24-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization25b"></div>
              <div class="click" id="diente25b-a"><div class="lineu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization26b"></div>
              <div class="click" id="diente26b-a">
                <div class="linet"></div><div id="furca26-a"></div>
                <div id="furca26-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization27b"></div>
              <div class="click" id="diente27b-a">
                <div class="linet"></div><div id="furca27-a"></div>
                <div id="furca27-b"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization28b"></div>
              <div class="click" id="diente28b-a">
                <div class="linet"></div><div id="furca28-a">
                </div><div id="furca28-b"></div>
              </div>
            </td>
          </tr>

        </tbody>
      </table>
    </td>
  </tr>

  <tr><td colspan="2"><table id="separador"><tbody><tr><td>INFERIOR</td></tr></tbody></table></td></tr>

  <tr>
    <td>
      <table id="tabla-5">
        <tbody>

          <tr>
            <td class="titulo">Lingual</td>
            <td class="noborde">
              <div id="lineas-gr"></div>
              <div id="visualization48a"></div>
              <div class="click" id="diente48-a">
                <div class="linelingualt"></div><div id="furca48"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization47a"></div>
              <div class="click" id="diente47-a">
                <div class="linelingualt"></div><div id="furca47"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization46a"></div>
              <div class="click" id="diente46-a">
                <div class="linelingualt"></div><div id="furca46"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization45a"></div>
              <div class="click" id="diente45-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization44a"></div>
              <div class="click" id="diente44-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization43a"></div>
              <div class="click" id="diente43-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization42a"></div>
              <div class="click" id="diente42-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization41a"></div>
              <div class="click" id="diente41-a"><div class="linelingualu"></div></div>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
    <td>
      <table id="tabla-6">
        <tbody>
          <tr>
            <td class="noborde">
              <div id="lineas-gr"></div>
              <div id="visualization31a"></div>
              <div class="click" id="diente31-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization32a"></div>
              <div class="click" id="diente32-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization33a"></div>
              <div class="click" id="diente33-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization34a"></div>
              <div class="click" id="diente34-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization35a"></div>
              <div class="click" id="diente35-a"><div class="linelingualu"></div></div>
            </td>
            <td class="noborde">
              <div id="visualization36a"></div>
              <div class="click" id="diente36-a">
                <div class="linelingualt"></div><div id="furca36"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization37a"></div>
              <div class="click" id="diente37-a">
                <div class="linelingualt"></div><div id="furca37"></div>
              </div>
            </td>
            <td class="noborde">
              <div id="visualization38a"></div>
              <div class="click" id="diente38-a">
                <div class="linelingualt"></div><div id="furca38"></div>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </td>
  </tr>
  <tr>
    <td>
      <div id="trr" style="background-color:#FF0080;">
        <div data-name="value" id="diente48" class="dientep">
            <div id="t48" class="cuadro click"></div>
            <div id="l48" class="cuadro izquierdo click"></div>
            <div id="b48" class="cuadro debajo click"></div>
            <div id="r48" class="cuadro derecha click click"></div>
            <div id="c48" class="centro click"></div>
        </div>
        <div data-name="value" id="diente47" class="dientep">
            <div id="t47" class="cuadro click"></div>
            <div id="l47" class="cuadro izquierdo click"></div>
            <div id="b47" class="cuadro debajo click"></div>
            <div id="r47" class="cuadro derecha click click"></div>
            <div id="c47" class="centro click"></div>
        </div>
        <div data-name="value" id="diente46" class="dientep">
            <div id="t46" class="cuadro click"></div>
            <div id="l46" class="cuadro izquierdo click"></div>
            <div id="b46" class="cuadro debajo click"></div>
            <div id="r46" class="cuadro derecha click click"></div>
            <div id="c46" class="centro click"></div>
        </div>
        <div data-name="value" id="diente45" class="dientep">
            <div id="t45" class="cuadro click"></div>
            <div id="l45" class="cuadro izquierdo click"></div>
            <div id="b45" class="cuadro debajo click"></div>
            <div id="r45" class="cuadro derecha click click"></div>
            <div id="c45" class="centro click"></div>
        </div>
        <div data-name="value" id="diente44" class="dientep">
            <div id="t44" class="cuadro click"></div>
            <div id="l44" class="cuadro izquierdo click"></div>
            <div id="b44" class="cuadro debajo click"></div>
            <div id="r44" class="cuadro derecha click click"></div>
            <div id="c44" class="centro click"></div>
        </div>
        <div data-name="value" id="diente43" class="dientep">
            <div id="t43" class="cuadro click"></div>
            <div id="l43" class="cuadro izquierdo click"></div>
            <div id="b43" class="cuadro debajo click"></div>
            <div id="r43" class="cuadro derecha click click"></div>
            <div id="c43" class="centro click"></div>
        </div>
        <div data-name="value" id="diente42" class="dientep">
            <div id="t42" class="cuadro click"></div>
            <div id="l42" class="cuadro izquierdo click"></div>
            <div id="b42" class="cuadro debajo click"></div>
            <div id="r42" class="cuadro derecha click click"></div>
            <div id="c42" class="centro click"></div>
        </div>
        <div data-name="value" id="diente41" class="dientep">
            <div id="t41" class="cuadro click"></div>
            <div id="l41" class="cuadro izquierdo click"></div>
            <div id="b41" class="cuadro debajo click"></div>
            <div id="r41" class="cuadro derecha click click"></div>
            <div id="c41" class="centro click"></div>
        </div>

      </div>
    </td>
    <td>
      <div id="tff" style="background-color:#FF0080;">
        <div data-name="value" id="diente31" class="dientepp">
            <div id="t31" class="cuadropp click"></div>
            <div id="l31" class="cuadropp izquierdopp click"></div>
            <div id="b31" class="cuadropp debajopp click"></div>
            <div id="r31" class="cuadropp derechapp click click"></div>
            <div id="c31" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente32" class="dientep">
            <div id="t32" class="cuadropp click"></div>
            <div id="l32" class="cuadropp izquierdopp click"></div>
            <div id="b32" class="cuadropp debajopp click"></div>
            <div id="r32" class="cuadropp derechapp click click"></div>
            <div id="c32" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente33" class="dientep">
            <div id="t33" class="cuadropp click"></div>
            <div id="l33" class="cuadropp izquierdopp click"></div>
            <div id="b33" class="cuadropp debajopp click"></div>
            <div id="r33" class="cuadropp derechapp click click"></div>
            <div id="c33" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente34" class="dientep">
            <div id="t34" class="cuadropp click"></div>
            <div id="l34" class="cuadropp izquierdopp click"></div>
            <div id="b34" class="cuadropp debajopp click"></div>
            <div id="r34" class="cuadropp derechapp click click"></div>
            <div id="c34" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente35" class="dientep">
            <div id="t35" class="cuadropp click"></div>
            <div id="l35" class="cuadropp izquierdopp click"></div>
            <div id="b35" class="cuadropp debajopp click"></div>
            <div id="r35" class="cuadropp derechapp click click"></div>
            <div id="c35" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente36" class="dientep">
            <div id="t36" class="cuadropp click"></div>
            <div id="l36" class="cuadropp izquierdopp click"></div>
            <div id="b36" class="cuadropp debajopp click"></div>
            <div id="r36" class="cuadropp derechapp click click"></div>
            <div id="c36" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente37" class="dientep">
            <div id="t37" class="cuadropp click"></div>
            <div id="l37" class="cuadropp izquierdopp click"></div>
            <div id="b37" class="cuadropp debajopp click"></div>
            <div id="r37" class="cuadropp derechapp click click"></div>
            <div id="c37" class="centropp click"></div>
        </div>
        <div data-name="value" id="diente38" class="dientep">
            <div id="t38" class="cuadropp click"></div>
            <div id="l38" class="cuadropp izquierdopp click"></div>
            <div id="b38" class="cuadropp debajopp click"></div>
            <div id="r38" class="cuadropp derechapp click click"></div>
            <div id="c38" class="centropp click"></div>
        </div>

      </div>
    </td>
  </tr>
  <tr>
  <td>
  <table id="tabla-7">
    <tbody>
      <tr>
        <td class="titulo">Vestibular</td>
        <td class="noborde">
          <div id="lineas-gr-inf"></div>
          <div id="visualization48b"></div>
          <div class="click"  id="diente48b-a">
            <div class="linet"></div><div id="furca48b"></div>
          </div>
        </td>
        <td class="noborde">
          <div id="visualization47b"></div>
          <div class="click"  id="diente47b-a">
            <div class="linet"></div><div id="furca47b"></div>
          </div>
        </td>
        <td class="noborde">
          <div id="visualization46b"></div>
          <div class="click"  id="diente46b-a">
            <div class="linet"></div><div id="furca46b"></div>
          </div>
        </td>
        <td class="noborde">
          <div id="visualization45b"></div>
          <div class="click"  id="diente45b-a"><div class="lineu"></div></div>
        </td>
        <td class="noborde">
          <div id="visualization44b"></div>
          <div class="click"  id="diente44b-a"><div class="lineu"></div></div>
        </td>
        <td class="noborde">
          <div id="visualization43b"></div>
          <div class="click" id="diente43b-a"><div class="lineu"></div></div>
        </td>
        <td class="noborde">
          <div id="visualization42b"></div>
          <div class="click" id="diente42b-a"><div class="lineu"></div></div>
        </td>
        <td class="noborde">
          <div id="visualization41b"></div>
          <div class="click" id="diente41b-a"><div class="lineu"></div></div>
        </td>
      </tr>

  </tbody></table>
  </td>
  <td>
  <table id="tabla-8">

  <tbody><tr>
  <td class="noborde">
  <div id="lineas-gr-inf"></div>
  <div id="visualization31b" style="width: 23px; height: 160px;position:absolute;margin:0 0 0 7px;"></div>

  <div class="click" id="diente31b-a"><div class="lineu"></div></div>
  </td>

  <td class="noborde">
  <div id="visualization32b" style="width: 22px; height: 160px;position:absolute;margin:0 0 0 7px;"></div>
  <div class="click" id="diente32b-a"><div class="lineu"></div></div>
  </td>
  <td class="noborde">
  <div id="visualization33b" style="width: 25px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div class="click" id="diente33b-a"><div class="lineu"></div></div>
  </td>
  <td class="noborde">
  <div id="visualization34b" style="width: 22px; height: 160px;position:absolute;margin:0 0 0 10px;"></div>
  <div class="click" id="diente34b-a"><div class="lineu"></div></div>
  </td>
  <td class="noborde">
  <div id="visualization35b" style="width: 25px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div class="click" id="diente35b-a"><div class="lineu"></div></div>
  </td>
  <td class="noborde">
  <div id="visualization36b" style="width: 50px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div class="click" id="diente36b-a">
    <div class="linet"></div><div id="furca36b"></div></div>
  </td>
  <td class="noborde">
  <div id="visualization37b" style="width: 47px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div class="click" id="diente37b-a"><div class="linet"></div><div id="furca37b"></div></div></td>
  <td class="noborde">
  <div id="visualization38b" style="width: 47px; height: 160px;position:absolute;margin:0 0 0 8px;"></div>
  <div class="click" id="diente38b-a"><div class="linet"></div><div id="furca38b"></div></div></td>
  </tr>

  </tbody></table>
  </td>
  </tr>


  </tbody></table>


  </div>
  <!--fin wrapper-->
</div><!--inicio contenido-->

</div>
<hr>
<div class="row">
<div class="col-sm-4 col-md-3 col-lg-3 col-6">
  <label for="bucal">Higiene Bucal</label>
  <select name="bucal" class="form-select" aria-label="Default select example">
    <option <?php if(!isset($pat['bucal']) || $pat["bucal"] == 'regular') echo "selected"; ?> value="regular">Regular</option>
    <option <?php if(isset($pat['bucal']) && $pat["bucal"] == 'buena') echo "selected"; ?> value="buena">Buena</option>
    <option <?php if(isset($pat['bucal']) && $pat["bucal"] == 'mala') echo "selected"; ?> value="mala">Mala</option>
  </select>
</div>
<div class="col-sm-4 col-md-3 col-lg-3 col-6">
  <label for="gingival">Mucosa Gingival</label>
  <select name="gingival" class="form-select" aria-label="Default select example">
    <option <?php if(!isset($pat['gingival']) || $pat["gingival"] == 'sana') echo "selected"; ?> value="sana">Sana</option>
    <option <?php if(isset($pat['gingival']) && $pat["gingival"] == 'alterada') echo "selected"; ?> value="alterada">Alterada</option>
    <option <?php if(isset($pat['gingival']) && $pat["gingival"] == 'gingivorragia') echo "selected"; ?> value="gingivorragia">Gingivorragia</option>
  </select>
</div>
<div class="col-sm-4 col-md-3 col-lg-3 col-6">
  <label for="sondeo">Sondeo</label>
  <select name="sondeo" class="form-select" aria-label="Default select example">
    <option <?php if(!isset($pat['sondeo']) || $pat["sondeo"] == 'cod1') echo "selected"; ?> value="cod1">Cod. 1</option>
    <option <?php if(isset($pat['sondeo']) && $pat["sondeo"] == 'cod2') echo "selected"; ?> value="cod2">Cod. 2</option>
    <option <?php if(isset($pat['sondeo']) && $pat["sondeo"] == 'cod3') echo "selected"; ?> value="cod3">Cod. 3</option>
    <option <?php if(isset($pat['sondeo']) && $pat["sondeo"] == 'cod4') echo "selected"; ?> value="cod4">Cod. 4</option>
    <option <?php if(isset($pat['sondeo']) && $pat["sondeo"] == 'cod5') echo "selected"; ?> value="cod5">Cod. 5</option>
  </select>
</div>
<div class="col-sm-4 col-md-3 col-lg-3 col-6">
  <label for="tartaro">Presencia de Tártaro</label>
  <select name="tartaro" class="form-select" aria-label="Default select example">
    <option <?php if(!isset($pat['tartaro']) || $pat["tartaro"] == 'leve') echo "selected"; ?> value="leve">Leve</option>
    <option <?php if(isset($pat['tartaro']) && $pat["tartaro"] == 'moderado') echo "selected"; ?> value="moderado">Moderado</option>
    <option <?php if(isset($pat['tartaro']) && $pat["tartaro"] == 'grave') echo "selected"; ?> value="grave">Grave</option>
    <option <?php if(isset($pat['tartaro']) && $pat["tartaro"] == 'supragingival') echo "selected"; ?> value="supragingival">Supragingival</option>
    <option <?php if(isset($pat['tartaro']) && $pat["tartaro"] == 'subgingival') echo "selected"; ?> value="subgingival">Subgingival</option>
  </select>
</div>
</div>
<div class="row">
<div class="col-sm-6 col-md-8 col-lg-8">
  <label for="diagnosis"><u><b>Diagnostico</b></u></label>
  <textarea class="form-control" id="diagnosis" name="diagnosis" rows="4"><?php if(isset($pat["periodonticsiidiagnosis"])) echo $pat["periodonticsiidiagnosis"];  ?></textarea>
</div>
<div class="col-sm-6 col-md-4  col-lg-4">
  <label for="treatment">Tratamiento</label>
  <select name="treatment" id="treatment" onChange="cambiar()" class="form-select" aria-label="Default select example">
    <option <?php if(!isset($pat) || $pat["periodonticsiitreatment"] == '--') echo "selected"; ?> value="--">--</option>
    <option <?php if(isset($pat) && $pat["periodonticsiitreatment"] == 'profilaxis') echo "selected"; ?> value="profilaxis">Profilaxis</option>
    <option <?php if(isset($pat) && $pat["periodonticsiitreatment"] == 'tartrectomia') echo "selected"; ?> value="tartrectomia">Tartrectomia</option>
  </select>
</div>
</div>
<br>
<div class="row">

<div id='caja_profilaxis'class="col-4">

</div>

<div id="caja_tartrectomia" class="col-4">

</div>
<script type="text/javascript">

  function cambiar(){
    var cod = document.getElementById("treatment").value;
    if(cod=='profilaxis'){
      removeAllChilds('caja_profilaxis');
      removeAllChilds('caja_tartrectomia');
      document.getElementById("caja_profilaxis").innerHTML = '<a class="btn btn-success" href="" data-toggle="modal" data-target="#profilaxis">Profilaxis</a>';
    }
    if(cod=='tartrectomia'){
      removeAllChilds('caja_tartrectomia');
      removeAllChilds('caja_profilaxis');
      document.getElementById("caja_tartrectomia").innerHTML = '<a class="btn btn-success" href="" data-toggle="modal" data-target="#tartrectomia">Tartrectomia</a>';

    }
    if(cod=='--'){
        removeAllChilds('caja_tartrectomia');
        removeAllChilds('caja_profilaxis');
    }
    //alert(cod);
  }
  cambiar();
  function removeAllChilds(a){
   var a=document.getElementById(a);
   while(a.hasChildNodes())
  	a.removeChild(a.firstChild);
 }
</script>
<!--inicio modal sesion profilaxis-->
<div class="modal fade" role="dialog" id="profilaxis">
<?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
<div class="modal-dialog">
  <div class="modal-content">

    <div class="modal-header">
      <h3 class="modal-title">Profilaxis</h3>

      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">
      <input type="hidden" name="namecontrol1" id="namecontrol1" value="profilaxis">
      <div class="from-group border border-primary rounded">
        <div class="container">
          <label for="">1. Sesión:</label>
          <input type="date" id="session1date1" class="form-control"  name="sesion1date1" value="<?php if(isset($pat["session1date1"])) echo $pat["session1date1"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session1evalued1" class="form-control"  name="session1evalued1" value="<?php if(isset($pat["session1evalued1"])) echo $pat["session1evalued1"];  ?>">
          <?php
          if(isset($pat['session1evalued1'])&&$pat['session1date1']!=''){
            if($pat['session1evalued1']=='--' || $pat['session1evalued1']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session1evalued1']=='incorrecto') {
              echo "<i style=\"color:green;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session1evalued1']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="from-group border border-warning rounded">
        <div class="container">
          <label for="">2. Sesión:</label>
          <input type="date" id="session1date2" class="form-control"  name="sesion1date2" value="<?php if(isset($pat["session1date2"])) echo $pat["session1date2"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session1evalued2" class="form-control"  name="session1evalued2" value="<?php if(isset($pat["session1evalued2"])) echo $pat["session1evalued2"];  ?>">

          <?php
          if(isset($pat['session1evalued2'])&&$pat['session1date2']!=''){
            if($pat['session1evalued2']=='--' || $pat['session1evalued2']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session1evalued2']=='incorrecto') {
              echo "<i style=\"color:green;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session1evalued2']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="from-group border border-success rounded">
        <div class="container">
          <label for="">3. Sesión:</label>
          <input type="date" id="session1date3" class="form-control"  name="sesion1date3" value="<?php if(isset($pat["session1date3"])) echo $pat["session1date3"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session1evalued3" class="form-control"  name="session1evalued3" value="<?php if(isset($pat["session1evalued3"])) echo $pat["session1evalued3"];  ?>">

          <?php
          if(isset($pat['session1evalued3'])&&$pat['session1date3']!=''){
            if($pat['session1evalued3']=='--' || $pat['session1evalued3']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session1evalued3']=='incorrecto') {
              echo "<i style=\"color:green;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session1evalued3']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="from-group">
        <div class="container">
          <div class="row">
            <div class="col-6">
               Fluorización
            </div>
            <div class="col-6">
              <select name="fluor" class="form-select" aria-label="Default select example">
                <option <?php if(!isset($s['sessionfluor']) || $s["sessionfluor"] == '') echo "selected"; ?> value="">--</option>
                <option <?php if(isset($s['sessionfluor']) && $s["sessionfluor"] == 'si') echo "selected"; ?> value="si">Si</option>
                <option <?php if(isset($s['sessionfluor']) && $s["sessionfluor"] == 'no') echo "selected"; ?> value="no">No</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <div class="text-danger">

        <?php
        if(isset($s['sessiondesc'])&& $s['sessiondesc']!=''){
          echo $s['sessiondesc'];
        }
        ?>
      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php
      if(isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'&&$pat['periodonticsiistatus']!='end'){
        echo "<button type=\"submit\" class=\"btn btn-success\" id=\"profilaxis_button\" name=\"profilaxis_button\">Enviar Sesion</button>";
      }
      ?>

    </div>

  </div>

  </div>
</div>
<!--fin modal profilaxis-->

<!--inicio modal tartrectomia-->
<div class="modal fade" role="dialog" id="tartrectomia">
<?php $a=DBUserInfo($_SESSION["usertable"]["usernumber"]);?>
<div class="modal-dialog">
  <div class="modal-content">

    <div class="modal-header">
      <h3 class="modal-title">Tartrectomia</h3>

      <button type="button" class="close" data-dismiss="modal" name="bu">&times;</button>
    </div>

    <div class="modal-body">
      <input type="hidden" name="namecontrol2" id="namecontrol2" value="tartrectomia">

      <div class="from-group border border-primary rounded">
        <div class="container">
          <label for="">1. Sesión:</label>
          <input type="date" id="session2date1" class="form-control"  name="session2date1" value="<?php if(isset($pat["session2date1"])) echo $pat["session2date1"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session2evalued1" class="form-control"  name="session2evalued1" value="<?php if(isset($pat["session2evalued1"])) echo $pat["session2evalued1"];  ?>">


          <!--<label for="">Aun no verificado por Docente</label>
          <i style="color:red;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>-->

          <?php
          if(isset($pat['session2evalued1'])&&$pat['session2date1']!=''){
            if($pat['session2evalued1']=='--' || $pat['session2evalued1']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session2evalued1']=='incorrecto') {
              echo "<i style=\"color:green;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session2evalued1']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>

        </div>
      </div>
      <br>
      <div class="from-group border border-warning rounded">
        <div class="container">
          <label for="">2. Sesión:</label>
          <input type="date" id="session2date2" class="form-control"  name="sesion2date2" value="<?php if(isset($pat["session2date2"])) echo $pat["session2date2"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session2evalued2" class="form-control"  name="session2evalued2" value="<?php if(isset($pat["session2evalued2"])) echo $pat["session2evalued2"];  ?>">
          <?php
          if(isset($pat['session2evalued2'])&&$pat['session2date2']!=''){
            if($pat['session2evalued2']=='--' || $pat['session2evalued2']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session2evalued2']=='incorrecto') {
              echo "<i style=\"color:green;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session2evalued2']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>
        </div>
      </div>
      <br>
      <div class="from-group border border-success rounded">
        <div class="container">
          <label for="">3. Sesión:</label>
          <input type="date" id="session2date3" class="form-control"  name="sesion2date3" value="<?php if(isset($pat["session2date3"])) echo $pat["session2date3"];  ?>" min="2015-01-01" max="2099-01-01">
          <input type="hidden" id="session2evalued3" class="form-control"  name="session2evalued3" value="<?php if(isset($pat["session2evalued3"])) echo $pat["session2evalued3"];  ?>">
          <?php

          if(isset($pat['session2evalued3'])&&$pat['session2date3']!=''){
            if($pat['session2evalued3']=='--' || $pat['session2evalued3']==''){
              echo "<br>Aun no verificado por Docente<br>";
            }elseif ($pat['session2evalued3']=='incorrecto') {
              echo "<i style=\"color:red;\" class=\"fa fa-times fa-3x fa-fw cursor fabians\"></i><br>";
            }elseif ($pat['session2evalued3']=='correcto') {
              echo "<i style=\"color:green;\" class=\"fa fa-check fa-3x fa-fw cursor fabians\"></i><br>";
            }

          }else{
            echo "<br><br><br>";
          }
          ?>
        </div>
      </div>

      <div class="text-danger">

        <?php
        if(isset($s['sessiondesc'])&& $s['sessiondesc']!=''){
          echo $s['sessiondesc'];
        }
        ?>
      </div>

    </div>

    <div class="modal-footer">

      <button type="button" class="mx-5 btn btn-danger" data-dismiss="modal" name="cancel_update">Cancelar</button>
      <?php
      if(isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'&&$pat['periodonticsiistatus']!='end'){
        echo "<button type=\"submit\" class=\"btn btn-success\" id=\"tartrectomia_button\" name=\"tartrectomia_button\">Enviar Session</button>";
      }
      ?>

    </div>

  </div>

  </div>
</div>
<!--fin modal tartrectomia-->

</div>
  <br>
<!--<div class="row">
  <button id="periodonto_register" class="btn btn-success" type="button" name="periodonto_register">Guardar Datos</button>
</div>-->
<a id="bacteriana"></a>
</div>

<br>

<hr>
<!--formulario para paciente fin--><!--
<div class="" style="height: 500px;" ></div>

<h2 align="center" class="mt-4">Ficha Clinica de Periodoncia II</h2>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
</ol>
-->
<div class="row">
  <div class="col-6 text-primary">

    <a href="periodonticsii.php?id=<?php echo $_GET['id']; ?>#bacteriana"><b> <u>Deteccion de Placa Bacteriana</u> </b></a>
  </div>
  <div class="col-6 text-success">
    <a href="periodonticsii.php?id=<?php echo $_GET['id']; ?>#personales" class="text-success"><b> <u>Datos Personales & Examen del Periodonto</u> <i class="fa fa-share"></i></b></a>
  </div>
</div>
<div class="container">
  <input type="hidden" name="olygram" id="olygram" value="<?php if(isset($pat['periodonticsiioleary'])) echo $pat['periodonticsiioleary']; ?>">
  <div class="row">
    <div class="col-md-4 col-sm-4 col-lg-3">
      <b>Indice de O'Leary</b>
    </div>
    <div class="col-md-4 col-sm-4 col-lg-3">
      <select class="form-select" name="option" aria-label="Default select example">
      <option value="1" selected>Pintar</option>
      <option value="2">Aucente</option>
      </select>
    </div>
  </div>
  <div class="row border">
    <div class="col-lg-6 col-md-6 col-sm-9 col-9 border">
      Indice primera consulta
    </div>
    <div align="center" class="col-lg-2 col-md-2 col-sm-3 col-3 border">
      <!--<input type="text" name="info" id="info"value="">%-->
      <label for="" id="info">%</label>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12 border">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-3">
          Fecha:
        </div>
        <div class="col-lg-8 col-md-8 col-sm-9 col-9">
          <input type="date" id="date1" class="form-control" name="date1" value="<?php if(isset($pat['date1'])){echo $pat['date1'];}else{echo date("Y-m-d");}?>" min="2015-01-01" max="2099-01-01">
        </div>
      </div>
    </div>
  </div>

  <div class="bg-danger mt-2" id='oleary'></div>
  <div style=" clear: both;"></div>

  <br>
  <div class="row border">
    <div class="col-lg-6 col-md-6 col-sm-9 col-9 border">
      Indice Alta
    </div>
    <div align="center" class="col-lg-2 col-md-2 col-sm-3 col-3 border">
      <!--<input type="text" name="info" id="info"value="">%-->
      <label for="" id="info2">%</label>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-12 col-12 border">
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-3">
          Fecha:
        </div>
        <div class="col-lg-8 col-md-8 col-sm-9 col-9">
          <input type="date" id="date2" class="form-control" name="date2" value="<?php if(isset($pat['date2'])) echo $pat['date2'];?>" min="2015-01-01" max="2099-01-01">
        </div>
      </div>

    </div>
  </div>

  <div class="bg-danger mt-2" id='oleary2'></div>
  <div style=" clear: both;"></div>
  <br>
  <div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="brushed"><u><b>Instrucción Técnica de Cepillado</b></u></label>
      <textarea class="form-control" id="brushed" name="brushed" rows="4"><?php if(isset($pat["periodonticsiibrushed"])) echo $pat["periodonticsiibrushed"];  ?></textarea>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
      <label for="comment"><u><b>Comentario</b></u></label>
      <textarea class="form-control" id="comment" name="comment" rows="4"><?php if(isset($pat["periodonticsiicomment"])) echo $pat["periodonticsiicomment"];  ?></textarea>
    </div>
  </div>
  <br>
  <div class="row">

    <?php

    if((isset($pat['observationaccepted'])&&$pat['observationaccepted']=='f') && (isset($pat['observationevaluated'])&&$pat['observationevaluated']=='t')&&isset($pat['periodonticsiistatus'])&&$pat['periodonticsiistatus']!='fail'&&$pat['periodonticsiistatus']!='canceled'){
      echo "<button id=\"oleary_register\" class=\"btn btn-success\" type=\"button\" name=\"oleary_register\">Enviar Datos</button>";
    }
    if(!isset($pat['observationaccepted'])){
      echo "<button id=\"oleary_register\" class=\"btn btn-success\" type=\"button\" name=\"oleary_register\">Enviar Datos</button>";
    }
    ?>
  </div>
</div>

<style media="screen">
  .dienteb{
    float: left;
    display: inline-block;
  }
  .cursor:hover {
      cursor: pointer;
  }
</style>
<!--</div>-->



</main>



                <!--pie de pagina-->
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Unsxx &copy; Clinica Odontologica</div>
                            <div>
                                <a href="#">Politicas de Privacidad</a>
                                &middot;
                                <a href="#">Terminos &amp; Condiciones</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!--fin div primero-->
        <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.bundle.min.js"></script>

        <script src="../js/scripts.js"></script>

        <!--bootstrap-->
        <!--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.slim.min.js"></script>

        <!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/popper.min.js"></script>

        <!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>-->
        <script src="../assets/graphic/bootstrap.min.js"></script>

        <!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>-->
        <script src="../assets/graphic/jquery-3.5.1.min.js"></script>

<script type="text/javascript">

function createOleary() {
    var htmlTT="",htmlBB="";
    var i=8;
    var sw=true,c='l';
    while(i>0&&i<9){
      htmlTT += '<div class="dienteb">' +
        '<svg width="40px" height="40px" class="bg-primary" id="tt'+c+i+'">' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor click" name="triangulo" id="tt'+c+'t'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor click" name="triangulo" id="tt'+c+'l'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor click" name="triangulo" id="tt'+c+'b'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor click" name="triangulo" id="tt'+c+'r'+i+'"/>' +
        '</svg>' +
        '<br>' +
        '<span style="padding-left: 14px; padding-right:14px" class="label label-info border">'+i+'</span>' +
        '<br>' +
        '<svg width="40px" height="40px" class="bg-primary" id="tb'+c+i+'">' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor click" name="triangulo" id="tb'+c+'t'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor click" name="triangulo" id="tb'+c+'l'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor click" name="triangulo" id="tb'+c+'b'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor click" name="triangulo" id="tb'+c+'r'+i+'"/>' +
        '</svg>' +
      '</div>';
      htmlBB += '<div class="dienteb">' +
        '<svg width="40px" height="40px" class="bg-primary" id="bt'+c+i+'">' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor click" name="triangulo" id="bt'+c+'t'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor click" name="triangulo" id="bt'+c+'l'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor click" name="triangulo" id="bt'+c+'b'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor click" name="triangulo" id="bt'+c+'r'+i+'"/>' +
        '</svg>' +
        '<br>' +
        '<span style="padding-left: 14px; padding-right:14px" class="label label-info border">'+i+'</span>' +
        '<br>' +
        '<svg width="40px" height="40px" class="bg-primary" id="bb'+c+i+'">' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="20 20, 0 0, 40 0" class="cursor click" name="triangulo" id="bb'+c+'t'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="0 0, 20 20, 0 40" class="cursor click" name="triangulo" id="bb'+c+'l'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 0 40" class="cursor click" name="triangulo" id="bb'+c+'b'+i+'"/>' +
          '<polygon fill="white" stroke="black" stroke-width="1px" points="40 40, 20 20, 40 0" class="cursor click" name="triangulo" id="bb'+c+'r'+i+'"/>' +
        '</svg>' +
      '</div>';
      if(sw&&i==1){
        sw=false;
        i--;
        c='r';
      }
      if(sw)
        i--;
      else
        i++;
    }

    $("#oleary").append(htmlTT);
    $("#oleary2").append(htmlBB);
}
function round(num, decimales = 2) {
  var signo = (num >= 0 ? 1 : -1);
  num = num * signo;
  if (decimales === 0) //con 0 decimales
      return signo * Math.round(num);
  // round(x * 10 ^ decimales)
  num = num.toString().split('e');
  num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
  // x * 10 ^ (-decimales)
  num = num.toString().split('e');
  return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}
function result(){
  var p=0;
  var p2=0;
  var paint=0;
  var paint2=0;
  var i=8;
  var sw=true,c='l';
  while(i>0&&i<9){
    var cont=0,cc=0;
    $('#tt'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p++;
      paint+=cc;
    }
    cont=0,cc=0;
    $('#tb'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p++;
      paint+=cc;
    }

    cont=0,cc=0;
    $('#bt'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p2++;
      paint2+=cc;
    }
    cont=0,cc=0;
    $('#bb'+c+i).children().each(function(index, el) {
        if(index<4){
          if($(this).attr('fill')=='red'){
            cc++;
          }
        }
        cont++;
    });
    if(cont==4){
      p2++;
      paint2+=cc;
    }
    if(sw&&i==1){
      sw=false;
      i--;
      c='r';
    }
    if(sw)
      i--;
    else
      i++;
  }
  //console.log('total: '+p);
  //$('#info').val(p+':'+paint);
  var r=(paint/(4*p))*100;
  var r2=(paint2/(4*p2))*100;
  r=round(r);
  r2=round(r2);
  $('#info').text(r+'%');
  $('#info2').text(r2+'%');
}
$(document).ready(function() {
  var a=new Array();
  var oly=new Array();
  a['diente18-a']='';a['diente17-a']='';a['diente16-a']='';a['diente15-a']='';a['diente14-a']='';a['diente13-a']='';a['diente12-a']='';a['diente11-a']='';
  a['diente21-a']='';a['diente22-a']='';a['diente23-a']='';a['diente24-a']='';a['diente25-a']='';a['diente26-a']='';a['diente27-a']='';a['diente28-a']='';
  a['diente18b-a']='';a['diente17b-a']='';a['diente16b-a']='';a['diente15b-a']='';a['diente14b-a']='';a['diente13b-a']='';a['diente12b-a']='';a['diente11b-a']='';
  a['diente21b-a']='';a['diente22b-a']='';a['diente23b-a']='';a['diente24b-a']='';a['diente25b-a']='';a['diente26b-a']='';a['diente27b-a']='';a['diente28b-a']='';
  a['diente41-a']='';a['diente42-a']='';a['diente43-a']='';a['diente44-a']='';a['diente45-a']='';a['diente46-a']='';a['diente47-a']='';a['diente48-a']='';
  a['diente31-a']='';a['diente32-a']='';a['diente33-a']='';a['diente34-a']='';a['diente35-a']='';a['diente36-a']='';a['diente37-a']='';a['diente38-a']='';
  a['diente41b-a']='';a['diente42b-a']='';a['diente43b-a']='';a['diente44b-a']='';a['diente45b-a']='';a['diente46b-a']='';a['diente47b-a']='';a['diente48b-a']='';
  a['diente31b-a']='';a['diente32b-a']='';a['diente33b-a']='';a['diente34b-a']='';a['diente35b-a']='';a['diente36b-a']='';a['diente37b-a']='';a['diente38b-a']='';

  a['t18']='';a['l18']='';a['b18']='';a['r18']='';a['c18']='';
  a['t17']='';a['l17']='';a['b17']='';a['r17']='';a['c17']='';
  a['t16']='';a['l16']='';a['b16']='';a['r16']='';a['c16']='';
  a['t15']='';a['l15']='';a['b15']='';a['r15']='';a['c15']='';
  a['t14']='';a['l14']='';a['b14']='';a['r14']='';a['c14']='';
  a['t13']='';a['l13']='';a['b13']='';a['r13']='';a['c13']='';
  a['t12']='';a['l12']='';a['b12']='';a['r12']='';a['c12']='';
  a['t11']='';a['l11']='';a['b11']='';a['r11']='';a['c11']='';

  a['t21']='';a['l21']='';a['b21']='';a['r21']='';a['c21']='';
  a['t22']='';a['l22']='';a['b22']='';a['r22']='';a['c22']='';
  a['t23']='';a['l23']='';a['b23']='';a['r23']='';a['c23']='';
  a['t24']='';a['l24']='';a['b24']='';a['r24']='';a['c24']='';
  a['t25']='';a['l25']='';a['b25']='';a['r25']='';a['c25']='';
  a['t26']='';a['l26']='';a['b26']='';a['r26']='';a['c26']='';
  a['t27']='';a['l27']='';a['b27']='';a['r27']='';a['c27']='';
  a['t28']='';a['l28']='';a['b28']='';a['r28']='';a['c28']='';

  a['t48']='';a['l48']='';a['b48']='';a['r48']='';a['c48']='';
  a['t47']='';a['l47']='';a['b47']='';a['r47']='';a['c47']='';
  a['t46']='';a['l46']='';a['b46']='';a['r46']='';a['c46']='';
  a['t45']='';a['l45']='';a['b45']='';a['r45']='';a['c45']='';
  a['t44']='';a['l44']='';a['b44']='';a['r44']='';a['c44']='';
  a['t43']='';a['l43']='';a['b43']='';a['r43']='';a['c43']='';
  a['t42']='';a['l42']='';a['b42']='';a['r42']='';a['c42']='';
  a['t41']='';a['l41']='';a['b41']='';a['r41']='';a['c41']='';

  a['t31']='';a['l31']='';a['b31']='';a['r31']='';a['c31']='';
  a['t32']='';a['l32']='';a['b32']='';a['r32']='';a['c32']='';
  a['t33']='';a['l33']='';a['b33']='';a['r33']='';a['c33']='';
  a['t34']='';a['l34']='';a['b34']='';a['r34']='';a['c34']='';
  a['t35']='';a['l35']='';a['b35']='';a['r35']='';a['c35']='';
  a['t36']='';a['l36']='';a['b36']='';a['r36']='';a['c36']='';
  a['t37']='';a['l37']='';a['b37']='';a['r37']='';a['c37']='';
  a['t38']='';a['l38']='';a['b38']='';a['r38']='';a['c38']='';

  oly['ttlt8']='';oly['ttlb8']='';oly['ttll8']='';oly['ttlr8']=''; oly['ttrt8']='';oly['ttrb8']='';oly['ttrl8']='';oly['ttrr8']='';
  oly['ttlt7']='';oly['ttlb7']='';oly['ttll7']='';oly['ttlr7']=''; oly['ttrt7']='';oly['ttrb7']='';oly['ttrl7']='';oly['ttrr7']='';
  oly['ttlt6']='';oly['ttlb6']='';oly['ttll6']='';oly['ttlr6']=''; oly['ttrt6']='';oly['ttrb6']='';oly['ttrl6']='';oly['ttrr6']='';
  oly['ttlt5']='';oly['ttlb5']='';oly['ttll5']='';oly['ttlr5']=''; oly['ttrt5']='';oly['ttrb5']='';oly['ttrl5']='';oly['ttrr5']='';
  oly['ttlt4']='';oly['ttlb4']='';oly['ttll4']='';oly['ttlr4']=''; oly['ttrt4']='';oly['ttrb4']='';oly['ttrl4']='';oly['ttrr4']='';
  oly['ttlt3']='';oly['ttlb3']='';oly['ttll3']='';oly['ttlr3']=''; oly['ttrt3']='';oly['ttrb3']='';oly['ttrl3']='';oly['ttrr3']='';
  oly['ttlt2']='';oly['ttlb2']='';oly['ttll2']='';oly['ttlr2']=''; oly['ttrt2']='';oly['ttrb2']='';oly['ttrl2']='';oly['ttrr2']='';
  oly['ttlt1']='';oly['ttlb1']='';oly['ttll1']='';oly['ttlr1']=''; oly['ttrt1']='';oly['ttrb1']='';oly['ttrl1']='';oly['ttrr1']='';

  oly['tblt8']='';oly['tblb8']='';oly['tbll8']='';oly['tblr8']=''; oly['tbrt8']='';oly['tbrb8']='';oly['tbrl8']='';oly['tbrr8']='';
  oly['tblt7']='';oly['tblb7']='';oly['tbll7']='';oly['tblr7']=''; oly['tbrt7']='';oly['tbrb7']='';oly['tbrl7']='';oly['tbrr7']='';
  oly['tblt6']='';oly['tblb6']='';oly['tbll6']='';oly['tblr6']=''; oly['tbrt6']='';oly['tbrb6']='';oly['tbrl6']='';oly['tbrr6']='';
  oly['tblt5']='';oly['tblb5']='';oly['tbll5']='';oly['tblr5']=''; oly['tbrt5']='';oly['tbrb5']='';oly['tbrl5']='';oly['tbrr5']='';
  oly['tblt4']='';oly['tblb4']='';oly['tbll4']='';oly['tblr4']=''; oly['tbrt4']='';oly['tbrb4']='';oly['tbrl4']='';oly['tbrr4']='';
  oly['tblt3']='';oly['tblb3']='';oly['tbll3']='';oly['tblr3']=''; oly['tbrt3']='';oly['tbrb3']='';oly['tbrl3']='';oly['tbrr3']='';
  oly['tblt2']='';oly['tblb2']='';oly['tbll2']='';oly['tblr2']=''; oly['tbrt2']='';oly['tbrb2']='';oly['tbrl2']='';oly['tbrr2']='';
  oly['tblt1']='';oly['tblb1']='';oly['tbll1']='';oly['tblr1']=''; oly['tbrt1']='';oly['tbrb1']='';oly['tbrl1']='';oly['tbrr1']='';


  oly['btlt8']='';oly['btlb8']='';oly['btll8']='';oly['btlr8']=''; oly['btrt8']='';oly['btrb8']='';oly['btrl8']='';oly['btrr8']='';
  oly['btlt7']='';oly['btlb7']='';oly['btll7']='';oly['btlr7']=''; oly['btrt7']='';oly['btrb7']='';oly['btrl7']='';oly['btrr7']='';
  oly['btlt6']='';oly['btlb6']='';oly['btll6']='';oly['btlr6']=''; oly['btrt6']='';oly['btrb6']='';oly['btrl6']='';oly['btrr6']='';
  oly['btlt5']='';oly['btlb5']='';oly['btll5']='';oly['btlr5']=''; oly['btrt5']='';oly['btrb5']='';oly['btrl5']='';oly['btrr5']='';
  oly['btlt4']='';oly['btlb4']='';oly['btll4']='';oly['btlr4']=''; oly['btrt4']='';oly['btrb4']='';oly['btrl4']='';oly['btrr4']='';
  oly['btlt3']='';oly['btlb3']='';oly['btll3']='';oly['btlr3']=''; oly['btrt3']='';oly['btrb3']='';oly['btrl3']='';oly['btrr3']='';
  oly['btlt2']='';oly['btlb2']='';oly['btll2']='';oly['btlr2']=''; oly['btrt2']='';oly['btrb2']='';oly['btrl2']='';oly['btrr2']='';
  oly['btlt1']='';oly['btlb1']='';oly['btll1']='';oly['btlr1']=''; oly['btrt1']='';oly['btrb1']='';oly['btrl1']='';oly['btrr1']='';

  oly['bblt8']='';oly['bblb8']='';oly['bbll8']='';oly['bblr8']=''; oly['bbrt8']='';oly['bbrb8']='';oly['bbrl8']='';oly['bbrr8']='';
  oly['bblt7']='';oly['bblb7']='';oly['bbll7']='';oly['bblr7']=''; oly['bbrt7']='';oly['bbrb7']='';oly['bbrl7']='';oly['bbrr7']='';
  oly['bblt6']='';oly['bblb6']='';oly['bbll6']='';oly['bblr6']=''; oly['bbrt6']='';oly['bbrb6']='';oly['bbrl6']='';oly['bbrr6']='';
  oly['bblt5']='';oly['bblb5']='';oly['bbll5']='';oly['bblr5']=''; oly['bbrt5']='';oly['bbrb5']='';oly['bbrl5']='';oly['bbrr5']='';
  oly['bblt4']='';oly['bblb4']='';oly['bbll4']='';oly['bblr4']=''; oly['bbrt4']='';oly['bbrb4']='';oly['bbrl4']='';oly['bbrr4']='';
  oly['bblt3']='';oly['bblb3']='';oly['bbll3']='';oly['bblr3']=''; oly['bbrt3']='';oly['bbrb3']='';oly['bbrl3']='';oly['bbrr3']='';
  oly['bblt2']='';oly['bblb2']='';oly['bbll2']='';oly['bblr2']=''; oly['bbrt2']='';oly['bbrb2']='';oly['bbrl2']='';oly['bbrr2']='';
  oly['bblt1']='';oly['bblb1']='';oly['bbll1']='';oly['bblr1']=''; oly['bbrt1']='';oly['bbrb1']='';oly['bbrl1']='';oly['bbrr1']='';

  function encript(){
    var str='';
    for (const key in a) {
      //console.log(`${key}: ${a[key]}`);
    //  console.log(a[key]);
      str+='['+key+'='+a[key]+']';
    }
    $('#draw').val(str);
    //para imprimir
  }
  function encriptoleary(){
    var str='';
    for (const key in oly) {
      //console.log(`${key}: ${a[key]}`);
    //  console.log(a[key]);
      str+='['+key+'='+oly[key]+']';
    }
    $('#olygram').val(str);
    //para imprimir
  }
  //var str='[diente18-a=][diente17-a=bg-primary][diente16-a=bg-primary][diente15-a=bg-primary]';
  function descript(str){
    var data=str.split(']');
    //console.log(a.length);
    for(var i=0;i<data.length-1;i++){
      var b=data[i].split('[');
      var c=b[1].split('=');
      a[c[0]]=c[1];
      if(c[1]=='click-red'){
        $('#'+c[0]).addClass(c[1]);//bg-danger
        //console.log(c[0]+':'+c[1]+'keys');
      }
      if(c[1]=='bg-danger'){
        $('#'+c[0]).children().each(function(index, el) {
            if ($(el).hasClass("linelingualu") ||$(el).hasClass("linelingualt") ||$(el).hasClass("lineu") ||$(el).hasClass("linet")) {

                $(el).addClass('bg-danger');
            }
        });
      }
      //console.log(c[0]+' = '+c[1]);
    }
  }
  function descriptoleary(str){
    var data=str.split(']');
    //console.log(a.length);
    for(var i=0;i<data.length-1;i++){
      var b=data[i].split('[');
      var c=b[1].split('=');
      oly[c[0]]=c[1];

      if(c[1]=='red'){
        //console.log(c[0]+' = '+c[1]);
        $('#'+c[0]).attr('fill','red');
      }
      if(c[1]=='gra'){
        $('#'+c[0]).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>');
        $('#'+c[0]).parent().children("i").css({
            "position": "absolute",
            "top": "24%",
            "left": "18.58ex"
        });
      }
      //[xdateu='+$('#date1').val()+']
      //if(c[0]=='xdateu')//paramos aqhi.....
      //  $('#date1').val(c[1]);

      //console.log(c[0]+' = '+c[1]);
    }
  }
  createOleary();


  descript(`<?php echo trim($pat["periodonticsiigram"]); ?>`);
  descriptoleary(`<?php echo trim($pat["periodonticsiioleary"]); ?>`);
  result();



    $(".click").click(function(event) {
      //todo el proceso para controles
      //var control = $("#controls").children().find('.active').attr('id');
      //console.log('inicio');
      //var control = $('input:radio[name=options]:checked').parent().attr('id');
      //console.log('fin'+control);
      //var cuadro = $(this).find("input[name=cuadro]:hidden").val();
      //mostramos a la consola
      console.log($(this).attr('id'))

      var desc=$(this).attr('id');//que es una X
      if(desc.charAt(0)=='t' || desc.charAt(0)=='l' ||desc.charAt(0)=='b' ||desc.charAt(0)=='r' ||desc.charAt(0)=='c'){
        if(desc.charAt(1)=='t' || desc.charAt(1)=='b'){
          //para oleary
          console.log($(this).attr('id'));
          var option = $('select[name=option]').val();
          if(option=='2'){
            var cont=0;
            $(this).parent().children().each(function(index, el) {
                console.log(index);
                cont++;
            });
            console.log('contador: '+cont);
            if(cont>=4){
              if(cont==4){
                $(this).parent().append('<i style="color:black;" class="fa fa-times fa-3x fa-fw cursor fabians"></i>');
                $(this).parent().children("i").css({
                    "position": "absolute",
                    "top": "24%",
                    "left": "18.58ex"
                });
                oly[desc]='gra';
              }else{
                $(this).parent().children("svg").remove();
                oly[desc]='';
                var com1=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'t'+desc.charAt(4);
                var com2=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'l'+desc.charAt(4);
                var com3=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'r'+desc.charAt(4);
                var com4=desc.charAt(0)+desc.charAt(1)+desc.charAt(2)+'b'+desc.charAt(4);
                if(oly[com1]=='gra')
                  oly[com1]='';
                if(oly[com2]=='gra')
                  oly[com2]='';
                if(oly[com3]=='gra')
                  oly[com3]='';
                if(oly[com4]=='gra')
                  oly[com4]='';
              }

            }
          }else {
            var color=$(this).attr('fill');
            if(color=='white'){
              $(this).attr('fill','red');
              if(oly[desc]!='gra')
                oly[desc]='red';
            }else{
              $(this).attr('fill','white');
              if(oly[desc]!='gra')
                oly[desc]='';
            }

          }
          result();
          encriptoleary();
          //para oleary
        }else {
          if ($(this).hasClass("click-red")) {
              $(this).removeClass('click-red');
              a[desc]='';
          } else {
             $(this).addClass('click-red');
             a[desc]='click-red';
          }
          encript();
        }


      }else{

        $(this).children().each(function(index, el) {
            if ($(el).hasClass("linelingualu") ||$(el).hasClass("linelingualt") ||$(el).hasClass("lineu") ||$(el).hasClass("linet")) {

                if($(el).hasClass("bg-danger")){
                  $(el).removeClass('bg-danger');
                  a[desc]='';
                }else{
                  $(el).addClass('bg-danger');
                  //console.log(el+'fabains');
                  a[desc]='bg-danger';
                }
            }
        });
        encript();
      }

        return false;
    });

    //fin click funcion
    return false;
});
</script>
<!--odontograma fin js-->
    </body>
</html>
<script language="JavaScript" src="../sha256.js"></script>
<script language="JavaScript" src="../hex.js"></script>
<script>

$(document).ready(function(){

      //cancel cancel_button
     $('#cancel_button').click(function(){
        location.reload();
     });
     function registerperiodonto(){
       var patientid = $('#patientid').val();
       var periodraw = $('#draw').val();
       var bucal = $('select[name=bucal]').val();
       var gingival = $('select[name=gingival]').val();
       var sondeo = $('select[name=sondeo]').val();
       var tartaro = $('select[name=tartaro]').val();

       var diagnostico = $('#diagnosis').val();
       var brushed = $('#brushed').val();
       var comment = $('#comment').val();
       var olygram = $('#olygram').val()+'[xu='+$('#info').text()+']'+'[xt='+$('#info2').text()+']'+'[xdateu='+$('#date1').val()+']'+'[xdatet='+$('#date2').val()+']';



       var treatment = $('select[name=treatment]').val();

       var ficha = $('#ficha').val();
           $.ajax({

              url:"../include/i_surgery.php",
              method:"POST",
              data: {patientid:patientid,periodraw:periodraw,bucal:bucal,gingival:gingival,sondeo:sondeo,tartaro:tartaro,diagnostico:diagnostico,treatment:treatment,ficha:ficha,brushed:brushed,comment:comment,olygram:olygram},

              success:function(data)
              {

                if(data=='yes'){
                  alert('Se envio los datos de la ficha clinica');
                  location.reload();
                  //location.href="index.php";
                }else{
                  alert(data);
                  console.log(data);
                }
              }
           });
     }
     //registrar todos de datos del paciente
     $('#periodonto_register').click(function(){
       if (confirm("Enviar los datos de ficha clinica?")) {
         registerperiodonto();
       }else{
           location.reload();
       }
     });
     $('#oleary_register').click(function(){
       if (confirm("Enviar los datos de ficha clinica?")) {
         registerperiodonto();
       }else{
           location.reload();
       }
     });
     //update
     $('#update_button').click(function(){
		 var username,userdesc,userfull,passHASHo,passHASHn;
		 if($('#passwordn1').val() != $('#passwordn2').val()){
			 alert('password confirmacion debe ser igual');
		 }else{
			 if($('#passwordn1').val() == $('#passwordo').val()){
				 alert('password nuevo debe ser diferente al anterior');
			 }else{
				 username = $('#username').val();
				 userdesc = $('#userdesc').val();
				 userfull = $('#userfull').val();
				 passHASHo = js_myhash(js_myhash($('#passwordo').val())+'<?php echo session_id(); ?>');
				 passHASHn = bighexsoma(js_myhash($('#passwordn2').val()),js_myhash($('#passwordo').val()));
				 $('#passwordn1').val('                                                     ');
				 $('#passwordn2').val('                                                     ');
				 $('#passwordo').val('                                                     ');

				 $.ajax({

						  url:"../include/i_optionlower.php",
						  method:"POST",
						  data: {username:username, userdesc:userdesc, userfullname:userfull, passwordo:passHASHo, passwordn:passHASHn},

						  success:function(data)
						  {
							   //alert(data);
							   if(data.indexOf('Data updated.') !== -1)
							   {
									alert("Data updated.");
									$('#updateModal').hide();
									location.reload();
							   }
							   else
							   {
								   if (data.indexOf('Incorrect password')!== -1) {
									   alert("Incorrect password");

									   //location.href="../indexs.php";
								   }else{
									   alert(data);
								   }

							   }

						  }
				 });

			 }
		 }

     });
     //profilaxis register
     function registersesionp(){
       //alert('se envio no juego');
       if (confirm("Guardar Sesion?")) {
         var ficha = $('#ficha').val();
         var namecontrol1 = $('#namecontrol1').val();
         var s1date1 = $('#session1date1').val();
         var s1date2 = $('#session1date2').val();
         var s1date3 = $('#session1date3').val();
         var treatment = $('select[name=treatment]').val();

         var s1evalued1 = $('#session1evalued1').val();
         var s1evalued2 = $('#session1evalued2').val();
         var s1evalued3 = $('#session1evalued3').val();
         var fluor = $('select[name=fluor]').val();
         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {fluor:fluor, namecontrol1:namecontrol1, s1evalued1:s1evalued1 ,s1evalued2:s1evalued2 ,s1evalued3:s1evalued3 ,treatment:treatment, ficha:ficha, s1date1:s1date1, s1date2:s1date2, s1date3:s1date3},

						  success:function(data)
						  {
                alert(data);
              }
				 });
       }
     }
     function registersesiont(){
       //alert('se envio no juego');
       if (confirm("Guardar Sesion?")) {
         var ficha = $('#ficha').val();
         var namecontrol2 = $('#namecontrol2').val();
         var s2date1 = $('#session2date1').val();
         var s2date2 = $('#session2date2').val();
         var s2date3 = $('#session2date3').val();
         var s2evalued1 = $('#session2evalued1').val();
         var s2evalued2 = $('#session2evalued2').val();
         var s2evalued3 = $('#session2evalued3').val();

         var treatment = $('select[name=treatment]').val();

         $.ajax({

						  url:"../include/i_session.php",
						  method:"POST",
						  data: {namecontrol2:namecontrol2, s2evalued1:s2evalued1, s2evalued2:s2evalued2, s2evalued3:s2evalued3, treatment:treatment, ficha:ficha, s2date1:s2date1, s2date2:s2date2, s2date3:s2date3},

						  success:function(data)
						  {
                alert(data);
              }
				 });
       }
     }
     $('#profilaxis_button').click(function(){
       registersesionp();
       location.reload();
     });
     $('#tartrectomia_button').click(function(){
       registersesiont();
       location.reload();
     });

});

</script>
