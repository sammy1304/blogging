<?php   
    #title
    $title = "Blog: Register";

    #include header
    include 'includes/header.php';

    #include connection
    include 'includes/connection.php';

    #include function
   include 'includes/functions.php';


         #keep track of form errors
          $errors = [];    
      
        #been sure user clicked the submit button   
      if (array_key_exists('register',$_POST)){

          if (empty($_POST['fname'])) { 
            $errors['fname'] = "please enter Firstname";
          }

          if(empty($_POST['lname'])) {
            $errors['lname'] = "please enter Lastname";
          }
        
          if(empty($_POST['email'])) {
            $errors['email'] = "please enter an email address";
          }

          if(empty($_POST['password'])) {
            $errors['password'] = "please enter a password";
          }

          if(empty($_POST['pword'])) {
              $errors['pword'] = "please enter password again";
           }    

          if($_POST['pword'] != $_POST['password']) {
               $errors['pword'] = "passwords do not match";
           }
    


           # check for duplicate emails...
            #$check = doesEmailExist($conn, $_POST['email']);
            #if($check) { 
            #$errors["email"] = "email already exist"; }



      

        # be sure there are no errors...
        if(empty($errors)) {

           # trim the post array
          $clean = array_map('trim', $_POST);

         $hash = password_hash($clean['password'], PASSWORD_BCRYPT);

          # re-initialize password;
          $clean['password'] = $hash;

          # insert into db
           doRegistration($conn, $clean);
      }
    }

           

    
?>


  <div class="wrapper">
      <h1 id="register-label">Admin Register</h1>
      <hr>
      <form id="register"  action ="" method ="POST">
       
        <div>
        
          <?php echo displayError("fname", $errors); ?>
      
          <label>first name:</label>
          <input type="text" name="fname" placeholder="first name">
        </div>
       
        <div>

          <?php echo displayError("lname", $errors); ?>
        
          <label>last name:</label> 
          <input type="text" name="lname" placeholder="last name">
        </div>

        <div>

          <?php echo displayError("email", $errors); ?>

          
          <label>email:</label>
          <input type="text" name="email" placeholder="email">
        </div>
       
        <div>

          <?php echo displayError("password", $errors); ?>

      
          <label>password:</label>
          <input type="password" name="password" placeholder="password">
        </div>
   
        <div>

          
          <?php echo displayError("pword", $errors); ?>
       
          <label>confirm password:</label>  
          <input type="password" name="pword" placeholder="password">
        </div>

        <input type="submit" name="register" value="register">
      </form>

      <h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
    </div>

    <?php

      include 'includes/footer.php';

    ?>