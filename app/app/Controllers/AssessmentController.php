<?php

namespace App\Controllers;

use App\Models\AssessmentModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class AssessmentController extends ResourceController
{
    public function index()
    {
        $userModel = new UserModel();
        $assessmentModel = new AssessmentModel();

        $input = $this->request->getJSON();
        $email = $input->email ?? null;
        $password = $input->password ?? null;
        $responses = $input->responses ?? null;

        // Login
        if (!$email || !$password) {
            return $this->fail('Email and password are required.');
        }

        $user = $userModel->where('email', $email)->first();
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid email or password.');
        }

        // Jika ada responses, hitung skor
        if ($responses) {
            if (!is_array($responses) || count($responses) !== 5) {
                return $this->failValidationError('Responses are required and must be an array of 5 answers.');
            }

            $score = array_sum($responses) * 4;

            $data = [
                'user_id' => $user['id'],
                'responses' => json_encode($responses),
                'score' => $score,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($assessmentModel->save($data)) {
                $category = $this->getCategory($score);

                return $this->respond([
                    'status' => 'success',
                    'message' => 'Assessment submitted successfully.',
                    'score' => $score,
                    'category' => $category,
                ]);
            }

            return $this->fail($assessmentModel->errors());
        }

        // Tampilkan pertanyaan jika tidak ada responses
        return $this->respond([
            'status' => 'success',
            'message' => 'Login successful, welcome ' . $user['username'],
            'scale_info' => '0 = Tidak pernah, 5 = Selalu',
            'questions' => $this->getQuestions(),
        ]);
    }

    // Tampilkan pertanyaan di view terpisah
    public function questions()
    {
        return view('assessment_questions', [
            'scale_info' => '0 = Tidak pernah, 5 = Selalu',
            'questions' => $this->getQuestions()
        ]);
    }

    // Fungsi untuk menampilkan hasil assessment berdasarkan user_id
    public function result()
    {
        $assessmentModel = new AssessmentModel();
    
        // Get user_id dari query string
        $userId = $this->request->getGet('user_id');
    
        // Validasi user_id
        if (!$userId || !is_numeric($userId)) {
            return $this->failValidationError('Invalid or missing user_id');
        }
    
        // Ambil hasil assessment terbaru untuk user
        $result = $assessmentModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->first();
    
        // Cek apakah hasil ditemukan
        if (!$result) {
            return $this->failNotFound('No assessment result found for the given user ID.');
        }
    
        // Hitung kategori dari skor
        $category = $this->getCategory($result['score']);
    
        // Tampilkan hasil ke view
        return view('assessment_result', [
            'score' => $result['score'],
            'category_label' => $category['label'],
            'category_description' => $category['description'],
        ]);
    }
    

    // Fungsi untuk mendapatkan daftar pertanyaan
    private function getQuestions()
    {
        return [
            [
                'id' => 1,
                'question' => 'Seberapa sering Anda merasa cemas atau gelisah dalam seminggu terakhir?',
                'options' => [0, 1, 2, 3, 4, 5]
            ],
            [
                'id' => 2,
                'question' => 'Apakah Anda merasa sulit untuk tidur atau mempertahankan tidur yang nyenyak?',
                'options' => [0, 1, 2, 3, 4, 5]
            ],
            [
                'id' => 3,
                'question' => 'Seberapa sering Anda merasa tidak memiliki energi untuk melakukan aktivitas sehari-hari?',
                'options' => [0, 1, 2, 3, 4, 5]
            ],
            [
                'id' => 4,
                'question' => 'Apakah Anda merasa kesulitan untuk menikmati hal-hal yang biasanya menyenangkan?',
                'options' => [0, 1, 2, 3, 4, 5]
            ],
            [
                'id' => 5,
                'question' => 'Seberapa sering Anda merasa sulit untuk fokus atau berkonsentrasi?',
                'options' => [0, 1, 2, 3, 4, 5]
            ],
        ];
    }


    // Fungsi untuk menghitung kategori dari skor
    private function getCategory($score)
    {
        if ($score >= 0 && $score <= 49) {
            return [
                'label' => 'Normal',
                'description' => 'Anda tidak menunjukkan gejala stres atau kecemasan yang signifikan.'
            ];
        } elseif ($score >= 50 && $score <= 69) {
            return [
                'label' => 'Stres ringan',
                'description' => 'Gejala stres ringan terdeteksi, pertimbangkan teknik relaksasi.'
            ];
        } elseif ($score >= 70 && $score <= 89) {
            return [
                'label' => 'Stres sedang',
                'description' => 'Anda mungkin memerlukan dukungan lebih lanjut untuk mengelola stres.'
            ];
        } elseif ($score >= 90 && $score <= 100) {
            return [
                'label' => 'Stres berat',
                'description' => 'Disarankan untuk berkonsultasi dengan profesional kesehatan mental.'
            ];
        }
        return [
            'label' => 'Tidak Terdefinisi',
            'description' => 'Kategori ini tidak dapat ditentukan berdasarkan skor yang ada.'
        ];
    }

    public function updateResult()
    {
        $userModel = new UserModel();
        $assessmentModel = new AssessmentModel();

        $input = $this->request->getJSON();
        $email = $input->email ?? null;
        $password = $input->password ?? null;
        $responses = $input->responses ?? null;

        // Validasi input
        if (!$email || !$password || !$responses) {
            return $this->failValidationError('Email, password, and responses are required.');
        }

        // Validasi user
        $user = $userModel->where('email', $email)->first();
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->failUnauthorized('Invalid email or password.');
        }

        // Validasi responses
        if (!is_array($responses) || count($responses) !== 5) {
            return $this->failValidationError('Responses must be an array of 5 answers.');
        }

        $score = array_sum($responses) * 4;

        // Cek apakah sudah ada data sebelumnya
        $existingResult = $assessmentModel->where('user_id', $user['id'])->orderBy('created_at', 'DESC')->first();
        if ($existingResult) {
            // Update data yang ada
            $data = [
                'id' => $existingResult['id'], // ID untuk menentukan data mana yang akan di-update
                'responses' => json_encode($responses),
                'score' => $score,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($assessmentModel->save($data)) {
                $category = $this->getCategory($score);

                return $this->respondUpdated([
                    'status' => 'success',
                    'message' => 'Assessment updated successfully.',
                    'score' => $score,
                    'category' => $category,
                ]);
            }
        } else {
            // Jika tidak ada data, tambahkan baru
            $data = [
                'user_id' => $user['id'],
                'responses' => json_encode($responses),
                'score' => $score,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            if ($assessmentModel->save($data)) {
                $category = $this->getCategory($score);

                return $this->respondCreated([
                    'status' => 'success',
                    'message' => 'Assessment submitted successfully.',
                    'score' => $score,
                    'category' => $category,
                ]);
            }
        }

        return $this->fail($assessmentModel->errors());
    }

}
