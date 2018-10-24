<?php
    include("config.php");

    session_start();
    $id = $_SESSION['id'];
    $now = date("Y-m-d");
    $s_date = date('Y-m-d H:i:s', strtotime($_POST['s_date']));
    $e_date = date('Y-m-d H:i:s', strtotime($_POST['e_date']));
    $text = $_POST['text'];
    $delivery_no = $_POST['delivery_no'];
    $delivery_company = $_POST['delivery_company'];

    $sql = "SELECT max(no)+1 FROM delivery";
    $no = mysqli_fetch_row(mysqli_query($con, $sql))[0];

    $sql = "INSERT INTO delivery(no, id, text, delivery_no, delivery_company, w_date, s_date, e_date) 
    VALUES($no, '$id', '$text', '$delivery_no', '$delivery_company', '$now', '$s_date', '$e_date');";

    $result = $con->query($sql);
    
    if($result)
    {
		echo "<script>alert('성공적으로 등록되었습니다');location.replace('/delivery.php');</script>";
        exit;
	}
	else
	{
		echo "<script>alert('등록에 실패하였습니다. 다시 시도해주세요.');history.back();</script>";
        exit;
	}
?>
