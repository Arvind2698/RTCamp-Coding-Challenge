<?php
    require './db.php';

    if(isset($_GET['id'])){

        $userId=$_GET['id'];
        $conn=createConnection();

        $query="delete from user_details where id=".$userId;

        if(mysqli_query($conn,$query)){
            header('Location: '.'../unsubscribeConformation.php');
        }else{
            header('Location: '.'../error.html');
        }

    }else{
        header('Location: '.'../error.html');
    }

?>