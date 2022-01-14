<?php include('connection.php'); 
if(isset($_SESSION['username'])){
 unset($_SESSION['username']);

if(isset($_POST['logout'])){
    session_destroy();
    header('location:index.php');
}
}
?>
