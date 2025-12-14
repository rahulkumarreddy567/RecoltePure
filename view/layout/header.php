<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RecoltePure</title>
  
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/favicon.png">
  <link rel="stylesheet" href="assets/css/homepage.css" />
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <nav class="navbar">
      <div class="logo">
        <a href="index.php?page=home" class="logo">
            <img src="assets/uploads/products/Logo.png" alt="RecoltePure Logo" sizes="16x16"/>
            RecoltePure
        </a>
      </div>
      <ul class="nav-links">
        <li><a href="index.php?page=home" class="active">Home</a></li>
        <li><a href="index.php?page=categories" class="active">Products</a></li>
        <li><a href="index.php?page=categories" class="active">Our Producers</a></li>
        <li><a href="view/contact.php" class="active">Contact Us</a></li>
        <li><a href="view/terms_and_conditions.php" class="active">Terms & Conditions</a></li>
      </ul>
      
      <div class="nav-actions">
        <form method="GET" action="index.php">
          <input type="hidden" name="page" value="categories">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">
                <i class='bx bx-search'></i>
            </button>
        </form>

        <a href="index.php?page=cart"><i class='bx bxs-cart' style="color: black"></i></a>

          <?php if (!$userData['is_logged_in']): ?>
            <a href="view/registration.php" class="sign-in">Sign Up</a>
        <?php else: ?>
            <button class="user-btn"><?php echo $userData['initial']; ?></button>
            <div class="dropdown-menu">
              <a href="view/profile.php">My Profile</a>
              <a href="view/orders.php">My Orders</a>
              <a href="view/logout.php">Logout</a>
            </div>
        <?php endif; ?>
      </div>
    </nav>
  </header>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          const btn = document.querySelector('.user-btn');
          const menu = document.querySelector('.dropdown-menu');
          if (btn && menu) {
            btn.addEventListener('click', function(e) {
              e.stopPropagation();
              menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            });
            document.addEventListener('click', function(e) {
              if (!menu.contains(e.target) && e.target !== btn) {
                menu.style.display = 'none';
              }
            });
          }
        });
      </script>