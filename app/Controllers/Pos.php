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
        // This can be called via API or accessed directly
        if ($this->request->getMethod() === 'post') {
            // Return JSON response for API calls
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Order counter reset to 1'
            ]);
        }
        
        // For direct access, return a simple page
        return view('pos/reset_counter');
    }

    public function diagnostic()
    {
        return view('pos/diagnostic');
    }
}
