<?php
include ("login_agents.php"); 
include ("header.php"); 
if(!$loggedin) echo "<script>window.location.replace('/Agents/login.php');</script>";
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
		$str_out ='<div id="add1" class="add"><select class="agents" id="agent" name="agent">';
					foreach ($ag_in as $agent) 
						$str_out=$str_out.'<option value="'.($agent[0]).'">'.($agent[1]).'</option>';
				
				$str_out=$str_out.'</select></div>';
				
				
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
	 

		<h1>Депремирование</h1>
		
		<form id="form" method="post" action="record_penalty.php" >
			
			
			<p>Агент:</p>
			
			<?php echo $str_out;?>
			<p>Тип отзыва:</p>
			<div id="feedback_type">
			<table>
				<tr>
					<td><p>Поощрение<input type="radio" id="good" name="feedback" onclick="javascript:yesnoCheck();" value="0"></p></td>
					<td><p>Наказание<input type="radio" id="bad" name="feedback"  onclick="javascript:yesnoCheck();" value="1"></p></td>
				</tr>
			</table>
			</div>
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
				<option value="2017">2017</option>
				</select>
			</p>
						
		 	
			<p>Причина:</p>
			<div id="Description"> 	
				<p><textarea rows="5" cols="45" id="text" name="text"></textarea></p>
			</div>
			
			<div id="percentage" style="visibility:hidden" ><p> 
			<p>Процент:</p>	
				<select name="percentage" id="pct" class="percent" >
				<option value="-"></option>
				<option value="5">5%</option>
				<option value="10">10%</option>
				<option value="15">15%</option>
				<option value="20">20%</option>
				<option value="25">25%</option>
				<option value="30">30%</option>
				<option value="35">35%</option>
				<option value="40">40%</option>
				<option value="45">45%</option>
				<option value="50">50%</option>
				<option value="55">55%</option>
				<option value="60">60%</option>
				</select></p>
			
			</div>
			<p><div id="errors"></div></p>	
			<p><input type="submit" name="send" class="send" value="ВВОД"></p>
		</form>
		
		<script>
		$('form').submit(function(event){
			var text_mask = /^[A-Za-z0-9]$/;
			var text=$("#text").val();
			var text_cond =text_mask.test(text);
			
			if (text_cond){
				  $( "#errors" ).text( "ОШИБКА: в тексте обнаружены запрещенные для ввода символы! " ).show().fadeOut( 8000 );
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
		function yesnoCheck() {
			if (document.getElementById('bad').checked) {
				document.getElementById('percentage').style.visibility = 'visible';
			} 
			else {
				document.getElementById('percentage').style.visibility = 'hidden';
			}
		}
		</script>


	</body>
</html>