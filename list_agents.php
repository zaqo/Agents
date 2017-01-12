<?php 
		echo <<<END
		<html>
		<head>
		<title>Суточный график</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8">
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		</head>
		<body>
END;
	
		require_once 'login_agents.php';
		
		//Set up mySQL connection
			$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
			$db_server->set_charset("utf8");
			If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
			mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
		
		// Top of the table
		echo "<table><caption><b>Список агентов</b></caption>";
		echo '<tr><th>№ </th><th>Ф.И.О.</th><th>Таб.номер</th><th>Статус</th><th>Системы</th></tr>';
		// Iterating through the array
		$counter=1;		
		//LOOK UP list of agents
				$textsql='SELECT * FROM agents ORDER BY name';// AND DATE_FORMAT(date,"%d-%m-%Y") = "'.$datestr.'")'; 
				$answsql=mysqli_query($db_server,$textsql);
				if(!$answsql) die("Database insert failed: ".mysqli_error($db_server));
				
				$num_of_ags=mysqli_num_rows($answsql);
				$row_span=$num_of_ags;
				$person= mysqli_fetch_row($answsql); // This one is to skip empty record at the top
				$value="";
				
				for($counter=1;$counter<$num_of_ags;$counter++) // < BECAUSE WE HIDE EMPTY AGENT RECORD
				{	
					
					$person= mysqli_fetch_row($answsql);
					if ($person[2]==1) $value="Ok";
					else $value="";
					$AgentSys="";
					for ($i=1;$i<11;$i++) {if ($person[$i+2]) $AgentSys=$AgentSys." $systems[$i],";};
					$AgentSys=substr($AgentSys,0,strlen($AgentSys)-1); // cut the last character
					echo "<tr><td>$counter</td><td>$person[1]</td>
						<td><a href=edit_pers_data.php?val=$person[0]>$person[0]</td>
						<td>$value</td>
						<td>$AgentSys</td></tr>";
						
				}
		echo "</table>";
	
	mysqli_close($db_server);
	?></body></html>
	