<?php
	include 'includes/connection.php';
	include 'includes/functions.php';

	$admin_id = $_GET['aid'];
	$data = extraInfo($conn, $admin_id);
	echo $data;