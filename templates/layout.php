<?php
$scriptPath = dirname($_SERVER['SCRIPT_NAME']);
$baseUrl = str_replace('/Script', '', $scriptPath);
?>
<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'BookFinder') ?></title>

    <!-- Fonts: preconnect first so the font request starts in parallel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Lato:ital,wght@0,300;0,400;0,700;1,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= $baseUrl ?>/css/stylesheet.css">

    <?= $extraHead ?? '' ?>
</head>
<body>
<?php include __DIR__ . '/../scripts/navbar.php'; ?>
<?= $pageContent ?>
</body>
</html>
