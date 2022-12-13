<?php
	require_once(__DIR__ . '/../config/Database.php');

	class Admin {
		private int $id;
		private string $email;
		private string $password;
		private object $pdo;

		public function __construct() {
			$this->pdo = Database::getInstance();
		}

		public function setId($id) {
			$this->id = $id;
		}
		public function setEmail($email) {
			$this->email = $email;
		}
		public function setPassword($password) {
			$this->password = $password;
		}

		public function getId() {
			return $this->id;
		}
		public function getEmail() {
			return $this->email;
		}
		public function getPassword() {
			return $this->password;
		}

		// Methode pour vérifier si l'admin existe
		public static function checkAdmin($email) {
			$pdo = Database::getInstance();
			$sql = "SELECT * FROM admin WHERE email = :email";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $email);
			$stmt->execute();
			$admin = $stmt->fetch();
			return $admin;
		}

		// Methode pour comparer le mot de passe
		public static function passwordVerification($email) {
			$pdo = Database::getInstance();
			$sql = "SELECT password FROM admin WHERE email = :email";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $email);
			$stmt->execute();
			$admin = $stmt->fetch();
			return $admin->password;
		}

		// Methode pour récupérer l'admin
		public static function get($email) {
			$pdo = Database::getInstance();
			$sql = "SELECT * FROM admin WHERE email = :email";
			$stmt = $pdo->prepare($sql);
			$stmt->bindValue(':email', $email);
			$stmt->execute();
			$admin = $stmt->fetch();
			return $admin;
		}

	}