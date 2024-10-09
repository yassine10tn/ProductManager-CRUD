<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productspanel";

try {

  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


  $id = $_POST['id'];
  $status = $_POST['status'];


  $stmt = $connection->prepare("UPDATE products SET etat = :status WHERE id = :id");
  $stmt->bindParam(':status', $status);
  $stmt->bindParam(':id', $id);


  $stmt->execute();

  header("Location: index.php");
  exit();
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
