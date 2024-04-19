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

<h1>Product List</h1>

<!-- Search form -->
<form action="<?= base_url('/inventory') ?>" method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search products..." name="q">
        <button type="submit" class="btn btn-primary">Search</button>
        <hr>
        <button type="button" class="btn btn-secondary" onclick="resetSearch()">Reset</button>
    </div>
</form>

<a href="/inventory/create" class="btn btn-primary">Add Product</a>

<table class="table">
    <!-- Table header -->
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Category Name</th>
            <th scope="col">Product Name</th>
            <th scope="col">Description</th>
            <th scope="col">Price</th>
            <th scope="col">Quantity</th>
            <th scope="col">Image</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="productTableBody">
    <?php if (isset($products) && is_array($products)): ?>
        <?php foreach($products as $product): ?>
            <tr>
                <!-- Table data -->
                <th scope="row"><?= $product['ProductID']?></th>
                <td><?= $product['CategoryName']?></td>
                <td><?= $product['ProductName']?></td>
                <td><?= $product['Description']?></td>
                <td><?= $product['Price']?></td>
                <td><?= $product['Quantity']?></td>
                <td><img src="/uploads/<?= $product['ImageURL']; ?>" alt="" width="100" height="100"></td>
                <td><?= $product['created_at']?></td>

                <!-- Action buttons -->
                <td>
                    <a href="#" class="btn btn-success btn-generate-qr" onclick="openQrModal(<?= $product['ProductID']?>, event)">Generate QR<i class="fa-solid fa-qrcode"></i></a><br><hr>
                    <a href="/inventory/edit/<?= $product['ProductID']?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteLink(<?= $product['ProductID']?>)"><i class="fa-solid fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <p>No products found</p>
    <?php endif; ?>
    </tbody>
</table>

<!-- Modal for QR code -->
<div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
    <!-- Modal content -->
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="qrCodeContainer"></div>
                <img id="qrCodeImage" src="" alt="QR Code" width="200">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="downloadQrCodeBtn" class="btn btn-primary">Download</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for delete confirmation -->
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

<!-- Include jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>


<!-- JavaScript for dynamic QR code generation and download -->
<script>
    // JavaScript function to set the delete link dynamically
    function setDeleteLink(productID) {
        document.getElementById('deleteProductLink').href = '/inventory/delete/' + productID;
    }
</script>

<!-- JavaScript for QR code modal -->
<script>
    document.getElementById('downloadQrCodeBtn').addEventListener('click', function() {
        // Get the QR code image URL
        let qrCodeImageUrl = document.getElementById('qrCodeImage').src;

        // Create an anchor element with download attribute
        let link = document.createElement('a');
        link.href = qrCodeImageUrl;
        link.download = 'qr_code.png';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });

    // Event listener for the modal close button
    $('#qrModal').on('hidden.bs.modal', function () {
        // Clear the QR code image source
        document.getElementById('qrCodeImage').src = '';
    });

    // JavaScript function to open the modal and display the QR code
    function openQrModal(productId, event) {
        // Prevent the default behavior of the anchor tag (i.e., prevent redirection)
        event.preventDefault();

        // Set the URL to generate the QR code
        let qrUrl = '/generate-qr-code/' + productId;

        // Fetch the QR code HTML from the server
        fetch(qrUrl)
            .then(response => response.text())
            .then(data => {
                // Add the HTML content to the modal body
                document.querySelector('#qrCodeContainer').innerHTML = data;

                // Open the modal
                $('#qrModal').modal('show');
            })
            .catch(error => {
                console.error('An error occurred:', error);
            });
    }

    function resetSearch() {
        // Clear the search input field
        document.querySelector('input[name="q"]').value = '';

        // Submit the form to reload the original table
        document.querySelector('form').submit();
    }
    let qrCodeContainer = document.getElementById('qrCodeContainer');
// Event listener for the modal shown event
$('#qrModal').on('shown.bs.modal', function () {
    // Get the QR code image element
    let qrCodeImage = document.getElementById('qrCodeImage');

    // Event listener for the image load event
    qrCodeImage.onload = function() {
        // Enable the download button once the image is loaded
        document.getElementById('downloadQrCodeBtn').disabled = false;
    };
});

// Event listener for the modal close event
$('#qrModal').on('hidden.bs.modal', function () {
    // Disable the download button when the modal is closed
    document.getElementById('downloadQrCodeBtn').disabled = true;
});

// Event listener for the download button click
document.getElementById('downloadQrCodeBtn').addEventListener('click', function() {
    // Get the QR code container element
    let qrCodeContainer = document.getElementById('qrCodeContainer');

    if (qrCodeContainer) {
        // Use html2canvas to capture the QR code container
        html2canvas(qrCodeContainer).then(function(canvas) {
            // Convert the canvas to a data URL representing the PNG image
            let imageDataURL = canvas.toDataURL('image/png');

            // Create an anchor element with download attribute
            let link = document.createElement('a');
            link.href = imageDataURL;
            link.download = 'qr_code.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    } else {
        console.error('QR code container not found.');
    }
});





</script>
</script>
<?php $this->endSection(); ?>
