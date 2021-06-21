<?php
    session_start();
    include './db.php';
    include './dispatchEmail.php';

    ini_set('display_errors', 1);

    if(isset($_SESSION['email'])){
        $conn=createConnection();

        $email=htmlspecialchars($_SESSION['email']);
        $activeStatus=0;
        $timeStamp=date('Y-m-d H:i:s');
        $activationCode=md5($timeStamp.$email);

        $query="insert into user_details(email,active,code,time) values(?,?,?,?);";
        $stmt=mysqli_prepare($conn,$query);

        mysqli_stmt_bind_param($stmt,'siss',$email,$activeStatus,$activationCode,$timeStamp);


        if(mysqli_stmt_execute($stmt)){
            $lastId=mysqli_insert_id($conn);

            $to=$email;
            $subject="Email Verification For XKCD App";
            $message="<h1>Please click the following link to verify you email account</h1><br><a target='_blank' href='http://localhost:8012/rtcamp-code-challenge/util/verifyUser.php?verificationCode=".$activationCode."&id=".$lastId."'>Activation Link</a>";

            try{
                if(sendMail($to,$subject,$message)){
                    session_unset();
                    session_destroy();
                    header('Location: '.'../emailSent.php');
                }else{
                    header('Location: '.'../error.html');
                }
            }catch(Exception $e){
                header('Location: '.'../error.html');
            }

        }else{
            header('Location: '.'../error.html');
        }

    }else{
        header('Location: '.'../error.html');
    }


?>