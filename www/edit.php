<?php
	session_start();

	# import functions lib..
	include 'includes/functions.php';

	# determine if user is logged in.
	checkLogin();

	# title
	$title = "Blog: Edit Post";

	# include dashboard header
	include 'includes/dashboard_header.php';

	# include db connection
	include 'includes/connection.php';

	# expect incoming request to come with an
	if(isset($_GET['post_id'])) {
		$postID = $_GET['post_id'];
	}

	# use DAO to fetch the current object's
	# data..
	$item = getPostByID($conn, $postID);

	$errors = [];

	if(array_key_exists('edit', $_POST)) {
		if(empty($_POST['title'])) {
			$errors['title'] = "Please enter a title";
		}

		if(empty($errors)) {
			$clean = array_map('trim', $_POST);
			$clean['pid'] = $postID;

			# do update..
			updatePost($conn, $clean);

			# redirect..
			#Utils::redirect("view_category.php", "");
		}
	}
	
?>

<div class="wrapper">
	<div id="stream">
		
		<h1 id="register-label">Edit Post</h1>
		<hr>
		<form id="register"  action ="" method ="POST">
			<div>
				<?php displayError('cat_name', $errors); ?>
				<label>title:</label>
				<input type="text" name="title" placeholder="title" value="<?php echo $item[1]; ?>">
			</div>

			<input type="submit" name="edit" value="edit">
		</form>


	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>