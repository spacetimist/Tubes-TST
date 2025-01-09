<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .content {
            max-width: 800px;
            margin: 0 auto;
            text-align: justify;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome to GaneshaHealth</h1>
    <div class="content">
        <p>
            GaneshaHealth menyediakan alat untuk membantu Anda memahami kondisi mental Anda melalui serangkaian pertanyaan assessment. 
            Assessment ini dirancang untuk mengukur tingkat kecemasan, stres, dan kesejahteraan Anda dalam seminggu terakhir.
        </p>
        <h2>Cara Pengerjaan</h2>
        <p>
            Anda akan diberikan 5 pertanyaan yang masing-masing memiliki skala dari <strong>0</strong> hingga <strong>5</strong>, 
            dengan arti sebagai berikut:
        </p>
        <ul>
            <li><strong>0</strong>: Tidak pernah</li>
            <li><strong>1</strong>: Jarang</li>
            <li><strong>2</strong>: Cukup sering</li>
            <li><strong>3</strong>: Sering</li>
            <li><strong>4</strong>: Sangat sering</li>
            <li><strong>5</strong>: Selalu</li>
        </ul>
        <h2>Interpretasi Hasil</h2>
        <p>
            Skor total Anda akan dihitung berdasarkan jawaban yang diberikan, dan hasilnya dikategorikan sebagai berikut:
        </p>
        <ul>
            <li><strong>0 - 49</strong>: Normal (Anda tidak menunjukkan gejala stres atau kecemasan yang signifikan)</li>
            <li><strong>50 - 69</strong>: Stres ringan (Gejala stres ringan terdeteksi, pertimbangkan teknik relaksasi)</li>
            <li><strong>70 - 89</strong>: Stres sedang (Anda mungkin memerlukan dukungan lebih lanjut untuk mengelola stres)</li>
            <li><strong>90 - 100</strong>: Stres berat (Disarankan untuk berkonsultasi dengan profesional kesehatan mental)</li>
        </ul>
        <p>
            Kami sarankan untuk menjawab pertanyaan dengan jujur agar mendapatkan hasil yang akurat. Data Anda akan dijaga kerahasiaannya.
        </p>
    </div>
    <div class="button-container">
        <a href="/assessment/questions" class="btn">Lihat Assessment</a>
    </div>
</body>
</html>
