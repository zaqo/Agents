<?php 
		echo <<<END
		<html>
		
		<head>
		<title>РЕЗУЛЬТАТЫ</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8">
		
		<link rel="stylesheet" type="text/css" href="../test/css/style.css" />
		
	</head>
	<body>
END;
	
		require_once 'login_agents.php';
		
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
		echo "<table>";
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
				$textsql='SELECT  registry.agent1,agents.name FROM registry LEFT JOIN agents ON registry.agent1=agents.tab_num WHERE route="'.$flightcode.'" AND date=CURDATE() ';// AND DATE_FORMAT(date,"%d-%m-%Y") = "'.$datestr.'")'; 
				$answsql=mysqli_query($db_server,$textsql);
				$num_of_ags=mysqli_num_rows($answsql);
				$row_span=$num_of_ags;
				if ($num_of_ags==0) {
					echo "<tr><td>$counter</td><td>$time_of_dep</td>
						<td><a href=enter_agents.php?flightcode=$flightcode&step=1;>$flightcode</td><td></td></tr>";
				}
				else
				{
					//echo "Number of agents".$num_of_ags."<\br>";
				
			
					echo "<tr><td>$counter</td><td >$time_of_dep</td>
						<td><a href=enter_agents.php?flightcode=$flightcode&step=1;>$flightcode</td><td>";
						$ag_count=0;
						while ($ag_count<$num_of_ags)
						{
							$result_arr = mysqli_fetch_row($answsql);//$answsql->fetch_array(MYSQLI_NUM);;
							$ag1_in=$result_arr[1];
							echo "$ag1_in ";
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
	