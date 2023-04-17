<form class="" action="datetime.php" method="post">
  <input type="text" name="datetime" value="<?php if(isset($_POST['datetime'])){echo $_POST['datetime'];}else{echo "2000-00-00";} ?>">
  <button type="submit" name="button">Conv</button>
</form>
<?php
$time=-1;
if (isset($_POST['datetime'])) {
  $time=strtotime($_POST['datetime'])+3600*9;
}
echo "Convec: ".$time;
echo "<br>";
echo date('d-m-Y h:i:s a', $time);
?>
