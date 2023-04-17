
<?php
require('header.php');

if(isset($_GET["order"]))
$order = myhtmlspecialchars($_GET["order"]);
else $order='';
if(isset($_GET["user"]))
$user = myhtmlspecialchars($_GET["user"]);
else $user='';

if(isset($_GET["type"]))
$type = myhtmlspecialchars($_GET["type"]);
else $type='';
if(isset($_GET["ip"]))
$ip = myhtmlspecialchars($_GET["ip"]);
else $ip='';
$get="&order=${order}&user=${user}&type=${type}&ip=${ip}";
if (isset($_GET["limit"]) && $_GET["limit"]>0)
  $limit = myhtmlspecialchars($_GET["limit"]);
else $limit = 50;
$log = DBGetLogs($order,$user, $type, $ip, $limit);
?>

                    <div class="container-fluid px-4">

                      <br>
                      <table class="table table-sm table-bordered table-hover">
                          <thead>
                      		<tr>
                      		 <td scope="col"><a href="log.php?order=user&limit=<?php echo $limit; ?>">Usuario #</a></td>
                      		 <td scope="col"><a href="log.php?order=ip&limit=<?php echo $limit; ?>">IP</a></td>
                      		 <td scope="col"><a href="log.php?order=type&limit=<?php echo $limit; ?>">Tipo</a></td>
                      		 <td scope="col">Fecha</td>
                      		 <td scope="col">Descripcion</td>
                      		</tr>
                      	</thead>
                          <tbody>

                      <?php
                      for ($i=0; $i<count($log); $i++) {
                        echo " <tr>\n";
                        //echo "  <td nowrap><a href=\"log.php?site=" . $log[$i]["site"] . "&limit=$limit\">" . $log[$i]["site"] . "</a></td>\n";
                        echo "  <td><a href=\"log.php?user=" . $log[$i]["user"] . "&limit=$limit\">" . $log[$i]["user"] . "</a></td>\n";
                        echo "  <td><a href=\"log.php?ip=" . $log[$i]["ip"] . "&limit=$limit\">" . $log[$i]["ip"] . "</a></td>\n";
                        echo "  <td><a href=\"log.php?type=" . $log[$i]["type"] . "&limit=$limit\">" . $log[$i]["type"] . "</a></td>\n";
                        echo "  <td>" . dateconv($log[$i]["date"]) . "</td>\n";
                        echo "  <td>" . $log[$i]["data"] . "</td>\n";

                        echo "</tr>\n";
                      }
                      echo "</tbody></table>\n";

                      ?>
                      <br>
                      <center>
                      <a href="log.php?limit=50<?php echo $get; ?>">50</a>
                      <a href="log.php?limit=200<?php echo $get; ?>">200</a>
                      <a href="log.php?limit=1000<?php echo $get; ?>">1000</a>
                      <a href="log.php?limit=1000000<?php echo $get; ?>">sin limite</a>
                    </div>
<?php
require('footer.php');
?>
