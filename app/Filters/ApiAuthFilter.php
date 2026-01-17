<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // API key authentication
        $apiKey = $request->getHeaderLine('X-API-Key');
        $validKey = getenv('API_KEY');
        
        if (empty($validKey) || $apiKey !== $validKey) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'success' => false,
                    'message' => 'Unauthorized'
                ]);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
