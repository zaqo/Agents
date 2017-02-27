<?php require_once 'login_agents.php';

include ("header.php"); 
if(!$loggedin) echo "<script>window.location.replace('/Agents/login.php');</script>";

		echo <<<END
		<html>
		
		<head>
		<title>Суточный график</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8">
		
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		
	</head>
	<body>
END;
	
		
		
		$datetime = new DateTime();
		$datestr = $datetime->format('d-m-Y');
		
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		If (!$conn) {
					echo "Can not connect to a database!!";
					die(print_r(sqlsrv_errors(),true));
					}
		
		$tsql = "select [Income], CONVERT(time,[Time]),[Outcome No_],[Owner Name] from $tablename WHERE  CONVERT (date, [Date])= CONVERT (date, GETDATE()) ORDER BY [Time]; "; //Request to MS SQL

		$stmt = sqlsrv_query( $conn, $tsql);
		
		if ( $stmt === false ) {
							echo "Error in statement preparation/execution.\n";
							die( print_r( sqlsrv_errors(), true));
						}
		sqlsrv_fetch( $stmt );
		$direction='';
		
		//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		
		// Top of the table
		echo "<table><caption><b>Суточный график работы </b></caption><br>$datestr";
		echo '<tr><th>№ </th><th>Время</th><th>Рейс</th><th>Агенты</th></tr>';
		// Iterating through the array
		$counter=1;
		while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) )  
		{ 
			
			if ($row[0]==0){ //row for the given flight
			
				$time_of_dep=$row[1]->format('H:i');
				$aircarrier=iconv('windows-1251','utf-8',$row[3]);
				$flightcode=iconv('windows-1251','utf-8',$row[2]);
				
		
				//LOOK UP list of agents
				$textsql='SELECT  oneregister.agent,agents.name FROM oneregister LEFT JOIN agents ON oneregister.agent=agents.tab_num WHERE route="'.$flightcode.'" AND date=CURDATE() ';// AND DATE_FORMAT(date,"%d-%m-%Y") = "'.$datestr.'")'; 
				$answsql=mysqli_query($db_server,$textsql);
				$num_of_ags=mysqli_num_rows($answsql);
				$row_span=$num_of_ags;
				if ($num_of_ags==0) {
					echo "<tr><td>$counter</td><td>$time_of_dep</td>
						<td><a href=enter_agents.php?flightcode=$flightcode&step=1&date=$datestr;>$flightcode</td><td></td></tr>";
				}
				else
				{
					echo "<tr><td>$counter</td><td >$time_of_dep</td>
						<td><a href=enter_agents.php?flightcode=$flightcode&step=1&date=$datestr;>$flightcode</td><td>";
						$ag_count=0;
						while ($ag_count<$num_of_ags)
						{
							$result_arr = mysqli_fetch_row($answsql);//$answsql->fetch_array(MYSQLI_NUM);;
							$ag_tab=$result_arr[0];
							$ag_in=$result_arr[1];
							//echo "<a href=delete_agent.php?tab_num=$ag_tab&flightcode=$flightcode>$ag_in , ";
							echo "<a href=delete_agent.php?tab_num=$ag_tab&flightcode=$flightcode&date=$datestr;>$ag_in ";
							$ag_count++;
						}
						echo "</td></tr>";
				}
			$counter+=1;
			}
		}
		echo "</table>";
	
	sqlsrv_close($conn);
	?>
	