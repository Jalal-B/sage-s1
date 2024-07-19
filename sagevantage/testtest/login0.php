<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db');

// Vérifier la connexion à la base de données
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données : " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer et valider les données du formulaire
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Validation basique
    if (empty($username) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
    } else {
        $username = $conn->real_escape_string($username);
        $sql = "SELECT id, username, password, role_id FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        // Vérifier si un utilisateur a été trouvé
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Vérifier le mot de passe
            if (password_verify($password, $row['password'])) {
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['role_id'] = $row['role_id'];
                echo "Connexion réussie.";
                
                // Redirection basée sur le rôle de l'utilisateur
                if ($row['role_id'] == 1) {
                    header("Location: admin.php"); // Rediriger vers la page d'administration
                } else {
                    header("Location: user.php"); // Rediriger vers la page utilisateur
                }
                exit;
            } else {
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}

?>
