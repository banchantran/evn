<?php
$query = 'SELECT * FROM `user` where lock = 0';
		$database->setQuery($query);
		$users = $database->loadResult();
		if($users)
		foreach ($users as $one){
				
				$ToEmail = $one['email'];
				$FromEmail = $email;
				$Subject = "Newways HTML Email";
				
				$Message = '<strong>'._CONTACT_US.'</strong><br />
					Name: '.$fullname.'<br>
					Address: '.$address.'<br>
					Email: <a href="mailto:'.$email.'">'.$email.'</a><br>
					<br /><hr /><strong>Content</strong>: <br>'.$content;
				
				$headers = "Content-type: text/html; charset=utf-8\r\n";
				$headers .= "From: ".$FromName." <".$FromEmail.">";
				
				mail($ToEmail, $Subject, $Message, $headers);
				
?>