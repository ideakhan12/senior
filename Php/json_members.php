<?php
	header("Content-type: application/json; charset=utf-8");
	include("config.php");

	$id = $_POST['id'];
	$sql = "SELECT door_ip, door_port, schedule, delivery, weather FROM members WHERE id = '$id'";

	$result = mysqli_query($con, $sql);
	$response = array();

	while($row = mysqli_fetch_array($result))
	{
		$response[] = array
		(
			'door_ip' => $row['door_ip'],
			'door_port' => $row['door_port'],
			'schedule' => $row['schedule'],
			'delivery' => $row['delivery'],
			'weather' => $row['weather'],
		);
	}
	//echo json_encode($response,JSON_UNESCAPED_UNICODE);
	echo json_encode($response,JSON_UNESCAPED_UNICODE);
?>