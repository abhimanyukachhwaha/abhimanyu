<?php



   if($_POST)
{
//require('constant.php');
    

    
   



require_once '../mailer/class.phpmailer.php'; 

if(isset($_POST) && !empty($_POST)){
	//echo "<pre>"; print_r($_POST);
    $name         = $_POST['name'];
    $email         = $_POST['email'];
    $subject        = $_POST['subject'];
	$message     = $_POST['message'];
    
    $html = "
                
				    <P>Name: ".$name." </p>
                    <p>Email: ".$email."</p>
                    <th>Subject: ".$subject."</p>
                    <p>Message: ".$message."</p>
                
				    
                
            
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
$mail->Username   ="abhiartsstudios@gmail.com";  
 //$mail->Password   ="your_gmail_password";
 
    
        $mail->setFrom( $email,'Abhi Studios');		 
        $mail->AddReplyTo("abhiartsstudios@gmail.com","abhiartstudios@gmail.com");
	    $mail->AddCC("vijaybissa@rathi.com"); 
        // $mail->addAddress('receiver2@gfg.com', 'Name'); 
        
        $mail->isHTML(true);								 
        $mail->Subject = "Query from abhistudios by $name"; 
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