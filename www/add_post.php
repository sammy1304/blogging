<?php
	session_start();

	$aid = $_SESSION['admin_id'];
	//	$pid = $_SESSION['post_id'];

	# title
	$title = "Blog: Add Post";

	# include db connection
	include 'includes/connection.php';

	# import functions lib..
	include 'includes/functions.php';


	# determine if user is logged in.
	checkLogin();



	# include dashboard header
	include 'includes/dashboard_header.php';

	

	# track errors
	$errors = [];

	if(array_key_exists('add', $_POST)) {

		if(empty($_POST['title'])) {
			$errors['title'] = "Please enter a title";
		}

		if(empty($_POST['post'])) {
			$errors['post'] = "Please enter a post ";
		}

		if(empty($errors)) {
			$clean = array_map('trim', $_POST);
			
		addPost($conn, $clean, $aid);

		}

	}
?>
	 <div class="wrapper">
		<div id="stream">
		
			<h1 id="register-label">Add Post</h1>
			<hr>
		    
		    <form id="register"  action ="add_post.php" method ="POST">
				<div>
					<?php displayError('title', $errors); ?>
					<label>Title:</label>
					<input type="text" name="title" placeholder="title">
				</div>
			
				<div>
					<?php displayError('post', $errors); ?>
					<label>POST:</label>
					<textarea name="post" placeholder="INPUT POST" cols="50" rows="10"></textarea>
				</div>

				<input type="submit" name="add" value="add">
			</form>

    	</div>
	</div>


<?php
	
	include 'includes/footer.php';

?>