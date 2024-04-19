<?php

$this->extend('layout/main');
$this->section('body');
?>

<br><a href="/inventory" class="btn btn-success">Back to Product List</a>
<h1>Add Product</h1>
<form action="/inventory/store" method="post" enctype="multipart/form-data">

<div class="mb-3">
  <label for="CategoryName" class="form-label">Product Category</label>
  <select class="form-control" name="CategoryName" required>
    <option>--Select Here--</option>◘
    <option value="Building Materials">Building Materials</option>
    <option value="Hardware Tools">Hardware Tools</option>
    <option value="Fasteners and Fixings">Fasteners and Fixings</option>
    <option value="Safety Equipment">Safety Equipment</option>
    <option value="Adhesives and Sealants">Adhesives and Sealants</option>
    <option value="Construction Equipment">Construction Equipment</option>
    <option value="Landscaping and Outdoor Supplies">Landscaping and Outdoor Supplies</option>
    <option value="Electrical and Plumbing Supplies">Electrical and Plumbing Supplies</option>
    <option value="Finishing Supplies">Finishing Supplies</option>
    <option value="Storage and Organization">Storage and Organization</option>
  </select>
</div>
<div class="mb-3">
  <label for="ProductName" class="form-label">Product Name</label>
  <input type="text" class="form-control" name="ProductName" placeholder="ex. Hammer" required>
</div>
<div class="mb-3">
  <label for="Description" class="form-label">Product Description</label>
  <textarea class="form-control" name="Description" rows="3"></textarea required>
</div>
<div class="mb-3">
  <label for="Price" class="form-label">Price</label>
  <input type="number" class="form-control" name="Price" required>
</div>
<div class="mb-3">
  <label for="Quantity" class="form-label">Quantity</label>
  <input type="number" class="form-control" name="Quantity" required>
</div>
<div class="mb-3">
  <label for="ImageURL" class="form-label">Image</label>
  <input type="file" class="form-control" name="ImageURL" required>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>

<?php $this->endSection(); ?>