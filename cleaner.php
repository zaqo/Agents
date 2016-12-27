<?php
header('Content-Type: text/html; charset=utf-8');
include ("../login_agents.php"); 


echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/test/css/style.css" />
		<title>Зачистка таблиц</title>
	</head>
	<body>
END;
	
/*
This script was set up to clean registry table of multiple agents	
*/	
echo 'Начинаем работу:<br>';

	
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		//Change table name here
		$textsql='SELECT * FROM registry ORDER BY date';
		$answsql=mysqli_query($db_server,$textsql);
		$num_=mysqli_num_rows($answsql);
		$row_in=array();
		$inserted=0;
			for ($i=0;$i<$num_;$i++)  
				{
					$row_in= mysqli_fetch_row($answsql);
					
						$date_rec=$row_in[0];
						$route_rec=$row_in[1];
						if ($row_in[2]) {
									$insert_line = 'INSERT INTO oneregister (date,route,agent) VALUES("'.$date_rec.'""'.$route_rec.'""'.$row_in[2].'")';
									mysqli_query($db_server,$insert_line)or die(mysqli_error($db_server));
									$inserted++;
						}
						if ($row_in[3]) {
									$insert_line = 'INSERT INTO oneregister (date,route,agent) VALUES("'.$date_rec.'""'.$route_rec.'""'.$row_in[3].'")';
									mysqli_query($db_server,$insert_line)or die(mysqli_error($db_server));
									$inserted++;
						}
						if ($row_in[4]) {
									$insert_line = 'INSERT INTO oneregister (date,route,agent) VALUES("'.$date_rec.'""'.$route_rec.'""'.$row_in[4].'")';
									mysqli_query($db_server,$insert_line)or die(mysqli_error($db_server));
									$inserted++;
						}
					//}
				}
        
		echo "Transferred ".$inserted." rows! <br>";
mysqli_close($db_server);
?>
</body></html>