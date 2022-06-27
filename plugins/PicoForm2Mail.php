<?php

class PicoForm2Mail extends AbstractPicoPlugin
{
	function onRequestUrl($url) {
		if (isset($_POST['send_email'])) {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];                                                   

			$encode = "dkF5ces8owU41DNP/DqBXMG28K/E4+CDTCJTGvXrvsI=3D";
			$password = "c=A3C=E1=E8=93_=A9=7F=CE=00N]=8E=B6=BB";
			$to = openssl_decrypt(quoted_printable_decode($encode), 'aes128', quoted_printable_decode($password));
			$email_subject = 'Fiche contact de dispositifs.fr';
			$body = "Nom: $name\nEmail: $email\nSujet: $subject\n\nMessage ci-dessous:\n$message";
			$from = 'From: contact@dispositifs.fr';

			mail($to, $email_subject, $body, $from) or die("Erreur de transmission du message");
		}
	}
};

?>
