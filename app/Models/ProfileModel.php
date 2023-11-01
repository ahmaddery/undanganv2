<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'alamat', 'nohp', 'email', 'password', 'created_at', 'updated_at', 'reset_token', 'token_created_at'];
}
