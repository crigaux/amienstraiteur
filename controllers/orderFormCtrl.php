<?php
require_once(__DIR__ . '/../models/Dish.php');
require_once(__DIR__ . '/../models/Reservation.php');
require_once(__DIR__ . '/../models/Order.php');
require_once(__DIR__ . '/../helpers/SessionFlash.php');
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../config/regex.php');
require_once(__DIR__ . '/../config/Database.php');
require_once(__DIR__ . '/../helpers/testInputs.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lastname = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS));
	if (testInput($lastname, NAME_REGEX) != 'true') {
		$errors['name'] = testInput($lastname, NAME_REGEX);
	}

	$firstname = trim(filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_SPECIAL_CHARS));
	if (testInput($firstname, NAME_REGEX) != 'true') {
		$errors['firstname'] = testInput($firstname, NAME_REGEX);
	}

	$email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
	if (testInput($email, MAIL_REGEX) != 'true') {
		$errors['email'] = testInput($email, MAIL_REGEX);
	}

	$phoneNb = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT));
	if (testInput($phoneNb, PHONE_REGEX) != 'true') {
		$errors['phoneNb'] = testInput($phoneNb, PHONE_REGEX);
	}

	$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_NUMBER_INT);
	if(testInput($date, DATE_REGEX) != 'true') {
		$errors['date'] = testInput($date, DATE_REGEX);
	}

	$time = intval(filter_input(INPUT_POST, 'time', FILTER_SANITIZE_NUMBER_INT));
	if (testInput($time, TIME_REGEX) != 'true') {
		$errors['time'] = testInput($time, TIME_REGEX);
	}

	$dishId = filter_input(INPUT_POST, 'dishList', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
	$quantity = filter_input(INPUT_POST, 'quantity', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

	foreach ($slots as $key => $slot) {
		if ($time == $key) {
			$datetime = $date . ' ' . $slot;
		}
	}

	if (empty($errors)) {
		
		$pdo = Database::getInstance();
		$pdo->beginTransaction();
		$reservation = new Reservation($datetime, $firstname, $email, $lastname, $phoneNb);
		
		$reservation->create();
		$lastId = $pdo->lastInsertId();
		
		for ($i=0; $i < count($dishId); $i++) { 
			$order = new Order($quantity[$i], $dishId[$i], $lastId);
			$order->create();
		}
		$pdo->commit();
		$reservation->create();
		SessionFlash::set('added', 'Votre réservation a bien été prise en compte.');
		header('Location: /');
		exit;
	}
}
include(__DIR__ . '/../views/templates/nav.php');
include(__DIR__ . '/../views/orderForm.php');
