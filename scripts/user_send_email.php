<?php



   if($_POST)
{
//require('constant.php');
        $user_name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $user_email     = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $subject   = filter_var($_POST["subject"], FILTER_SANITIZE_STRING);

    
   



require_once '../mailer/class.phpmailer.php'; 

if(isset($_POST) && !empty($_POST)){
	//echo "<pre>"; print_r($_POST);
    $name         = $_POST['name'];
    $email        = $_POST['email'];
	$subject     = $_POST['subject'];
    
    $html = "
                
				    <P>Page Name: ".$page." </p>
                    <p>Name: ".$name."</p>
                    <th>Email: ".$email."</p>
                    <p>Message: ".$subject."</p>
                
				    
                
            
            ";
$mail = new PHPMailer(true); 
$mail->IsSMTP();
$mail->Mailer = "smtp";
    
    try { 
	
      //$mail->SMTPDebug = 2;									 
         //$mail->IsSMTP(); 
		 //$mail->isHTML(true);
		 //$mail->Host       = "listserv.rathi.com";      
		 //$mail->Port       = 25;             
		 //$mail->AddAddress($email1);
		 //$mail->Username   ="info@rathi.com";  
		//$mail->Password   ="your_gmail_password";
            	
	
$mail->isSMTP();
$mail->Host = 'listserv.rathi.com';
$mail->SMTPAuth = false;
$mail->SMTPAutoTLS = false; 
$mail->Port = 25; 
$mail->Username   ="info@rathi.com";  
 //$mail->Password   ="your_gmail_password";
 
    
        $mail->setFrom( $email,'ARITPl Website');		 
        $mail->AddReplyTo("vijaybissa@rathi.com","vijaybissa@rathi.com");
	    $mail->AddCC("vijaybissa@rathi.com"); 
        // $mail->addAddress('receiver2@gfg.com', 'Name'); 
        
        $mail->isHTML(true);								 
        $mail->Subject = "Query from Tech Anand Rathi by $name"; 
        $mail->Body = $html; 
        $mail->send();
        $output = array(
            'status' => 1,
        ); 
		//print_r('here');
    } catch (Exception $e) { 
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; //die;
        $output = array(
            'status' => 0,
        );
    } 
    
}else{
    $output = array(
        'status' => 0,
    );
}
echo json_encode($output);die; 




} 

?>