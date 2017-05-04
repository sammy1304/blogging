<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	checkLogin();

	# include db connection
	include 'includes/connection.php';

	# expect incoming request to come with an id..
	if(isset($_GET['post_id'])) {
		$postID = $_GET['post_id'];
	}

	# handle delete
	insertarchive($conn, $postID);

	# redirect 
	redirect('view_post.php', "");