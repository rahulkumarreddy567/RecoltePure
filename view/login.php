<?php
ob_start();
session_start();
include("../db_connection.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    // FARMER LOGIN
    $sql_farmer = "SELECT * FROM farmer WHERE email='$username' LIMIT 1";
    $result_farmer = mysqli_query($db, $sql_farmer);

    if ($result_farmer && mysqli_num_rows($result_farmer) == 1) {
        $farmer = mysqli_fetch_assoc($result_farmer);
        // Verify farmer password against password column
        if (isset($farmer['password']) && password_verify($password, $farmer['password'])) {
            $_SESSION['login_user'] = $farmer['email'];
            $_SESSION['role'] = "farmer";
            $_SESSION['user_name'] = $farmer['name'];
            header("Location: homepage.php");
            exit();
        }
    }

    // CUSTOMER LOGIN
    $sql_user = "SELECT * FROM users WHERE email='$username' LIMIT 1";
    $result_user = mysqli_query($db, $sql_user);

    if ($result_user && mysqli_num_rows($result_user) == 1) {
        $user = mysqli_fetch_assoc($result_user);
        if (isset($user['password']) && password_verify($password, $user['password'])) {
            $_SESSION['login_user'] = $user['email'];
            $_SESSION['role'] = "customer";
            $_SESSION['user_name'] = $user['name'];
            header("Location: homepage.php");
            exit();
        }
    }

    $error = "Invalid Username or Password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RecoltePure</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/login.css">
    <style>
        .error-msg {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 14px;
        }

        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s, opacity 0.3s;
        }

        .social-link:hover {
            transform: scale(1.2);
            opacity: 0.8;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="left-panel">
            <div class="panel-content-bottom">
                <div class="user-profile">
                    <div class="user-info"></div>
                </div>
            </div>
        </div>

        <div class="right-panel">
            <div class="header"></div>

            <div class="form-container">
                <div class="welcome-text">
                    <h2>Welcome <br>to RecoltePure</h2>
                </div>

                <form method="POST" action="">
                    
                    <?php if(!empty($error)) { ?>
                        <div class="error-msg"><?php echo htmlspecialchars($error); ?></div>
                    <?php } ?>

                    <div class="input-group">
                        <input type="email" name="username" placeholder="Email" class="input-field" required>
                    </div>
                    
                    <div class="input-group">
                        <input type="password" name="password" id="password" placeholder="Password" class="input-field" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>

                    <a href="#" class="forgot-link">Forgot password?</a>

                    <button type="submit" class="btn btn-primary">Login</button>

                    <p class="signup-text">
                        Don't have an account? <a href="registration.php">Sign up</a>
                    </p>
                </form>
            </div>

            <div class="social-footer">
                <a href="https://www.facebook.com/RecoltePure" target="_blank" class="social-link">
                    <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/124/124010.png" width="20" height="20" alt="Facebook">
                </a>
                <a href="https://www.twitter.com/RecoltePure" target="_blank" class="social-link">
                    <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/733/733579.png" width="20" height="20" alt="Twitter">
                </a>
                <a href="https://www.linkedin.com/company/RecoltePure" target="_blank" class="social-link">
                    <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/174/174857.png" width="20" height="20" alt="LinkedIn">
                </a>
                <a href="https://www.instagram.com/RecoltePure" target="_blank" class="social-link">
                    <img class="social-icon" src="https://cdn-icons-png.flaticon.com/512/2111/2111463.png" width="20" height="20" alt="Instagram">
                </a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>