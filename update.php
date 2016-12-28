<?php
// This is a script to update agent's personal data from the form
include ("login_agents.php"); 
 
	$tab_num= $_REQUEST['tab_num'];
	$Personal= $_REQUEST['Persdata'];
	
	var_dump($Personal);
	
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
$row = 1;
$inserted=0;
$updated=0;
					
				$textsql='UPDATE agents SET ';
				
				
				foreach($Personal as $chkbox) $textsql=$textsql.", $chkbox=1 ";
				$textsql=$textsql."WHERE tab_num=$tab_num";
				echo $textsql."<br>";
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
				echo '<script>history.go(-1);</script>';	
	
mysqli_close($db_server);
?>