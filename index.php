<?php?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .auth-container {
            background: #181818;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            width: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .auth-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
            color: #e53935;
            width: 100%;
        }
        .auth-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .auth-form input[type="text"],
        .auth-form input[type="password"] {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #e53935;
            border-radius: 4px;
            background: #222;
            color: #fff;
            box-sizing: border-box;
        }
        .auth-form input[type="text"]::placeholder,
        .auth-form input[type="password"]::placeholder {
            color: #bbb;
        }
        .auth-form button {
            width: 100%;
            padding: 0.75rem;
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .auth-form button:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h2>Connexion</h2>
        <form class="auth-form" action="login.php" method="POST">
            <input type="text" name="username" placeholder="Nom d'utilisateur" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</body>
</html>