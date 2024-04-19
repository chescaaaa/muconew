<?php

$this->extend('layout/main');
$this->section('body');
?>

<br><a href="/inventory" class="btn btn-success">Back to Product List</a>
<h1>Edit Product</h1>
<form action="/inventory/update/<?= $product['ProductID']; ?>" method="post" enctype="multipart/form-data">

<div class="mb-3">
  <label for="CategoryName" class="form-label">Product Category</label>
  <select class="form-control" name="CategoryName" required>
    <option value="" <?= empty($product['CategoryName']) ? 'selected' : '' ?>>--Select Here--</option>

    <?php
    $categories = [
        "Building Materials",
        "Hardware Tools",
        "Fasteners and Fixings",
        "Safety Equipment",
        "Adhesives and Sealants",
        "Construction Equipment",
        "Landscaping and Outdoor Supplies",
        "Electrical and Plumbing Supplies",
        "Finishing Supplies",
        "Storage and Organization"
    ];

    foreach ($categories as $category) {
        $selected = ($product['CategoryName'] == $category) ? 'selected' : '';
        echo "<option value=\"$category\" $selected>$category</option>";
    }
    ?>
  </select>
</div>
<div class="mb-3">
  <label for="ProductName" class="form-label">Product Name</label>
  <input type="text" class="form-control" name="ProductName" value="<?= $product['ProductName']; ?>" required>
</div>
<div class="mb-3">
  <label for="Description" class="form-label">Product Description</label>
  <input type="text" class="form-control" name="Description" value="<?= $product['Description']; ?>" required>
</div>
<div class="mb-3">
  <label for="Price" class="form-label">Price</label>
  <input type="number" class="form-control" name="Price" value="<?= $product['Price']; ?>" required>
</div>
<div class="mb-3">
  <label for="Quantity" class="form-label">Quantity</label>
  <input type="number" class="form-control" name="Quantity" value="<?= $product['Quantity']; ?>" required>
</div>
<div class="mb-3">
  <label for="ImageURL" class="form-label">Image</label>
  <input type="file" class="form-control" name="ImageURL" value="<?= $product['ImageURL']; ?>">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php $this->endSection(); ?>
