<?php
session_start();
if(!isset($_SESSION["user"])){
    header("Location: ../index.php");
    exit();
}
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/gatepassform.css">
    <title>Get Pass Form</title>
    <style>
        body {
            margin: 0;
            background: #111;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 2rem;
            margin-right: 2rem;
        }
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
        }
        .user-name {
            color: #fff;
            background: #181818;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: bold;
        }
        .logout-btn {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container {
            background: #181818;
            padding: 2rem 2.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            width: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .form-container h2 {
            margin-bottom: 1.5rem;
            text-align: center;
            color: #e53935;
            width: 100%;
        }
        .getpass-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .getpass-form input[type="text"],
        .getpass-form input[type="number"],
        .getpass-form textarea {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #e53935;
            border-radius: 4px;
            background: #222;
            color: #fff;
            box-sizing: border-box;
            resize: none;
        }
        .getpass-form input[type="text"]::placeholder,
        .getpass-form input[type="number"]::placeholder,
        .getpass-form textarea::placeholder {
            color: #bbb;
        }
        .getpass-form button {
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
        .getpass-form button:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="main-content">
        <div class="top-bar">
            <span class="user-name"><?php echo htmlspecialchars($user); ?></span>
            <form action="../Controller/logout.php" method="POST" style="margin:0;">
                <button type="submit" class="logout-btn">Déconnexion</button>
            </form>
        </div>
        <div class="form-container">
            <h2>Gate Pass Form</h2>
            <form class="getpass-form" action="../Controller/addgatepass.php" method="POST">
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
    </div>
</body>
</html>