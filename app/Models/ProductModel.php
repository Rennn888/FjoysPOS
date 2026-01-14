<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'price', 'category', 'image_url', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getActiveProducts()
    {
        return $this->where('is_active', 1)->findAll();
    }

    public function getProductsByCategory()
    {
        return $this->where('is_active', 1)
                    ->orderBy('category', 'ASC')
                    ->orderBy('name', 'ASC')
                    ->findAll();
    }
}
