<?php
session_start();
include_once 'db.php';
include_once 'header_frontend.php';
$con = new DB_con();

if(isset($_POST['sendmessage'])){
	require 'phpmailer/PHPMailerAutoload.php';
	$name = $_POST['name'];
	$email = $_POST['email'];
	$message = $_POST['message'];

	$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'henry@softwareseni.com';                 // SMTP username
$mail->Password = 'henry1234';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('henry@softwareseni.com', 'Henry N');
$mail->addAddress('henrylumbanraja26@gmail.com', 'Henry');     // Add a recipient
//$mail->addAddress('henry.lumra@gmail.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Email from Contact Us';
$mail->Body    = $_POST['message'];
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
	echo 'Message could not be sent.';
	echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
	echo 'Message has been sent';
	$con->insert_contact_us($name, $email, $message);
}
}
?>

<form action="" method="post">
	<table>
		<th valign="top"><label>Contact Us</label></th>
		<tr> 
			<td valign="top"><label>Your Name</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Your name" size="30" type="text" name="name" required></td>
		</tr>
		<tr> 
			<td valign="top"><label>Your Email</label></td>
			<td valign="top">:</td>
			<td><input placeholder="Your email" size="30" type="email" name="email" required></td>
		</tr>
		<tr> 
			<td valign="top"><label>Your Message</label></td>
			<td valign="top">:</td>
			<td><textarea name="message" rows="5" cols="50" placeholder="Your Message" required ></textarea><br><br></td>
		</tr>
		<tr>
			<td colspan="3" align="right"><button type="submit" name="sendmessage">Send</button></td>
		</tr>
	</table>
</form>

<?php
include_once 'footer.php';