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

	.memo
	{
		background-color: rgba(255,255,255,0.9);
		color:black;
		border-bottom:1px dashed #eeeeee;
		margin-bottom: 10px;
		/*border-bottom :1px solid #cccccc;*/
	}

	#wdate
	{
		margin-left:-13em;
		margin-top:2em;
	}

	table
	{
		padding:0px;
		margin:0px;
	}
	hr
	{
		background-color: #eeeeee;
		height: 1px; 
		border: 0;
	}
	a
	{
		text-decoration:none;
		color:black;
	}

	#text
	{
		width:70%;
	}
	</style>
</head>
<body>
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #ffffff">
			<ul style="margin-top:0.7em">
				<li></li>
				<li style="margin-top:0.2em"><font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font></li>
				<li><a href="/demand_w.php" data-ajax="false" style="margin-left:4.4em; margin-bottom:-0.7em; margin-top:-0.6em"><img src="img/edit.png" width="23em"></a></li>
			</ul>
			<hr/>
		</div>
		<div data-role="content" align="center">
			<br/>
			<div style="width:85%; border:1px solid #eee; padding-top:1em; padding-bottom:1em; margin-bottom:0.5em;">
				<img src="img/memo.png" width="30em" id="menu_img"><br/>
				<font size="2em">일정</font>
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
						echo "<br/><div id='text'><a href='#'><font size='3em' id='text'>", $text, "</font>";
						echo "<br/><font size='1.5em' id='date'>", $s_date, " ~ ", $e_date, "</font></a></div><br/><br/>";
						echo "</div>";
					}
				?>
		</div>
	</div>
</body>
</html>