<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Agila Inventory Management System</title>
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px;
    }
    
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #f2f2f2;
    }

    tbody tr:hover {
      background-color: #e6e6e6;
    }
    .modal {
      display: none; /* Hide modal by default */
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4); /* Black background with opacity */
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

  </style>
</head>
<body>
  <h1>Hardware Inventory Management System</h1>

    <form action="/inventory/add" method="POST" id="addItemForm">
      <h2>Add New Item</h2>
      <label for="itemName">Item Name:</label>
      <input type="text" id="itemName" name="itemName" required><br><br>

      <label for="description">Description:</label>
      <textarea id="description" name="description" required></textarea><br><br>

      <label for="price">Price:</label>
      <input type="number" id="price" name="price" min="0" step="0.01" required><br><br>

      <label for="quantity">Quantity:</label>
      <input type="number" id="quantity" name="quantity" min="1" required><br><br>
      
      <label for="category">Category:</label>
      <select id="CategoryID" name="category" required></select><br><br>

      <input type="submit" value="Add Item">
  </form>

  <div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h2>Edit Item</h2>
    <form id="editItemForm">
      <label for="editItemName">Item Name:</label>
      <input type="text" id="editItemName" name="editItemName" required><br><br>

      <label for="editDescription">Description:</label>
      <textarea id="editDescription" name="editDescription" required></textarea><br><br>

      <label for="editPrice">Price:</label>
      <input type="number" id="editPrice" name="editPrice" min="0" step="0.01" required><br><br>

      <label for="editQuantity">Quantity:</label>
      <input type="number" id="editQuantity" name="editQuantity" min="1" required><br><br>

      <input type="submit" value="Save">
    </form>
  </div>
</div>

  <h2>Inventory Items</h2>
    <table id="inventoryTable">
    <thead>
      <tr>
        <th>ID</th>
        <th>Category</th>
        <th>Item Name</th>
        <th>Description</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Action</th> 
      </tr>
    </thead>
      <tbody id="inventoryBody">
        <?php foreach ($inventoryItems as $item): ?>
          <tr>
            <td><?= $item['ProductID'] ?></td>
            <td id="categoryName<?= $item['ProductID'] ?>"></td>
            <td><?= $item['ProductName'] ?></td>
            <td><?= $item['Description'] ?></td>
            <td>P<?= number_format($item['Price'], 2) ?></td>
            <td><?= $item['Quantity'] ?></td>
            <td>
            <button onclick="editItem(<?= $item['ProductID'] ?>)">Edit</button>
            <button onclick="deleteItem(<?= $item['ProductID'] ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
  </table>
<script>  
  const modal = document.getElementById('editModal');

  function openModal(item) {
    console.log('Item:', item); // Log the value of item
    const editForm = document.getElementById('editItemForm');
    const itemNameInput = document.getElementById('editItemName');
    const descriptionInput = document.getElementById('editDescription');
    const priceInput = document.getElementById('editPrice');
    const quantityInput = document.getElementById('editQuantity');

    itemNameInput.value = item.ProductName; // Error occurs here
    descriptionInput.value = item.Description;
    priceInput.value = item.Price;
    quantityInput.value = item.Quantity;

    modal.style.display = 'block'; 
}

  function closeModal() {
    modal.style.display = 'none';
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      closeModal();
    }
  };
    function displayInventoryItems() {
      fetch('/inventory/fetchItems')
        .then(response => response.json())
        .then(data => {
          const inventoryBody = document.getElementById('inventoryBody');
          inventoryBody.innerHTML = '';

          data.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
              <td>${item.ProductID}</td>
              <td id="categoryName${item.ProductID}"></td>
              <td>${item.ProductName}</td>
              <td>${item.Description}</td>
              <td>${typeof item.Price === 'number' ? '$' + item.Price.toFixed(2) : item.Price}</td>
              <td>${item.Quantity}</td>
              <td id="actionCell${item.ProductID}"> <!-- Adding an ID to the action cell -->
                <button onclick="editItem(${item.ProductID})">Edit</button>
                <button onclick="deleteItem(${item.ProductID})">Delete</button>
              </td>
            `;
            inventoryBody.appendChild(row);

            fetch(`/inventory/fetchCategoryName/${item.CategoryID}`)
              .then(response => response.json())
              .then(categoryData => {
                const categoryNameCell = document.getElementById(`categoryName${item.ProductID}`);
                categoryNameCell.textContent = categoryData && categoryData.CategoryName ? categoryData.CategoryName : 'Unknown';
              })
              .catch(error => {
                console.error('Error fetching category name:', error);
              });
          });
        })
        .catch(error => {
          console.error('Error fetching inventory items:', error);
        });
    }

  function populateCategories() {
  fetch('/inventory/fetchCategories') 
    .then(response => response.json())
    .then(data => {
      const categorySelect = document.getElementById('CategoryID');

      data.forEach(category => {
        const option = document.createElement('option');
        option.value = category.CategoryID;
        option.textContent = category.CategoryName;
        categorySelect.appendChild(option);
      });
    })
    .catch(error => {
      console.error('Error fetching categories:', error);
    });
}

function insertItem() {
  const form = document.getElementById('addItemForm');
  form.addEventListener('submit', function (event) {
    event.preventDefault();

    const formData = new FormData(this);

    fetch('/inventory/add', {
      method: 'POST',
      body: formData,
    })
      .then(response => {
        if (response.ok) {
          console.log('Item added successfully');
          window.location.href = '/inventory'; // Redirect to /inventory
        } else {
          console.error('Failed to add item');
        }
      })
      .catch(error => {
        console.error('Error adding item:', error);
      });
  });
}
  function editItem(productId) {
    // Fetch the item data from the server using productId
    fetch(`/inventory/getItem/${productId}`)
        .then(response => response.json())
        .then(item => {
            // Log the received item
            console.log('Item:', item);

            if (item) {
                openModal(item);
            } else {
                console.error('Error: Item is undefined');
            }
        })
        .catch(error => {
            console.error('Error fetching item details:', error);
        });
}
function deleteItem(productID) {
  fetch(`/inventory/delete/${productID}`, {
    method: 'DELETE'
  })
    .then(response => {
      if (response.status === 204) {
        console.log('Item deleted successfully');
        return true;
      } else {
        console.error('Failed to delete item');
        return false;
      }
    })
    .then(deletionSuccessful => {
      if (deletionSuccessful) {
        displayInventoryItems(); // Update the table after successful deletion
      }
    })
    .catch(error => {
      console.error('Error deleting item:', error);
    });
}


  insertItem();
  window.onload = function() {
      populateCategories();
      displayInventoryItems();
    };
</script>
</body>
</html>
