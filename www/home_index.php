<?php
    include 'includes/connection.php';
   
    include 'includes/header_index.php';


     include 'includes/functions.php';


                   


     

?>

            <div class="container">

                <div class="row">

                   <div class="col-sm-8 blog-main">

                   		<div class="blog-post">

                     <?php $display = displayPost($conn); echo $display; ?>


                     	</div>

          <nav class="blog-pagination">
            <a class="btn btn-outline-primary" href="#">Older</a>
            <a class="btn btn-outline-secondary disabled" href="#">Newer</a>
          </nav>

        </div><!-- /.blog-main -->

        		 <div class="col-sm-3 offset-sm-1 blog-sidebar">

          		<div class="sidebar-module sidebar-module-inset">

            <h4>About</h4>
            <p>Another one! We the best.</p>

          		</div>

                   <div class="sidebar-module">
            				<h4>Archives</h4>
            					<ol class="list-unstyled">

                   <?php $display = displayarchive($conn); echo $display; ?>

                   		</ol>
                  </div>

                  </div><!-- /.blog-sidebar -->

      </div><!-- /.row -->

    </div><!-- /.container -->

    














































