<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // Nama tabel di database
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['username', 'email', 'password', 'created_at', 'updated_at']; // Kolom yang dapat diisi
    protected $useTimestamps = true; // Menggunakan kolom `created_at` dan `updated_at`

    // Tambahan validasi untuk data pengguna
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[255]',
        'email'    => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[8]',
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'Email sudah terdaftar.',
        ],
    ];
}
