
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
		
	
		$tab_num= $_POST['val'];
		$day = $_POST['day'];
		$day_to = $_POST['day_to'];
		$year_from    = $_POST['year_from'];
		$month_from    = $_POST['month_from'];
		$year_to    = $_POST['year_to'];
		$month_to   = $_POST['month_to'];
		$carrier   = $_POST['carrier'];
	
	$startdate='';
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
			$enddate = '';
			switch ($month_to) {
				case 1:
					$enddate='Январь';
					break;
				case 2:
					$enddate='Февраль';
					break;
				case 3:
					$enddate='Март';
					break;
				case 4:
					$enddate='Апрель';
					break;
				case 5:
					$enddate='Май';
					break;
				case 6:
					$enddate='Июнь';
					break;
				case 7:
					$enddate='Июль';
					break;
				case 8:
					$enddate='Август';
					break;
				case 9:
					$enddate='Сентябрь';
					break;
				case 10:
					$enddate='Октябрь';
					break;
				case 11:
					$enddate='Ноябрь';
					break;
				case 12:
					$enddate='Декабрь';
					break;
			}
	$startyear = 0;
	switch ($year_from) {
		case 0:
			$startyear=2012;
			break;
		case 1:
			$startyear=2013;
			break;
		case 2:
			$startyear=2014;
			break;
		case 3:
			$startyear=2015;
			break;
		case 4:
			$startyear=2016;
			break;
	}
	$endyear = 0;
	switch ($year_to) {
		case 0:
			$endyear=2012;
			break;
		case 1:
			$endyear=2013;
			break;
		case 2:
			$endyear=2014;
			break;
		case 3:
			$endyear=2015;
			break;
		case 4:
			$endyear=2016;
			break;
	}
	
	$input_d=array($year_from,$month_from,$day);
	//$date_q=implode("-",$input_d);
	
	$date_f=mktime(0,0,0,$month_from,$day,$year_from);
	$date_t=mktime(0,0,0,$month_to,$day_to,$year_to);
	//echo "DATE is: ".$date_q."<\br>";
	$date_from=date("Y-m-d", $date_f);
	$date_to=date("Y-m-d", $date_t);
	$date_from_g=date("d-m-Y", $date_f);
	$date_to_g=date("d-m-Y", $date_t);
	//echo "PROCESSED DATE is: ".$date_my."<\br>";
	if ($tab_num)
		$query_day = "SELECT date,route,agents.name FROM oneregister LEFT JOIN agents ON oneregister.agent=agents.tab_num WHERE oneregister.date BETWEEN '$date_from' AND '$date_to' AND oneregister.route LIKE '$carrier%' AND agents.tab_num='$tab_num'";
	else
	   $query_day = "SELECT date,route,agents.name FROM oneregister LEFT JOIN agents ON oneregister.agent=agents.tab_num WHERE oneregister.date BETWEEN '$date_from' AND '$date_to' AND oneregister.route LIKE '$carrier%'";
	
	//echo $query_day."<br>";
	$day_answ = mysql_query($query_day);
	$rowsin = mysql_num_rows($day_answ);
	$day_row= mysql_fetch_row($day_answ);
	//echo "RESPONSE is: ".$rowsin."<\br>";	
	
		echo  "<h1>"." СТАТИСТИКА РАБОТЫ:</h1><br><br><h2><div align='center'> C: ".$date_from_g."    ПО: ".$date_to_g." </div></h2> <br>";
		//echo  "<h1> за период:</h1> ";	
		echo "<table>";
		echo "<tr><th>Дата</th><th>Рейс</th><th>Агент</th></tr>";
		
		for ($j=0; $j<$rowsin; $j++)
		{
			
			$day_row= mysql_fetch_row($day_answ);
			$ag_name=$day_row[2];
			$airflight=$day_row[1];
			echo "<tr><td>$day_row[0]</td><td>$airflight</td><td>$ag_name</td></tr>";
		}
		echo "</table>"; 
	echo <<<_END
	<a href="index_daily.php" > <img src="/Agents/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
	</body>
	</html>
_END;
	mysql_close($db_server);
	?>
	
