<?php
	include('config.php');

	$id = $_POST['id'];
	$name = $_POST['name'];
	$pwd = $_POST['pwd'];
	$phone = $_POST['phone'];
	$adr = $_POST['adr'];

	
	$sql = "SELECT * FROM members WHERE id='$id'";
	$confirm = $con->query($sql);

	if($confirm->num_rows==1)
	{
		//header("Content-Type:text/html; charset=UTF-8");
		echo "<script>alert('해당 아이디가 존재합니다.');history.back();</script>";
		exit;
	}
	else
	{
		$sql = "INSERT INTO members(id,name,password,phone,address) VALUES('$id','$name','$pwd','$phone','$adr')";
		$result = $con->query($sql);

		if(!$result)
		{
			echo "<script>alert('회원가입에 실패하였습니다. 다시 시도해주세요.');history.back();</script>";
			exit;
		}
		else
		{
			echo "<script>alert('회원가입이 완료되었습니다.');location.replace('./login.html');</script>";
			exit;
		}
	}
	
?>