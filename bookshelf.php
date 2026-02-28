<?php
require_once __DIR__ . '/scripts/sessionStart.php';
require_once __DIR__ . "/classes/Books.php";
require_once __DIR__ . "/classes/BookDB.php";
require_once __DIR__ . '/scripts/DB/db.inc.php';
require_once __DIR__ . '/scripts/checkLoginStatus.php';
require_once __DIR__ . '/classes/Sorter.php';
require_once __DIR__ . '/templates/sortModes/bookSortModes.php';

mustBeLoggedIn();

$usersBooks = [];
if(isset($_SESSION['userID'])) {
    $bookDB = new BookDB($pdo);
    $usersBooks = $bookDB->userFetchAllBooks($_SESSION['userID']);
}

$sort = $_GET['sort'] ?? 'title_asc';
$usersBooks = Sorter::sort($usersBooks, $sort, $bookSortModes, 'title_asc');

$pageTitle = 'Din Bokhylle';
ob_start();
?>
<div class="page-content">
    <h1>Din Bokhylle</h1>

    <?php if(empty($usersBooks)): ?>
        <h2>Bokhyllen din er tom.</h2>
    <?php else: ?>
        <form method="get" id="sortForm">
            <label for="sort">Sorter etter:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="title_asc"   <?= $sort === 'title_asc'   ? 'selected' : '' ?>>Tittel (a-å)</option>
                <option value="title_desc"  <?= $sort === 'title_desc'  ? 'selected' : '' ?>>Tittel (å-a)</option>
                <option value="author_asc"  <?= $sort === 'author_asc'  ? 'selected' : '' ?>>Forfatter (a-å)</option>
                <option value="author_desc" <?= $sort === 'author_desc' ? 'selected' : '' ?>>Forfatter (å-a)</option>
                <option value="pages_asc"   <?= $sort === 'pages_asc'   ? 'selected' : '' ?>>Sider (lav-høy)</option>
                <option value="pages_desc"  <?= $sort === 'pages_desc'  ? 'selected' : '' ?>>Sider (høy-lav)</option>
            </select>
        </form>
        <?php foreach($usersBooks as $book): ?>
            <div class="bookItem">
                <?php include 'templates/bookCard.php'; ?>
                <button type="button" class="removeBookBtn" data-id="<?= $book->getBookId() ?>">Fjern boken fra hyllen</button>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<script>
document.querySelectorAll(".removeBookBtn").forEach(btn => {
    btn.addEventListener("click", async () => {
        const bookItem = btn.closest(".bookItem");
        const bookId = btn.dataset.id;

        if(!confirm("Er du sikker på du vil fjerne boken?")) return;

        const response = await fetch("api/handleBookshelf.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "remove", bookID: bookId })
        });

        const result = await response.json();
        alert(result.message);
        if(result.success) bookItem.remove();
    });
});
</script>
<?php
$pageContent = ob_get_clean();
include __DIR__ . '/templates/layout.php';
