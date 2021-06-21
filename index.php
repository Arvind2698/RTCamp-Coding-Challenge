<?php
    session_start();
    require './util/db.php';

    $inputFieldText=" ";
    $buttonStatus="";

    if(isset($_POST['email'])){

        $enteredEmail=htmlspecialchars($_POST['email']);

        $conn=createConnection();
        $query="select id from user_details where email='".$enteredEmail."'";

        $result=mysqli_query($conn,$query);

        if(mysqli_num_rows($result)>0){
            $inputFieldText=$enteredEmail;
            $buttonStatus="style='display:inline-block'";
        }else{
            $_SESSION['email']=$enteredEmail;
            header('Location: '.'./util/insertUser.php');
        }

    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>rtCamp Programming Challenge</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<script>
    function verifyEmail(email){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
</script>
<body>
    <div class="main-section-overlay"></div>
    <div class="main-section">
        <div class="main-section-content">
            <h1>
                A webcomic of romance, sarcasm, math, and language.
            </h1>
            <h3>Get an interesting comic straight to you inbox every 5 minutes. Register now!!</h3>

            <div class="input-form"">
                <input name="email" id="email" value="<?php echo $inputFieldText; ?>"  type="email" required class="email-input" placeholder="Enter your email....">
                <a name="allow" id="allow" class="submit-button not-visible" onclick="onSubmitClick()" >Submit</a>
                <a name="deny" id="deny" class="invalid-button not-visible" <?php echo $buttonStatus;  ?> disabled>Invalid Email</a>
            </div>

        </div>
    </div>
</body>
<script>
    let emailInput=document.getElementById("email");
    emailInput.addEventListener('keyup',(e)=>{
        // console.log(e);
        if( (e.key!=" " && e.key.length==1) || e.key=="Backspace"){
            inputChange();
        }else if(e.key=="Enter"){

            let userEmail=document.getElementById("email").value;
            let submit=document.getElementById("allow");
            let invalid=document.getElementById("deny");

            if(verifyEmail(userEmail)){
                onSubmitClick();
            }else{
                invalid.style.display="inline-block";
                submit.style.display="none"
            }
        }
    });

    function inputChange(){

        let userEmail=document.getElementById("email").value;
        let submit=document.getElementById("allow");
        let invalid=document.getElementById("deny");

        if(verifyEmail(userEmail)){
            invalid.style.display="none";
            submit.style.display="inline-block"
        }else{
            invalid.style.display="inline-block";
            submit.style.display="none"
        }
    }

    function onSubmitClick(){

        var f = document.createElement('form');
         f.action=' ';
         f.method='POST';
         var i=document.createElement('input');
         i.type='hidden';
         i.name='email';
         i.value=emailInput.value;
         f.appendChild(i);

         document.body.appendChild(f);
         f.submit();

    }

</script>
</html>