<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $session = session();
        $userId = $session->get('user_id'); // Ambil ID pengguna dari sesi
        $model = new ProfileModel();
        $data['user'] = $model->find($userId);
        return view('user/show', $data);
    }

    public function edit()
    {
        $session = session();
        $userId = $session->get('user_id'); // Ambil ID pengguna dari sesi
        $model = new ProfileModel();
        $data['user'] = $model->find($userId);
        return view('user/edit', $data);
    }

    public function update()
    {
        $session = session();
        $userId = $session->get('user_id'); // Ambil ID pengguna dari sesi
        $model = new ProfileModel();
        $data = [
            'username' => $this->request->getPost('username'),
            'alamat' => $this->request->getPost('alamat'),
            'nohp' => $this->request->getPost('nohp'),
            'email' => $this->request->getPost('email'),
        ];

        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($userId, $data);
        return redirect()->to('/user');
    }
    public function user()
    {
        $model = new ProfileModel();
        $data['users'] = $model->findAll();
        return view('admin/profile/index', $data);
    }
}
