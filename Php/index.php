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
				<li style="margin-top:0.2em"><font size="4.5em" face="sans-serif">누구세홈</font></li>
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
							<a href="#" data-ajax="false">
							<img src="img/monitor.png" width="30em" id="menu_img"><br/>
							<font size="2em">모니터링</font>
							</a>
						</div>
						<div id="menu">
							<a href="./list.php" data-ajax="false">
							<img src="img/memo.png" width="30em" id="menu_img"><br/>
							<font size="2em">일정/택배</font>
							</a>
						</div>
						<div id="menu">
							<a href="#" data-ajax="false">
							<img src="img/images.png" width="30em" id="menu_img"><br/>
							<font size="2em">히스토리</font>
							</a>
						</div>
						<div id="menu">
							<a href="#" data-ajax="false">
							<img src="img/setting.png" width="30em" id="menu_img"><br/>
							<font size="2em">환경설정</font>
							</a>
						</div>

						<div style="border:1px solid #eee; width:90%; text-align:left; margin-top:0.5em;">
							<center>
							<img src="img/list2.jpg" id="title_img"></center>
							<!-- 타이틀 -->
							<div style="margin-top:0.2em;border-bottom: 1px solid #eee">
								<!--
								<font size="3em" id="title">공지사항</font>
								<img src="img/notice.png" width="20em">
							-->
							</div>
						<?php
							include('config.php');
							$sql = "SELECT * FROM notice order by w_date";
							$result = mysqli_query($con, $sql);

							while( $data = mysqli_fetch_array($result))
							{ 
								$no = $data['no'];
								$title = $data['title'];
								$contents = $data['contents'];
								$w_date = date("Y-m-d", strtotime($data['w_date']));

								echo "<div style='margin-bottom:0.8em'>";
								echo "<a style='margin-top:2em;'><font size='1.5em' color='gray' style='margin-left:4em'>", $w_date, " </font>";
								echo "<font size='2.5em' style='margin-left:3em'>#", $title, "</font><br/></a>";
								echo "</div>";
								
							}
						?>
					</div>
						<center>
						<br/>
						<br/>
						<!--
						<table width="90%">
	        					<tr>
	        						<td align="center" valign="center" width="47%" id="menu">
	        							<a href="http://localhost/m_monitoring.php">
	        							<img src="img/video-camera.png" width="50em" style="padding:0px; margin:5px;"></a>
	        							<br/>
	        							<font id="mfont"><b>실시간 모니터링</b></font>
	        						</td>
	        						<td width="6%"></td>
	        						<td align="center" valign="center" width="47%" id="menu">
	        							<a href="./list.php" data-ajax="false">
	        							<img src="img/notepad.png" width="50em" style="padding:0px; margin:5px;"></a>
	        							<br/>
	        							<font id="mfont"><b>일정 / 택배</b></font>
	        						</td>
	        					</tr>
	        					<tr>
	        						<td colspan="3" height="18px"></td>
	        					</tr>
	        					<tr>
	        						<td align="center" valign="center" width="47%" id="menu">
	        							<a href="http://localhost/m_monitoring.php">
	        							<img src="img/screen.png" width="50em" style="padding:0px; margin:5px;"></a>
	        							<br/>
	        							<font id="mfont"><b>히스토리</b></font>
	        						</td>
	        						<td width="6%"></td>
	        						<td align="center" valign="center" width="47%" id="menu">
	        							<a href="http://localhost/m_monitoring.php">
	        							<img src="img/settings.png" width="50em" style="padding:0px; margin:5px;"></a>
	        							<br/>
	        							<font id="mfont"><b>환경설정</b></font>
	        						</td>
	        					</tr>
	        				</table>
	        			-->
	        			</center>
					</td>
				</tr>
			</table>
	</div>
</body>
</html>