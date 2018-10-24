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

	hr
	{
		background-color: #eeeeee; 
		height: 1px; 
		border: 0;
	}
	</style>

</head>
<body>

	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #fff">
			<ul style="margin-top:0.6em">
				<li></li>
				<li style="margin-top:0.2em">
					<font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font>
				</li>
				<li><a><img src="img/cancel.png" width="23em" style="margin-left:4.4em; margin-top:-0.6em; margin-bottom:0em" onclick="logout()"></a></li>
			</ul>
		</div>
		<div data-role="content" align="center" style="background-color:#eee; margin:0px; padding:0px">
			<div style="width:100%; background-color:#b9b9b9; height:1px"></div>
			<div style="width:98%; background-image:url(img/monitoring_imgbar.png); 
				background-size:100%; height:27%; text-align:left; margin-top:0.2em;">
				<p style="font-size:1.5em; margin-left:1.5em; margin-top:0.1em; padding-top:2.9em; color:white">
					모니터링</p>
				<p style="font-size:0.7em; margin-left:3.3em; color:white; margin-top:-1.8em">
				언제 어디서든 외부 상황을 모니터링 할 수 있어요</p>
			</div>

			<img id="img" width="97%" style="border:1px solid gray; margin-top:4px">
			<p id="name"></p>
			<script type="text/javascript">
				setInterval(function()
				{
					var d = new Date().toISOString();

					url = 'monitor/server.jpg?' + (new Date()).getTime();
					$("#img").attr('src',url);
				},100);		
			</script>
		</div>
	</div>
</body>
</html>