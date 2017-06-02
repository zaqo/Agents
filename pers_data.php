<?php
include ("login_agents.php");
include_once("header.php"); 
   //set_time_limit(0);

echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
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
				echo '<form id="form" method=post action=update.php >
						<table>
						<tr><th colspan="2" ><p>Cотрудник:</p></th></tr>
						<tr><td colspan="2"><p>ФИО:<input type="text" name="fio" class="name" value="'.$person[1].'" disabled/></p></td></tr>
						<tr><td colspan="2"><p>Таб.номер: <input type="text" value="'.$id.'" name="tab_num" disabled/></p></td></tr>
						<tr><td><p>Статус:</p></td><td><input type="checkbox" name="Persdata[]" class="name" value="status" '.$status.'/></td></tr>
						<tr><td colspan="2"><p><b>Системы:</b></p></td></tr>
						<tr><td>DCS</td><td><input type="checkbox" name="Persdata[]" class="name" value="DCS" '.$dcs.'/></td></tr>
						<tr><td>Amadeus</td><td><input type="checkbox" name="Persdata[]" class="name" value="Amadeus" '.$ama.'/></td></tr>
						<tr><td>Sabre</td><td><input type="checkbox" name="Persdata[]" class="name" value="Sabre" '.$sab.'/></td></tr>
						<tr><td>BA</td><td><input type="checkbox" name="Persdata[]" class="name" value="BA" '.$ba.'/></td></tr>
						<tr><td>Navitar</td><td><input type="checkbox" name="Persdata[]" class="name" value="Navitare" '.$nav.' /></td></tr>
						<tr><td>Troya</td><td><input type="checkbox" name="Persdata[]" class="name" value="Troya" '.$tro.'/></td></tr>
						<tr><td>EK</td><td><input type="checkbox" name="Persdata[]" class="name" value="EK" '.$ek.'/></td></tr>
						<tr><td>Astra</td><td><input type="checkbox" name="Persdata[]" class="name" value="Astra" '.$ast.'/></td></tr>
						<tr><td>Travelsky</td><td><input type="checkbox" name="Persdata[]" class="name" value="Travelsky" '.$tra.'/></td></tr>
						<tr><td>AngeLight</td><td><input type="checkbox" name="Persdata[]" class="name" value="AngeLight" '.$ang.'/></td></tr>
						<tr><td colspan="2"><p><input type="hidden" value="'.$id.'" name="tab_num"><input type="submit" name="send" class="send" value="ВВОД"></p></td></tr></table>';					
				echo '</form>';

				// Here records section about agent
	
			$query_user = "SELECT date, description,percentage, booked_by, booked_date,goodbad,pen_id FROM pen_register 
							WHERE pen_register.agentid = '$id'";
			$answsql=mysqli_query($db_server,$query_user);
			if(!$answsql) die("Database SELECT failed: ".mysqli_error($db_server));	
			$rows = $answsql->num_rows;

			echo  "<br><hr><br><div class='colortext'> ОТЗЫВЫ ПО РАБОТЕ АГЕНТА:</div>";
				
			echo "<br><table>";
			echo "<tr><th>№</th><th>Тип</th><th>Дата</th><th>Причина</th><th>%</th><th>Занесено</th><th>Дата</th><th></th></tr>";
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
				echo "<tr><td>$Num</td><td>$type</td><td>$date_show</td><td><a href='update_penalty.php?val=$row[6]'>$text_descr</a></td><td>$pct</td><td>$row[3]</td><td>$date_book</td>
						<td><a href='delete_penalty.php?val=$row[6]' > <img src='/Agents/css/delete.png' alt='Delete' title='Удалить' ></a></td></tr>";
			}
			echo "</table>"; 
		echo <<<_END
		<a href="pers_rec.php" > <img src="/Agents/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
_END;
				
mysqli_close($db_server);
?>
</body></html>