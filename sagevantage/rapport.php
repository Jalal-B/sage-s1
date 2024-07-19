<!-- la table rapport contient les champs suivants :
CREATE TABLE rapports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    date_generation DATETIME NOT NULL,
    user_id INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
); -->

<?php
session_start();

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'db');

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$rapport_genere = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $type = $_POST['type-rapport'];
    $date_fin = $_POST['date-fin'];
    $user_id = $_SESSION['user_id'];

    // Insertion du nouveau rapport dans la base de données
    $sql = "INSERT INTO rapports (type, date_fin, date_generation, user_id) 
            VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $type, $date_fin, $user_id);
    
    if ($stmt->execute()) {
        $rapport_genere = true;
    } else {
        echo "Erreur lors de la génération du rapport : " . $stmt->error;
    }
    $stmt->close();
}

// Récupération de tous les rapports
$sql = "SELECT r.*, u.username FROM rapports r 
        JOIN users u ON r.user_id = u.id 
        ORDER BY r.date_generation DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publier des Reports - Sage et Vantage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="rapport.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Intégration Sage/Vantage</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Accueil</a></li>
                    <li><a href="tasks.html">Tâches</a></li>
                    <li><a href="users.php">Profil</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="rapport-section">
                <h2>Publier des Reports</h2>
                <form action="rapport.php" method="post" class="rapport-form">
                    <div class="form-group">
                        <label for="type-rapport">Type de rapport :</label>
                        <input type="text" id="type-rapport" name="type-rapport" required>
                    </div>
                    <div class="form-group">
                        <label for="date-fin">Date:</label>
                        <input type="date" id="date-fin" name="date-fin" required>
                    </div>
                    <button type="submit" class="btn">Publier le report</button>
                </form>
            </section>
            
            <?php if ($rapport_genere): ?>
            <section class="rapport-resultat">
                <h3>Report publier avec succès</h3>
            </section>
            <?php endif; ?>

            <section class="rapports-liste">
                <h3>Liste des reports publier</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>Date </th>
                            <th>Date de génération</th>
                            <th>Utilisateur</th>
                        </tr>
                    <tbody>
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['type']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_fin']); ?></td>
                            <td><?php echo htmlspecialchars($row['date_generation']); ?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
    <footer>
        <div class="container">
            <p>&copy; 2024 Intégration Sage et Vantage. Tous droits réservés by Bichrou Jalal Eddine.</p>
        </div>
    </footer>
</body>
</html>

<?php
$conn->close();
?>