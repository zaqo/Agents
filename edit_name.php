<?php
include ("login_agents.php"); 
include_once("header.php");
if(!$loggedin) echo "<script>window.location.replace('/Agents/login.php');</script>";
?>
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/Agents/js/form_methods.js"></script>		
		<title>Редактирование личных данных сотрудника</title>
	</head>
	<body>
	<?php
		$tab_num=$_POST['val'];
		$name="";
		//Connect to database
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		//Prepare list of agents
		$textsql='SELECT  name FROM agents WHERE tab_num="'.$tab_num.'"';
		$answsql=mysqli_query($db_server,$textsql);
		$name= mysqli_fetch_row($answsql);
		if (isset($_POST['val']))
		{
			echo '<form id="form_2" method="post" action=update_name.php >
						<table>
						<tr><th colspan="2" ><p>Cотрудник:</p></th></tr>
						<tr><td colspan="2"><p>ФИО:<input type="text" name="fio" class="name" value="'.$name[0].'" ></p></td></tr>
						<tr><td colspan="2"><p>Таб.номер: <input type="text" name="tab_num" value="'.$tab_num.'" disabled/></p></td></tr>
						<tr><td colspan="2"><input type="hidden" value="'.$tab_num.'" name="old_tab_num"><input type="submit" name="send" class="send" value="ВВОД"></p></td></tr></table>';					
				echo '</form>';
		}	
		 mysqli_free_result($answsql);
		mysqli_close($db_server);
?>
</body></html>