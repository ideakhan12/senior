<?php
	include('config.php');

	session_start();
    $id = $_SESSION['id'];
    $new = $_POST['new'];

	$no = $_POST['no'];
	$text = $_POST['text'];
	$s_date = $_POST['s_date'];
	$e_date = $_POST['e_date'];
	$s_time = $_POST['s_time'];
	$e_time = $_POST['e_time'];
	$delivery_no = $_POST['delivery_no'];
    $delivery_company = $_POST['delivery_company'];
	$now = date("Y-m-d");

	if($new == 1)
	{
		$sql = "SELECT max(no)+1 FROM delivery";
    	$no = mysqli_fetch_row(mysqli_query($con, $sql))[0];

		$sql = "INSERT INTO delivery(no, id, text, delivery_no, delivery_company, s_date, e_date, s_time, e_time, w_date)
		VALUES($no, '$id', '$text', '$delivery_no', '$delivery_company', '$s_date', '$e_date', '$s_time', '$e_time', '$now');";
	}
	else
	{
		$sql = "UPDATE delivery SET text = '$text', delivery_no = '$delivery_no', delivery_company = '$delivery_company',
		 s_date = '$s_date', e_date = '$e_date', s_time = '$s_time', e_time = '$e_time' WHERE id = '$id' AND no = '$no'";
	}
	//echo $sql;
	
	$result = $con->query($sql);

	if(!$result)
	{
		echo "<script>alert('저장에 실패하였습니다. 다시 시도해주세요.');history.back();</script>";
		exit;
	}
	else
	{
		echo "<script>alert('저장되었습니다.');history.go(-2);</script>";
		exit;
	}
?>