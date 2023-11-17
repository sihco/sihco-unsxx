<?php
require('header.php');
?>


              <!--inicio de main-->
                <main>
                    <div class="container-fluid px-3">
                        <h2 class="mt-3">SEGUIMIENTO A PACIENTES</h2>
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
                                    <th scope="col">Fecha ultima actualización</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody>


                        <?php
                        //$usr = DBAllUserInfo();

                        //$pr = DBAllPatientRemissionClinicalInfo();
                        $pr = DBAllFollowPatient();
                        //if(isset($_GET['id'])&& is_numeric($_GET['id'])){
                        //  $pr = DBAllPatientRemissionClinicalInfo($_GET['id']+1);
                        //}
                        //$pr = DBAllRemissionInfo(null, false, $limit);
                        $size=count($pr);
                        for ($i=0; $i < $size; $i++) {
                              echo " <tr>\n";
                              echo "   <td>" . ($size-$i) . "</td>";
                              echo "   <td><a href=\"patientfollow.php?id=".$pr[$i]['patientid']."\">" . $pr[$i]["patientname"] ." ". $pr[$i]["patientfirstname"] ." ". $pr[$i]["patientlastname"] ."</a></td>";
                              echo "   <td>" . $pr[$i]["patientage"] . "</td>";



                        			echo "   <td>" . datetimeconv($pr[$i]["updatetime"]) ."</td>";
                              echo "   <td><div class=\"btn-group\"><a href=\"patientfollow.php?id=".$pr[$i]['patientid']."\" class=\"btn btn-primary btn-sm\" name=\"\" >Ver</a></div></td>";

                              echo "</tr>";
                        }
                        echo "</tbody></table>\n";

                        ?>
                        </div>

                    </div>

<?php
require('footer.php');
?>
