<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
    
        // Cek apakah sesi 'user_id' ada
        if ($userId !== null) {
            // Sesi tersimpan, arahkan ke halaman user
            return redirect()->to('/user');
        }
    
        // Jika sesi tidak ada, tampilkan halaman index
        return view('index');
    }
    

    public function template()
    {

        // Tampilkan halaman index
        return view('template');
    }

    public function admin(): string
    {

        // Tampilkan halaman index
        return view('admin/dashboard');
    }


}
