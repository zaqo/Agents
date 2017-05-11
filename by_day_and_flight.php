
	<?php 
		
		echo <<<END
		<html>
		
		<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>РЕЗУЛЬТАТЫ</title>
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		
	</head>
	<body>
END;
	
		require_once 'login_agents.php';
		$db_server = mysql_connect($db_hostname, $db_username,$db_password);

		If (!$db_server) die("Can not connect to a database!!".mysql_error());
		
		mysql_select_db($db_database)or die(mysql_error());
		
	

		$day = $_POST['day'];
	
		$year_from    = $_POST['year_from'];
		$month_from    = $_POST['month_from'];
		$flight    = $_POST['flight'];

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
	//$date_q=implode("-",$input_d);
	
	$date_f=mktime(0,0,0,$month_from,$day,$year_from);

	//echo "DATE is: ".$date_q."<\br>";
	$date_from=date("Y-m-d", $date_f);
	
	$date_from_g=date("d-m-Y", $date_f);
	
	//echo "PROCESSED DATE is: ".$date_my."<\br>";
	
		$query_day = "SELECT agents.name FROM oneregister LEFT JOIN agents ON oneregister.agent=agents.tab_num WHERE oneregister.date = '$date_from' AND oneregister.route='$flight'";
	
	
	//echo $query_day."<br>";
	$day_answ = mysql_query($query_day);
	$rowsin = mysql_num_rows($day_answ);
	//$day_row= mysql_fetch_row($day_answ);
	//echo "RESPONSE is: ".$rowsin."<\br>";	
	
		echo  "<h1>"." РЕЗУЛЬТАТЫ ПОИСКА:</h1><br>";
		echo  "<h2> <div align='center'> Дата: $day / $month_from <br> Рейс: $flight</th></div></h2> ";	
		echo "<table>";
		echo "<tr><th>№</th><th>Агент</th></tr>";
		
		for ($j=0; $j<$rowsin; $j++)
		{
			$Num=$j+1;
			$day_row= mysql_fetch_row($day_answ);
			$ag_name=$day_row[0];
			
			echo "<tr><td>$Num</td><td>$ag_name</td></tr>";
		}
		echo "</table>"; 
	echo <<<_END
	<a href="search_by_flight.php" > <img src="/Agents/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
	</body>
	</html>
_END;
	mysql_close($db_server);
	?>
	
