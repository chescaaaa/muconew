<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\InventoryModel;
use App\Models\CartModel;
use App\Models\CategoryModel;
use App\Models\OrderModel;
use App\Models\OrderDetailModel;
use App\Models\TransactionModel;
use CodeIgniter\Model;

class ShopController extends BaseController
{
    public function index()
    {
        $inventoryModel = new InventoryModel();
        $data['products'] = $inventoryModel->findAll(); 

        return view('website/index', $data);
    }

    public function addToCart($productId)
    {
        // Hardcoded customer ID for demonstration purposes
        $customerId = 1;
        $quantity = 1; // You can adjust the quantity as needed

        // Check if the product ID is valid
        $inventoryModel = new InventoryModel();
        $product = $inventoryModel->find($productId);

        if (!$product) {
            // Redirect or handle the case where the product is not found
            return redirect()->to('/shop')->with('error', 'Product not found');
        }

        // Check if the CartModel exists and create an instance if not
        $cartModel = new CartModel();

        // Check if the product already exists in the cart for the customer
        $existingCartItem = $cartModel->where('ProductID', $productId)->first();

        if ($existingCartItem) {
            // If the product exists, update the quantity
            $newQuantity = $existingCartItem['Quantity'] + $quantity;
            $cartModel->update($existingCartItem['CartID'], ['Quantity' => $newQuantity]);
        } else {
            // If the product does not exist, insert a new cart item
            $cartModel->insert(['CustomerID' => $customerId, 'ProductID' => $productId, 'Quantity' => $quantity]);
        }

        // You can redirect to the shopping page or any other appropriate page
        return redirect()->to('/cart')->with('success', 'Product added to cart');
    }
    public function ShopProducts()
    {
        $inventoryModel = new InventoryModel();
        $data['products'] = $inventoryModel->findAll(); 

        return view('website/shop', $data);
    }
    public function cart()
    {   
        $inventoryModel = new InventoryModel();
        $categoryModel = new CategoryModel();
        
        $customerId = 1; 
        $cartModel = new CartModel();
        
        $cartItems = $cartModel->select('cart.ProductID, cart.Quantity')
            ->join('products', 'cart.ProductID = products.ProductID')
            ->join('Category', 'products.CategoryID = Category.CategoryID')
            ->where('cart.CustomerID', $customerId)
            ->findAll();
        
        foreach ($cartItems as &$item) {
            $productDetails = $inventoryModel->find($item['ProductID']);
            $categoryDetails = $categoryModel->find($productDetails['CategoryID']);
        
            // Add additional details to the cart item
            $item['ProductName'] = $productDetails['ProductName'];
            $item['Price'] = $productDetails['Price'];
            $item['CategoryName'] = $categoryDetails['CategoryName'];
        }
        
        $data['cartItems'] = $cartItems;
        
        return view('website/cart', $data);
    }      

