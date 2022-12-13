<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once(__DIR__ . '/../../vendor/autoload.php');

require_once(__DIR__ . '/../../models/Order.php');
require_once(__DIR__ . '/../../models/Reservation.php');
require_once(__DIR__ . '/../../config/regex.php');
require_once(__DIR__ . '/../../config/config.php');
require_once(__DIR__ . '/../../helpers/SessionFlash.php');

// ###############################################################################
// ###                    TEST SI L'UTILISATEUR EST UN ADMIN                   ###	
// ###############################################################################

if (!isset($_SESSION['user'])) {
	header('Location: /');
	exit;
}


// ###############################################################################
// ###                           AFFICHE LES COMMANDES                         ###	
// ###############################################################################

if ($_SERVER['REQUEST_URI'] == '/admin/commandes') {
	$reservations = Reservation::getAll('orders');

	include(__DIR__ . '/../../views/admin/templates/dbHeader.php');
	include(__DIR__ . '/../../views/admin/dbOrders.php');
	include(__DIR__ . '/../../views/admin/templates/dbFooter.php');

	// ###############################################################################
	// ###                           VALIDE UNE COMMANDES                          ###	
	// ###############################################################################

} else if ($_SERVER['REQUEST_URI'] == '/admin/commandes/validate') {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$validate = intval(filter_input(INPUT_POST, 'validate', FILTER_SANITIZE_NUMBER_INT));
		$reservation = Reservation::get($validate);
		$orders = Order::getAll($reservation->id);
		if (empty($validate)) {
			$errors['validate'] = 'Veuillez sélectionner une commande';
		}

		if (empty($errors) && $reservation->validated_at == NULL) {
			Reservation::validate($validate);
			
			$mail = new PHPMailer(true);

			try {
				//Server settings
				$mail->CharSet = 'UTF-8';
				$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username   = 'contact.annexe.restaurant@gmail.com';                     //SMTP username
				$mail->Password   = 'deafbihuvbvqygzf';                               //SMTP password
				$mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
				$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

				//Recipients
				$mail->setFrom('contact.annexe.restaurant@gmail.com', 'Amiens Traiteur');
				$mail->addAddress($reservation->email);     //Add a recipient
				// $mail->addAddress('ellen@example.com');               //Name is optional
				// $mail->addReplyTo('info@example.com', 'Information');
				// $mail->addCC('cc@example.com');
				// $mail->addBCC('bcc@example.com');

				//Attachments
				// $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
				// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

				//Content
				$mail->isHTML(true);                                  //Set email format to HTML
				$mail->Subject = 'Votre réservation a été validée';
				$mail->Body    = 
				'Bonjour,<br> votre réservation au nom de ' . $reservation->lastname . ', pour le ' . $formatDate->format(strtotime($reservation->datetime)) . ' a été validée. <br> Détail de la commande : <br> ';
				$total = 0;
				foreach ($orders as $key => $order) {
					$mail->Body    .= $order->quantity . ' ' . $order->title . ' au prix de ' . $order->price . '€ <br>';
					$total += $order->quantity * $order->price;
				};
				$mail->Body    .= '<br> 
				Prix total de la commande : ' . $total . '€ <br>
				Merci de votre confiance, à bientôt !';
				// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->send();
				echo 'Message has been sent';
				SessionFlash::set('message', 'Validation effectuée');
				header('Location: /admin/commandes');
				exit;
			} catch (Exception $e) {
				echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}
	}

	// ###############################################################################
	// ###                           SUPPRIME UNE COMMANDES                        ###	
	// ###############################################################################

} else if ($_SERVER['REQUEST_URI'] == '/admin/commande/delete/' . $id) {

	$id = intval($id);
	if (Reservation::delete($id) == true) {
		SessionFlash::set('message', 'Suppression effectuée');
		header('Location: /admin/commandes');
		exit;
	} else {
		SessionFlash::set('message', 'Erreur lors de la suppression');
		header('Location: /admin/commandes');
		exit;
	}
}
