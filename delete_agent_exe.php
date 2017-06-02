<?php
include ("login_agents.php"); 
// this prog is to execute record clean after jscript confirm
	$tab_num= $_REQUEST['tn'];
	$flight= $_REQUEST['fl'];
	$flight_date= $_REQUEST['dt'];
	
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
				$textsql='DELETE FROM  oneregister WHERE agent="'.$tab_num.'" AND route="'.$flight.'" AND date="'.$flight_date.'"';
				$answsql=mysqli_query($db_server,$textsql);
				
				if(!$answsql) die("Database delete record failed: ".mysqli_error($db_server));
				echo '<script>history.go(-1);</script>';	
	
mysqli_close($db_server);
?>
</body></html>