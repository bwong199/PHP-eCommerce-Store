<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){

	$name = trim($_POST["name"]);
	$email = trim($_POST["email"]);
	$message = trim($_POST["message"]);

	if($name == "" OR $email == "" OR $message == ""){
		$error_message =  "You must specify a value for name and email address, and message.";
	}


	if(!isset($error_message)){
		foreach($_POST as $value){
			if(stripos($value, 'Content-Type:') !== False){
				$error_message = "There was a problem with the information you entered.";
			}
		}
	}



	if(!isset($error_message) && $_POST['address'] = ''){
		$error_message = "your form submission has an error.";
	}

	require_once('inc/phpmailer/class.phpmailer.php');
	$mail = new PHPMailer();

	if(!isset($error_message) && !$mail->ValidateAddress($email)){
		$error_message = "You must specify a valid email address.";
	}

	if (!isset($error_message)){
		$email_body = "";
		$email_body = $email_body . "Name: " . $name . "<br>";
		$email_body = $email_body . "Email: " . $email . "<br>";
		$email_body = $email_body . "Message: " . $message;

		$mail->SetFrom($email, $name);
	    $address = "orders@shirts4mike.com";
	    $mail->AddAddress($address, "Shirts 4 Mike");
	    $mail->Subject    = "Shirts 4 Mike Contact Form Submission | " . $name;
	    $mail->MsgHTML($email_body);

	    if(!$mail->Send()) {
			header("Location: contact.php?status=thanks");
			exit;
	    } else {
	      $error_message =  "There was a problem sending the email: " . $mail->ErrorInfo;
	    }



	}

}



?>

<?php 
$pageTitle = "Contact Mike";
$section = "contact";
include('inc/header.php'); ?>

	<div class="section page">

		<div class="wrapper">

			<h1>Contact</h1>

			<?php if(isset($_GET['status']) AND $_GET['status'] == 'thanks'){ ?>

				<p>Thanks for the email! I&rsquo;ll be in touch shortly. </p>
			<?php } else {?>
			
			<p>I&rsquo;d love to hear from you! Complete the form to send me an email.</p>

			<?php 
				if (!isset($error_message)){

				} else {
					echo '<p class="message">'.$error_message.'</p>';	
				}
			?>

			<form method="post" action="contact.php">

				<table>
					<tr>
						<th>
							<td>			
								<label for="name">Name </label>
								<input type="text" name="name" id="name" value="<?php if (isset($name)){echo htmlspecialchars($name) ;}  ?>">
							</td>
						</td>
					</tr>
					<tr>
						<th>
							<td>			
								<label for="email">email </label>
								<input type="text" name="email" id="email" value="<?php if (isset($email)){echo htmlspecialchars($email);}  ?>">
							</td>
						</td>
					</tr>
					<tr>
						<th>
							<td>			
								<label for="message">Message </label>
								<textarea name="message" id="message"><?php if (isset($message)){echo htmlspecialchars($message) ;} ?></textarea>
							</td>
						</td>
					</tr>
					<tr style="display: none;">
						<th>
							<td>			
								<label for="address">Address </label>
								<input type="text" name="address" id="address">
								<p>Humans (and frogs): please leave this field blank; </p>
							</td>
						</td>
					</tr>
				</table>
				<input type="submit" value="send">
			</form>

			<?php } ?>
		</div>
	</div>

<?php include('inc/footer.php'); ?>
