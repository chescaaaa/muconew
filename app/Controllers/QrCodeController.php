<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use SimpleSoftwareIO\QrCode\Generator;

class QrCodeController extends BaseController
{
    public function index()
    {
        // Generate the QR code
        $qrCode = $this->generateQrCode('Your QR code data here');

        // Pass the QR code to the view
        return view('products/qr', ['qrCode' => $qrCode]);
    }

    public function generateAddToCartQR($productId)
    {
        // Generate the URL for adding the product to the cart
        $addToCartUrl = base_url("/cart/add/$productId");

        // Generate the QR code with the add to cart URL
        $qrCode = $this->generateQrCode($addToCartUrl);

        // Pass the QR code and product ID to the view
        return view('products/qr', ['qrCode' => $qrCode, 'productId' => $productId]);
    }


    private function generateQrCode($data)
    {
        // Create a new instance of the QR code generator
        $qrCode = new Generator;

        // Generate the QR code
        return $qrCode->size(200)->generate($data);
    }
}
