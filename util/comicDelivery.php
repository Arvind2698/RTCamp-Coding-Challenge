<?php

require '../vendor/autoload.php';
require './db.php';

function comicIdSelection(){
    $ch=curl_init();
    $url="https://xkcd.com/info.0.json";

    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

    $resp=curl_exec($ch);
    if(!$e=curl_error($ch)){
        $data=json_decode($resp,true);
        curl_close($ch);

        $totalComics=$data['num'];
        $randomComic=rand(1,$totalComics);
        return $randomComic;
    }

    return -1;
}

function getComic($to,$id){
    $comicId=comicIdSelection();
    if($comicId>0){

        $ch=curl_init();
        $url="https://xkcd.com/".$comicId."/info.0.json";

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $resp=curl_exec($ch);

        if(!$e=curl_error($ch)){
            $data=json_decode($resp,true);
            curl_close($ch);

            $comicTitle=$data['safe_title'];
            $comicImage=$data['img'];

            // if(sendComic($comicTitle,$comicImage,$to)){
            //     echo "done";
            // }else{
            //     echo "email failed";
            // }
            sendComic($comicTitle,$comicImage,$to,$id);
        }

    }
}

function sendComic($title,$img,$to,$id){

    $body="
            <div style='display:flex;justify-content:center;align-items:center;margin:30px'>
                <img style='display:block' src='".$img."'>
            </div>
            <br><br>
            <a href='http://localhost:8012/rtcamp-code-challenge/util/unsubscribe.php?id=".$id."'>Click here to unsubscribe</a>
        ";


    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587,'tls'))
      ->setUsername("USERNAME")
      ->setPassword("PASSWORD");

    // Create the Mailer using your created Transport
    $mailer = new Swift_Mailer($transport);

    // Create a message
    $message = (new Swift_Message("A new Comic from XKCD"))
    ->setFrom(['rctarvind@gmail.com' => 'Your Comic Supplier'])
    ->setTo($to)
    ->setBody($body);

    $message->setContentType("text/html");

    $message->attach(Swift_Attachment::fromPath($img));
    // Send the message

    $result = $mailer->send($message);

    if($result){
    return true;
    }

    return false;

}

function iterateDatabase(){
    $conn=createConnection();

    $query="select id,email from user_details where active=1";

    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result)>0){

        while($row=mysqli_fetch_assoc($result)){
            $userEmail=$row['email'];
            $userId=$row['id'];

            getComic($userEmail,$userId);
        }

    }
}

iterateDatabase();

?>