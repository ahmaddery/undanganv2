<?php


namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'reset_token', 'token_created_at'];

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function insertUser($data)
    {
        return $this->insert($data);
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }
    public function getUserByResetToken($token)
{
    return $this->where('reset_token', $token)->first();
}


}
