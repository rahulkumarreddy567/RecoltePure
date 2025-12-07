<?php
session_start();
include "db_connection.php";

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';   


$cat_sql = "SELECT * FROM categories";
$categories = mysqli_query($db, $cat_sql);

if ($category_id == 0) {
    $prod_sql = "SELECT * FROM products";
} else {
    $prod_sql = "SELECT * FROM products WHERE category_id = $category_id";
}

if ($sort === 'low') {
    $prod_sql .= " ORDER BY price ASC";
} elseif ($sort === 'high') {
    $prod_sql .= " ORDER BY price DESC";
}
elseif ($sort === "newest") {
    $prod_sql .= " ORDER BY created_on DESC"; 
}
elseif ($sort === "oldest") {
    $prod_sql .= " ORDER BY created_on ASC"; 
}

$products = mysqli_query($db, $prod_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecoltPure | Shopping | vegetable</title>
    <link rel="stylesheet" href="categories.css"></link>
    <link href="https://fonts.googleapis.com/css2?fami  ly=Lato:wght@300;400;700&family=Dancing+Script:wght@600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
</head>
<body>
    <!-- Header / Hero Section -->
    <header class="page-header">
        <h1>Shop</h1>
        <div class="breadcrumb">
            Home <span>/</span> Shop
        </div>
    </header>

    <div class="container">

        <!-- Categories Section -->
        <section class="categories-section">
            <div class="subtitle">When health is organic</div>
            <h2 class="section-title">Shop Our Organic Products</h2>
            
            <div class="category-list">
                <?php while($cat = mysqli_fetch_assoc($categories)) : ?>
                    <a href="categories.php?category_id=<?php echo $cat['category_id']; ?>">
                        <div class="category-item">
                            <div class="cat-img-wrapper">
                                 <img src="assets/images/<?php echo $cat['image']; ?>" alt="<?php echo $cat['category_name']; ?>">
                            </div>
                             <h4><?php echo ucfirst($cat['category_name']); ?></h4>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

        </section>

        <!-- Sort / Filter Bar -->
        <div class="toolbar">
            <div class="showing-text">Showing 1-10 of 85 Items</div>
            <div class="actions">
                <span class="view-options">
                    <i class="fas fa-th-large"></i>
                    <i class="fas fa-list"></i>
                </span>
                <select class="sort-select" style="margin-left: 15px;" onchange="location='?category_id=<?php echo $category_id; ?>&sort=' + this.value;">
                    <option value="">Default Sorting</option>
                    <option value="low" <?php if($sort=='low') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="high" <?php if($sort=='high') echo 'selected'; ?>>Price: High to Low</option>
                    <option value="newest" <?php if($sort=='newest') echo 'selected'; ?>>Newest Arrivals</option>
                    <option value="oldest" <?php if($sort=='oldest') echo 'selected'; ?>>Oldest Arrivals</option>
                </select>

            </div>
        </div>

        

        <!-- Product Grid -->
        <div class="product-grid">
<?php while($prod = mysqli_fetch_assoc($products)) : ?>
    <div class="product-card">
        <span class="badge"><?php echo $prod['stock_quantity']; ?></span>
        <img src="assets/images/<?php echo $prod['image']; ?>" alt="<?php echo $prod['product_name']; ?>" class="product-img">
        <div class="product-cat">
            <?php 
            $cat_name = mysqli_fetch_assoc(mysqli_query($db, "SELECT category_name FROM categories WHERE category_id=".$prod['category_id']));
            echo ucfirst($cat_name['category_name']);
            ?>
        </div>
        <h3 class="product-title"><?php echo $prod['product_name']; ?></h3>
        <div class="product-footer">
            <div>
                <span class="price">$<?php echo $prod['price']; ?></span>
                <?php if (!empty($prod['old_price']) && $prod['old_price'] != $prod['price']) : ?>
                <span class="old-price" style="text-decoration: line-through;">
                $<?php echo $prod['old_price']; ?>
                </span>
                <?php endif; ?>
            </div>
            <div class="add-btn"><i class="fas fa-shopping-bag"></i></div>
        </div>
    </div>
<?php endwhile; ?>
</div>


        <!-- Pagination -->
        <div class="pagination">
            <span class="page-num active">1</span>
            <span class="page-num">2</span>
            <span class="page-num">3</span>
            <span class="page-num">25</span>
        </div>

    </div>

</body>
</html>