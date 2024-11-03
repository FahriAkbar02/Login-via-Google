<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Periksa apakah sesi pengguna mengandung informasi yang menunjukkan pengguna sudah login
        if (!session()->has('google_id')) {
            // Jika tidak, arahkan pengguna ke halaman login
            return redirect()->to('/login');
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Redirect ke halaman dashboard
        return redirect()->to('/dashboard');

        // Tidak perlu implementasi di sini
    }
}
