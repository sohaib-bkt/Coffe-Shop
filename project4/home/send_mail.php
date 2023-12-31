<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require '../../phpmailer/PHPMailer-master/src/Exception.php';
require '../../phpmailer/PHPMailer-master/src/PHPMailer.php';
require '../../phpmailer/PHPMailer-master/src/SMTP.php';


if (isset($_POST["send"])) {
 
    $mail = new PHPMailer(true);
   
      //Server settings
      $mail = new PHPMailer(true);
      $mail->isSMTP();                                   
      $mail->Host       = 'smtp.gmail.com';    
      $mail->SMTPAuth   = true;           
      $mail->Username   = 'sohaibbouktiba2004@gmail.com';   
      $mail->Password   = 'agomedxvzbizffkt';   
      $mail->SMTPSecure = 'ssl';            
      $mail->Port       = 465;                                    
   
      
      $mail->setFrom( $_POST["email"], $_POST["name"]); 
      $mail->addAddress('sohaibbouktiba2004@gmail.com');     
      $mail->addReplyTo($_POST["email"], $_POST["name"]); 
   
      
      $mail->isHTML(true);               
      $mail->Subject = $_POST["name"]." a envoyer un message ";   
      $mail->Body    = $_POST["text"]; 
        
      
      $mail->send();
      echo
      " 
      <script> 
       alert('Message was sent successfully!');
       document.location.href = 'home.php';
      </script>
      ";
  }

?>



