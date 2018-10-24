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
	#element
	{
		width:99%;
		text-align:left;
		font-family:'Titillium Web', sans-serif; 
		background-color:#fff;
		margin-bottom:0.4em;
	}
	table
	{
		border-collapse:collapse;
	}
	td
	{
		background-color:white;
		border-bottom:4px solid #eee;

	}
	
	.company
	{
		font-size:0.8em;
		background-color:#eee;
		width: 107%;
		margin-top:-1.5em;
		margin-bottom:-2.7em;
		height:45px;
		padding-top:15px;
	}
	option
	{
		margin-top:10px;
	}
	
	</style>
</head>
<?php
	include('config.php');
	$no = $_POST['no']; // 수정할 게시글의 고유번호
	$sql = "SELECT text, delivery_no, delivery_company, s_date, e_date, s_time, e_time FROM delivery WHERE id = '$id' and no = '$no'";
	            
	$result = mysqli_query($con, $sql);
	while( $data = mysqli_fetch_array($result))
	{ 
	    $text = $data['text'];
	    $delivery_no = $data['delivery_no'];
	    $delivery_company = $data['delivery_company'];
	    $s_date = $data['s_date'];
	    $e_date = $data['e_date'];
	    $s_time = $data['s_time'];
	    $e_time = $data['e_time'];
	 }
?>

<body>
	<div data-role="page">
		<div data-role="navbar" align="center" style="background-color: #fff">
			<ul style="margin-top:0.6em">
				<li></li>
				<li style="margin-top:0.45em">
					<font size="4.5em" face="sans-serif" style="cursor:pointer"
					onclick="window.location.href='./index.php'">누구세홈</font>
				</li>
				<li><a style="margin-bottom:1.9em"></a></li>
			</ul>
		</div>
		<div data-role="content" align="center" style="background-color: #eee">
			<div style="width:100%; background-color:#b9b9b9; height:1px"></div>
			<div style="width:98%; background-image:url(img/delivery_imgbar.png); 
				background-size:100%; height:27%; text-align:left; margin-top:0.2em">
				<p style="font-size:1.5em; margin-left:1.5em; margin-top:0.1em; padding-top:2.9em; color:white">
					택배</p>
				<p style="font-size:0.7em; margin-left:3.3em; color:white; margin-top:-1.8em">
				운송장번호를 등록하여 택배 알림 서비스를 받아보세요</p>
			</div>
			<form action="/delivery_md.php" method="post" data-ajax="false">
				<input type="hidden" name="new" value="0">
				<?php
					echo "<input type='hidden' name='no' value='$no'>";
				?>
			<table width="98%" bgcolor="#eee" style="margin-top:4px">
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">제목</p>
					</td>
					<td>
						<?php
							echo "<input type='text' name='text' value='$text'>";
						?>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">택배사</p>
					</td>
					<td>
						<select id="com" name="delivery_company" class="company">
							<option id="delivery_com" value="epost">우체국택배</option>
							<option id="lotteglogis" value="lotteglogis">롯데택배</option>
							<option id="ilogen" value="ilogen">로젠택배</option>
							<option id="doortodoor" value="doortodoor">CJ대한통운</option>
							<option id="cupost" value="cupost">CU편의점택배</option>
						</select>
						<script>
							$( document ).ready(function() 
							{ 
								$("#com option[value='<?= $delivery_company ?>']").attr('selected','selected'); 
								$("#com").selectmenu("refresh", true);
							});
						</script>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="23%">
						<p style="font-size:0.8em; margin-left:1em">운송장번호</p>
					</td>
					<td>
						<?php
							echo "<input type='text' name='delivery_no' value='$delivery_no'>";
						?>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">시작일</p>
					</td>
					<td>
						<?php
							echo "<input type='date' name='s_date' value='$s_date'>";
						?>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">종료일</p>
					</td>
					<td>
						<?php
							echo "<input type='date' name='e_date' value='$e_date'>";
						?>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">시작시간</p>
					</td>
					<td>
						<?php
							echo "<input type='time' name='s_time' value='$s_time'>";
						?>
					</td>
				</tr>
				<tr>
					<td width="15%" align="right">
						<img src="img/check3.png" width="20em" style="margin-top:4px">
					</td>
					<td width="18%">
						<p style="font-size:0.8em; margin-left:1em">종료시간</p>
					</td>
					<td>
						<?php
							echo "<input type='time' name='e_time' value='$e_time'>";
						?>
					</td>
				</tr>
				</table>
				<div id="element" style="text-align:center; background-color:#535353" onclick="this.parentNode.submit()">
					<p style="font-size:0.8em; margin-top:0px; padding-top:1em; padding-bottom:1em; color:white">저장하기</p>
				</div>
			</form>
		</div>
	</div>
</body>
</html>