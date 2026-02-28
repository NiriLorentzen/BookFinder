<?php
require_once __DIR__ . '/scripts/sessionStart.php';
require_once __DIR__ . '/scripts/checkLoginStatus.php';
require_once __DIR__ . '/api/booksAPI.php';

$canSaveBook = true;

if($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['bookRec'])) {
    try {
        $api = new GoogleBooksApi();
        $recommendations = $api->fetchBooks($_GET['bookRec']);
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

$pageTitle = 'Bokdatabase';
$extraHead = '<script src="scripts/JS/buttons.js" defer></script>';
ob_start();
?>
<div class="page-content">
    <h1>BookFinder</h1>

    <form method="get" action="">
        <label for="bookRec">Bok database!:</label><br>
        <input type="text" id="bookRec" placeholder="Søk med navn, forfatter" name="bookRec" value="<?= htmlspecialchars($_GET['bookRec'] ?? '') ?>"><br>
        <button type="submit">Søk</button>
    </form>

    <?php if(!empty($recommendations)): ?>
        <div id="results">
            <?php foreach ($recommendations as $book): ?>
                <?php include __DIR__ . '/templates/bookCard.php'; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script>
window.addEventListener('DOMContentLoaded', () => {
    saveBookBtn();
});
</script>
<?php
$pageContent = ob_get_clean();
include __DIR__ . '/templates/layout.php';
