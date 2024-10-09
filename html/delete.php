<?php
// Vérifier si l'ID est défini dans la requête GET
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $servername = "localhost"; 
    $username = "root"; 
    $password = ""; 
    $dbname = "productspanel";

    try {
      
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connection->prepare("DELETE FROM products WHERE id = :id");
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../html/index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erreur: " . $e->getMessage();
    }
} else {
    header("Location: ../html/index.php");
    exit;
}
?>
