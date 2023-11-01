<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $session = session();
        $userId = $session->get('user_id');
    
        if ($userId) {
            $user = $this->userModel->getUserById($userId);
    
            // Calculate the session expiration time
            $sessionExpiration = time() + config('App')->sessionExpiration;
    
            // Pass the user data and session expiration time to the view
            echo view('dashboard', ['user' => $user, 'sessionExpiration' => $sessionExpiration]);
        } else {
            // If there is no user ID in the session, redirect back to the login page
            return redirect()->to('/login');
        }
    }
    
}
