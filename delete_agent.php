﻿<?php
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
	$tab_num= $_REQUEST['tab_num'];
	$flightcode= $_REQUEST['flightcode'];
	$tr_date=$_REQUEST['date'];
	//$flightcode=iconv('windows-1251','utf-8',$flightcode);
    $datetime = new DateTime();
	//$datestr = $datetime->format('d-m-Y');
	//echo $id;
	$day= substr($tr_date,0,2);
	$dayint=(int)$day;
	$month= substr($tr_date,3,2);
	$monthint=(int)$month;
	$year=substr($tr_date,-4);
	$yearint=(int)$year;
	//echo "Date is ".$day.$month.$year."<br>";
	$datetime=mktime(0,0,0,$month,$day,$year);
	$date_from=date("Y-m-d", $datetime);
	
	
//echo 'Некоторая отладочная информация:';
//print_r($_FILES);
//var_dump($id);
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
$row = 1;
$inserted=0;
$updated=0;
				echo '<script>var doDel=confirm("Удалить запись об агенте?");
					if(doDel) window.location.replace("http://localhost/Agents/delete_agent_exe.php?tn='.$tab_num.'&fl='.$flightcode.'&dt='.$date_from.'");
				</script>';
				echo '<script>history.go(-1);</script>';	
	
mysqli_close($db_server);
?>
</body></html>