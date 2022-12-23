<?php
   if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // access
        $secretKey = '6LdP-sAZAAAAADnaCsV6F52CN3XOyjQM3xOVIg1L';
        $captcha = $_POST['g-recaptcha-response'];

        if(!$captcha){
          echo '<p class="alert alert-warning">Please check the the captcha form.</p>';
          exit;
        }

        # FIX: Replace this email with recipient email
        $mail_to = "contact@jared.solutions";
        
        # Sender Data
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);
        $subject = "Jared.Solutions - NEW contact - " . $email ;
		
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($phone) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-warning">Please complete the form and try again.</p>';
            exit;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);

        if(intval($responseKeys["success"]) !== 1) {
          echo '<p class="alert alert-warning">Please check the the captcha form.</p>';
        } else {
            # Mail Content
            $content = "Name: $name\n";
            $content .= "Email: $email\n\n";
            $content .= "Phone: $phone\n";
            $content .= "Message:\n$message\n";

            # email headers.
            $headers = "From: $name <$email>";

            # Send the email.
            $success = mail($mail_to, $subject, $content, $headers);
            if ($success) {
                # Set a 200 (okay) response code.
                http_response_code(200);
                echo '<p class="alert alert-success">Thank You! Your message has been sent.</p>';
            } else {
                # Set a 500 (internal server error) response code.
                http_response_code(500);
                echo '<p class="alert alert-warning">Oops! Something went wrong, we couldnt send your message.</p>';
            }
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo '<p class="alert alert-warning">There was a problem with your submission, please try again.</p>';
    }












////////////////////////////////////////////////////////////////////////
 
 
 
?>
<style>
@charset "utf-8";
/* CSS Document */

* { margin: 0; padding: 0; }
html { height: 101%; }
body { background: #f2f2f2 url('https://i.imgur.com/nyNOhHy.png'); font-size: 16px; padding-bottom: 65px; }

h1 { line-height:1.4em; font-size: 24px; margin-bottom:8px; }
h2 { line-height:1.2em; font-size: 20px; }
p { line-height:1.2em; margin-bottom:24px; }

a { color:#42241b; font-size:16px; text-decoration:none; }
a:hover { color:#000; text-decoration:underline;  }

.wrapper {
	margin: 47px auto;
	max-width:580px;
}

#ads {
	position:absolute;
	float:right;
	right: 20px;
}

@media only screen and ( max-width: 1124px ){
#ads { display:none; }
}

#contact_form { 
	text-shadow:0 1px 0 #FFF;
	border-radius:4px;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	background:#F9F9F9;
	padding:25px;
	
}


#ff label { 
	cursor:pointer;
	margin:4px 0;
	color:#ed7700;
	display:block;
	font-weight:800;
	
}

input { 
	display:block;
	width:90%;
	border-radius:4px;
	-webkit-border-radius:4px;
	-moz-border-radius:4px;
	background-color:#f4f4f4;
	color:#000;
	border:1px solid #5f5f5f;
	padding:10px;
	margin-bottom:25px;
}

.sendButton {
	cursor:pointer;
	-moz-box-shadow:inset 0px 1px 0px 0px #fce2c1;
	-webkit-box-shadow:inset 0px 1px 0px 0px #fce2c1;
	box-shadow:inset 0px 1px 0px 0px #fce2c1;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ffc477), color-stop(1, #fb9e25) );
	background:-moz-linear-gradient( center top, #ffc477 5%, #fb9e25 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffc477', endColorstr='#fb9e25');
	background-color:#ffc477;
	-webkit-border-radius:16px;
	-moz-border-radius:16px;
	border-radius:16px;
	border:1px solid #eeb44f;
	color:#ffffff;
	font-family:Arial;
	font-size:14px;
	width:25%;
	font-weight:bold;
	text-shadow:1px 1px 0px #cc9f52;
}
.sendButton:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fb9e25), color-stop(1, #ffc477) );
	background:-moz-linear-gradient( center top, #fb9e25 5%, #ffc477 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fb9e25', endColorstr='#ffc477');
	background-color:#fb9e25;
}


</style>