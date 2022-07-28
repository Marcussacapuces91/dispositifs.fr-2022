<?php


class PicoForm2Mail extends AbstractPicoPlugin
{
	function onRequestUrl($url) {
		if (isset($_POST['send_email'])) {

/**
 * Placer un fichier secret.php à la racine du site contenant les valeurs de deux variables locales :
 * $secret
 * $site_key
 * Contenant les valeurs données par le site hcaptcha.com
 */
			include($_SERVER['DOCUMENT_ROOT']."/secret.php");
			
			

			$token = $_POST['h-captcha-response'];
			$remote = $_SERVER['REMOTE_ADDR'];
			$response = file_get_contents("https://hcaptcha.com/siteverify?sitekey=$site_key&secret=$secret&response=$token&remoteip=$remote");
			if (!json_decode($response)->success) {
				header("HTTP/1.1 404 Captcha error!");
				return;
			}

			$dump = json_encode($_SERVER, JSON_PRETTY_PRINT) . json_encode($_POST, JSON_PRETTY_PRINT) . $response;

			$email = $_POST['email'];
			$subject = $_POST['subject'];
			$message = $_POST['message'];                                                   

			$encode = "dkF5ces8owU41DNP/DqBXMG28K/E4+CDTCJTGvXrvsI=3D";
			$password = "c=A3C=E1=E8=93_=A9=7F=CE=00N]=8E=B6=BB";
			$to = openssl_decrypt(quoted_printable_decode($encode), 'aes128', quoted_printable_decode($password));
			$email_subject = 'Fiche contact de dispositifs.fr';
			$body = "Nom: $name\nEmail: $email\nSujet: $subject\n\nMessage ci-dessous:\n$message\n---\nSERVER & POST:\n$dump";
			$from = 'From: contact@dispositifs.fr';

			mail($to, $email_subject, $body, $from) or die("Erreur de transmission du message");
		}
	}
};

?>
