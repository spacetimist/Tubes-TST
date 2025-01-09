<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Result</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .result {
            font-size: 1.5em;
            color: #4CAF50;
        }
        .category {
            font-size: 1.2em;
            color: #FF5722;
        }
        .description {
            font-size: 1em;
            color: #555;
            margin-top: 10px;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Hasil Assessment Anda</h1>
    <p class="result">Skor Anda: <?= $score; ?></p>
    <p class="category">Kategori: <?= $category_label; ?></p>
    <p class="description"><?= $category_description; ?></p>
    <a href="/" class="btn">Kembali ke Dashboard</a>
</body>
</html>
