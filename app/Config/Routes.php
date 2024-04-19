<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//$routes->get('/inventory', 'InventoryController::index2');
$routes->get('/','UserController::loginView');
$routes->get('/dashboard','UserController::dashboard');
$routes->get('/website','UserController::website');

//user register and login
$routes->get('/login', 'UserController::loginView');
$routes->post('/login', 'UserController::login');
$routes->get('/logout','UserController::logout');

$routes->get('/register', 'UserController::registerView');
$routes->post('/register', 'UserController::register');

//inventory
$routes->get('/inventory','InventoryController::index');
$routes->get('/inventory/create','InventoryController::create');
$routes->post('/inventory/store','InventoryController::store');
$routes->get('/inventory/edit/(:num)','InventoryController::edit/$1');
$routes->post('/inventory/update/(:num)','InventoryController::update/$1');
$routes->get('/inventory/delete/(:num)','InventoryController::delete/$1');
$routes->post('/inventory/search', 'InventoryController::search');

//website navigation
$routes->get('/index', 'WebController::website');
$routes->get('/about', 'WebController::about');
$routes->get('/shop', 'WebController::shop');
$routes->get('/contact', 'WebController::contact');
$routes->get('/error', 'WebController::error');
$routes->get('/cart', 'WebController::cart');
$routes->get('/index2', 'WebController::index2');
$routes->get('/mail', 'WebController::mail');
$routes->get('/news', 'WebController::news');
$routes->get('/single-product', 'WebController::singleproduct');
$routes->get('/single-news', 'WebController::singlenews');
$routes->get('/checkouts', 'WebController::checkouts');

//shop
$routes->get('/shop', 'ShopController::ShopProducts');

//cart
$routes->get('/cart/add/(:num)', 'ShopController::addToCart/$1');
$routes->post('/cart/updateQuantity', 'ShopController::updateQuantity');

//qr
$routes->get('/generate-qr-code/(:num)', 'QrCodeController::generateAddToCartQR/$1');
$routes->get('/test', 'QrCodeController::generateAddToCartQR');

//checkout
$routes->get('/checkout', 'ShopController::checkout');
$routes->post('/place-order', 'ShopController::placeOrder');
$routes->get('/thank-you', 'ShopController::thankyou');

$routes->get('/inventory/orders', 'ShopController::orders');
$routes->post('/orders/updateStatus/(:num)/(:any)', 'ShopController::updateStatus/$1/$2');
