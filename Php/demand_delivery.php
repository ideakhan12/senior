<?php
	header("Content-type: application/json; charset=utf-8");
	include("config.php");

	$id = $_POST['id'];
	$sql = "SELECT * FROM delivery WHERE id = '$id'";

	$result = mysqli_query($con, $sql);
	$response = array();

	while($row = mysqli_fetch_array($result))
	{
		$response[] = array
		(
			'no' => $row['no'],
			'id' => $row['id'],
			'text' => $row['text'],
			'delivery_no' => $row['delivery_no'],
			'delivery_company' => $row['delivery_company'],
			'w_date' => $row['w_date'],
			's_date' => $row['s_date']. " " .$row['s_time'],
			'e_date' => $row['e_date']. " " .$row['e_time']
		);
	}
	//echo json_encode($response,JSON_UNESCAPED_UNICODE);
	echo json_encode($response,JSON_UNESCAPED_UNICODE);
?>