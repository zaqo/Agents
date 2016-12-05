<?php
//header('Content-Type: text/html; charset=utf-8');
include ("login_agents.php"); 
?>


		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript">

		function addField () {
			var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;
			$('div#add_field_area').append('<div id="add'+telnum+'" class="add"><label> Поле №'+telnum+'</label><input type="text" width="120" name="val'+telnum+'" id="val" onblur="writeFieldsVlues();"  value=""/><div class="deletebutton" onclick="deleteField('+telnum+');"></div></div>');
		}

		function addMyField () {
			var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;
			var $content=$("select#agents").html();
			//alert ($content);
			//var $agents=$('#agents').clone(true);
			//alert(agents);
			//$('div#add_field_area').append($agents);
			$('div#add_field_area').find('div.add:last').append('<hr><tr><div id="add'+telnum+'" class="add"><label> №'+telnum+
			'</label><select name="agent'+telnum+'" >'+$content+
			'</select></div></tr><tr><div class="deletebutton" onclick="deleteField('+telnum+');"></div></tr>');
		}
		function addList(str) {
			var telnum = parseInt($('#add_field_area').find('div.add:last').attr('id').slice(3))+1;
			var agents = parseHTML(str);
			$('#add_field_area').find('div.add1').clone().append('div#add_field_area');
			
			$('div#add_field_area').append('<div id="add'+telnum+'" class="add"><label> Поле №'+telnum+
			'</label>'+
			'<div class="deletebutton" onclick="deleteField('+telnum+');"></div></div>');
		}
		
		function deleteField (id) {
			$('div#add'+id).remove();
			writeFieldsValues();
		}

		function writeFieldsValues () {
			var str = [];
			var tel = '';
			for(var i = 0; i<$("input#val").length; i++) {
			tel = $($("input#val")[i]).val();
				if (tel !== '') {
					str.push($($("input#val")[i]).val());
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
		$textsql='SELECT  tab_num,name FROM agents ORDER BY name';
		$answsql=mysqli_query($db_server,$textsql);
		$num_of_ags=mysqli_num_rows($answsql);
		$i=0;
		$ag_in=array();
		$ag_string='';
			for ($i=0;$i<$num_of_ags;$i++)  
				{
					$ag_in[$i]= mysqli_fetch_row($answsql);
					$ag_string=$ag_string.'<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				}
			$ag_string=$ag_string.'</select>';
			//echo $ag_string;
		//Looking up who of agents was placed on this flight today
			$textsql='SELECT  agent1 FROM registry WHERE route="'.$flightcode.'" AND date=CURDATE()';
			//SELCT info for a given FLIGHT, ONLY TODAY's records are visible
			
			$answsql=mysqli_query($db_server,$textsql); //exceptions handling to add here!!	
			$nop=mysqli_num_rows($answsql);
		
		if (($step==1) or (!isset($step))) // AGENTS HAVE NOT BEEN SET YET : BUT THIS METHOD - IT LOOKS UGLY!
		{
			echo  "<h1>"." ВЫБЕРИТЕ СОТРУДНИКОВ: "." </h1> ";	
			echo '<form action=enter_agents.php>';
			echo "<div id=\"add_field_area\">";
			echo "<table>";
			echo "<tr><th>РЕЙС: $flightcode</th></tr>";
			echo "<tr><th>АГЕНТЫ</th></tr>";

			$agent1='';
			$agent2='';
		
			if ($nop!=0) 
			{	
			
				foreach ($answsql as $rowin)
				{
				
					$agent1=$rowin[0];
				
					$str_out= '<tr><td><div id="add1" class="add"><label>№1:</label><select class="agents" id="agents" name="agent1" >';
					
					foreach ($ag_in as $agent){
					
						if ($agent1==$agent[0]) $str_out+= '<option value="'.($agent[0]).'" selected>'.($agent[1]).'</option>';
						else $str_out+= '<option value="'.($agent[0]).'">'.($agent[1]).'</option>';
					}  
						
					echo $str_out.'</select></div></td></tr>';
							
				}
			
			}
			else{
				
				$str_out ='<tr><td><div id="add1" class="add"><label>№1:</label><select class="agents" id="agents" name="agent1"><option value=""></option>';
					foreach ($ag_in as $agent) 
						$str_out=$str_out.'<option value="'.($agent[0]).'">'.($agent[1]).'</option>';
				
				$str_out=$str_out.'</select></div></td></tr>';
				echo $str_out;
				
			};
			?>
						
			</div>
			<tr><td>
				<div onclick="addMyField();" class="addbutton">Добавить агента</div>
        <!--<input type="hidden" name="values" id="values"  value="<?php=$array?>"/> -->
			</tr></td>
			<input type="hidden" name="values" id="values"  value="<?php=$ag_in[1][0]?>"/>			
		
			<tr><td><center><input type="hidden" value=2 name="step">
			 <input type="hidden" value="'.$flightcode.'" name="flightcode">
			 <input type="submit" value="ВВОД">
			 </td></tr>
			</table>
		</form>
	<?php mysqli_free_result($answsql);
   };
   if ($step==2) //After SUBMIT we update records
   {
	$agent1='';
	$agent2='';
	$agent3='';
	$flightcode= $_GET['flightcode'];
	$agent1= $_GET['agent1'];
	//$agent2= $_GET['agent2'];
	//$agent3= $_GET['agent3'];
		//echo 'Agent #1:  '.$agent1.' Agent #2: '.$agent2."Agent #3: ".$agent3.'\n';
	
	if ($nop) //IF NO RECORDS EXIST - PLEASE CHECK THIS OUT!
		{
			$textsql='UPDATE registry SET agent1="'.$agent1.'" WHERE route="'.$flightcode.'" AND date = CURDATE()';
			$answsql=mysqli_query($db_server,$textsql);
			if(!$answsql) die("Database update failed: ".mysqli_error($db_server));
			echo '<script>history.go(-2)</script>'; //returns user on a main screen
		}
		else
		{
			$textsql='INSERT INTO registry (date,agent1,route) VALUES (CURRENT_TIMESTAMP,"'.$agent1.'","'.$flightcode.'")';
			$answsql=mysqli_query($db_server,$textsql);
			if(!$answsql) die("Database update failed: ".mysqli_error($db_server));
			echo '<script>history.go(-2)</script>';
			//echo '<meta http-equiv="refresh" content="0; URL="http://portal.pulkovo-airport.com\test\start_mssql.php"" />';
		}
   }
   
mysqli_close($db_server);
?>
</body></html>