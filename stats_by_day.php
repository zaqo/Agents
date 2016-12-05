
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
		//$year_to    = $_POST['year_to'];
		//$month_to   = $_POST['month_to'];

	
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
	
	$date_q=mktime(0,0,0,$month_from,$day,$year_from);
	//echo "DATE is: ".$date_q."<\br>";
	$date_my=date("Y-m-d", $date_q);
	//echo "PROCESSED DATE is: ".$date_my."<\br>";
	$query_day = "SELECT registry.route, agents.name FROM registry LEFT JOIN agents ON registry.agent1=agents.tab_num WHERE registry.date='$date_my'";
	$day_answ = mysql_query($query_day);
	$rowsin = mysql_num_rows($day_answ);
	//$day_row= mysql_fetch_row($day_answ);
	//echo "RESPONSE is: ".$rowsin."<\br>";	
	
		echo  "<h1>"." СТАТИСТИКА РАБОТЫ:</br></br><div align='center'>".$date_my." </div></h1> ";
		//echo  "<h1> за период:</h1> ";	
		echo "<table>";
		echo "<tr><th>Рейс</th><th>Агент</th></tr>";
		//echo "<tr><td>$startdate</td><td>$startyear</td><td>$enddate</td><td>$endyear</td></tr>";
		//echo "</table></br></br>";
		//$colsin = mysql_num_fields($resultin);
		
	
		//echo "<table>";
		//echo "<tr><th>АЭРОПОРТ ВЫЛЕТА</th><th>ПРИБЫЛО РЕЙСОВ</th><th>СРЕДНЕЕ ЗА НЕДЕЛЮ</th></tr>";

		for ($j=0; $j<$rowsin; $j++)
		{
			//$summain=0;
			//$average=0;
			//$rowin = mysql_fetch_row($resultin);
			$day_row= mysql_fetch_row($day_answ);
			$ag_name=$day_row[1];
			$airflight=$day_row[0];
			echo "<tr><td>$airflight</td><td>$ag_name</td></tr>";
		}
		echo "</table>"; 
	echo <<<_END
	<a href="index_daily.html" > <img src="/prod/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
	</body>
	</html>
_END;
	mysql_close($db_server);
	?>
	
