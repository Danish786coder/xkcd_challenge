<?php include('connection.php'); ?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<title>login Page</title>
</head>
<body>
  <body>
    <div class="login-page">
      <div class="form">
        <div class="login">
          <div class="login-header">
            <h3>LOGIN</h3>
            <p>Please enter your credentials to Login.</p>
            <p class="session">
            <?php
                if(isset($_SESSION['msgmailsending'])){
                echo $_SESSION['msgmailsending'];
                unset($_SESSION['msgmailsending']);
              }
              if(isset($_SESSION['msgverification'])){
                echo $_SESSION['msgverification'];
                unset($_SESSION['msgverification']);
              }
              if(isset($_SESSION['passwordmatch'])){
                echo $_SESSION['passwordmatch'];
                unset($_SESSION['passwordmatch']);
              }

              if(isset($_SESSION['emailmatch'])){
                echo $_SESSION['emailmatch'];
                unset($_SESSION['emailmatch']);
              }

              if(isset($_SESSION['msgunsubscribe'])){
                echo $_SESSION['msgunsubscribe'];
                unset($_SESSION['msgunsubscribe']);
              }

            ?>
            </p>
          </div>
        </div>
        <form  action=" " method="post" class="login-form">
          <input type="email" name="email" placeholder="email" required/>
          <input type="password" name="password" placeholder="password" required/>
          <button type="submit" name="submit" class="button_a">Login</button>
          <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
        </form>
      </div>
    </div>
</body>
</body>
</html>

<?php
    if(isset($_POST['submit'])){
      $email=mysqli_real_escape_string($conn,$_POST['email']);
      $password=md5(mysqli_real_escape_string($conn,$_POST['password']));

      $searchquery="select * from user_table where email='$email' and status='active' ";
      $query=mysqli_query($conn,$searchquery);
      $count=mysqli_num_rows($query);

      if($count==1){
        $user=mysqli_fetch_assoc($query);

        $dbpassword=$user['password'];

        $_SESSION['username']=$user['username'];

        if($dbpassword===$password){
          $_SESSION['login']="Login Successfully";
          header('location:main.php');
        }
        else{
          $_SESSION['passwordmatch']="*password not matching";
          header('location:index.php');
        }
      }
      else{
        $_SESSION['emailmatch']="*Email is not exist";
        header('location:index.php');
      }
    }

?>