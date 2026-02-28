<?php
require_once __DIR__ . '/scripts/sessionStart.php';
require_once __DIR__ . '/scripts/checkLoginStatus.php';
mustBeLoggedIn();

$pageTitle = 'Brukerside';
ob_start();
?>
<div class="page-content">
    <h1>Brukerside</h1>
    <?php if(isset($_SESSION['userID'])): ?>
        <table>
            <tr>
                <th>BrukerID</th>
                <th>Fornavn</th>
                <th>Etternavn</th>
                <th>Email</th>
                <?php if(checkAdmin()): ?>
                    <th>Brukertype</th>
                <?php endif; ?>
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($_SESSION['userID'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?php echo htmlspecialchars($_SESSION['fornavn'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?php echo htmlspecialchars($_SESSION['etternavn'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?php echo htmlspecialchars($_SESSION['email'], ENT_QUOTES, 'UTF-8') ?></td>
                <?php if(checkAdmin()): ?>
                    <td>Admin</td>
                <?php endif; ?>
            </tr>
        </table><br>
        <form action="Scripts/userDelete.php" method="post" onsubmit="return confirm('Er du sikker på at du vil slette brukeren?');">
            <button type="submit">Slett bruker</button>
        </form>
    <?php endif; ?>
</div>
<?php
$pageContent = ob_get_clean();
include __DIR__ . '/templates/layout.php';
