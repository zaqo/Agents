﻿<?php
include ("login_agents.php"); 
include_once("header.php");
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
$status="";
 $dcs="";
 $ama="";
 $sab="";
 $ba="";
 $nav="";
 $tro="";
 $ek="";
 $ast="";
 $tra="";
 $ang="";

				$textsql='SELECT * FROM  agents WHERE tab_num="'.$id.'"';
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
				$person= mysqli_fetch_row($answsql);
				//var_dump($person);
				if ($person[2]) $status="checked";
				if ($person[3]) $dcs="checked";
				if ($person[4]) $ama="checked";
				if ($person[5]) $sab="checked";
				if ($person[6]) $ba="checked";
				if ($person[7]) $nav="checked";
				if ($person[8]) $tro="checked";
				if ($person[9]) $ek="checked";
				if ($person[10]) $ast="checked";
				if ($person[12]) $ang="checked";
				if ($person[11]) $tra="checked";
				echo '<form id="form" method=post action="pers_rec_show.php" >
						<table>
						<tr><th colspan="2" ><p>Cотрудник:</p></th></tr>
						<tr><td colspan="2"><p>ФИО:<input type="text" name="fio" class="name" value="'.$person[1].'" disabled/></p></td></tr>
						<tr><td colspan="2"><p>Таб.номер: <input type="text" value="'.$id.'" name="tab_num" disabled/></p></td></tr>
						<tr><td><p>Статус:</p></td><td><input type="checkbox" name="Persdata[]" class="name" value="Status" '.$status.' disabled/></td></tr>
						<tr><td colspan="2"><p><b>Системы:</b></p></td></tr>
						<tr><td>DCS</td><td><input type="checkbox" name="Persdata[]" class="name" value="DCS" '.$dcs.' disabled/></td></tr>
						<tr><td>Amadeus</td><td><input type="checkbox" name="Persdata[]" class="name" value="Amadeus" '.$ama.' disabled/></td></tr>
						<tr><td>Sabre</td><td><input type="checkbox" name="Persdata[]" class="name" value="Sabre" '.$sab.' disabled/></td></tr>
						<tr><td>BA</td><td><input type="checkbox" name="Persdata[]" class="name" value="BA" '.$ba.' disabled/></td></tr>
						<tr><td>Navitar</td><td><input type="checkbox" name="Persdata[]" class="name" value="Navitare" '.$nav.' disabled/></td></tr>
						<tr><td>Troya</td><td><input type="checkbox" name="Persdata[]" class="name" value="Troya" '.$tro.' disabled/></td></tr>
						<tr><td>EK</td><td><input type="checkbox" name="Persdata[]" class="name" value="EK" '.$ek.' disabled/></td></tr>
						<tr><td>Astra</td><td><input type="checkbox" name="Persdata[]" class="name" value="Astra" '.$ast.' disabled/></td></tr>
						<tr><td>Travelsky</td><td><input type="checkbox" name="Persdata[]" class="name" value="Travelsky" '.$tra.' disabled/></td></tr>
						<tr><td>AngeLight</td><td><input type="checkbox" name="Persdata[]" class="name" value="AngeLight" '.$ang.' disabled/></td></tr>
						<tr><td colspan="2"><p><input type="hidden" value="'.$id.'" name="tab_num"><input type="submit" name="send" class="send" value="НАЗАД"></p></td></tr></table>';					
				echo '</form>';
				
mysqli_close($db_server);
?>
</body></html>