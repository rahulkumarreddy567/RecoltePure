<?php
require_once "config/db_connection.php";
require_once "model/FarmerProduct.php";

class ProductController {
    private $db;
    private $model;
    private $farmer_id;
    public $error = '';
    public $success = '';
    public $edit_mode = false;
    public $product = [];
    public $categories = [];

    public function __construct($db) {
        $this->db = $db;
        $this->model = new FarmerProduct($db);

      
        if (!isset($_SESSION['login_user'])) {
            die("You must be logged in.");
        }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'farmer') {
            die("You must be logged in as a farmer.");
        }

        // Get farmer ID
        $this->farmer_id = $this->model->getFarmerIdByEmail($_SESSION['login_user']);
        if (!$this->farmer_id) die("Farmer record not found.");

        // Load categories
        $this->categories = $this->model->getCategories();
    }

    // Load product if edit mode
    public function loadProduct() {
        if (isset($_GET['product_id'])) {
            $this->edit_mode = true;
            $product_id = (int)$_GET['product_id'];
            $this->product = $this->model->getProduct($product_id, $this->farmer_id);
            if (!$this->product) die("Product not found or permission denied.");
        }
    }

    // Handle form submission
   public function handleUpload() {
    if (isset($_POST['upload'])) {
        // 1. Sanitize Inputs
        $product_name = mysqli_real_escape_string($this->db, $_POST['product_name']);
        $description = mysqli_real_escape_string($this->db, $_POST['description']);
        $price = (float)$_POST['price'];
        $old_price = !empty($_POST['old_price']) ? (float)$_POST['old_price'] : NULL;
        $stock = (int)$_POST['stock_quantity'];
        $category_id = (int)$_POST['category_id'];

        // Default: Keep old image if editing, or empty if new
        $file_name = $this->edit_mode ? $this->product['image'] : '';

        // 2. Handle Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['name'] != '') {
            
            // FIX: Added missing semicolon and ensured path goes up one level
            $target_dir = __DIR__ . "/../assets/uploads/products/";
            
            // Create unique name
            $generated_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $generated_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate Image
            $check = getimagesize($_FILES["image"]["tmp_name"]);

            if ($check === false) {
                $this->error = "File is not an image.";
            } elseif ($_FILES["image"]["size"] > 5000000) {
                $this->error = "File too large.";
            } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $this->error = "Only JPG, PNG, GIF allowed.";
            } else {
                // Create directory if missing
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }

                // Attempt to move file
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Upload Success: Update the filename variable
                    $file_name = $generated_name;

                    // Delete old image if we are replacing it
                    if ($this->edit_mode && !empty($this->product['image'])) {
                        $old_image_path = $target_dir . $this->product['image'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                } else {
                    $this->error = "Image upload failed. Check folder permissions.";
                }
            }
        }

        // 3. Save to Database (Only if no errors)
        if (empty($this->error)) {
            $data = [
                'product_name' => $product_name,
                'description' => $description,
                'price' => $price,
                'old_price' => $old_price,
                'stock_quantity' => $stock,
                'category_id' => $category_id,
                'farmer_id' => $this->farmer_id,
                'image' => $file_name,
                'product_id' => $this->edit_mode ? (int)$_GET['product_id'] : null
            ];

            if ($this->edit_mode) {
                $result = $this->model->updateProduct($data);
                $this->success = $result ? "Product updated successfully!" : "Database error!";
            } else {
                $result = $this->model->insertProduct($data);
                $this->success = $result ? "Product uploaded successfully!" : "Database error!";
                if ($result) $_POST = []; // clear form
            }
        }
    }
}

    // Render view
    public function render($view) {include "../view/$view.php";
    }
}
