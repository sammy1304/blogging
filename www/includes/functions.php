<?php
		
	
		    function checkLogin() {
		        if(!isset($_SESSION['admin_id'])) {
		                
		             redirect("bloglogin.php", "");
		        }
		    
		     }



		function displayError($keys,$arr){
			if(isset($arr[$keys])) {
				echo '<span class="err">'.$arr[$keys]. '</span>';
			}
		}


		function doRegistration($dbconn, $input) {
		           $stmt = $dbconn->prepare("INSERT INTO admin(firstname, lastname, email, hash) 
				VALUES(:fn, :ln, :e, :h)");

	         	$data = [
		      	":fn" => $input['fname'],
			    ":ln" => $input['lname'],
		     	":e" => $input['email'],
			    ":h" => $input['password']
		        ];

		        $stmt->execute($data);
	    
	        }

	

		 function doLogin($dbconn, $input) {
			$result = [];

			$stmt = $dbconn->prepare("SELECT admin_id, hash FROM admin WHERE email=:e");
			$stmt->bindParam(":e", $input['email']);

			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);

			# if either the email or password is wrong, we return a false array
			if( ($stmt->rowCount() != 1) || !password_verify($input['password'], $row['hash']) ) {

			redirect("bloglogin.php? +msg=", "either username or password is incorrect");
				exit();
			} else {
				# return true plus extra information...
				$result[] = true;
				$result[] = $row['admin_id'];
			}

			return $result;
         }


             function redirect($loc, $msg) {
			header("Location: ".$loc.$msg);
		     }


	         function addPost($dbconn, $input, $aid) {
			      $stmt = $dbconn->prepare("INSERT INTO post(post_id,title, post, user_id,date) VALUES(NULL,:t, :p, :uid, NOW())");
			        	$data = [
		      	":t" => $input['title'],
			    ":uid" => $aid,
		     	":p" => $input['post']
			    
		        ];

		        $stmt->execute($data);
	    

			      
		      }

		      function viewPost($dbconn) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM post");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<tr><td>'.$row[0].'</td>'.
							'<td>'.$row[1].'</td>'.
							'<td>'.$row[3].'</td>'.
				'<td><a href="edit.php?post_id='.$row[0].'">edit</a></td>
				<td><a href="delete.php?post_id='.$row[0].'">delete</a></td>
				<td><a href="archive.php?post_id='.$row[0].'">archive</a></td></tr>';
			}

			return $result;
		}


			 function showPost($dbconn) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM admin");
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<a href="profile.php?aid='.$row[0].'">'.$row[1].'</a><br/>';
			}

			return $result;
		}
       
       	 function extraInfo($dbconn, $admin_id) {
			$result = "";

			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE admin_id=:aid");
			$stmt->bindParam(":aid", $admin_id);
			$stmt->execute();

			while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {
				$result .= '<p>'.$row['email'].'</p><h3>'.$row['lastname'].'</h3><br/>';
			}

			return $result;
		}



		 function curNav($page) {
			$curPage = basename($_SERVER['SCRIPT_FILENAME']);
			if($curPage == $page) {
				echo 'class="selected"';
		    }
		  }


		 function getPostByID($dbconn, $post_id) {
			$stmt = $dbconn->prepare("SELECT * FROM post WHERE post_id=:pid");
			$stmt->bindParam(":pid", $post_id);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);

			return $row;
		}

		 function getAdminByID($dbconn, $adminid) {
			$stmt = $dbconn->prepare("SELECT * FROM admin WHERE admin_id=:aid");
			$stmt->bindParam(":aid", $adminid);
			$stmt->execute();

			$row = $stmt->fetch(PDO::FETCH_BOTH);

			return $row;
		}

		 function updatePost($dbconn, $input) {
			$stmt = $dbconn->prepare("UPDATE post SET title=:name WHERE post_id=:postid");

			$data = [
				":name" => $input['title'],
				":postid" => $input['pid']
			];

			$stmt->execute($data);
		}	


		function deletePost($dbconn, $postid) {
			$stmt = $dbconn->prepare("DELETE FROM post WHERE post_id=:pid");
			$stmt->bindParam("pid", $postid);

			$stmt->execute();
		}

		  function insertarchive($dbconn,  $pid) {
			      $stmt = $dbconn->prepare("INSERT INTO archive(archive_id, post_id,date) VALUES(NULL, :pid, NOW())");
			        $stmt->bindParam(":pid", $pid);
		      	

		        $stmt->execute($data);
	    

		    }


		    function displayarchive($dbconn){
		             $result = "";

		              $stmt = $dbconn->prepare("SELECT DISTINCT DATE_FORMAT(date,'%M,%Y') AS d,post_id FROM archive");
				
			         $stmt->execute();
		        
		        while($row = $stmt->fetch(PDO::FETCH_BOTH)){

				       $post = getPostById($dbconn,$row['post_id']);
				       
				      $result .= '<li><a href="homepage.php?date='.$post['date'].'">'.$row['d'].'</a></li>';
                          
   		            }
		            
		        return $result;
	
	        }


	        	function displayPost($dbconn){
		$result = "";

		$stmt = $dbconn->prepare("SELECT title,user_id,post,DATE_FORMAT(date,'%M %e, %Y') AS d FROM post");
		$stmt->execute();
		while ($row = $stmt->fetch(PDO::FETCH_BOTH)){

			   $item = getAdminByID($dbconn,$row['user_id']);


/*			$result .= '<div class="blog-post">
            			<h2 class="blog-post-title">'.$row['title'].'</h2>
            			<p class="blog-post-meta">'.$row['d'].' by <a href="#">'.$item['firstname'].'</a></p>
            			<p clas="blog-post">'.$row['post'].'</p></div>';		*/


            $result .= 	'<h2 class="blog-post-title">'.$row['title'].'</h2>'.
            '<p class="blog-post-meta">'.$row['d'].'<a href="#">'.$item['firstname'].' '.$item['lastname'].'</a></p>'.
            '<p>'.$row['post'].'</p>';

			
		}

		return $result;
		
	}
	



?>


