<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'db');

if (isset( $_POST['username']) && isset($_POST['password'])) {
    // Récupérer et valider les données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $username = filter_input(INPUT_POST,'username');

    $username = htmlentities(mysqli_real_escape_string($conn, $_POST['username']));
    $password = htmlentities(mysqli_real_escape_string($conn, $_POST['password']));

    // Validation basique
    if (empty($username) || empty($password)) {
        echo "Veuillez remplir tous les champs.";
    } else {
        $sql= "SELECT id,username FROM users  WHERE username='$username' AND password='$password'";
        $result= mysqli_query($conn,$sql);
        $row= mysqli_fetch_array($result);
        if ($row['username'] == $username && $row['password'] == $password){
            $_SESSION['username']= $row['username'];
            $_SESSION['id']= $row['id'];
            echo "Connexion réussie.";
            header("Location: index.html");
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}
?>