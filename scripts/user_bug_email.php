
   
   <?php
     @set_time_limit(1200);
ini_set('memory_limit', '30M');
  // include phpmailer class
  require_once '../mailer/class.phpmailer.php';
  define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/PHPExcel_1.8.0/Classes/PHPExcel.php';
//require_once dirname(__FILE__) . '/PHPExcel_1.8.0/Classes/PHPExcel/IOFactory.php';
  // creates object
 $mail = new PHPMailer(true); 
  //include('db_connection.php');

	

 
   
 
     
 
     $usernumbmail = $_POST['usernumbmail']; 
     $url = $_POST['url']; // required
 
    $error_message = "";
  //  $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  
 
    $email_message = "Form details below.\n\n";
 
     
    function clean_string($string) {
      $bad = array("content-type","bcc:","to:","cc:","href");
      return str_replace($bad,"",$string);
    }
 
     
	$message_table = '<table border="1">';
$message_table .= '<tr>';
$message_table .= '<th>Email or Phone number:</th>';
$message_table .= '<th>URL of website:</th>';
//$message_table .= '<th>Email:</th>';
//$message_table .= '<th>Message:</th>';
//$message_table .= '</tr>';
	
			$message_table .= '<tr>';
$message_table .= '<td>'.$usernumbmail.'</td>';
$message_table .= '<td>'.$url.'</td>';		 
//$message_table .= '<td>'.$email.'</td>';		 
//$message_table .= '<td>'.$comments.'</td>';		 

$message_table .= '</tr>';
$message_table .= '</table>';





	
 //echo  $message_table;
	
	// echo $email_message;
	
	    $full_name  = 'info@rathi';
        $email1     = 'info@rathi.com';
        $subject    = "Query from ARITPL by $url";
 
       try
    {
     $mail->IsSMTP(); 
     $mail->isHTML(true);
	 
                 
     $mail->Host       = "listserv.rathi.com";      
     $mail->Port       = 25;             
     $mail->AddAddress($email1);
	 
	// print_r ($mail);
	// die();
     $mail->Username   ="info@rathi.com";  
                         // $mail->Password   ="your_gmail_password";            
                         $mail->SetFrom('info@aritpl.com','ARITPl Website');
                         $mail->AddReplyTo("info@aritpl.com","info@aritpl.com");
					     $mail->AddCC("info@aritpl.com");
					//$mail->AddCC("gautamagarwal@rathi.com");
						 //$mail->AddCC("mis@rathi.com");
						  //$mail->AddBCC("vijaybissa@rathi.com");
						 //$mail->AddBCC("akshaypatra@rathi.com");
     $mail->Subject    = $subject;
     $mail->Body    = $message_table;
     $mail->AltBody    = $message_table;
    // print_r ($mail);
	// print_r ($email_message);
  
  if($mail->Send())
     {
		 
     
      $msg = "<div class='alert alert-success'>
        Hi,<br /> ".$full_name." mail was successfully sent to ".$email." go and check, cheers :)
        </div>";
		//print_r ($msg);
     
     }
	}
    
    catch(phpmailerException $ex)
    {
     $msg = "<div class='alert alert-warning'>".$ex->errorMessage()."</div>";
   }
   
  
header("Location: ../test-popup.html");
?>
 
<!-- include your own success html here -->

 

 
