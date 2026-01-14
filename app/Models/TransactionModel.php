<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'transaction_id', 'device_id', 'items', 'subtotal', 'total',
        'payment_method', 'cash_received', 'change_given',
        'transaction_date', 'synced_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = null;

    public function getDailySales($date = null)
    {
        $date = $date ?? date('Y-m-d');
        return $this->where('DATE(transaction_date)', $date)
                    ->selectSum('total', 'total_sales')
                    ->selectCount('id', 'transaction_count')
                    ->first();
    }

    public function getSalesReport($startDate, $endDate)
    {
        return $this->where('transaction_date >=', $startDate)
                    ->where('transaction_date <=', $endDate)
                    ->orderBy('transaction_date', 'DESC')
                    ->findAll();
    }
}
