<?php if (!empty($products) && is_array($products)): ?>
    <?php foreach($products as $product): ?>
        <tr>
            <!-- Display product details here -->
        </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="9">No products found</td>
    </tr>
<?php endif; ?>