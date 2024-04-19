<?php
$this->extend('layout/main');
$this->section('body');
?>

<?php if(session()->getFlashdata('success')): ?>
    <div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        // Add JavaScript to automatically hide the alert after 3 seconds
        setTimeout(function(){
            document.getElementById('alertMessage').style.display = 'none';
        }, 3000);
    </script>
<?php endif; ?>

<h1>Order List</h1><br>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer ID</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Phone</th>
            <th scope="col">Comments</th>
            <th scope="col">Total Amount</th>
            <th scope="col">Status</th>
            <th scope="col">Order Date</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (isset($orders) && is_array($orders) && !empty($orders)): ?>
            <?php foreach($orders as $order): ?>
                <tr>
                    <th scope="row"><?= $order['OrderID']?></th>
                    <td><?= $order['CustomerID']?></td>
                    <td><?= $order['Name']?></td>
                    <td><?= $order['Email']?></td>
                    <td><?= $order['Address']?></td>
                    <td><?= $order['PhoneNo']?></td>
                    <td><?= $order['Comments']?></td>
                    <td><?= $order['TotalAmount']?></td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="statusDropdown<?= $order['OrderID'] ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                <?= $order['Status'] ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="statusDropdown<?= $order['OrderID'] ?>">
                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $order['OrderID'] ?>, 'Pending')">Pending</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $order['OrderID'] ?>, 'Shipped')">Shipped</a></li>
                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?= $order['OrderID'] ?>, 'Delivered')">Delivered</a></li>
                            </ul>
                        </div>
                    </td>
                    <td><?= $order['OrderDate']?></td>
                    <td>
                        <!-- Button to generate QR code -->
                        <a href="/inventory/edit/<?= $order['OrderID']?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteLink(<?= $order['OrderID']?>)"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No orders found</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="deleteProductLink" class="btn btn-danger" href="#">Delete</a>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to set the delete link dynamically
    function setDeleteLink(productID) {
        document.getElementById('deleteProductLink').href = '/inventory/delete/' + productID;
    }

    // JavaScript function to update the status
    
   
    function updateStatus(orderID, status) {
        // Send AJAX request to update the status in the database
        fetch('/orders/updateStatus/' + orderID + '/' + status, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Add X-Requested-With header for CodeIgniter CSRF protection
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the status in the table cell
                document.getElementById('statusDropdown' + orderID).innerText = status;
                // Show success message
                alert('Order status updated successfully');
            } else {
                // Show error message
                alert('Failed to update order status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show error message
            alert('Failed to update order status');
        });
    }

</script>

<?php $this->endSection(); ?>
<script src="https://kit.fontawesome.com/80a719bb33.js" crossorigin="anonymous"></script>
