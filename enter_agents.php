<?php
include ("login_agents.php"); 
?>
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">

		function addMyField () {
			var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;
			var $content=$("select#val1").html();
			$('div#add_field_area').find('div.add:last').append('<div id="field'+telnum+'"><hr><tr><div id="add'+telnum+'" class="add"><label> №'+telnum+
			'</label><select name="val'+telnum+'" id="val" onblur="writeFieldsValues();" >'+$content+
			'</select></div></tr><tr><div class="deletebutton" onclick="deleteField('+telnum+');"></div></tr></div>');
		}
		
		function deleteField (id) {
			$('div#field'+id).remove();
		}

		function writeFieldsValues () {
			var str = [];
			var tel = '';
			for(var i = 0; i<$("select#val").length; i++) {
			tel = $($("select#val")[i]).val();
				if (tel !== '') {
					str.push($($("input#values")[i]).val());
				}
			}
			$("input#values").val(str.join("|"));
		}
		</script>		
		<title>ВВОД Агентов</title>
	</head>
	<body>
	<?php
	$step= $_REQUEST['step'];
	$flightcode= $_REQUEST['flightcode'];
	
	
	//Connect to database
		$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
		$db_server->set_charset("utf8");
		If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
		mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		//Prepare list of agents
		$textsql='SELECT  tab_num,name,status FROM agents WHERE status=1 ORDER BY name';
		$answsql=mysqli_query($db_server,$textsql);
		$num_of_ags=mysqli_num_rows($answsql);
		$i=0;
		$ag_in=array();
		$ag_string='';
			for ($i=0;$i<$num_of_ags;$i++)  
				{
					$ag_in[$i]= mysqli_fetch_row($answsql);
					if ($ag_in[$i][2]) $ag_string=$ag_string.'<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				}
			$ag_string=$ag_string.'</select>';
			
		if (($step==1) or (!isset($step))) 
		{
			echo  "<h1>"." ВЫБЕРИТЕ СОТРУДНИКОВ: "." </h1> ";	
			echo '<form action=enter_agents.php>';
			echo "<div id=\"add_field_area\">";
			echo "<table><center>";
			echo "<tr><th>РЕЙС: $flightcode</th></tr>";
			echo "<tr><th>АГЕНТЫ</th></tr>";

				$str_out ='<tr><td><div id="add1" class="add"><label>№1:</label><select class="agents" id="val1" name="val"><option value=""></option>';
					foreach ($ag_in as $agent) 
						$str_out=$str_out.'<option value="'.($agent[0]).'">'.($agent[1]).'</option>';
				
				$str_out=$str_out.'</select></div></td></tr>';
				echo $str_out;
				
			?>
						
			</div>
			<tr><td 
				 onclick="addMyField();" class="addbutton">Добавить агента   
			</td></tr>	
			<tr><td><input type="hidden" value=2 name="step">
			 <input type="hidden" value="<?=$flightcode?>" name="flightcode">
			 <input type="submit" value="ВВОД">
			 </td></tr></center>
			</table>
		</form>
	<?php mysqli_free_result($answsql);
   };
   if ($step==2) //After SUBMIT we update records
   {
	$agents=array();
	$count = count($_GET)-2;
	$ik=0;
	$flightcode= $_GET['flightcode'];

	foreach ($_GET as $got)
	{
		$agents[$ik]=$got;
		$ik++;
	}
	$agents[]=$count;
	
			for($i=0;$i<$count;$i++)
			{
			  //THis is to cancel not unique records from the form
				$unique=1;
				for($ir=0;$ir<$i;$ir++)
				{
					if ($agents[$ir]==$agents[$i]) {
						echo " i= ".$i." : ir = ".$ir." - breaking! <br>";
						$unique=0;
						break; // Skip inserting repeating value
					}
				}			
				if(($agents[$i]!=0)&&($unique!=0)){ //Skip empty records
						$textsql='INSERT INTO oneregister (date,agent,route) VALUES (CURRENT_TIMESTAMP,"'.$agents[$i].'","'.$flightcode.'")';
						//echo " Tab_num= ".$agents[$i]." : - inserting! <br>";
						$answsql=mysqli_query($db_server,$textsql);
						if(!$answsql) die("Database update failed: ".mysqli_error($db_server));
				}
			}
			echo '<script>history.go(-2)</script>';	
			
   }
mysqli_close($db_server);
?>
</body></html>