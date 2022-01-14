<?php include('connection.php'); ?>

<?php
   if(isset($_SESSION['username'])){
?>
   
      <!DOCTYPE html>
      <html>
      <head>
    <title>main page</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    </head>
     <body>

       <h1 style="text-align:center"> WELCOME TO XKCD CHALLENGE</h1>
       <h2 style="text-align:center; margin-top:105px">Congratulation <?php echo $_SESSION['username']; ?>! ,for succesfully completing the challenge</h2>

    <form action="logout.php" method="post">
        <input type="submit" name="logout" value="LOGOUT" class="logout_btn"/>
    </form>

     </body>
    </html>
    <?php
   }
   ?>