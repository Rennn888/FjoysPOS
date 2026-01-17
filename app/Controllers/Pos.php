<?php

namespace App\Controllers;

class Pos extends BaseController
{
    public function index()
    {
        return view('pos/index');
    }

    public function resetOrderCounter()
    {
        // Reset order counter endpoint
        if ($this->request->getMethod() === 'post') {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order counter reset to 1'
            ]);
        }
        
        return view('pos/reset_counter');
    }
}
