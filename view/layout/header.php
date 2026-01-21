<?php
if (session_status() === PHP_SESSION_NONE) session_start();

if (!isset($userData)) {
    $isLoggedIn = isset($_SESSION['user_id']);
    $initial = 'U';

    if ($isLoggedIn) {
        $displayName = $_SESSION['user_name'] ?? $_SESSION['login_user'] ?? '';
        
        if (!empty($displayName)) {
            $initial = strtoupper(substr($displayName, 0, 1));
        }
    }

    $userData = [
        'is_logged_in' => $isLoggedIn,
        'initial'      => $initial
    ];
}

$page = $_GET['page'] ?? 'home';
$cssFile = 'homepage.css'; // Default

switch ($page) {
    case 'contact':
        $cssFile = 'Contact.css';
        break;
    case 'terms':
        $cssFile = 'terms.css';
        break;
    case 'cart':
        $cssFile = 'cart.css';
        break;
    case 'categories':
        $cssFile = 'categories.css';
        break;
    case 'login':
        $cssFile = 'login.css';
        break;
    case 'register':
        $cssFile = 'registration.css';
        break;
    // Add other cases as needed
}
?>
<?php
// Only include cart model if file exists and we need it
if (file_exists(__DIR__ . '/../../model/Cart.php')) {
    require_once __DIR__ . '/../../model/Cart.php';
    $cartCount = Cart::getTotalQuantity();
} else {
    $cartCount = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>RecoltePure</title>
  
  <link rel="icon" type="image/png" sizes="512x512" href="assets/images/favicon.png">
  
  <!-- Always load homepage.css for navbar styles, but be careful of conflicts -->
  <link rel="stylesheet" href="assets/css/homepage.css" />
  
  <?php if ($cssFile !== 'homepage.css'): ?>
      <link rel="stylesheet" href="assets/css/<?= htmlspecialchars($cssFile) ?>?v=<?= time() ?>" />
  <?php endif; ?>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
    .icon-wrapper {
        position: relative;
        display: inline-flex; 
        align-items: center;
        justify-content: center;
    }

  
    .icon-wrapper i {
        font-size: 1.6rem; 
        color: #333;
    }

    
    .cart-badge {
        position: absolute;
        top: -5px; 
        right: -8px;  
        
        background-color: #ff4757; 
        color: white;
        
        font-size: 12px;
        font-weight: 700;
        font-family: sans-serif;
        
        /* Ensure it's a circle */
        width: 18px;
        height: 18px;
        border-radius: 50%;
        
        /* Center text */
        display: flex;
        align-items: center;
        justify-content: center;
        
        
        /* Ensure it sits on top */
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
</style>
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
        <li><a href="index.php?page=home" class="<?= $page === 'home' ? 'active' : '' ?>">Home</a></li>
        <li><a href="index.php?page=categories" class="<?= $page === 'categories' ? 'active' : '' ?>">Product</a></li>
        <li><a href="index.php?page=farmers" class="<?= $page === 'farmers' ? 'active' : '' ?>">Our Producers</a></li>
        <li><a href="index.php?page=contact" class="<?= $page === 'contact' ? 'active' : '' ?>">Contact Us</a></li>
        <li><a href="index.php?page=terms" class="<?= $page === 'terms' ? 'active' : '' ?>">Terms & Conditions</a></li>
      </ul>
      
      <div class="nav-actions">

      <div class="menu-icon" id="menu-toggle">
     <i class='bx bx-menu'></i> </div>
        <form method="GET" action="index.php" class="search-box">
          <input type="hidden" name="page" value="categories">
        
          <input type="text" name="search" class="search-input" placeholder="Search..." 
                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        
          <button type="submit" class="search-btn">
              <i class='bx bx-search'></i>
          </button>
        </form>

        <a href="index.php?page=cart" class="cart-link" style="text-decoration: none;">
            <div class="icon-wrapper">
                <i class='bx bxs-cart' style="color: black"></i>
                
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </div>
        </a>
        <?php if (!$userData['is_logged_in']): ?>
           <a href="index.php?page=login" class="sign-in">Sign Up</a>
        <?php else: ?>
            <button class="user-btn"><?php echo $userData['initial']; ?></button>
            <div class="dropdown-menu">
                <a href="index.php?page=profile">My Profile</a>
                <a href="index.php?page=my_orders">My Orders</a>
                <a href="index.php?page=logout">Logout</a>
            </div>
        <?php endif; ?>
      </div>
</nav>
  </header>
  <script src="assets/js/main.js" defer></script>

