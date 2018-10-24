<?php
	header("Content-type: application/json; charset=utf-8");
	include("config.php");

	$sql = "SELECT * FROM demand";

	$result = mysqli_query($con, $sql);
	$response = array();

	while($row = mysqli_fetch_array($result))
	{
		$response[] = array
		(
			'no' => $row['no'],
			'id' => $row['id'],
			'text' => $row['text'],
			'w_date' => $row['w_date'],
			's_date' => $row['s_date'],
			'e_date' => $row['e_date']
		);
	}
	//echo json_encode($response,JSON_UNESCAPED_UNICODE);
	echo json_encode($response);
?>