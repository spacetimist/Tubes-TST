<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AuthController extends ResourceController
{
    // Public function for user registration
    public function register()
    {
        $userModel = new UserModel();
        $data = $this->request->getJSON(true); // Get input JSON as an array

        // Hash the password before saving (using bcrypt)
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

        // Save the user data
        if ($userModel->save($data)) {
            return $this->respondCreated(['message' => 'User registered successfully']);
        }

        return $this->fail($userModel->errors());
    }
}
