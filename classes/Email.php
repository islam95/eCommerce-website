<?php
// Not Working yet!!
require_once('PHPMailer/PHPMailerAutoload.php');

class Email {

	private $mail;

	public function __construct(){
		$this->mail = new PHPMailer(); //PHPMailer Object
		$this->mail->isSMTP();  // Set mailer to use SMTP
		// Enable SMTP authentication
		$this->mail->SMTPAuth = true; //Set this to true if SMTP host requires authentication to send email
		$this->mail->SMTPKeepAlive = true; // So that connection is not closed after sending an email
		$this->mail->Host = "smtp.gmail.com"; //Set SMTP host name
		$this->mail->Port = 465; //Set TCP port to connect to. it could be 25 too, many..
		$this->mail->SMTPSecure = "ssl";  //SMTP ssl encryption
		$this->isHTML(true);
		//Provide username and password     
		$this->mail->Username = "islamwolf23@gmail.com";
		$this->mail->Password = "yusufibnumar89"; 
		
		$this->mail->From = "islamwolf23@gmail.com";
		$this->mail->FromName = "Islam Dudaev";
		$this->mail->addReplyTo("islamwolf23@gmail.com", "Islam");

	}


	public function process($case = null, $array = null){

		if(!empty($case)){
			//using switch in case we will want any other emails in future
			switch ($case) {
				case 1:
				// add url to the array - activation link
				$link  = "<a href=\"".WEBSITE_URL."?page=activate&encode=";
				$link .= $array['encode']; 
				$link .= "\">".WEBSITE_URL."?page=activate&encode=";
				$link .= $array['encode']; 
				$link .= "</a>";
				$array['link'] = $link;

				$this->mail->Subject = "Activate you account - Khizir.com";
				// sending HTML message
				$this->mail->msgHTML($this->fetchEmail($case, $array));
				//Add a recipient
				$this->mail->addAddress($array['email'], $array['first_name'].' '.$array['last_name']); 
				break;
			}
			if($this->mail->send()){ // if it sent successfully
				$this->mail->clearAddresses(); //Clear all To recipients.
				return true;
			}
			return false; 
		}
	}


	public function fetchEmail($case = null, $array = null){
		if(!empty($case)){
			if(!empty($array)){
				foreach($array as $key => $value){
					${$key} = $value; //first_name 
				}
			}
			ob_start();// output buffering function. To output dynamic functions as normal strings.
			require_once(EMAILS_PATH.DIR_SEP.$case.".php"); // $case = 1 from process() method above
			$printout = ob_get_clean(); // to get the content from the buffer and close the buffer
			return $this->wrapEmail($printout); // Wrapping email content in div tag for the specific style.
		}
	}

	// Wrapping email content in div tag for the specific style.
	public function wrapEmail($content = null){
		if(!empty($content)){
			return "<div>{$content}</div>";
		}
	}




}



