<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productspanel";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['pass'];
    $sql = "SELECT * FROM admin WHERE email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && $admin['password'] === $password) {

      header("Location: ../html/index.php");
      exit();
    } else {
      $_SESSION['error_message'] = "Invalid email or password";
    }
  }
} catch (PDOException $e) {
  $_SESSION['error_message'] = "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/loginStyle.css" />
  <script src="https://kit.fontawesome.com/f91e82eda9.js" crossorigin="anonymous"></script>
  <title>Login - Admin</title>
  <style>
    .alert {
      padding: 15px;
      background-color: #f44336;
      color: white;
      margin-bottom: 15px;
      border-radius: 5px;
      display: none;
    }
  </style>
</head>

<body>
  <div class="container"></div>
  <div class="form-box">
    <h1>Login</h1>
    <!-- Alert message -->
    <div id="alertMessage" class="alert">
      <?php
      if (isset($_SESSION['error_message'])) {
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); // Clear the message after showing it
      }
      ?>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <div class="input-group">
        <div class="input-field">
          <i class="fa-solid fa-user"></i>
          <input type="email" placeholder="Enter admin email" name="email" maxlength="100" required />
        </div>

        <div class="input-field">
          <i class="fa-solid fa-lock"></i>
          <input type="password" placeholder="Enter password" name="pass" maxlength="20" required />
        </div>

      </div>
      <div class="btn-field">
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
  <script>
    // Display the alert message if it exists
    window.onload = function() {
      const alertMessage = document.getElementById('alertMessage');
      if (alertMessage.textContent.trim() !== '') {
        alertMessage.style.display = 'block';
      }
    };
  </script>
</body>

</html>