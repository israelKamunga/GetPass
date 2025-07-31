<?php
session_start();
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/UserController.php');
require_once(__DIR__ . '/../Model/User.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $data = [
        'id_hod_manager'   => $_POST['id_hod_manager'] ?? '',
        'name_hod_manager' => $_POST['name_hod_manager'] ?? '',
        'id_supervisor'    => $_POST['id_supervisor'] ?? '',
        'name_supervisor'  => $_POST['name_supervisor'] ?? '',
        'description'      => $_POST['description'] ?? '',
        'quantity'         => $_POST['quantity'] ?? '',
        'destination'      => $_POST['destination'] ?? ''
    ];

    // Connexion à la base de données et insertion
    $database = new Database();
    $db = $database->getConnection();
    $user = new User($db);

    $result = $user->insertGatePass($data);

    if ($result) {
        // Redirection ou message de succès
        header("Location: ../Vue/succesinsert.php");
        exit();
    } else {
        // Redirection ou message d'erreur
        header("Location: ../Vue/errorinsert.php");
        exit();
    }
} else {
    // Accès direct interdit
    header("Location: ../Vue/GatePassForm.php");
    exit();
}