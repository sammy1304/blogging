<?php
	session_start();


	# title
	$title = "Blog: View Post";


	# include db connection
	include 'includes/connection.php';
	
	# import functions lib..
	include 'includes/functions.php';


	# include dashboard header
	include 'includes/dashboard_header.php';


	# determine if user is logged in.
	checkLogin();


?>

<div class="wrapper">
	<div id="stream">
		<table id="tab">
				<thead>
					<tr>
						<th>Post id</th>
						<th>post</th>
						<th>Edit</th>
						<th>Delete</th>
						<th>Archive</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$post = viewpost($conn);
					echo $post;
				?>
          		</tbody>
			</table>
	</div>
</div>


<?php
	
	include 'includes/footer.php';

?>