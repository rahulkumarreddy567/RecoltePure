<?php
session_start();
require_once '../config/db_connection.php';

$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';
$error = '';
$success = '';

// Validate token from session store
$valid = false;
if (!empty($email) && !empty($token) && isset($_SESSION['pwd_reset'][$email])) {
    $entry = $_SESSION['pwd_reset'][$email];
    // token valid for 30 minutes
    if ($entry['token'] === $token && (time() - $entry['created']) < 1800) {
        $valid = true;
    } else {
        $error = 'Reset link expired. Please generate a new one.';
    }
} else {
    $error = 'Invalid reset link. Please generate a new one.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid) {
    $new = $_POST['new_password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';
    if ($new === '' || $confirm === '') {
        $error = 'Please enter and confirm your new password.';
    } elseif ($new !== $confirm) {
        $error = 'Passwords do not match.';
    } else {
        $hash = password_hash($new, PASSWORD_BCRYPT);
        // Try update in users, then farmer
        $updated = false;
        $stmt = $db->prepare('UPDATE users SET password = ? WHERE email = ?');
        $stmt->bind_param('ss', $hash, $email);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            $updated = true;
        } else {
            $stmt = $db->prepare('UPDATE farmer SET password_hash = ? WHERE email = ?');
            $stmt->bind_param('ss', $hash, $email);
            $stmt->execute();
            if ($stmt->affected_rows > 0) {
                $updated = true;
            }
        }

        if ($updated) {
            $success = 'Password updated successfully. Redirecting to login...';
            // Invalidate token
            unset($_SESSION['pwd_reset'][$email]);
            echo '<script>setTimeout(function(){ window.location.href = "login.php"; }, 1500);</script>';
        } else {
            $error = 'Unable to update password. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password | RecoltePure</title>
  <style>
    body { font-family: Inter, Arial, sans-serif; background:#f5f6f8; }
    .wrapper { max-width: 420px; margin: 60px auto; background:#fff; padding:24px; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.08); }
    .btn { width:100%; padding:10px 14px; border:none; border-radius:8px; background:#2d7a2d; color:#fff; cursor:pointer; }
    .input-box { display:flex; flex-direction:column; gap:8px; padding:10px 0; }
    .notice { margin-top:12px; padding:10px; background:#e7f3ff; border:1px solid #cbe1ff; color:#0b5ed7; border-radius:8px; }
    .error { margin-top:12px; padding:10px; background:#fde2e4; border:1px solid #fac5ca; color:#b02a37; border-radius:8px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <h1>Reset Password</h1>
    <?php if (!empty($error)) : ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <?php if ($valid) : ?>
      <form method="POST" action="reset_password.php?email=<?php echo urlencode($email); ?>&token=<?php echo urlencode($token); ?>">
        <div class="input-box">
          <label>New Password</label>
          <input type="password" name="new_password" required>
        </div>
        <div class="input-box">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Update Password</button>
      </form>
    <?php endif; ?>
    <?php if (!empty($success)) : ?>
      <div class="notice"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