    public function updateQuantity()
    {
        $productId = $this->request->getPost('ProductId');
        $quantity = $this->request->getPost('Quantity');
    
        if (!is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Invalid product ID or quantity']);
        }
    
        $cartModel = new CartModel();
        $updated = $cartModel->updateQuantity($productId, $quantity);
    
        if ($updated) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update quantity']);
        }
    }
    
    public function fetchCartItems()
    {
        // Hardcoded customer ID for demonstration purposes
        $customerId = 1;

        $cartItems = [];

        $cartModel = new CartModel();
        $cartItemsData = $cartModel->select('cart.ProductID, cart.Quantity, products.ProductName, products.Price, products.ImageURL')
            ->join('products', 'cart.ProductID = products.ProductID')
            ->where('cart.CustomerID', $customerId)
            ->findAll();

        foreach ($cartItemsData as $itemData) {
            $cartItem = [
                'ProductID' => $itemData['ProductID'],
                'Quantity' => $itemData['Quantity'],
                'ProductName' => $itemData['ProductName'],
                'Price' => $itemData['Price'],
                'ImageURL' => $itemData['ImageURL'], // Include the ImageURL key
            ];
            $cartItems[] = $cartItem;
        }

        return $cartItems;
    }

    public function checkout()
    {

        $userId = 1; // Assuming the user ID is known
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $cartItems = $this->fetchCartItems();

        $subtotal = $this->calculateSubtotal($cartItems);
        $shipping = 0; 
        $total = $subtotal + $shipping;
    
        // Pass data to the checkout view
        $data = [
            'user' => $user,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $total,
        ];
    
        return view('website/checkout', $data);
    }

    private function clearCart()
    {
        // Hardcoded customer ID for demonstration purposes
        $customerId = 1;

        // Delete all cart items for the customer
        $cartModel = new CartModel();
        $cartModel->where('CustomerID', $customerId)->delete();
    }

    private function calculateSubtotal($cartItems)
    {
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $subtotal += $item['Price'] * $item['Quantity'];
        }

        return $subtotal;
    }

    public function placeOrder()
    {
    // Fetch cart items
    $cartItems = $this->fetchCartItems();

    // Iterate over each item in the cart
    foreach ($cartItems as $item) {
        // Retrieve product details from the inventory
        $inventoryModel = new InventoryModel();
        $product = $inventoryModel->find($item['ProductID']);

        // Check if the product exists and if its quantity is sufficient
        if ($product && $product['Quantity'] >= $item['Quantity']) {
            // Subtract the quantity from the inventory
            $newQuantity = $product['Quantity'] - $item['Quantity'];
            $inventoryModel->update($item['ProductID'], ['Quantity' => $newQuantity]);
        } else {
            // Handle the case where the product is not found or the quantity is insufficient
            // You can redirect the user back to the cart page with an error message
            return redirect()->to('/cart')->with('error', 'Insufficient quantity for product: ' . $item['ProductName']);
        }
    }

        $cartItems = $this->fetchCartItems();
        $subtotal = $this->calculateSubtotal($cartItems);
        $shipping = 0;
        $total = $subtotal + $shipping;
    
        $orderData = [
            'CustomerID' => 1,
            'OrderDate' => date('Y-m-d H:i:s'), 
            'TotalAmount' => $total,
            'Status' => 'Pending', 
        ];
    
        $orderModel = new OrderModel();
        $orderId = $orderModel->insert($orderData);
    
        $orderDetailModel = new OrderDetailModel();
        foreach ($cartItems as $item) {
            $orderDetailData = [
                'OrderID' => $orderId,
                'ProductID' => $item['ProductID'],
                'Quantity' => $item['Quantity'],
                'UnitPrice' => $item['Price'],
            ];
            $orderDetailModel->insert($orderDetailData);
        }
    
        // Retrieve the order details including the purchased products
        $orderDetails = $orderDetailModel->where('OrderID', $orderId)->findAll();
    
        // Pass the order details to the view
        $data['orderDetails'] = $orderDetails;
    
        // Clear the cart after placing the order
        $this->clearCart();
    
        // Record the transaction
        $transactionData = [
            'OrderID' => $orderId,
            'TransactionDate' => date('Y-m-d H:i:s'), 
            'PaymentMethod' => 'Online Payment', 
            'Amount' => $total,
        ];
    
        $transactionModel = new TransactionModel();
        $transactionModel->insert($transactionData);
    
        return redirect()->to('/thank-you')->with('success', 'Order placed successfully!')->with('cartItems', $cartItems);
    }
    

    public function thankyou()
    {
        $orderModel = new OrderModel();
        // Retrieve the most recent order
        $mostRecentOrder = $orderModel->orderBy('OrderID', 'DESC')->first();
    
        // Check if there's a recent order
        if ($mostRecentOrder) {
            $orderId = $mostRecentOrder['OrderID'];
    
            // Retrieve the order details for the most recent order
            $orderDetailModel = new OrderDetailModel();
            $orderDetails = $orderDetailModel->getOrderDetailsWithProductInfo($orderId);
    
            // Pass the order details to the view
            return view('website/thank-you', ['orderDetails' => $orderDetails]);
        } else {
            // Handle the case where no recent order is found
            // For example, redirect the user to a different page or show an error message
            return redirect()->to('/error')->with('error', 'No recent orders found.');
        }   
    }

    public function orders(){
        $ordersModel = new OrderModel();
        $data['orders'] = $ordersModel->findAll();
    return view('products/orders', $data);
    }

    public function updateStatus($orderId, $status)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            return $this->response->setJSON(['success' => false, 'message' => 'Order not found']);
        }

        $updated = $orderModel->update($orderId, ['Status' => $status]);

        if ($updated) {
            return $this->response->setJSON(['success' => true, 'message' => 'Order status updated successfully', 'newStatus' => $status]);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update order status']);
        }
    }



}
