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

		$id = $_GET['val'];
	
		//$year_from    = $_POST['year_from'];
		//$month_from    = $_POST['month_from'];
		//$text    = $_POST['text'];
		//$pct    = $_POST['percentage'];
		//$agent = $_POST['agent'];
		//$goodbad = $_POST['feedback'];

	
		
		
	
	// Now let's prepare user screen
	$query_user = "SELECT agentid, date, description, percentage, booked_by, booked_date,goodbad,isDeleted FROM pen_register 
					WHERE pen_register.pen_id = '$id'";
	$answsql=mysqli_query($db_server,$query_user);
			if(!$answsql) die("Database SELECT failed: ".mysqli_error($db_server));	
	 $rows = $answsql->num_rows;
	 if (!$rows) die("Record not found: ".mysqli_error($db_server));
	
	$row= mysqli_fetch_row($answsql);
	// First get agent name
	$tab_num=$row[0];
	$agentsql="SELECT name FROM agents WHERE tab_num='$row[0]'";
				$answsql=mysqli_query($db_server,$agentsql);
				if(!$answsql) die("Database SELECT failed: ".mysqli_error($db_server));
	$person= mysqli_fetch_row($answsql);			
	
	
	// Second look for records about him
	
	
		echo "<form id='form_penalty' method=post action='' >";
		echo  "<h1>"." ЗАПИСЬ ПО АГЕНТУ:  $person[0]</h1><br>";
		echo  "<h2> <div align='center'> Табельный номер: $tab_num</th></div></h2> ";	
		echo "<table>";
		echo "<tr><th>Поле</th><th>Значение</th></tr>";
		$red="<img src='/Agents/src/redcircle.png' alt='Penalty'  width='32' height='32'>";
		$green="<img src='/Agents/src/greencircle.png' alt='Penalty'  width='32' height='32'>";
		
		if(!$row[7])
		{
			$type="";
			$date_reg=$row[1];
			$text_descr=$row[2];
			$pct=$row[3];
			$author=$row[4];
			$date_ins=$row[5];
			$date_show=substr($date_reg, 8,2)."-".substr($date_reg, 5,2)."-".substr($date_reg, 2,2);
			$date_book=substr($date_ins, 8,2)."-".substr($date_ins, 5,2)."-".substr($date_ins, 2,2);
			if(!$row[7])
			{	
				if ($row[6]) 
				{	
					$type=$red;
				}
				else
				{
					$type=$green;
					
				}
				
				echo "<tr><td>Дата события</td><td>$date_reg</td><tr>
					  <tr><td>Дата регистрации</td><td>$date_ins</td><tr>
					  <tr><td>Зарегистировал</td><td>$author</td><tr>
					  <tr><td>Тип</td><td>$type</td><tr>
					  <tr><td>Описание</td><td><input type='text' name='desc' class='penalty' value='$text_descr' ></td><tr>";
				if 	($row[6])  
					echo " <tr><td>Процент</td><td><input type='text' name='pct' class='penalty' value='$pct' ></td><tr>";
				
			}
			echo	"  <tr><td colspan=2><input type='submit' name='send' class='send' value='ВВОД'></p></td></tr></table>";					
			echo '</form>';
		}
		
		if($_POST['desc']||$_POST['pct'])
		{
			$text_new=$_POST['desc'];
			$pct_new=$_POST['pct'];
			$textsql="UPDATE pen_register SET ";
			if($text_new)
			{
				$textsql=$textsql." description='$text_new', ";
				
			}
			if($pct_new) $textsql=$textsql." percentage=$pct_new, ";
			$textsql=$textsql." booked_by='$user' WHERE pen_id=$id";
	
			$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
			echo '<script>history.go(-2);</script>';
		}
	echo <<<_END
	<a href="pers_data.php?val='$tab_num'" > <img src="/Agents/src/arrow_left.png" alt="Go back" title="Back" width="64" height="64"></a>
	</body>
	</html>
_END;
	mysqli_free_result($answsql);
	mysqli_close($db_server);
	?>
	
