<?php

namespace App\Models;

use CodeIgniter\Model;

class InventoryModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'ProductID';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['CategoryName', 'ProductName', 'Description', 'Price', 'Quantity', 'ImageURL', 'created_at'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function getCartProducts($customerId)
    {
        return $this->select('ProductID, ProductName, CategoryName, Price, Quantity, ImageURL')->findAll();
    }

    public function searchProducts($searchQuery)
    {
        // Add debugging statement to log the search query
        log_message('debug', 'Search query: ' . $searchQuery);

        $builder = $this->builder(); // Get a query builder instance

        $result = $builder->like('ProductName', $searchQuery)->get()->getResult();

        // Add error handling to check if no results were found
        if (empty($result)) {
            log_message('debug', 'No products found for search query: ' . $searchQuery);
            return [];
        }

        return $result;
    }

}
