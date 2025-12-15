<?php

require_once 'config/db_connection.php';
require_once 'model/UserModel.php';

class RegisterController {
    private $model;

    public function __construct($dbConnection) {
        $this->model = new UserModel($dbConnection);
    }

    public function index() {
        $error = "";
        $success = "";
        include 'view/registration.php';
    }

    public function handleRequest() {
        $error = "";
        $success = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // 1. Gather Input
            $role = $_POST['role'] ?? 'user';
            $firstName = trim($_POST['firstName'] ?? '');
            $surname = trim($_POST['surname'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $certNumber = trim($_POST['certNumber'] ?? '');
            $password = $_POST['password'] ?? '';
            $terms = isset($_POST['terms']) ? 1 : 0;
            $fullName = $firstName . " " . $surname;

            // 2. Validate
            if (!$terms) {
                $error = "You must accept terms and privacy policy.";
            } elseif (empty($email) || empty($password) || empty($firstName) || empty($surname)) {
                $error = "All fields are required.";
            } else {
                // 3. Check if exists
                if ($this->model->emailExists($email, $role)) {
                    $error = "Email already registered as " . $role . ".";
                } else {
                    // 4. Create User/Farmer
                    $password_hash = password_hash($password, PASSWORD_BCRYPT);
                    $registered = false;

                    if ($role === 'farmer') {
                        $registered = $this->model->registerFarmer($fullName, $email, $phone, $address, $certNumber, $password_hash);
                    } else {
                        $registered = $this->model->registerUser($fullName, $email, $address, $password_hash);
                    }

                    if ($registered) {
                        // Set Session
                        $_SESSION['role'] = $role;
                        $_SESSION['login_user'] = $email;
                        $success = "registered";
                       
                    } else {
                        $error = "Database error. Please try again.";
                    }
                }
            }
        }
        
        include 'view/registration.php';
    }
}
?>