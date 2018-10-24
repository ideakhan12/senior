<?php
	session_start();
	$id = $_SESSION['id'];

	if(!isset($_SESSION['id']))
	{
		header ('Location: ./login.html');
	}
?>
<!DOCTYPE>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link rel="stylesheet" type="text/css" href="framework/jquery.mobile.structure-1.4.5.min.css"/>
	<script src="//code.jquery.com/jquery.min.js"></script>
	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<script src="fullsize.js"></script>
	<style>
	/* 웹 폰트 */
	@import url(https://fonts.googleapis.com/css?family=Roboto:300);

	html, body, div[data-role="page"], div[data-role="content"]
	{
		width:100%;
	  	background: #ffffff;
	  	font-family: "Roboto", sans-serif;
	  	margin: 0px;
	  	padding: 0px;
	}

	/* 상단바 색상 */
	.ui-page .ui-header
	{
		background-color: #e74c3c;
		border-style: none;
	}

	hr
	{
		background-color:#eee;
		width:100%;
	}
	.ui-input-text
	{
		margin-left:16px;
		width:80%;
		outline: 0;
	  	border:none;
	  	background-color: #f3f3f3;
	  	color:white;
	  	display:inline-block;
	}
	input[type="button"]
	{
		border:none;
		border:1px solid gray;
		font-size:0.8em;
		width:40%;
		height:30px;
		display:inline-block;
	}

	#element
	{
		width:99%;
		text-align:left;
		font-family:'Titillium Web', sans-serif; 
		background-color:#fff;
		margin-bottom:0.4em;
	}

	.switch
	{
		width:40%; 
		height:30px; 
		display:inline-block;
		font-size:0.8em;
		line-height:30px; 
		margin:auto; padding:auto;
		background-color:white;
	}
	#set
	{
		background-color:#e3f0f8;
	}

	#unset
	{
		background-color:#eeeeee;
	}

</style>
	<script>
		function logout()
		{
			var answer = confirm("로그아웃 하시겠습니까?")
			if (answer)
			{
				location.href="/logout.php";
			}
		}
	</script>

</head>
<body>
	<?php
        include('config.php');
        $sql = "SELECT door_ip, door_port, schedule, delivery, weather FROM members WHERE id = '$id'";
        $result = mysqli_query($con, $sql);
        while( $data = mysqli_fetch_array($result))
        { 
            $door_ip = $data['door_ip'];
            $door_port = $data['door_port'];
            $schedule = $data['schedule'];
            $delivery = $data['delivery'];
            $weather = $data['weather'];
        }
     ?>
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #fff">
			<ul style="margin-top:0.6em">
				<li></li>
				<li style="margin-top:0.45em">
					<font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font>
				</li>
				<li><a><img src="img/cancel.png" width="23em" style="margin-left:4.4em; margin-top:-0.3em; margin-bottom:0.4em" onclick="logout()"></a></li>
			</ul>
		</div>

		<div data-role="content" align="center" style="background-color:#eee; margin:0px; padding:0px">
			<div style="width:100%; background-color:#b9b9b9; height:1px"></div>
			<div style="width:98%; background-image:url(img/imgbar.png); 
				background-size:100%; height:27%; text-align:left; margin-top:0.2em">
				<p style="font-size:1.5em; margin-left:1.5em; margin-top:0.1em; padding-top:2.9em; color:white">
					환경설정</p>
				<p style="font-size:0.7em; margin-left:3.3em; color:white; margin-top:-1.8em">
				알림 활성화 기능을 이용한 스마트 홈 IOT</p>
			</div>
			
			<div style="width:98%; background-color:#eee; margin-top:0.3em;">
				<form action="/setting_w.php" method="post" data-ajax="false">
				<div id="element">
					<table width="100%">
						<tr>
							<td width="15%"><img src="img/setting_home.png" width="40em"
							 style="margin-left:1em;padding-top:0.5em; padding-bottom:0.5em"></td>
							<td width="30%">
								<p style="font-size:0.8em; margin-left:1em">DOOR IP</p>
							</td>
							<td>
								<?php
									echo "<input type='text' name='ip' value='$door_ip'>";
								?>
							</td>
						</tr>
					</table>
				</div>
				<div id="element">
					<table width="100%">
						<tr>
							<td width="15%"><img src="img/setting_home.png" width="40em"
							 style="margin-left:1em;padding-top:0.5em; padding-bottom:0.5em"></td>
							<td width="30%">
								<p style="font-size:0.8em; margin-left:1em">DOOR PORT</p>
							</td>
							<td>
								<?php
									echo "<input type='text' name='port' value='$door_port'>";
								?>
							</td>
						</tr>
					</table>
				</div>
				<div id="element">
					<table width="100%">
						<tr>
							<td width="15%"><img src="img/setting_alarm.png" width="40em"
							 style="margin-left:1em;padding-top:0.5em; padding-bottom:0.5em"></td>
							<td width="30%">
								<p style="font-size:0.8em; margin-left:1em">SCHEDULE</p>
							</td>
							
							<td align="center" valign="center">
								<?php
									echo "<input type='hidden' id='schedule' name='schedule' value='$schedule'>";
									if ($schedule == 1)
									{
										echo "<div class='switch' id='switch_schedule' name='schedule_on'
										style='background-color:#e3f0f8'>ON</div> ";
										echo "<div class='switch' id='switch_schedule' name='schedule_off'
										style='background-color:#eeeeee'>OFF</div>";
									}
									else
									{
										echo "<div class='switch' id='switch_schedule' name='schedule_on'
										style='background-color:#eeeeee'>ON</div> ";
										echo "<div class='switch' id='switch_schedule' name='schedule_off'
										style='background-color:#e3f0f8'>OFF</div>";
									}
								?>
							</td>
						</tr>
					</table>
				</div>
				
				
				<div id="element">
					<table width="100%">
						<tr>
							<td width="15%"><img src="img/setting_alarm.png" width="40em"
							 style="margin-left:1em;padding-top:0.5em; padding-bottom:0.5em"></td>
							<td width="30%">
								<p style="font-size:0.8em; margin-left:1em">DELIVERY</p>
							</td>
							<td align="center" valign="center">
								<?php
									echo "<input type='hidden' id='delivery' name='delivery' value='$delivery'>";
									if ($delivery == 1)
									{
										echo "<div class='switch' id='switch_delivery' name='delivery_on'
										style='background-color:#e3f0f8'>ON</div> ";
										echo "<div class='switch' id='switch_delivery' name='delivery_off'
										style='background-color:#eeeeee'>OFF</div>";
									}
									else
									{
										echo "<div class='switch' id='switch_delivery' name='delivery_on'
										style='background-color:#eeeeee'>ON</div> ";
										echo "<div class='switch' id='switch_delivery' name='delivery_off'
										style='background-color:#e3f0f8'>OFF</div>";
									}
								?>
							</td>
						</tr>
					</table>
				</div>
				<div id="element">
					<table width="100%">
						<tr>
							<td width="15%"><img src="img/setting_alarm.png" width="40em"
							 style="margin-left:1em;padding-top:0.5em; padding-bottom:0.5em"></td>
							<td width="30%">
								<p style="font-size:0.8em; margin-left:1em">WEATHER</p>
							</td>
							<td align="center" valign="center">
								<?php
									echo "<input type='hidden' id='weather' name='weather' value='$weather'>";

									if ($weather == 1)
									{
										echo "<div class='switch' id='switch_weather' name='weather_on'
										style='background-color:#e3f0f8'>ON</div> ";
										echo "<div class='switch' id='switch_weather' name='weather_off'
										style='background-color:#eeeeee'>OFF</div>";
									}
									else
									{
										echo "<div class='switch' id='switch_weather' name='weather_on'
										style='background-color:#eeeeee'>ON</div> ";
										echo "<div class='switch' id='switch_weather' name='weather_off'
										style='background-color:#e3f0f8'>OFF</div>";
									}
								?>
							</td>
						</tr>
					</table>
				</div>
				<script>
				$(document).ready(function() 
				{
				    $(".switch").click(function() 
				    {
				    	var $color = $(this).css("background-color");
				    	var $onoff = $(this).attr('name');

				    	/* 일정 */
				    	if(($onoff) == 'schedule_on')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='schedule_off']").css("background-color", "#eeeeee");
				    			$("#schedule").attr('value','1');
				    		}
				    	}
				    	if(($onoff) == 'schedule_off')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='schedule_on']").css("background-color", "#eeeeee");
				    			$("#schedule").attr('value','0');
				    		}
				    	}

				    	/* 택배 */
				    	if(($onoff) == 'delivery_on')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='delivery_off']").css("background-color", "#eeeeee");
				    			$("#delivery").attr('value','1');
				    		}
				    	}
				    	if(($onoff) == 'delivery_off')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='delivery_on']").css("background-color", "#eeeeee");
				    			$("#delivery").attr('value','0');
				    		}
				    	}

				    	/* 날씨 */
				    	if(($onoff) == 'weather_on')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='weather_off']").css("background-color", "#eeeeee");
				    			$("#weather").attr('value','1');
				    		}
				    	}
				    	if(($onoff) == 'weather_off')
				    	{
				    		if(($color) == 'rgb(238, 238, 238)')
				    		{
				    			$(this).css("background-color", "#e3f0f8");
				    			$("div[name='weather_on']").css("background-color", "#eeeeee");
				    			$("#weather").attr('value','0');
				    		}
				    	}
				    	
				    });
				});
				</script>

				<div id="element" style="text-align:center; background-color:#535353" onclick="this.parentNode.submit()">
					<p style="font-size:0.8em; margin-top:0px; padding-top:1em; padding-bottom:1em; color:white">저장하기</p>
				</div>
				</form>
			</div>
    	</div>
</body>
</html>