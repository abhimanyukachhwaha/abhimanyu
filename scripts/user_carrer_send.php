<?php
  
 if($_POST)
{

require_once '../mailer/class.phpmailer.php'; 

$postData = $uploadedFile = $statusMsg = '';
$msgClass = 'errordiv';
if(isset($_POST['submit'])){
//echo "<pre>"; print_r($_FILES);die;	
    // Get the submitted form data
    $postData = $_POST;
    $page         = $_POST['origin'];
    $name         = $_POST['name'];
    $mob          = $_POST['mob'];
    $email        = $_POST['email'];
	$comments     = $_POST['comments'];
    
    // Check whether submitted data is not empty
    
        
        // Validate email
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $statusMsg = 'Please enter your valid email.';
        }else{
            $uploadStatus = 1;
           
            // Upload attachment file
            if(!empty($_FILES["attachment"]["name"])){
                
                // File path config
                $targetDir = "../uploads/";
                $fileName = basename($_FILES["attachment"]["name"]);
					
                $targetFilePath = $targetDir . $fileName;
				//echo $targetFilePath;die;
                $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
                
                // Allow certain file formats
                $allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg');
                if(in_array($fileType, $allowTypes)){
				//echo'9';die;
					
                    // Upload file to the server
                    if(move_uploaded_file($_FILES["attachment"]["tmp_name"], $targetFilePath)){
                        $uploadedFile = $targetFilePath;
                    }else{
                        $uploadStatus = 0;
                        $statusMsg = "Sorry, there was an error uploading your file.";
                    }
                }else{
					//echo'10';die;
                    $uploadStatus = 0;
                    $statusMsg = 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.';
                }
            }
            
            if($uploadStatus == 1){
                //echo'8';die;
				
				 //$mail->IsSMTP(); 
				 //$mail->isHTML(true);
				 //$mail->Host       = "listserv.rathi.com";      
				 //$mail->Port       = 25;             
				
				 //$mail->Username   ="info@rathi.com";  
		
				
				
                // Recipient
                $toEmail = 'info@aritpl.com';

                // Sender
                $from = $email;
                $fromName = 'Tech Anand Rathi';
                
                // Subject
                $emailSubject = 'Carrer Request Submitted by '.$name;
                
                // Message 
                $htmlContent = '<h2>Carrer Request Submitted</h2>
				    <p><b>Page Name:</b> '.$page.'</p>
                    <p><b>Name:</b> '.$name.'</p>
					<p><b>Mobile:</b> '.$mob.'</p>
                    <p><b>Email:</b> '.$email.'</p>
                    <p><b>Message:</b> '.$comments.'</p>';
				//echo "<pre>"; print_r($headers);die;
				// Header for sender info
                $headers = "From: $fromName"." <".$from.">";

                if(!empty($uploadedFile) && file_exists($uploadedFile)){
                    //echo'1'; die;
                    // Boundary 
                    $semi_rand = md5(time()); 
                    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
                    
                    // Headers for attachment 
                    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                    
                    // Multipart boundary 
                    $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                    "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n"; 
                    
                    // Preparing attachment
                    if(is_file($uploadedFile)){
						
                        $message .= "--{$mime_boundary}\n";
                        $fp =    @fopen($uploadedFile,"rb");
                        $data =  @fread($fp,filesize($uploadedFile));
                        @fclose($fp);
                        $data = chunk_split(base64_encode($data));
                        $message .= "Content-Type: application/octet-stream; name=\"".basename($uploadedFile)."\"\n" . 
                        "Content-Description: ".basename($uploadedFile)."\n" .
                        "Content-Disposition: attachment;\n" . " filename=\"".basename($uploadedFile)."\"; size=".filesize($uploadedFile).";\n" . 
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                    }
                    
                    $message .= "--{$mime_boundary}--";
                    $returnpath = "-f" . $email;
                    
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $message, $headers, $returnpath);
                    
                    // Delete attachment file from the server
                    @unlink($uploadedFile);
                }else{
					
				//echo'2'; die;	
                     // Set content-type header for sending HTML email
                    $headers .= "\r\n". "MIME-Version: 1.0";
                    $headers .= "\r\n". "Content-type:text/html;charset=UTF-8";
                    
                    // Send email
                    $mail = mail($toEmail, $emailSubject, $htmlContent, $headers); 
                }
                
                // If mail sent
                if($mail){
					//echo'3'; die;
                    $statusMsg = 'Your contact request has been submitted successfully !';
                    $msgClass = 'succdiv';
                    
                    $postData = '';
					header("Location: ../thank-you.php");
                }else{
					//echo'4'; die;
                    $statusMsg = 'Your contact request submission failed, please try again.';
                }
            }
        }
    
}




} 

?>
 
<!-- include your own success html here -->

 

 
