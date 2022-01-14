<?php include('connection.php'); ?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/style.css">
<title>SignUp Page</title>
</head>
<body>
  <body>
    <div class="login-page">
      <div class="form">
        <div class="login">
          <div class="login-header">
            <h3>SIGNUP</h3>
            <p>Please enter your credentials to signup.</p>
             <div class="session">
            <?php
               if(isset($_SESSION['msgemail'])){
                 echo $_SESSION['msgemail'];
                 unset($_SESSION['msgemail']);
               }
               if(isset($_SESSION['msgpassword'])){
                echo $_SESSION['msgpassword'];
                unset($_SESSION['msgpassword']);
              }
              if(isset($_SESSION['msgmailsending'])){
                echo $_SESSION['msgmailsending'];
                unset($_SESSION['msgmailsending']);
              }
            ?>
            </div>
          </div>
        </div>
        <form  action=" " method="post" class="login-form">
          <input type="text"  name="username" placeholder="username" required/>
           <input type="email" name="email" placeholder="email" required/>
          <input type="password" name="password" placeholder="password" required/>
          <input type="password" name="cpassword" placeholder="confirm password" required/>
          <button type="submit" name="submit" class="button_a">Sign up</button>
          <p class="message">Already registered? <a href="index.php">Login</a></p>
        </form>
      </div>
    </div>
</body>
</body>
</html>

<?php
     if(isset($_POST['submit'])){
       $username=mysqli_real_escape_string($conn,$_POST['username']);
       $email=mysqli_real_escape_string($conn,$_POST['email']);
       $password=md5(mysqli_real_escape_string($conn,$_POST['password']));
       $cpassword=md5(mysqli_real_escape_string($conn,$_POST['cpassword']));
       $token=bin2hex(random_bytes(15));

       $sql1="select * from user_table where email='$email' ";
       $emailquery=mysqli_query($conn,$sql1);
       $emailcount=mysqli_num_rows($emailquery);

       if($emailcount>0){
         $_SESSION['msgemail'] ="*Email already exist";
         header('location:signup.php');
       }
       else{
         if($password===$cpassword){
           $sql2="insert into user_table(username,email,password,cpassword,token,status,subscribe) 
           values('$username','$email','$password','$cpassword','$token','inactive','yes')";

           $iquery=mysqli_query($conn,$sql2);

           if($iquery){
             $subject="Email Verification";
             $body="Hi, $username.click here to activate your account
             http://localhost/xkcd_challenge/email_verification.php?token=$token";

             $headers="From: khanfurqankhan123@gmail.com";

             if(mail($email,$subject,$body,$headers)){
               $_SESSION['msgmailsending']="*Check your mail to verify your account  $email";
               header('location:index.php');
             }
             else{
               $_SESSION['msgmailsending']= "*Email sending failed";
               header('location:index.php');
             }
           }
           
          }
          else{
            $_SESSION['msgpassword']= "*password and confirm password is not same";
            header('location:signup.php');
          }
       }
     }
     

?>