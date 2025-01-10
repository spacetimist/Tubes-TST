<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommendations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1, h2 {
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .section {
            margin-bottom: 20px;
        }
        ul {
            padding-left: 20px;
        }
        ul li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Recommendations</h1>
        <div class="section">
            <h2>Assessment Result</h2>
            <p><strong>Category:</strong> <?= $category; ?></p>
            <p><strong>Description:</strong> <?= $description; ?></p>
        </div>

        <?php if (!empty($articles)): ?>
        <div class="section">
            <h2>Recommended Articles</h2>
            <ul>
                <?php foreach ($articles as $article): ?>
                    <li>
                        <a href="<?= $article['link']; ?>" target="_blank"><?= $article['title']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if (!empty($psychologists)): ?>
        <div class="section">
            <h2>Recommended Psychologists</h2>
            <p><strong>Specialist:</strong> <?= ucfirst($specialist); ?></p>
            <ul>
                <?php foreach ($psychologists as $psychologist): ?>
                    <?php if ($psychologist['specialist'] == $specialist): // Filter based on specialist ?>
                        <li>
                            <?= $psychologist['psychologist_name']; ?> (<?= $psychologist['specialist']; ?>)
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
