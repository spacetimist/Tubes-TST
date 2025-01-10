<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class RecommendationController extends ResourceController
{
    private function callApi($method, $url, $params = [])
    {
        $client = \Config\Services::curlrequest(); // Menggunakan layanan curl bawaan CodeIgniter
        
        // Pilihan berdasarkan metode HTTP
        $options = [];
        if ($method === 'GET' && !empty($params)) {
            $url .= '?' . http_build_query($params);
        } elseif ($method === 'POST') {
            $options['form_params'] = $params;
        }
    
        try {
            $response = $client->request($method, $url, $options);
            return json_decode($response->getBody(), true); // Decode hasil JSON ke array
        } catch (\Exception $e) {
            return null; // Tangani kesalahan dengan mengembalikan null
        }
    }

    public function recommendations()
    {
        $userId = $this->request->getGet('user_id'); // Ambil user_id dari query string
    
        if (!$userId) {
            return $this->failValidationError('User ID is required.');
        }
    
        // Panggil API GaneshaHealth untuk hasil assessment
        $assessment = $this->callApi('GET', 'https://yasrazhaf.my.id/assessment/resultJSON?user_id=' . $userId);
    
        // if (!$assessment || $assessment['status'] !== 'success') {
        //     return $this->fail('Unable to fetch assessment data.');
        // }
    
        $category = $assessment['category']['label']; // Ambil label kategori
    
        // Tentukan spesialisasi berdasarkan kategori
        $specialist = null;
        if ($category === 'Stres ringan') {
            $specialist = 'konseling';
        } elseif ($category === 'Stres sedang') {
            $specialist = 'klinis';
        } elseif ($category === 'Stres berat') {
            $specialist = 'Psikiater';
        }
    
        // Jika kategori adalah "Normal", hanya rekomendasikan artikel
        if ($category === 'Normal') {
            $articles = $this->callApi('GET', 'https://asa99.my.id/articles');
    
            return view('recommendation', [
                'category' => $category,
                'description' => $assessment['category']['description'],
                'articles' => $articles,
                'psychologists' => [], // Tidak ada psikolog untuk kategori Normal
                'specialist' => null,
            ]);
        }
    
        // Untuk kategori lain, rekomendasikan psikolog berdasarkan spesialisasi
        $psychologists = $this->callApi('GET', 'https://asa99.my.id/appointments/available', ['specialist' => $specialist]);
        $articles = $this->callApi('GET', 'https://asa99.my.id/articles');
    
        return view('recommendation', [
            'category' => $category,
            'description' => $assessment['category']['description'],
            'articles' => $articles,
            'psychologists' => $psychologists,
            'specialist' => $specialist,
        ]);
    }
    
    
    
    

    // Endpoint untuk meneruskan proses booking
    public function book()
    {
        // Implementasi layanan booking
    }
}
