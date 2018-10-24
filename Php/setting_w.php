<?php
	include('config.php');

	session_start();
    $id = $_SESSION['id'];

	$ip = $_POST['ip'];
	$port = $_POST['port'];
	$schedule = $_POST['schedule'];
	$delivery = $_POST['delivery'];
	$weather = $_POST['weather'];


	$sql = "UPDATE members SET door_ip = '$ip', door_port = '$port', 
	schedule = '$schedule', delivery = '$delivery', weather = '$weather' WHERE id = '$id'";

	$result = $con->query($sql);

	if(!$result)
	{
		echo "<script>alert('저장에 실패하였습니다. 다시 시도해주세요.');history.back();</script>";
		exit;
	}
	else
	{
		echo "<script>alert('저장되었습니다.');history.back();</script>";
		exit;
	}
?>