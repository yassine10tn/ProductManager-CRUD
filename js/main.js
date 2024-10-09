// Function to handle CRUD operations and interact with the database
let submit = document.getElementById('submit');

submit.onclick = function () {
    let title = document.getElementById('title').value;
    let price = document.getElementById('price').value;
    let image = document.getElementById('image').value;
    let productDetail = document.getElementById('product_detail').value;
    let status = document.getElementById('status').value;

    // Insert new product into the database
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "insert.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Refresh the page to show the updated product list
            location.reload();
        }
    };
    xhr.send(JSON.stringify({
        title: title,
        price: price,
        image: image,
        product_detail: productDetail,
        status: status
    }));
};

// Function to delete a product from the database
function deleteData(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "delete.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Refresh the page to show the updated product list
            location.reload();
        }
    };
    xhr.send(JSON.stringify({ id: id }));
}

// Function to update a product in the database
function updateData(id) {
    let title = dataPro[id].title;
    let price = dataPro[id].price;
    let image = dataPro[id].image;
    let productDetail = dataPro[id].product_detail;
    let status = dataPro[id].status;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "update.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Refresh the page to show the updated product list
            location.reload();
        }
    };
    xhr.send(JSON.stringify({
        id: id,
        title: title,
        price: price,
        image: image,
        product_detail: productDetail,
        status: status
    }));
}
