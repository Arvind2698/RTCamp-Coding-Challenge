<?php
    include './db.php';

    if(isset($_GET['verificationCode'])){

        $conn=createConnection();

        $verificationCode=$_GET['verificationCode'];
        $userId=$_GET['id'];

        $query="select code from user_details where id=?";
        $stmt=mysqli_prepare($conn,$query);
        mysqli_stmt_bind_param($stmt,'i',$userId);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_assoc($result)) {
                $dbCode=$row['code'];
                break;
            }

            if($dbCode==$verificationCode){

                $updateQuery="update user_details set active=1 where id=".$userId;

                if (mysqli_query($conn, $updateQuery)) {

                    header('Location: '.'../success.php');

                } else {
                    header('Location: '.'../error.html');
                }
            }else {
                header('Location: '.'../error.html');
            }


        } else {
            header('Location: '.'../error.html');
        }

    }else{
        header('Location: '.'../error.html');
    }