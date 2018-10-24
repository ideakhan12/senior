<?php
	session_start();

	if(!isset($_SESSION['id']))
	{
		header ('Location: ./login.html');
	}
?>
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
	#background
	{
		background: linear-gradient( rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5) ), url('img/back01.jpg');
    	height: :100%;
    	background-size: cover;
		background-repeat: no-repeat;
		text-align: center;
	}

	hr
	{
		background-color: #eeeeee; 
		height: 1px; 
		border: 0;
	}

	#title
	{
		margin-left:1em;
		line-height: 40px;
	}

	#title_img
	{
		width:97%;
		margin-bottom:2px;
		margin-top:4px;
	}

	#menu
	{
		border:1px solid #eee;
		width:21.2%;
		height:80px;
		display: inline-block;
	}

	#menu_img
	{
		margin-top:15px;
		margin-bottom:8px;
	}

	a
	{
		text-decoration:none;
		color:black;
	}

	.ui-input-text
	{
		border-radius: 13px;
		outline: 0;
	  	background: #f4f4f4;
	  	width: 65%;
	  	border:1px solid #eee;
	  	margin: 7px 0px 0px 0px;
	  	padding: 0px;
	  	font-size:3em;
	  	display: inline-block;
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
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #ffffff">
			<ul style="margin-top:0.7em">
				<li></li>
				<li style="margin-top:0.2em"><font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font></li>
				<li><a><img src="img/cancel.png" width="23em" style="margin-left:4.4em; margin-top:-0.6em; margin-bottom:-0.4em" onclick="logout()"></a></li>
				<!--
				<li><a href="#" data-ajax="false" style="margin-left:4.4em; margin-bottom:-0.6em; margin-top:-0.6em"><img src="img/cancel.png" width="23em"></a></li>-->
			</ul>
			<hr/>
		</div>
		<div data-role="content" align="center">
			<table width="100%" height="100%" style="background-color: white">
				<tr>
					<td valign="top" style="padding-top:0px" align="center">
						<div style="width:90%; height:14%; margin-top:1em; margin-bottom:-0.5em;">
							<font size="2em" style="font-weight: bold">Q&A</font><br/>
							<input type="text" style="width:100px">
						</div>
						<div id="menu">
							<a href="./monitoring.php" data-ajax="false">
							<img src="img/monitor.png" width="30em" id="menu_img"><br/>
							<font size="2em">모니터링</font>
							</a>
						</div>
						<div id="menu">
							<a href="./list.php" data-ajax="false">
							<img src="img/memo_check.png" width="30em" id="menu_img"><br/>
							<font size="2em">일정</font>
							</a>
						</div>
						<div id="menu">
							<a href="./delivery.php" data-ajax="false">
							<img src="img/box.png" width="30em" id="menu_img"><br/>
							<font size="2em">택배</font>
							</a>
						</div>
						<div id="menu">
							<a href="#" data-ajax="false">
							<img src="img/setting.png" width="30em" id="menu_img"><br/>
							<font size="2em">환경설정</font>
							</a>
						</div>
						<?php
					include('config.php');
					$sql = "SELECT * FROM demand WHERE id = '$id' order by w_date, s_date";
					$result = mysqli_query($con, $sql);

					while( $data = mysqli_fetch_array($result))
					{ 
						$no = $data['no'];
						$w_date = date("M d, Y", strtotime($data['w_date']));
						$s_date = date("Y/m/d H시 i분", strtotime($data['s_date']));
						$e_date = date("Y/m/d H시 i분", strtotime($data['e_date']));
						$text = $data['text'];

						echo "<div class='memo'>";
						echo "<font size='2em' face='sans-serif' color='gray' style='font-weight:bold' id='wdate'>",$w_date, "</font><br/>";
						echo "<br/><a href='#'><font size='3em'>", $text, "</font>";
						echo "<br/><font size='1.5em' id='date'>", $s_date, " ~ ", $e_date, "</font></a><br/><br/>";
						echo "</div>";
					}
				?>
					</td>
				</tr>
			</table>
	</div>
</body>
</html>