<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\CartModel;

class WebController extends BaseController
{
    public function website()
    {
        $inventoryModel = new InventoryModel();
        $data['products'] = $inventoryModel->findAll(); 

        return view('website/index', $data);
    }
    public function about()
    {
        return view('website/about');
    }
    public function shop()
    {
        $inventoryModel = new InventoryModel();
        $products = $inventoryModel->findAll(); 

        foreach ($products as &$product) {
            $product['Category'] = $product['Category'] ?? 'default_category'; 
        }

        $data['products'] = $products;

        return view('website/shop', $data);
    }
    public function contact()
    {
        return view('website/contact');
    }
    public function error()
    {
        return view('website/404');
    }
    public function cart()
    {
        $customerId = 1; 
        $cartModel = new CartModel();
        $inventoryModel = new InventoryModel();  // Rename variable to reflect the correct model

        // Assuming getCartItems method is defined in CartModel
        $cartItems = $cartModel->getCartItems($customerId);
        $data['cartItems'] = $cartItems;

        // Assuming getCartProducts method is defined in InventoryModel
        $cartProducts = $inventoryModel->getCartProducts($customerId);
        $data['cartProducts'] = $cartProducts;

        return view('website/cart', $data);
    }
    public function checkouts()
    {
        return view('website/checkout');
    }
    public function index2()
    {
        $inventoryModel = new InventoryModel();
        $data['products'] = $inventoryModel->findAll(); 

        return view('website/index_2', $data);
        }
    public function mail()
    {
        return view('website/mail');
    }
    public function news()
    {
        return view('website/news');
    }
    public function singleproduct()
    {
        return view('website/single-product');
    }
    public function singlenews()
    {
        return view('website/single-news');
    }
}
