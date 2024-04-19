<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Cart</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="assets/css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="assets/css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="#">Home</a>
									<ul class="sub-menu">
										<li><a href="/index">Static Home</a></li>
										<li><a href="/index2">Slider Home</a></li>
									</ul>
								</li>
								<li><a href="/about">About</a></li>
								<li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="/error">404 page</a></li>
										<li><a href="/about">About</a></li>
										<li><a href="/cart">Cart</a></li>
										<li><a href="/checkout">Check Out</a></li>
										<li><a href="/contact">Contact</a></li>
										<li><a href="/news">News</a></li>
										<li><a href="/shop">Shop</a></li>
									</ul>
								</li>
								<li><a href="/news">News</a>
									<ul class="sub-menu">
										<li><a href="/news">News</a></li>
										<li><a href="/singlenews">Single News</a></li>
									</ul>
								</li>
								<li><a href="/contact">Contact</a></li>
								<li><a href="/shop">Shop</a>
									<ul class="sub-menu">
										<li><a href="/shop">Shop</a></li>
										<li><a href="/checkout">Check Out</a></li>
										<li><a href="/singleproduct">Single Product</a></li>
										<li><a href="/cart">Cart</a></li>
									</ul>
								</li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="/cart"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Cart</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="cart-table-wrap">
					<table class="cart-table">
					<thead class="cart-table-head">
							<tr class="table-head-row">
								<th class="product-remove"></th>
								<th class="product-image"></th>
								<th class="product-name">Name</th>
								<th class="product-price">Price</th>
								<th class="product-quantity">Quantity</th>
								<th class="product-total">Total</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$subtotal = 0; // Initialize subtotal variable
							foreach ($cartItems as $item):
								$productKey = array_search($item['ProductID'], array_column($cartProducts, 'ProductID'));
								$prod = $cartProducts[$productKey];
								$totalPrice = $item['Quantity'] * $prod['Price'];
								$subtotal += $totalPrice; // Add the current product's total to subtotal
							?>
							<tr>
								<td class="product-remove"><a href="#">Remove</a></td>
								<td class="product-image">
									<img src="uploads/<?= $prod['ImageURL']; ?>" alt="Product Image">
								</td>
								<td class="product-name"><?= $prod['ProductName']; ?></td>
								<td class="product-price">₱ <?= $prod['Price']; ?></td>
								<td class="product-quantity">
									<!-- Add the hidden input field for productId -->
									<input type="hidden" name="productId" value="<?= $prod['ProductID']; ?>">
									<!-- Use input type "number" for quantity with min value of 1 and an ID for easier selection -->
									<input id="quantity_<?= $prod['ProductID']; ?>" type="number" name="quantity" value="<?= $item['Quantity']; ?>" min="1">
								</td>
								<td class="product-total">₱ <?= $totalPrice; ?></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="total-section">
						<table class="total-table">
							<thead class="total-table-head">
								<tr class="table-total-row">
									<th>Total</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody>
							<tr class="total-data">
								<td><strong>Subtotal: </strong></td>
								<td>₱<?= $subtotal; ?></td>
							</tr>
							<tr class="total-data">
								<td><strong>Shipping: </strong></td>
								<td><!-- shippingFee; --></td>
							</tr>
							<tr class="total-data">
								<td><strong>Total: </strong></td>
								<td>₱<?= $subtotal ; ?></td> <!--<td><= $subtotal + shippingFee; ></td> -->
							</tr>
							</tbody>
						</table>
						<div class="cart-buttons">
							<a href="/checkout" class="boxed-btn black">Check Out</a>
						</div>
					</div>

					<!--<div class="coupon-section">
						<h3>Apply Coupon</h3>
						<div class="coupon-form-wrap">
							<form action="index">
								<p><input type="text" placeholder="Coupon"></p>
								<p><input type="submit" value="Apply"></p>
							</form>
						</div>
					</div>-->
				</div>
			</div>
		</div>
	</div>
	<!-- end cart -->
	
	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>At Agila Hardware and Construction Supplies, we are committed to providing superior quality building materials and tools to empower construction projects of all sizes. With a dedication to excellence and customer satisfaction, we strive to be your trusted partner in achieving outstanding results.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>Roxas Drive, Guinobatan, Calapan City, Oriental Mindoro.</li>
							<li>jhm_bim@yahoo.com</li>
							<li>0977 801 7788</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index">Home</a></li>
							<li><a href="about">About</a></li>
							<li><a href="services">Shop</a></li>
							<li><a href="news">News</a></li>
							<li><a href="contact">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2023 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="assets/js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="assets/js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="assets/js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="assets/js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="assets/js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

	<script>
document.querySelectorAll('.product-quantity input').forEach(input => {
    input.addEventListener('input', function() {
        // Get the product ID and new quantity
        let productIdElement = this.closest('tr').querySelector('[name="productId"]');
        let productId = null; // Declare productId variable outside the if block
        if (productIdElement) {
            productId = productIdElement.value; // Assign value inside the if block
        } else {
            console.error('Element with name "productId" not found in the closest <tr> element.');
            return; // Exit function if productIdElement is not found
        }
        let newQuantity = parseInt(this.value.trim());

        // Validate the new quantity (e.g., ensure it's a positive integer)
        if (isNaN(newQuantity) || newQuantity <= 0) {
            console.error('Invalid quantity entered:', this.value);
            return; // Exit function if the quantity is invalid
        }

        // Make an AJAX request to update the quantity
        fetch('/cart/updateQuantity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Add X-Requested-With header for CSRF protection
            },
            body: JSON.stringify({
                productId: productId,
                quantity: newQuantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Quantity updated successfully
                console.log('Quantity updated successfully');
                // Optionally, update the UI to reflect the new quantity
            } else {
                // Handle errors
                console.error('Failed to update quantity:', data.message);
            }
        })
        .catch(error => {
            console.error('An error occurred:', error);
        });
    });
});
</script>

</body>
</html>