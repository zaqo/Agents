<?php
include ("login_agents.php"); 
?>
<html lang="ru">
	<head>
		<title>Форма</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf8" />
		
		<link rel="stylesheet" type="text/css" href="/Agents/css/style.css" />
		<!--[if lt IE 9]> 
			<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!--<script type="text/javascript" src="./js/jquery.js"></script>-->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	</head>
	<body>
	 <div class="dropdown">
		<button onclick="myFunction()" class="dropbtn">Меню</button>
		<div id="myDropdown" class="dropdown-content">
			<a href="pers_rec.php">Данные сотрудника</a>
		</div>
	</div>
	 <script>
	
/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
	function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
	}

// Close the dropdown if the user clicks outside of it
	window.onclick = function(event) {
		if (!event.target.matches('.dropbtn')) {

			var dropdowns = document.getElementsByClassName("dropdown-content");
			var i;
			for (i = 0; i < dropdowns.length; i++) {
			var openDropdown = dropdowns[i];
				if (openDropdown.classList.contains('show')) {
					openDropdown.classList.remove('show');
				}
			}
		}
	
	}
	</script> 
		<h1>Работа агента за период</h1>
		
		<form id="form" method="post" action="stats_by_day.php" >
			<p>Сотрудник:</p>
			<div id="agent">
			<?php
				
				//Connect to database
				$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
				$db_server->set_charset("utf8");
				If (!$db_server) die("Can not connect to a database!!".mysqli_connect_error($db_server));
				mysqli_select_db($db_server,$db_database)or die(mysqli_error($db_server));
		
				//Prepare list of agents
				$textsql='SELECT  tab_num,name FROM agents WHERE status=1 ORDER BY name';
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
				$ag_string='<select class="agents" id="val1" name="val"><option value=""></option>'.$ag_string.'</select>';
				echo $ag_string;
			?>
			</div>
			<p>С:</p>
			<p>День:</p>
			<div id="day"><p> 	
				<select name="day" id="day" class="day" >
				<option value="01">1</option>
				<option value="02">2</option>
				<option value="03">3</option>
				<option value="04">4</option>
				<option value="05">5</option>
				<option value="06">6</option>
				<option value="07">7</option>
				<option value="08">8</option>
				<option value="09">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
				</select></p>
			
			</div>
		 	<p>Месяц:</p>
			<div id="month_fr"><p> 	
				<select name="month_from" id="mfr" class="date" >
				<option value="1">Январь</option>
				<option value="2">Февраль</option>
				<option value="3">Март</option>
				<option value="4">Апрель</option>
				<option value="5">Май</option>
				<option value="6">Июнь</option>
				<option value="7">Июль</option>
				<option value="8">Август</option>
				<option value="9">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
				</select></p>
			
			</div>
			<p>Год: <select name="year_from" id="yfr" class="date" >
				<option value="2016">2016</option>
				</select>
			</p>
			<p>ПО:</p>
			<p>День:</p>
			<div id="day"><label><p> 	
				<select name="day_to" id="day_to" class="day" >
				<option value="01">1</option>
				<option value="02">2</option>
				<option value="03">3</option>
				<option value="04">4</option>
				<option value="05">5</option>
				<option value="06">6</option>
				<option value="07">7</option>
				<option value="08">8</option>
				<option value="09">9</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
				<option value="13">13</option>
				<option value="14">14</option>
				<option value="15">15</option>
				<option value="16">16</option>
				<option value="17">17</option>
				<option value="18">18</option>
				<option value="19">19</option>
				<option value="20">20</option>
				<option value="21">21</option>
				<option value="22">22</option>
				<option value="23">23</option>
				<option value="24">24</option>
				<option value="25">25</option>
				<option value="26">26</option>
				<option value="27">27</option>
				<option value="28">28</option>
				<option value="29">29</option>
				<option value="30">30</option>
				<option value="31">31</option>
				</select></p></label>
			
			</div>
		 	<p>Месяц:</p>
			<div id="month_to"><label><p> 	
				<select name="month_to" id="mto" class="date" >
				<option value="1">Январь</option>
				<option value="2">Февраль</option>
				<option value="3">Март</option>
				<option value="4">Апрель</option>
				<option value="5">Май</option>
				<option value="6">Июнь</option>
				<option value="7">Июль</option>
				<option value="8">Август</option>
				<option value="9">Сентябрь</option>
				<option value="10">Октябрь</option>
				<option value="11">Ноябрь</option>
				<option value="12">Декабрь</option>
				</select></p></label>
			
			</div>
			<p>Год: <select name="year_to" id="yto" class="date" >
				<option value="2016">2016</option>
				</select>
			</p>
			<p>Авиакомпания:</p>
			<div id="Carrier"><label><p> 	
				<select name="carrier" id="carrier" class="carrier" >
				<option value="FV">Россия</option>
				<option value="SU">Аэрофлот</option>
				<option value="DP">Победа</option>
				<option value="S7">S7</option>
				<option value="U6">Уральские ав.</option>
				<option value="7R">РусЛайн</option>
				<option value="GH">Глобус</option>
				<option value="UT">UTair</option>
				<option value="LH">Lufthansa</option>
				<option value="AY">Finnair</option>
				<option value="AF">AirFrance</option>
				</select></p></label>
			
			</div>
			
			<p><div id="errors"></div></p>	
			<p><input type="submit" name="send" class="send" value="ВВОД"></p>
		</form>
		
		<script>
		$('form').submit(function(event){
			var year_cond =($("#yto").val()<$("#yfr").val());
			var year_cond_eq =($("#yto").val()===$("#yfr").val());
			var month_cond =($("#mfr").val()>$("#mto").val());
			if (year_cond){
				  $( "#errors" ).text( "ОШИБКА: Год ОКОНЧАНИЯ не может быть раньше года НАЧАЛА! " ).show().fadeOut( 8000 );
					event.preventDefault();
				return false;
			}
			else if (month_cond & year_cond_eq){
				$( "#errors" ).text( "ОШИБКА: Месяц ОКОНЧАНИЯ не может быть раньше месяца НАЧАЛА!" ).show().fadeOut( 8000 );
					event.preventDefault();
				return false;
			}
			
			var res=$.post(
					$(this).attr("action"),
					$(this).serialize(),
					void(0)
				).html();
				
				return;
		});	
		
		</script>
		<?php mysqli_free_result($answsql);
			mysqli_close($db_server);
		?>
	</body>
</html>