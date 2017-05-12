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
		$textsql='SELECT  tab_num,name,status FROM agents ORDER BY name';
		$answsql=mysqli_query($db_server,$textsql);
		$num_of_ags=mysqli_num_rows($answsql);
		
		$ag_in=array();
		
			for ($i=0;$i<$num_of_ags;$i++)  
				{
					$ag_in[$i]= mysqli_fetch_row($answsql);
				}
		
			echo  "<h1>"." ВЫБЕРИТЕ СОТРУДНИКОВ: "." </h1> ";	
			echo '<form action=pers_data.php>';
			
			echo "<table>";
			
			echo "<tr><th>АГЕНТЫ</th></tr>";
				$pad='';
				$str_out ='<tr><td><div id="add1" class="add"><select class="agents" id="val1" name="val"><option value=""></option>';
					foreach ($ag_in as $agent) 
					{
						$pad='';
						if (!$agent[2]) $pad="* "; //Marking employees who left 
						$str_out=$str_out.'<option value="'.($agent[0]).'">'.$pad.($agent[1]).'</option>';
					}
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