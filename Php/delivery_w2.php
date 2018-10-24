<?php
	session_start();
	$id = $_SESSION['id'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<link rel="stylesheet" type="text/css" href="framework/jquery.mobile.structure-1.4.5.min.css" type="text/css"/>
	<script src="//code.jquery.com/jquery.min.js" type="text/javascript"></script>
	<script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js" type="text/javascript"></script>
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

	/* 상단바 스타일 */
	.ui-page .ui-header
	{
		background-color: #ffffff;
		border-style: none;
	}

	hr
	{
		background-color: #eeeeee; 
		height: 1px; 
		border: 0;
	}

	#img
	{
		width:85%;
		border:1px solid #eee;
		margin-top:19px;
		margin-bottom:0px;
	}

	
	/* 입력 스타일 */
	input
	{
		font-size:12px;
		color: black;
		padding:0px;

	}

	.ui-input-text
	{
		margin-top:-20px;
		margin-bottom:10px;
		outline: 0;
	  	background: rgba(0,0,0,0);
	  	width: 80%;
	  	border:none;
	  	background-color: #fff;
	  	border-bottom: 1px dashed #eee;
	  	box-sizing: border-box;
	  	color:white;
	}

	a
	{
		text-decoration: none;
		color:black;
	}

	#menu
	{
		border:1px solid #eee;
		width:41.8%;
		height:75px;
		display: inline-block;
		margin-bottom: 4px;
	}

    #menu_img
	{
		margin-top:10px;
		margin-bottom:0px;
	}

	.company
	{
		padding-top:-100px;
		font-size:12px;
		text-align: left;
		border-bottom:1px dashed #eee;
		margin-top:-10px;
		margin-left:15px;
		padding-left:3px;
		padding-bottom:5px;
	}
	</style>

</head>
<body>
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #ffffff">
			<ul style="margin-top:0.7em">
				<li><a href="/delivery.php" data-ajax="false" style="margin-left:-6em; margin-bottom:-0.7em; margin-top:-0.4em"><img src="img/back.png" width="20em"></a></li>
				<li style="margin-top:0.2em"><font size="4.5em" face="sans-serif">누구세홈</font></li>
				<li></li>
			</ul>
			<hr/>
		</div>
		<div data-role="content" align="center">

			<div style="width:85%; border:1px solid #eee;">
				<!--<img src="img/time.png" width="97%" id="img">-->
				<form action="/input_delivery.php" method="post" data-ajax="false">
					<br/>
					<font size="2em" color="gray" style="margin-left:-200px; font-weight:bold"># 제목<br/><br/></font>
					<input type="text" name="text" required>
					<font size="2em" color="gray" style="margin-left:-190px; font-weight:bold"># 택배사<br/></font>
					<select name="delivery_company" class="company">
						<option value="epost">우체국택배</option>
						<option value="lotteglogis">롯데택배</option>
						<option value="ilogen">로젠택배</option>
						<option value="doortodoor">CJ대한통운</option>
						<option value="cupost">CU편의점택배</option>
					</select>
					<font size="2em" color="gray" style="margin-left:-170px; font-weight:bold"># 운송장번호<br/><br/></font>
					<input type="text" name="delivery_no" required>
					<font size="2em" color="gray" style="margin-left:-180px; font-weight:bold"># 시작시간<br/><br/></font>
					<input type = "datetime-local" name="s_date" required>
					<font size="2em" color="gray" style="margin-left:-180px; font-weight:bold"># 종료시간<br/><br/></font>
					<input type = "datetime-local" name="e_date" required>
				<!--
				<input type = "datetime-local" name="e_date" placeholder="# 종료시간" data-clear-btn ="true">
			-->
				<input type="submit" value="등록">
				</form>
			</div>

			<!--
			<div id="top">
				<br/>
				<font size="6em" face="sans-serif" style="font-weight: bold">2018 May 22</font>
			</div>
			<div id="contents">
				<br/>
				
			</div>
			<div id="bottom">
			</div>
		-->
		</div>
	</div>
</body>
</html>