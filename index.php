<?php
session_start();
require_once 'config/Database.php';
require_once 'controller/UserController.php';

$database = new Database();
$db = $database->getConnection();

$controller = new UserController($db);

// Test avec un nom d'utilisateur
$controller->showUser("admin");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Authentification</title>
</head>
<body>
    <div class="auth-container">
        <h2>Connexion</h2>
        <form class="auth-form" action="index.php" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>