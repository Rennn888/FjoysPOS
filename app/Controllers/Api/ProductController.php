<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;

class ProductController extends BaseController
{
    protected $productModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        try {
            $products = $this->productModel->getActiveProducts();
            return $this->response->setJSON([
                'success' => true,
                'data' => $products,
                'timestamp' => time()
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to fetch products'
            ]);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productModel->find($id);
            if (!$product) {
                return $this->response->setStatusCode(404)->setJSON([
                    'success' => false,
                    'message' => 'Product not found'
                ]);
            }
            return $this->response->setJSON([
                'success' => true,
                'data' => $product
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to fetch product'
            ]);
        }
    }
}
