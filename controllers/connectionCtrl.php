<?php
    require_once(__DIR__ . '/../models/Admin.php');
    require_once(__DIR__ . '/../config/regex.php');
    require_once(__DIR__ . '/../helpers/testInputs.php');
    require_once(__DIR__ . '/../helpers/SessionFlash.php');
    
    if(isset($_SESSION['user'])) {
        header('Location: /');
        exit();
    }
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        if(testInput($email, MAIL_REGEX) != 'true') {
            $errors['email'] = testInput($email, MAIL_REGEX);
        }

        $password = $_POST['password'];

        if(Admin::checkAdmin($email) == true) {
                if(Admin::passwordVerification($email) != false){
                    $hash = Admin::passwordVerification($email);
        
                    if(password_verify($password, $hash) == true) {
                        $user = Admin::get($email);
                        $user->password = NULL;
                        $_SESSION['user'] = $user;
                        header('Location: /');
                        exit();
                    } else {
                        $errors['password'] = 'Mot de passe incorrect';
                    }
                } else {
                    $errors['email'] = 'Email ou mot de passe incorrect';
                }
            }
        } else {
            $errors['email'] = 'Cet email n\'existe pas';
        }

    include(__DIR__ . '/../views/templates/nav.php');
    include(__DIR__ . '/../views/connection.php');