<?php
#status not finished
header("Content-type: text/html; charset=UTF-8");

include 'connect.php';

$result = pg_query($db, "SELECT * FROM userinfo u WHERE u.email = '$_POST[email]'");

$total = pg_num_rows($result);

if($total == 1)
{
	$row = pg_fetch_assoc($result);
    $obj -> errno = 0;
	$obj -> first_name = $row[first_name];
	$obj -> last_name = $row[last_name];
	$obj -> phone = $row[phone_number];
	$obj -> money = $row[balance];
	echo json_encode($obj);
}
else {
    $obj -> errno = 1;
    echo json_encode($obj);
}

?>