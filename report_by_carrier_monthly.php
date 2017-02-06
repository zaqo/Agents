<?php
include ("login_agents.php"); 
include_once("header.php");
//set_time_limit(100);
echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/Agents/js/form_methods.js"></script>		
		<title>Отчет по работе сотрудников за месяц</title>
	</head>
	<body>
	<h1>Укажите месяц:</h1>
		
		<form id="form" method="post" action="report_by_carrier_monthly.php" >
			
		 	<p>Месяц:</p>
			<div id="month"><p> 	
				<select name="month" id="mfr" class="date" >
				<option value="1">Январь</option>
				<option value="2">Февраль</option>
				<option value="3">Март</option>
				<option value="4">Апрель</option>
				<option value="5">Май</option>
				<option value="6">Июнь</option>
				<option value="7">Июль</option>
				<option value="8">Август</option>
				<option value="9">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
				</select></p>
			
			</div>
			<p>Год: <select name="year" id="yfr" class="date" >
				<option value="2016">2016</option>
				<option value="2017">2017</option>
				</select>
			</p>
						<p><input type="submit" name="send" class="send" value="ВВОД"></p>
		</form>
END;
	
	if (!$loggedin) die();
	// Check the input
	if (isset($_POST['month'])&&isset($_POST['year']))
	{	
		$month = $_POST['month'];
		$year = $_POST['year'];
		$date_f=mktime(0,0,0,$month,1,$year);
		$date_t=mktime(0,0,0,$month,31,$year);
	//echo "DATE is: ".$date_q."<\br>";
		$date_from=date("Y-m-d", $date_f);
		$date_to=date("Y-m-d", $date_t);
		$date_from_pub=date("m-Y", $date_f);
	//Connect to database
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		//Prepare list of records for checkin work
		$textsql="SELECT date,route,agent,agents.name,agents.tab_num FROM oneregister LEFT JOIN agents ON oneregister.agent=agents.tab_num WHERE oneregister.date BETWEEN '$date_from' AND '$date_to' ORDER BY agents.tab_num ";
		$answsql=mysqli_query($db_server,$textsql);
		$num_of_recs=mysqli_num_rows($answsql);
		echo  "<h1>"." СТАТИСТИКА РАБОТЫ:</h1><br><br><h2><div align='center'> ЗА: ".$date_from_pub." </div></h2> <br>";
		//echo  "<h1> за период:</h1> ";	
		echo "<table>";
		echo "<tr><th>№ </th><th>Табельный ном. </th><th>Агент </th><th>Компании</th></tr>";
		$i=0;
		$agent="";
		$pers_record="";
		$flag=0;
		do{
		 $one_row= mysqli_fetch_row($answsql);
		 $i++;
		}while($one_row[2]==" ");
		$agent=$one_row[2];
		$agent_name=$one_row[3];
		$agent_num=$one_row[4];
		$carrier=substr($one_row[1],0,2);
		if ($carrier){
			$pers_record.=$carrier;
			$flag=1;
		}
		$k=1;
		while ($i<=$num_of_recs)
		{
			
			$one_row= mysqli_fetch_row($answsql);
			$ag_curr=$one_row[2];
			$airflight=substr($one_row[1],0,2);
			if ($agent!=$ag_curr)
			{	
				if($agent_name){ 
					echo "<tr><td>$k</td><td>$agent_num</td><td>$agent_name</td><td>$pers_record</td></tr>";
				$k++;
				}	
				$agent=$ag_curr;
				$pers_record=$airflight;
				$agent_name=$one_row[3];
				$agent_num=$one_row[4];
			}
			else
			{
				if(!strstr($pers_record,$airflight)) $pers_record.=", ".$airflight; 
			}
				$i++;
		}
		echo "</table>";

	mysqli_free_result($answsql);
mysqli_close($db_server);
	}

echo <<<END
</body></html>
END;
?>