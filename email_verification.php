<?php include('connection.php'); 

if(isset($_GET['token'])){
    $token=$_GET['token'];

    $sql="select * from user_table where token='$token' ";
    $query=mysqli_query($conn,$sql);
    $count=mysqli_num_rows($query);

    if($count==1){
        $sql2="update user_table set status='active' where token='$token' ";
        $query2=mysqli_query($conn,$sql2);
        if($query2){
            $_SESSION['msgverification']="your account is verified";
            header('location:index.php');
        }
        else{
            $_SESSION['msgverification']="your account is not verified";
            header('location:index.php');
        }
    }
}

?>
