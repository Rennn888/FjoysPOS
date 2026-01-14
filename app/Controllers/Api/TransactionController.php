<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use CodeIgniter\HTTP\ResponseInterface;

class TransactionController extends BaseController
{
    protected $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function sync()
    {
        try {
            $json = $this->request->getJSON(true);
            
            if (!isset($json['transactions']) || !is_array($json['transactions'])) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Invalid request format'
                ]);
            }

            $synced = [];
            $failed = [];

            foreach ($json['transactions'] as $transaction) {
                // Check if transaction already exists
                $existing = $this->transactionModel->where('transaction_id', $transaction['transaction_id'])->first();
                
                if ($existing) {
                    $synced[] = $transaction['transaction_id'];
                    continue;
                }

                // Prepare data
                $data = [
                    'transaction_id' => $transaction['transaction_id'],
                    'device_id' => $transaction['device_id'] ?? null,
                    'items' => json_encode($transaction['items']),
                    'subtotal' => $transaction['subtotal'],
                    'total' => $transaction['total'],
                    'payment_method' => $transaction['payment_method'] ?? 'cash',
                    'cash_received' => $transaction['cash_received'] ?? null,
                    'change_given' => $transaction['change_given'] ?? null,
                    'transaction_date' => $transaction['transaction_date'],
                    'synced_at' => date('Y-m-d H:i:s'),
                ];

                if ($this->transactionModel->insert($data)) {
                    $synced[] = $transaction['transaction_id'];
                } else {
                    $failed[] = $transaction['transaction_id'];
                }
            }

            return $this->response->setJSON([
                'success' => true,
                'synced' => count($synced),
                'failed' => count($failed),
                'synced_ids' => $synced,
                'failed_ids' => $failed
            ]);

        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ]);
        }
    }

    public function dailySales()
    {
        try {
            $date = $this->request->getGet('date') ?? date('Y-m-d');
            $sales = $this->transactionModel->getDailySales($date);
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $sales,
                'date' => $date
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to fetch daily sales'
            ]);
        }
    }

    public function report()
    {
        try {
            $startDate = $this->request->getGet('start_date') ?? date('Y-m-d');
            $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');
            
            $transactions = $this->transactionModel->getSalesReport($startDate, $endDate);
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $transactions,
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to generate report'
            ]);
        }
    }
}
