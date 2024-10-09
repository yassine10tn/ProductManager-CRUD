<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productspanel";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = "";
    $name = "";
    $status = "";
    $description = "";
    $user = "";

    $errorMessage = "";
    $successMessage = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST["id"];
        $name = $_POST["name"];
        $status = $_POST["status"];
        $description = $_POST["description"];
        $user = $_POST["user"];

        if (empty($id) || empty($name) || empty($status) || empty($description) || empty($user)) {
            $errorMessage = "All fields are required!";
        } else {
            // Prepare the insert query
            $stmt = $connection->prepare("INSERT INTO products (id, `nom produit`, etat, description, user) VALUES (:id, :name, :status, :description, :user)");
            // Bind the parameters
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':user', $user);

            // Execute the query
            if ($stmt->execute()) {
                $successMessage = "Product added successfully";
                // Redirect to the home page
                header("location: ../html/index.php");
                exit;
            } else {
                $errorMessage = "Failed to add the product.";
            }
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
    <title>My Shop - Add Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        .btn-outline-primary {
            color: #0d6efd;
            border-color: #0d6efd;
        }
        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header img {
            max-height: 50px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="header mb-4">
            <h2 class="mb-0">New Product</h2>
            <img src="../img/logo.jpeg" alt="Logo">
        </div>
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">Getting information</h2>
            </div>
            <div class="card-body">
                <?php 
                if (!empty($errorMessage)) {
                    echo "
                    <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                        <strong>$errorMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }

                if (!empty($successMessage)) {
                    echo "
                    <div class='alert alert-success alert-dismissible fade show' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                }
                ?>

                <form action="" method="post">
                    <div class="mb-3">
                        <label for="id" class="form-label">ID</label>
                        <input type="number" id="id" name="id" value="<?php echo htmlspecialchars($id); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" name="status" class="form-select" required>
                            <option value="en stock" <?php echo $status == 'en stock' ? 'selected' : ''; ?>>En stock</option>
                            <option value="hors stock" <?php echo $status == 'hors stock' ? 'selected' : ''; ?>>Hors stock</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required><?php echo htmlspecialchars($description); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="user" class="form-label">User</label>
                        <input type="text" id="user" name="user" value="<?php echo htmlspecialchars($user); ?>" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a class="btn btn-outline-primary me-2" role="button" href="../html/index.php">Cancel</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
