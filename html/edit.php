<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "productspanel";

try {
    // Create a PDO connection
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = "";
    $name = "";
    $product_details = "";
    $status = "";
    $user = "";
    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // GET method: Display product data

        if (!isset($_GET["id"])) {
            header("Location: ../html/index.php");
            exit;
        }
        $id = $_GET["id"];

        $stmt = $connection->prepare("SELECT * FROM products WHERE id = :id");
        // Bind the parameter
        $stmt->bindParam(':id', $id);
        // Execute the query
        $stmt->execute();
        // Fetch the resulting row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            header("Location: ../html/index.php");
            exit;
        }

        // Populate the variables with the product data
        $id = $row["id"];
        $name = $row["nom produit"];
        $product_details = $row["description"];
        $status = $row["etat"];
        $user = $row["user"];
    } else {
        // POST method: Update product data
        $id = $_POST["id"];
        $name = $_POST["name"];
        $product_details = $_POST["product_details"];
        $status = $_POST["status"];
        $user = $_POST["user"];

        if (empty($id) || empty($name) || empty($product_details) || empty($status) || empty($user)) {
            $errorMessage = "All fields are required!";
        } else {
            // Prepare the UPDATE query
            $stmt = $connection->prepare("UPDATE products SET `nom produit`=:name, `description`=:product_details, `etat`=:status, `user`=:user WHERE id=:id");
            // Bind the parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':product_details', $product_details);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':user', $user);
            // Execute the query
            $stmt->execute();

            $successMessage = "Product updated successfully";
            header("Location: ../html/index.php");
            exit;
        }
    }
} catch (PDOException $e) {
    $errorMessage = "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .form-container {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
        }
        .form-header img {
            max-height: 50px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="form-container">
        <div class="form-header">
            <h2>Edit Product</h2>
            <img src="../img/logo.jpeg" alt="Logo">
        </div>

        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?php echo htmlspecialchars($errorMessage); ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?php echo htmlspecialchars($successMessage); ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

            <div class="mb-3">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="product_details" class="form-label">Product Details</label>
                <textarea id="product_details" name="product_details" rows="3" class="form-control" required><?php echo htmlspecialchars($product_details); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select id="status" name="status" class="form-select" required>
                    <option value="en stock" <?php echo $status === 'en stock' ? 'selected' : ''; ?>>In Stock</option>
                    <option value="hors stock" <?php echo $status === 'hors stock' ? 'selected' : ''; ?>>Out of Stock</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="user" class="form-label">User</label>
                <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($user); ?>" class="form-control" required>
            </div>

            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-secondary" href="../html/index.php">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
