<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class InventoryController extends BaseController
{
    public function index()
    {
        $inventoryModel = new InventoryModel();

        // Retrieve the search query parameter
        $searchQuery = $this->request->getGet('q');

        // If a search query is provided, filter products accordingly
        if (!empty($searchQuery)) {
            $data['products'] = $inventoryModel->like('ProductName', $searchQuery)->findAll();
        } else {
            $data['products'] = $inventoryModel->findAll();
        }

        return view('products/list', $data);
    }

    public function cart()
    {
        $customerId = 1; 
        $cartModel = new InventoryModel();
        $cartProducts = $cartModel->getCartItems($customerId);

        $data['cartProducts'] = $cartProducts;

        return view('website/cart', $data);
    }


    public function create()
    {
        return view('products/add');
    }

    public function store()
    {
        $insertProduct = new InventoryModel();

            if($img = $this->request->getFile('ImageURL')){
                if($img->isValid() && ! $img->hasMoved()){
                    $imageName = $img->getRandomName();
                    $img->move('uploads/', $imageName);
                }
            }
            $data = array(
                'CategoryName'=> $this->request->getPost('CategoryName'),
                'ProductName'=> $this->request->getPost('ProductName'),
                'Description'=> $this->request->getPost('Description'),
                'Price'=> $this->request->getPost('Price'),
                'Quantity'=> $this->request->getPost('Quantity'),
                'ImageURL'=> $imageName,
            );
            $insertProduct->insert($data);

            return redirect()->to('/inventory')->with('success','Product Added Successfully!');
        }
    public function edit($ProductID)
    {
        $fetchproduct = new InventoryModel();
        $data['product'] = $fetchproduct->where('ProductID', $ProductID)->first();

        return view('products/edit', $data);
    }
    public function update($ProductID)
    {
        $updateProduct = new InventoryModel();
        $db = db_connect();

        if($img = $this->request->getFile('ImageURL')){
            if($img->isValid() && ! $img->hasMoved()){
                $imageName = $img->getRandomName();
                $img->move('uploads/', $imageName);
            }
        }

        if(!empty($_FILES['ImageURL']['name'])){
            $db->query("UPDATE products SET ImageURL = '$imageName' WHERE ProductID = '$ProductID' ");
        }

        $data = array(
            'CategoryName'=> $this->request->getPost('CategoryName'),
            'ProductName'=> $this->request->getPost('ProductName'),
            'Description'=> $this->request->getPost('Description'),
            'Price'=> $this->request->getPost('Price'),
            'Quantity'=> $this->request->getPost('Quantity'),
        );

        $updateProduct->update($ProductID, $data);
        return redirect()->to('/inventory')->with('success','Student Updated Successfully!');
    }
    public function delete($ProductID)
    {
        $deleteProduct = new InventoryModel();
        $deleteProduct->delete($ProductID);

        return redirect()->to('/inventory')->with('success','Product Deleted Successfully');
    }

    public function search()
    {
        $searchQuery = $this->request->getGet('q');

        if ($searchQuery !== null) {
            $inventoryModel = new InventoryModel();
            $data['products'] = $inventoryModel->searchProducts($searchQuery);

            // Render the table body as a view fragment and return it as a response
            $viewContent = view('products/table_body', $data);
            return $this->response->setJSON(['table_body' => $viewContent]);
        } else {
            // Handle the case where the search query is null
            // You can return an empty result or an error message
            return $this->response->setJSON(['table_body' => '']);
        }
    }

}