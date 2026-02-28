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

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Move every modal overlay to <body> so position:fixed works from the viewport.
    // Without this, a CSS transform on an ancestor (.book:hover) creates a new
    // stacking context that breaks position:fixed for children.
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        document.body.appendChild(overlay);
    });

    function closeAllModals() {
        document.querySelectorAll('.modal-overlay.open').forEach(o => {
            o.classList.remove('open');
        });
        document.body.classList.remove('modal-open');
    }

    // Open
    document.querySelectorAll('[data-open-modal]').forEach(el => {
        el.addEventListener('click', () => {
            const overlay = document.getElementById(el.dataset.openModal);
            if (!overlay) return;
            overlay.classList.add('open');
            document.body.classList.add('modal-open');
        });
    });

    // Close via × button
    document.querySelectorAll('[data-close-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            const overlay = document.getElementById(btn.dataset.closeModal);
            if (!overlay) return;
            overlay.classList.remove('open');
            document.body.classList.remove('modal-open');
        });
    });

    // Close by clicking the dark backdrop
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', e => {
            if (e.target === overlay) closeAllModals();
        });
    });

    // Close on Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeAllModals();
    });
});
</script>
</body>
</html>
