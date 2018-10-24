<?php
	include('config.php');
	session_start();

    $id = $_SESSION['id'];
	$no = $_POST['no'];

	$sql = "DELETE FROM delivery WHERE id = '$id' AND no = '$no'";
	//echo $sql;
	
	$result = $con->query($sql);

	if(!$result)
	{
		echo "<script>alert('삭제에 실패하였습니다. 다시 시도해주세요.');history.back();</script>";
		exit;
	}
	else
	{
		echo "<script>alert('삭제되었습니다.');history.go(-1);</script>";
		exit;
	}
?>