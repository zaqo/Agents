<?php
include ("login_agents.php"); 
include ("header.php"); 
if(!$loggedin) echo "<script>window.location.replace('/Agents/login.php');</script>";
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
	 

		<h1>Поиск по номеру рейса</h1>
		
		<form id="form" method="post" action="by_day_and_flight.php" >
			
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
				<option value="2018">2018</option>
				</select>
			</p>
						
		 	
			<p>Рейс:</p>
			<div id="Flight"> 	
				<p><input type="text" id="fl" name="flight" class="name" value="" placeholder="FV1122"/></p>
			</div>
			
			<p><div id="errors"></div></p>	
			<p><input type="submit" name="send" class="send" value="ВВОД"></p>
		</form>
		
		<script>
		$('form').submit(function(event){
			var flight_mask = /^[A-Za-z0-9]{4,8}$/;
			var flight=$("#fl").val();
			var flight_cond =flight_mask.test(flight);
			
			if (!flight_cond){
				  $( "#errors" ).text( "ОШИБКА: Укажите пожалуйста правильно номер рейса! " ).show().fadeOut( 8000 );
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


	</body>
</html>