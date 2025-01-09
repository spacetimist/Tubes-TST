<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assessment Questions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        .scale-info {
            text-align: center;
            margin-bottom: 20px;
            font-style: italic;
            color: #555;
        }
        .question {
            margin-bottom: 20px;
        }
        .options {
            list-style: none;
            padding: 0;
        }
        .options li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Assessment Questions</h1>
    <p class="scale-info"><?= $scale_info; ?></p>
    <form method="" action="">
        <?php foreach ($questions as $question): ?>
            <div class="question">
                <p><strong><?= $question['id'] . '. ' . $question['question']; ?></strong></p>
                <ul class="options">
                    <?php foreach ($question['options'] as $option): ?>
                        <li>
                            <label>
                                <input type="radio" name="responses[<?= $question['id']; ?>]" value="<?= $option; ?>" required>
                                <?= $option; ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <button type="submit">Submit Assessment</button>
    </form>
</body>
</html>
