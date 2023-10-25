<?php
require('header.php');
?>
                    <div class="container-fluid px-4">

                        <h2 class="mt-4">Pacientes derivados en linea</h2>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Odontologia(UNSXX)</li>
                        </ol>
<div class="table-responsive">


<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Paciente</th>
            <th scope="col">Edad</th>
            <th scope="col">Consulta</th>
            <th scope="col">Diagnostico Presuntivo</th>
            <th scope="col">Especialidad Derivada</th>
            <th scope="col">Fecha Remisión</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
<?php
//$usr = DBAllUserInfo();

//$pr = DBAllPatientRemissionInfo();
$pr=DBAllRemissionPatientInfo($_SESSION['usertable']['usernumber']);
//$pr = DBAllRemissionInfo(null, false, $limit);
$size=count($pr);
for ($i=0; $i < $size; $i++) {
      echo " <tr>\n";
      echo "   <td>" . ($size-$i) . "</td>";
      echo "   <td>" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</td>";
      echo "   <td>" . $pr[$i]["patientage"] . "</td>";
      echo "   <td>" . $pr[$i]["motconsult"] . "</td>";
      echo "   <td>" . $pr[$i]["diagnosis"] . "</td>";

			echo "   <td>" . $pr[$i]['clinicalspecialty'] . "</td>";

			echo "   <td>" . datetimeconv($pr[$i]["updatetimeremission"]) ."</td>";
      echo "   <td><div class=\"btn-group\"><a href=\"report.php?id=" . $pr[$i]["patientadmissionid"] . "\" class=\"btn btn-success btn-sm\">Imprimir</a></div></td>";

      echo "</tr>";
}
echo "</tbody></table>\n";

?>
<!--tabla para pacientes remitidos fin-->
</div>


                    </div>
<?php
require('footer.php');
?>
