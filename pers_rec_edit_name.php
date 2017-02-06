<?php
include ("login_agents.php"); 
include_once("header.php");
?>
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="/Agents/js/form_methods.js"></script>		
		<title>Выбор сотрудника</title>
	</head>
	<body>
	<?php
	
	if (!$loggedin) die();
	//Connect to database
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		//Prepare list of agents
		$textsql='SELECT  tab_num,name FROM agents ORDER BY name';
		$answsql=mysqli_query($db_server,$textsql);
		$num_of_ags=mysqli_num_rows($answsql);
		//$i=0;
		$ag_in=array();
		
		$ag_string='';
			for ($i=0;$i<$num_of_ags;$i++)  
				{
					$ag_in[$i]= mysqli_fetch_row($answsql);
					$ag_string=$ag_string.'<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				}
			$ag_string=$ag_string.'</select>';
			
		
			echo  "<h1>"." ИЗМЕНИТЬ ЛИЧНЫЕ ДАННЫЕ: "." </h1> ";	
			echo '<form id="form_1" method="post" action="edit_name.php">';
			//echo "<div id=\"add_field_area\">";
			echo "<table>";
			//echo "<tr><th>РЕЙС: $flightcode</th></tr>";
			echo "<tr><th>Укажите сотрудника:</th></tr>";

				$str_out ='<tr><td><div id="add1" class="add"><select class="agents" id="val1" name="val"><option value=""></option>';
					foreach ($ag_in as $agent) 
						$str_out=$str_out.'<option value="'.($agent[0]).'">'.($agent[1]).'</option>';
				
				$str_out=$str_out.'</select></div></td></tr>';
				echo $str_out;
				
			?>
						
			</div>
			
			<tr><td>
			 <input type="submit" value="ВВОД">
			 </td></tr>
			</table>
		</form>
	<?php	
		
	 mysqli_free_result($answsql);
 
   
mysqli_close($db_server);
?>
</body></html>