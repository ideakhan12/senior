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
	a
	{
		text-decoration:none;
		color:black;
	}
	</style>
</head>
<body>
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #fff">
			<ul style="margin-top:0.6em">
				<li></li>
				<li style="margin-top:0.45em">
					<font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font>
				</li>
				<li><a href="/delivery_w.php" data-ajax="false"><img src="img/edit.png" width="23em" style="margin-left:4.4em; margin-top:-0.3em; margin-bottom:0.05em" onclick="logout()"></a></li>
			</ul>
		</div>
		<div data-role="content" align="center">
			<div style="width:100%; background-color:#b9b9b9; height:1px"></div>
			<div style="width:98%; background-image:url(img/delivery_imgbar.png); 
				background-size:100%; height:27%; text-align:left; margin-top:0.2em">
				<p style="font-size:1.5em; margin-left:1.5em; margin-top:0.1em; padding-top:2.9em; color:white">
					택배</p>
				<p style="font-size:0.7em; margin-left:3.3em; color:white; margin-top:-1.8em">
				운송장번호를 등록하여 택배 알림 서비스를 받아보세요</p>
			</div>
			<form id="modify" name="modifyform" action="/delivery_m.php" method="post" data-ajax="false">
			<input type="hidden" value="0" id="no" name="no">
				<?php
					include('config.php');
					$sql = "SELECT * FROM delivery WHERE id = '$id' order by w_date, s_date";
					$result = mysqli_query($con, $sql);

					while( $data = mysqli_fetch_array($result))
					{ 
						$no = $data['no'];
						$$s_date = date("Y/m/d", strtotime($data['s_date']));
						$e_date = date("Y/m/d", strtotime($data['e_date']));
						$s_time = date("H시 i분", strtotime($data['s_time']));
						$e_time = date("H시 i분", strtotime($data['e_time']));
						$w_date = date("M d, Y", strtotime($data['w_date']));
						$delivery_no = $data['delivery_no'];
						$delivery_company = $data['delivery_company'];
						$text = $data['text'];

						echo "<div class='memo'>";
						echo "<font size='2em' face='sans-serif' color='gray' style='font-weight:bold' id='wdate'>",$w_date, "</font><br/>";
						echo "<br/><a href='#' id='$no' onclick='modifyDelivery(this)'><font size='3em'>", $text, "</font>";
						echo "<br/><font size='1.5em' id='date'>", $s_date, " ~ ", $e_date, "</font></a><br/><br/>";
						echo "</div>";
					}
				?>
			</form>
		</div>
	</div>
	<script>
		function modifyDelivery(obj)
		{
			var click_id = obj.id;
			document.modifyform.no.value = click_id;
			document.getElementById('modify').submit()
		}
	</script>
</body>
</html>