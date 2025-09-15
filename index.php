<?php
session_start();
require_once(__DIR__ . '/config/db.php');
require_once(__DIR__ . '/Controller/UserController.php');
require_once(__DIR__ . '/Model/User.php');

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$message = "";

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $userGet = $user->getUserByUsername($_POST["username"], $_POST["password"]);
    print_r($userGet);
    if(empty($userGet)) {
        $message = "Nom d'utilisateur ou mot de passe incorrect.";
    } else {
        $_SESSION["user"] = $userGet["Username"];
        header("Location: Vue/gatepasses.php");
        exit();
    }
}


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
        <!-- Ajout du logo/brand -->
        <div style="display: flex; justify-content: center; margin-bottom: 1.5rem;">
            <img src="assets/img/brand.png" alt="Brand" style="height: 60px;">
        </div>
        <h2>Connexion</h2>
        <form class="auth-form" action="index.php" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <label for=""><?php echo $message; ?></label>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>

</html>