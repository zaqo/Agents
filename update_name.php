<?php
// This is a script to update agent's personal data from the form
include ("login_agents.php"); 
include ("header.php"); 
if(!$loggedin) echo "<script>window.location.replace('/Agents/login.php');</script>";
 
	$tab_num= $_REQUEST['tab_num'];
	$old_tab_num= $_REQUEST['old_tab_num'];
	$name= $_REQUEST['fio'];
	
	//var_dump($Personal);
	
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
				//$dim = count($Personal);

				//echo $dim."<br>";	
				$textsql='UPDATE agents SET name="'.$name.'" WHERE tab_num="'.$old_tab_num.'"'; //ready for editing tab_num also
				
				
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database UPDATE failed: ".mysqli_error($db_server));
				echo '<script>history.go(-2);</script>';	
	
mysqli_close($db_server);
?>