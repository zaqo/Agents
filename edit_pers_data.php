<?php
header('Content-Type: text/html; charset=utf-8');
include ("login_agents.php"); 
   //set_time_limit(0);

echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/test/css/style.css" />
		<title>Личная карточка Агента</title>
	</head>
	<body>
END;
	$id= $_REQUEST['val'];
	//$flightcode= $_REQUEST['flightcode'];
	//$flightcode=iconv('windows-1251','utf-8',$flightcode);
    $datetime = new DateTime();
	$datestr = $datetime->format('d-m-Y');
	//echo $id;
	
	
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

				$textsql='SELECT * FROM  agents WHERE tab_num="'.$id.'"';
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
				$person= mysqli_fetch_row($answsql);
				echo '<form id="form" method=post action=update.php >
						<table>
						<tr><th><p>Cотрудник:</p></th></tr>
						<tr><td><p>ФИО:<input type="text" name="fio" class="name" value="'.$person[1].'" disabled/></p></td></tr>
						<tr><td><p>Статус:<input type="checkbox" name="Persdata[]" class="name" value="status" checked/></p></td></tr>
						<tr><td><p>Системы:<br>
											DCS - <input type="checkbox" name="Persdata[]" class="name" value="dcs" /><br>
											Amadeus - <input type="checkbox" name="Persdata[]" class="name" value="amadeus" /><br>
											Sabre - <input type="checkbox" name="Persdata[]" class="name" value="sabre" /><br>
											BA - <input type="checkbox" name="Persdata[]" class="name" value="ba" /><br>
											Navitar - <input type="checkbox" name="Persdata[]" class="name" value="navitar" /><br>
											Troya - <input type="checkbox" name="Persdata[]" class="name" value="troya" /><br>
											SITA - <input type="checkbox" name="Persdata[]" class="name" value="sita" /><br>
											Astra - <input type="checkbox" name="Persdata[]" class="name" value="astra" /><br>
											Travelsky - <input type="checkbox" name="Persdata[]" class="name" value="travelsky" /><br>
											AngeLight - <input type="checkbox" name="Persdata[]" class="name" value="angelight" /></p></td></tr>
						<tr><td><p><input type="hidden" value="'.$id.'" name="tab_num"><input type="submit" name="send" class="send" value="ВВОД"></p></td></tr></table>';
				
				echo '</form>';
				
	
mysqli_close($db_server);
?>
</body></html>