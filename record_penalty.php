
	<?php 
		
		echo <<<END
		<html>
		
		<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Регистрация депремирования</title>
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		
	</head>
	<body>
END;
	
		require_once 'login_agents.php';
		include ("header.php"); 
		
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
				If (mysqli_connect_errno()) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
	

		$day = $_POST['day'];
	
		$year_from    = $_POST['year_from'];
		$month_from    = $_POST['month_from'];
		$text    = $_POST['text'];
		$pct    = $_POST['percentage'];
		$agent = $_POST['agent'];
		$goodbad = $_POST['feedback'];

	switch ($month_from) {
				case 1:
					$startdate='Январь';
					break;
				case 2:
					$startdate='Февраль';
					break;
				case 3:
					$startdate='Март';
					break;
				case 4:
					$startdate='Апрель';
					break;
				case 5:
					$startdate='Май';
					break;
				case 6:
					$startdate='Июнь';
					break;
				case 7:
					$startdate='Июль';
					break;
				case 8:
					$startdate='Август';
					break;
				case 9:
					$startdate='Сентябрь';
					break;
				case 10:
					$startdate='Октябрь';
					break;
				case 11:
					$startdate='Ноябрь';
					break;
				case 12:
					$startdate='Декабрь';
					break;
			}

	
	
	$input_d=array($year_from,$month_from,$day);
	
	$date_f=mktime(0,0,0,$month_from,$day,$year_from);

	$date_from=date("Y-m-d", $date_f);
	
		
		$textsql='INSERT INTO pen_register(goodbad,date,agentid,description,percentage,booked_by,booked_date) 
		VALUES ("'.$goodbad.'","'.$date_from.'", "'.$agent.'","'.$text.'","'.$pct.'","'.$user.'",CURRENT_DATE)';
	
	
		
	$answsql=mysqli_query($db_server,$textsql);
			if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
	
	// Now let's prepare user screen
	
	// First get agent name
	
	$agentsql="SELECT name FROM agents WHERE tab_num='$agent'";
				$answsql=mysqli_query($db_server,$agentsql);
				if(!$answsql) die("Database SELECT failed: ".mysqli_error($db_server));
	$person= mysqli_fetch_row($answsql);			
	
	// Second look for records about him
	
	$query_user = "SELECT date, description,percentage, booked_by, booked_date,goodbad FROM pen_register 
					WHERE pen_register.agentid = '$agent'";
	$answsql=mysqli_query($db_server,$query_user);
			if(!$answsql) die("Database SELECT failed: ".mysqli_error($db_server));	
	 $rows = $answsql->num_rows;

		echo  "<h1>"." ЗАПИСИ ПО АГЕНТУ:  $person[0]</h1><br>";
		echo  "<h2> <div align='center'> Табельный номер: $agent</th></div></h2> ";	
		echo "<table>";
		echo "<tr><th>№</th><th>Тип</th><th>Дата</th><th>Причина</th><th>%</th><th>Занесено</th><th>Дата</th></tr>";
		$red="<img src='/Agents/src/redcircle.png' alt='Penalty'  width='32' height='32'>";
		$green="<img src='/Agents/src/greencircle.png' alt='Penalty'  width='32' height='32'>";
		for ($j=0; $j<$rows; $j++)
		{
			$Num=$j+1;
			$type="";
			$row= mysqli_fetch_row($answsql);
			$text_descr=$row[1];
			$date_reg=$row[0];
			$date_ins=$row[4];
			if ($row[5]) 
			{	
				$type=$red;
				$pct=$row[2];
			}
			else
			{
				$type=$green;
				$pct="-";
			}
			$date_show=substr($date_reg, 8,2)."-".substr($date_reg, 5,2)."-".substr($date_reg, 2,2);
			$date_book=substr($date_ins, 8,2)."-".substr($date_ins, 5,2)."-".substr($date_ins, 2,2);
			echo "<tr><td>$Num</td><td>$type</td><td>$date_show</td><td>$row[1]</td><td>$pct</td><td>$row[3]</td><td>$date_book</td></tr>";
		}
		echo "</table>"; 
	echo <<<_END
	<a href="penalty.php" > <img src="/Agents/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
	</body>
	</html>
_END;
	mysqli_free_result($answsql);
	mysqli_close($db_server);
	?>
	
