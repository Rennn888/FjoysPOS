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

    public function getMonthlySales($month = null, $year = null)
    {
        $month = $month ?? date('m');
        $year = $year ?? date('Y');
        
        return $this->where('MONTH(transaction_date)', $month)
                    ->where('YEAR(transaction_date)', $year)
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

    public function getItemSalesStats($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? date('Y-m-d');
        $endDate = $endDate ?? $startDate;
        
        // Get transactions for the date range
        $transactions = $this->where('DATE(transaction_date) >=', $startDate)
                             ->where('DATE(transaction_date) <=', $endDate)
                             ->findAll();
        
        $stats = [];
        
        foreach ($transactions as $t) {
            $items = json_decode($t['items'], true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    $name = $item['name'] ?? 'Unknown Item';
                    // Append flavor if exists to differentiate items
                    if (!empty($item['flavor'])) {
                        $name .= ' (' . $item['flavor'] . ')';
                    }
                    
                    $qty = $item['quantity'] ?? 0;
                    $price = $item['price'] ?? 0;
                    
                    if (!isset($stats[$name])) {
                        $stats[$name] = [
                            'name' => $name,
                            'quantity' => 0,
                            'total' => 0
                        ];
                    }
                    
                    $stats[$name]['quantity'] += $qty;
                    $stats[$name]['total'] += ($price * $qty);
                }
            }
        }
        
        // Sort by quantity desc
        usort($stats, function($a, $b) {
            return $b['quantity'] - $a['quantity'];
        });
        
        return $stats;
    }
}
