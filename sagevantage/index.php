<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$username = $isLoggedIn ? $_SESSION['username'] : '';
$role = $isLoggedIn ? $_SESSION['role_id'] : '';

// Vérifier si l'utilisateur a un rôle d'admin
function isAdmin() {
    return isset($_SESSION['role_id']) && $_SESSION['role_id'] === 'admin';
}

// Vérifier si l'utilisateur a un rôle d'utilisateur standard
function isStandardUser() {
    return isset($_SESSION['role_id']) && $_SESSION['role_id'] === 'user';
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Sage et Vantage</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
            <h1>Sage/Vantage</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="tasks.html">Tâches</a></li>
                    <?php if ($isLoggedIn): ?>
                    <li><a href="users.php"><span>My Acc(<?php echo htmlspecialchars($username); ?>) </span></a></li>
                        <li><a href="logout.php">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="login.html">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="hero">
                <h2>Bienvenue dans l'application SAGE/VANTAGE</h2>
                <p>Gérez vos intégrations entre Sage et Vantage efficacement et facilement.</p>
                <a href="tasks.html" class="btn">Voir mes tâches</a>
            </section>
            <h2>Sage</h2>
            <section class="features">
                <div class="feature">
                    <h3>Gestion des tâches</h3>
                    <a href="" class="btn-main">Créez, mettez à jour et supprimez</a>
                </div>
                <div class="feature">
                    <h3>Suivi en temps réel</h3>
                    <a href="tasks.html" class="btn-main">Surveillez les intégrations</a>
                </div>
                <div class="feature">
                    <h3>Rapports détaillés</h3>
                    <a href="" class="btn-main">Générez des rapports</a>
                </div>
            </section>
            <h2>Vantage</h2>
            <section class="features">
                <div class="feature">
                    <h3>Gestion des tâches</h3>
                    <a href="tasks.html" class="btn-main">Créez, mettez à jour et supprimez</a>
                </div>
                <div class="feature">
                    <h3>Suivi en temps réel</h3>
                    <a href="tasks.html" class="btn-main">Surveillez les intégrations</a>
                </div>
                <div class="feature">
                    <h3>Rapports détaillés</h3>
                    <a href="" class="btn-main">Générez des rapports</a>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Intégration Sage et Vantage. Tous droits réservés by Bichrou Jalal Eddine.</p>
            <a href="rapport.php" class="btn-report">Report Error</a>
        </div>
    </footer>
</body>
</html>