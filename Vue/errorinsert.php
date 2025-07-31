<?php
session_start()
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Erreur</title>
    <style>
        body {
            background: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-box {
            background: #181818;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            text-align: center;
        }
        .error-message {
            color: #e53935;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
        }
        .back-btn {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }
        .back-btn:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="error-box">
        <div class="error-message">
            Une erreur est survenue lors de l'enregistrement du formulaire.<br>
            Veuillez réessayer.
        </div>
        <a href="GatePassForm.php" class="back-btn">Retour</a>