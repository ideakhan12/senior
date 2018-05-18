<?php
include('config.php');

session_start();

$id = $_POST['id'];
$pwd = $_POST['pwd'];

$sql = "SELECT * FROM members WHERE id='$id'";
$result = $con->query($sql);

if($result->num_rows==1)
{
	$row=$result->fetch_array(MYSQLI_ASSOC);
	if($row['password'] == $pwd)
	{
		$_SESSION['id'] = $id;
		if(isset($_SESSION['id']))
		{
			header('Location: ./index.php');
		}
		else
		{
			echo "세션 저장 실패";
		}
	}
	else
	{
		echo "wrong id or pw";
	}
}
else
{
	echo "wrong id or pwd";
}
?>
