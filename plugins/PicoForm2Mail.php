<?php

class PicoForm2Mail extends AbstractPicoPlugin
{
	function onRequestUrl($url) {

//		print_r($_SERVER);
//		print_r($_REQUEST);
//		print_r($_POST);
		if (isset($_POST['send_email'])) {
			$name = $_POST['name'];
			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];                                                   

			$to = 'contact' + '@' + 'dispositifs' + '.' + 'fr';
			$email_subject = 'Fiche contact de dispositifs.fr';
			$body = "Nom: $name\nEmail: $email\nSujet: $subject\n\nMessage ci-dessous:\n$message";
			$from = 'From: contact@dispositifs.fr';

			mail($to, $email_subject, $body, $from) or die("Erreur de transmission du message");
		}

//		phpinfo();
	}
};
	
// phpinfo();


?>
