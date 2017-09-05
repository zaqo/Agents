<?php
header('Content-Type: text/html; charset=utf-8');
include ("login_agents.php"); 
   //set_time_limit(0);

echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/test/css/style.css" />
		<script src="alert_window.js"></script>
		<title>Личная карточка Агента</title>
	</head>
	<body>
END;
	$id= $_REQUEST['val'];
	
    $datetime = new DateTime();
	
	
	

		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
$row = 1;
$inserted=0;
$updated=0;
				echo '<script>var doDel=confirm("Удалить запись?");
					if(doDel) window.location.replace("http://localhost/Agents/delete_penalty_exe.php?val='.$id.'");
				</script>';	
				
				echo '<script>history.go(-1);</script>';	
	
mysqli_close($db_server);
?>
</body></html>