<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;

class Dashboard extends BaseController
{
    protected $productModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'products' => $this->productModel->findAll(),
            'todaySales' => $this->transactionModel->getDailySales(),
            'monthlySales' => $this->transactionModel->getMonthlySales(),
            'itemSalesStats' => $this->transactionModel->getItemSalesStats(), // Defaults to today
            'recentTransactions' => $this->transactionModel
                ->orderBy('transaction_date', 'DESC')
                ->limit(10)
                ->findAll()
        ];

        return view('dashboard', $data);
    }

    public function products()
    {
        $data = [
            'products' => $this->productModel->findAll()
        ];

        return view('products', $data);
    }

    public function reports()
    {
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-d', strtotime('-7 days'));
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = [
            'transactions' => $this->transactionModel->getSalesReport($startDate, $endDate),
            'itemSalesStats' => $this->transactionModel->getItemSalesStats($startDate, $endDate),
            'start_date' => $startDate,
            'end_date' => $endDate
        ];

        return view('reports', $data);
    }
}
