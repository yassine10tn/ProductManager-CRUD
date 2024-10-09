<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Shop</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <script>
    function clearSearch() {
      document.getElementById('searchInput').value = '';
      fetchProducts('');
    }

    function disconnect() {
      window.location.href = 'login.php';
    }

    function fetchProducts(query) {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `search.php?search=${encodeURIComponent(query)}`, true);
      xhr.onload = function() {
        if (xhr.status === 200) {
          document.getElementById('productTableBody').innerHTML = xhr.responseText;
        }
      };
      xhr.send();
    }

    function handleSearchInput(event) {
      const query = event.target.value;
      fetchProducts(query);
    }

    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('searchInput').addEventListener('input', handleSearchInput);
      fetchProducts('');
    });
  </script>
</head>

<body class="bg-light">
  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h1 class="center flex-grow-1">List of Products</h1>
      <img src="../img/logo.jpeg" alt="Logo" class="img-fluid" style="max-height: 80px;">
    </div>
    <div class="mb-3">
      <a href="../html/create.php" role="button" class="btn btn-primary">New Product</a>
      <button onclick="clearSearch();" class="btn btn-secondary ms-2">Refresh</button>
      <button onclick="disconnect();" class="btn btn-danger ms-2 m-2">Disconnect</button>
    </div>
    <form method="GET" action="index.php" class="mb-3">
      <div class="input-group">
        <input type="text" name="search" class="form-control p-2" placeholder="Search by product name" id="searchInput">
        <button class="btn btn-outline-secondary" type="submit" style="display: none;">Search</button>
      </div>
    </form>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Status</th>
          <th>Description</th>
          <th>User</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="productTableBody">
      </tbody>
    </table>
  </div>
</body>

</html>
