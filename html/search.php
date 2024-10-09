<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "productspanel";

try {
  $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $search = isset($_GET['search']) ? $_GET['search'] : '';

  if ($search !== '') {
    $sql = "SELECT * FROM products WHERE `nom produit` LIKE :search";
  } else {
    $sql = "SELECT * FROM products";
  }

  $stmt = $connection->prepare($sql);

  if ($search !== '') {
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam);
  }

  $stmt->execute();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $status = $row['etat'];
    echo "
            <tr>
                <td>{$row['id']}</td>
                <td>{$row['nom produit']}</td>
                <td>
                    <select name='status' class='form-select' disabled>
                        <option value='en stock'" . ($status == 'en stock' ? ' selected' : '') . ">En stock</option>
                        <option value='hors stock'" . ($status == 'hors stock' ? ' selected' : '') . ">Hors stock</option>
                    </select>
                </td>
                <td>{$row['description']}</td>
                <td>{$row['user']}</td>
                <td>
                    <a class='btn btn-primary btn-sm' href='../html/edit.php?id={$row['id']}'>Edit</a>
                    <a class='btn btn-danger btn-sm' href='../html/Delete.php?id={$row['id']}'>Delete</a>
                </td>  
            </tr>";
  }
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
