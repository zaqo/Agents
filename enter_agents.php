<?php
header('Content-Type: text/html; charset=utf-8');
include ("login_agents.php"); 


echo <<<END
		<html>
		
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" type="text/css" href="/test/css/style.css" />
		<title>ВВОД Агентов</title>
	</head>
	<body>
END;
	$step= $_REQUEST['step'];
	$flightcode= $_REQUEST['flightcode'];
	//$flightcode=iconv('windows-1251','utf-8',$flightcode);
    $datetime = new DateTime();
	$datestr = $datetime->format('d-m-Y');
	
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
			for ($i=0;$i<$num_of_ags;$i++)  
				{
					$ag_in[$i]= mysqli_fetch_row($answsql);
				}
        
		//Looking up who of agents was placed on this flight today
			$textsql='SELECT  agent1 FROM registry WHERE route="'.$flightcode.'" AND date=CURDATE()';//ONLY TODAYs records are visible
			$answsql=mysqli_query($db_server,$textsql); //exceptions handling to add here!!	
			$nop=mysqli_num_rows($answsql);
			//echo "NOP is :".$nop;
		
		if (($step==1) or (!isset($step))) // AGENTS HAVE NOT BEEN SET YET : BUT THIS METHOD - IT LOOKS UGLY!
		{
			echo  "<h1>"." ВЫБЕРИТЕ СОТРУДНИКОВ: "." </h1> ";	
			echo '<form action=enter_agents.php>';
			echo "<table>";
			echo "<tr><th>РЕЙС: $flightcode</th></tr>";
			echo "<tr><th>АГЕНТЫ</th></tr>";
			$agent1='';
			$agent2='';
		
		if ($nop!=0) 
		{	
			for ($j=0; $j<$nop; ++$j) //this loop is redundant, must be only one record for a day
			{
				$rowin = mysqli_fetch_row($answsql);	
				//echo "I am in".$nop."\n";
				$agent1=$rowin[0];
				//$agent2=$rowin[1];
				//$agent3=$rowin[2];
				
				//echo 'Agent #1:  '.$agent1.' Agent #2: '.$agent2."Agent #3: ".$agent3.'\n';
				
				//echo '<tr><td><b>'.$flightcode.'</b></td>';
					echo '<tr><td> <select name="agent1" >';
					for ($i=0;$i<$num_of_ags;$i++){
						if ($agent1==$ag_in[$i][0]) echo '<option value="'.($ag_in[$i][0]).'" selected>'.($ag_in[$i][1]).'</option>';
						else echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
					}  
						
					echo '</select><br></td>';
					/*
					echo '<td> <select name="agent2" >';
					for ($i=0;$i<$num_of_ags;$i++){
						if ($agent2==$ag_in[$i][0]) echo '<option value="'.($ag_in[$i][0]).'" selected>'.($ag_in[$i][1]).'</option>';
						else echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
					}  
						
					echo '</select><br></td>';
					echo '<td> <select name="agent3" >';
					for ($i=0;$i<$num_of_ags;$i++){
						if ($agent3==$ag_in[$i][0]) echo '<option value="'.($ag_in[$i][0]).'" selected>'.($ag_in[$i][1]).'</option>';
						else echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
					}  
						
					echo '</select><br></td>';
					*/
					
			}
			
		}
		else{
				$rowin = mysqli_fetch_row($answsql);		
				//$flight_from_db=$rowin[0];
				//echo '<tr><td><b>'.$flightcode.'</b></td>';
				echo '<tr><td> <select name="agent1" >
					<option value=""></option>';
					for ($i=0;$i<$num_of_ags;$i++)  
						echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				echo '</select><br></td>';
				/*
				echo '<td> <select name="agent2" >
					<option value=""></option>';
					for ($i=0;$i<$num_of_ags;$i++)  
						echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				echo	'</select><br></td>';
				echo '<td> <select name="agent3" >;
					<option value=""></option>';
					for ($i=0;$i<$num_of_ags;$i++)  
						echo '<option value="'.($ag_in[$i][0]).'">'.($ag_in[$i][1]).'</option>';
				echo '</select><br></td>';
				*/
			};
		
		echo '<tr><td colspan=4><center><input type="hidden" value=2 name="step">
			  <input type="hidden" value="'.$flightcode.'" name="flightcode"><input type="submit" value="ВВОД"></td></tr>';
		echo "</table>";
		echo "</form>";
	mysqli_free_result($answsql);
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