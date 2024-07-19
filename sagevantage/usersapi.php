<?php
// Fonction pour ajouter un utilisateur dans Sage
function addUserToSage($username, $password, $role_id) {
    $url = 'https://api.sage.com/users'; // URL de l'API Sage
    $data = [
        'username' => $username,
        'password' => $password,
        'role_id' => $role_id
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        die('Error adding user to Sage');
    }
    
    return json_decode($result, true);
}

// Fonction pour ajouter un utilisateur dans Vantage
function addUserToVantage($username, $password, $role_id) {
    $url = 'https://api.vantage.com/users'; // URL de l'API Vantage
    $data = [
        'username' => $username,
        'password' => $password,
        'role_id' => $role_id
    ];
    
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data)
        ]
    ];
    
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        die('Error adding user to Vantage');
    }
    
    return json_decode($result, true);
}

// Ajouter un utilisateur dans les deux systèmes
function addUser($username, $password, $role_id) {
    $sageResult = addUserToSage($username, $password, $role_id);
    $vantageResult = addUserToVantage($username, $password, $role_id);
    
    return [
        'sage' => $sageResult,
        'vantage' => $vantageResult
    ];
}

// Exemple d'utilisation
$username = 'newuser';
$password = 'password123';
$role_id = 'admin';

$results = addUser($username, $password, $role_id);
print_r($results);
?>
