<?php
session_start();
if(!isset($_SESSION["Utilisateur"])){
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/gatepassform.css">
    <title>Get Pass Form</title>
</head>
<body>
    <div class="form-container">
        <h2>Gate Pass Form</h2>
        <form class="getpass-form" action="#" method="POST">
            <input type="text" name="id_hod_manager" placeholder="ID HOD or Manager" required>
            <input type="text" name="name_hod_manager" placeholder="Name (HOD or Manager)" required>
            <input type="text" name="id_supervisor" placeholder="ID Supervisor" required>
            <input type="text" name="name_supervisor" placeholder="Name (Supervisor)" required>
            <textarea name="description" placeholder="Description" rows="3" required></textarea>
            <input type="number" name="quantity" placeholder="Quantity" min="1" required>
            <input type="text" name="destination" placeholder="Destination" required>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>