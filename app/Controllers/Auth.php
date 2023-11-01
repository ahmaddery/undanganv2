<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    public function __construct()
    {
        helper(['form', 'url']);
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $user = $this->userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil, lakukan sesuatu seperti menyimpan sesi

                $session = session();
                $session->set('user_id', $user['id']);

                return redirect()->to('/user'); // Ganti '/dashboard' dengan URL halaman dashboard Anda
            } else {
                // Login gagal, tampilkan pesan kesalahan
                session()->setFlashdata('error', 'Login failed. Please check your email and password.');
            }
        }

        return view('auth/login');
    }

    public function register()
    {
        if ($this->request->getMethod() === 'post') {
            $username = $this->request->getVar('username');
            $email = $this->request->getVar('email');
            $password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
    
            // Pengecekan apakah username sudah terdaftar
            $userExists = $this->userModel->where('username', $username)->first();
            // Pengecekan apakah email sudah terdaftar
            $emailExists = $this->userModel->where('email', $email)->first();
    
            if ($userExists && $emailExists) {
                $session = session();
                $session->setFlashdata('error', 'Username dan Email sudah terdaftar.');
                return redirect()->to('/register');
            } elseif ($userExists) {
                $session = session();
                $session->setFlashdata('error', 'Username sudah terdaftar.');
                return redirect()->to('/register');
            } elseif ($emailExists) {
                $session = session();
                $session->setFlashdata('error', 'Email sudah terdaftar.');
                return redirect()->to('/register');
            }
    
            $data = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
            ];
    
            $this->userModel->insertUser($data);
    
            // Registrasi berhasil, lakukan sesuatu seperti menyimpan sesi
            return redirect()->to('/login'); // Ganti '/dashboard' dengan URL halaman dashboard Anda
        }
    
        return view('auth/register');
    }
    
    public function logout()
    {
        $session = session();

        // Periksa apakah sesi user_id ada
        if ($session->has('user_id')) {
            // Jika ada, hapus sesi user_id
            $session->remove('user_id');
        }

        // Setelah menghapus sesi, arahkan pengguna kembali ke halaman login
        return redirect()->to('/auth/login'); // Ganti '/auth/login' dengan URL login Anda
    }

    public function forgotPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $email = $this->request->getVar('email');
    
            $user = $this->userModel->getUserByEmail($email);
    
            if ($user) {
                // Generate a random reset code
                $resetCode = bin2hex(random_bytes(16));
    
                // Store the reset code and timestamp in the database
                $this->userModel->update($user['id'], ['reset_token' => $resetCode, 'token_created_at' => date('Y-m-d H:i:s')]);
    
                // Set the expiration date for the token
                $expirationDate = date('Y-m-d H:i:s', strtotime('+1 day'));
    
                // Send reset code via email
                $resetLink = base_url("reset_password/$resetCode");
                $emailService = service('email');
                $emailService->setTo($email);
                $emailService->setFrom('admin@ahmadderi.my.id', 'Code Reset password');
                $emailService->setSubject('Password Reset Code');
    
                // Set email message
                $emailService->setMessage('
                <!DOCTYPE html>
                <html>
                
                <head>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                        }
                
                        .container {
                            width: 50%;
                            margin: 0 auto;
                            padding: 20px;
                            border: 1px solid #e1e1e1;
                            border-radius: 5px;
                            background-color: #f9f9f9;
                        }
                
                        .header {
                            text-align: center;
                            margin-bottom: 30px;
                        }
                
                        .message {
                            margin-bottom: 20px;
                        }
                
                        .reset-link {
                            display: block;
                            text-align: center;
                            padding: 10px;
                            background-color: #4CAF50;
                            color: white;
                            text-decoration: none;
                            border-radius: 5px;
                            width: 50%;
                            margin: 0 auto;
                        }
                
                        .footer {
                            text-align: center;
                            margin-top: 30px;
                            color: #777;
                        }
                    </style>
                </head>
                
                <body>
                    <div class="container">
                        <div class="header">
                            <h2>Atur Ulang Kata Sandi Anda</h2>
                        </div>
                        <div class="message">
                            <p>Halo ' . $user['username'] . ',</p>
                            <p>Kami menerima permintaan untuk mengatur ulang kata sandi Anda. Klik tautan di bawah ini untuk mengatur ulang kata sandi Anda.</p>
                        </div>
                        <a class="reset-link" href="' . $resetLink . '">Atur Ulang Kata Sandi</a>
                        <div class="footer">
                            <p>Tautan ini akan kedaluwarsa pada ' . $expirationDate . '. Mohon atur ulang kata sandi sebelum waktu tersebut.</p>
                        </div>
                    </div>
                </body>
                
                </html>


                ');
    
                if ($emailService->send()) {
                    session()->setFlashdata('success', 'Kode reset kata sandi telah dikirim ke email Anda.');
                } else {
                    session()->setFlashdata('error', 'Gagal mengirim kode reset. Silakan coba lagi nanti.');
                }
            } else {
                session()->setFlashdata('error', 'No user found with that email.');
            }
        }
    
        return view('auth/forgot_password');
    }
    

    public function resetPassword($token)
    {
        // Periksa validitas token di sini
        $user = $this->userModel->getUserByResetToken($token);
    
        if (!$user || !$this->isTokenValid($user['token_created_at'])) {
            return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token. Please try again.');
        }
    
        return view('auth/reset_password', ['token' => $token]);
    }
    
    public function processResetPassword()
    {
        if ($this->request->getMethod() === 'post') {
            $token = $this->request->getVar('token');
            $newPassword = $this->request->getVar('new_password');
            $confirmPassword = $this->request->getVar('confirm_password');
    
            // Lakukan validasi password di sini
            if ($newPassword !== $confirmPassword) {
                return redirect()->back()->with('error', 'Passwords do not match. Please try again.');
            }
    
            $user = $this->userModel->getUserByResetToken($token);
            if (!$user || !$this->isTokenValid($user['token_created_at'])) {
                return redirect()->to('/forgot-password')->with('error', 'Invalid or expired token. Please try again.');
            }
    
            // Jika validasi berhasil, lakukan reset password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $this->userModel->update($user['id'], ['password' => $hashedPassword, 'reset_token' => null, 'token_created_at' => null]);
    
           // Kirim email notifikasi bahwa kata sandi berhasil diganti
$emailService = service('email');
$emailService->setTo($user['email']);
$emailService->setFrom('admin@ahmadderi.my.id', 'pergantian password');
$emailService->setSubject('Password Changed Successfully');

// Set email message
$emailService->setMessage('
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
            }

            .container {
                width: 50%;
                margin: 0 auto;
                padding: 20px;
                border: 1px solid #e1e1e1;
                border-radius: 5px;
                background-color: #f9f9f9;
            }

            .header {
                text-align: center;
                margin-bottom: 30px;
            }

            .message {
                margin-bottom: 20px;
            }

            .footer {
                text-align: center;
                margin-top: 30px;
                color: #777;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2>Pergantian Kata Sandi Berhasil</h2>
            </div>
            <div class="message">
                <p>Halo ' . $user['username'] . ',</p>
                <p>Kata sandi Anda telah berhasil diganti.</p>
            </div>
            <div class="footer">
                <p>Jika Anda tidak mengubah kata sandi Anda, segera hubungi kami.</p>
            </div>
        </div>
    </body>
    </html>
');

// Kirim email
$emailService->send();

    
            // Redirect ke halaman login dengan pesan sukses
            return redirect()->to('/login')->with('success', 'Password has been reset successfully. Please login with your new password.');
        }
    }
    
    
    private function isTokenValid($tokenCreatedAt)
    {
        $expiration = new \DateTime($tokenCreatedAt);
        $expiration->add(new \DateInterval('PT1H')); // Token berlaku selama 1 jam
    
        return $expiration > new \DateTime();
    }
    
}
