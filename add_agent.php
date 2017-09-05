<?php
include ("login_agents.php"); 
				
				$tab_num=$_REQUEST['tab_num'];
				$name=$_REQUEST['fio'];
				$Personal= $_REQUEST['Persdata'];
	
				//var_dump($Personal);var_dump($tab_num);var_dump($name);
	
				$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
				$db_server->set_charset("utf8");
				If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
				mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
				$row = 1;
				$inserted=0;
				$updated=0;
					
				$textsql='INSERT INTO agents(name,tab_num';//,status) VALUES ("'.$name.'","'.$tab_num.'","'.$Personal[1].'")';
				
				
				foreach($Personal as $chkbox) $textsql=$textsql.",$chkbox";
				$textsql=$textsql.") VALUES ('$name','$tab_num'";
				foreach($Personal as $chkbox) $textsql=$textsql.",1";
				$textsql=$textsql.")";
				//echo $textsql."<br>";
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
				echo '<script>history.go(-2);</script>';	
	
				mysqli_close($db_server);
			
		?>
		
		
		