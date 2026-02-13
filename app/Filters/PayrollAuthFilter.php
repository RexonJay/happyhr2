<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PayrollAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $user = auth()->user();

        // Not logged in or not allowed
        if (!$user 
            || (!$user->inGroup('payroll hr') 
                && !$user->inGroup('admin')
                && !$user->inGroup('payroll'))) 
        {
            // Detect if API/AJAX/JSON request
            if ($request->isAJAX() || $request->getHeaderLine('Accept') === 'application/json') {
                return service('response')->setJSON([
                    'status'  => 'error',
                    'message' => 'Unauthorized'
                ]);
            }

            // Otherwise redirect to login
            return redirect()->to('login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Nothing
    }
}
