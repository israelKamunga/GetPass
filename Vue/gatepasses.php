<?php
session_start();
require_once(__DIR__ . '/../Model/User.php');
require_once(__DIR__ . '/../config/db.php');
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}
$username = $_SESSION["user"];
$search_date = $_GET['search_date'] ?? '';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Récupération des gatepass
$gatepasses = $user->getAllGatePasses();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des GatePass</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            background: #111;
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        .top-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 1rem;
            margin: 1rem 2rem 2rem 2rem;
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
        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }
        .search-bar input[type="date"] {
            padding: 0.5rem;
            border-radius: 4px;
            border: 1px solid #e53935;
            background: #222;
            color: #fff;
            margin-right: 1rem;
        }
        a{
            text-decoration: none;
            color: white;
        }
        .search-bar button, .search-bar .new-gatepass-btn {
            background: #e53935;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .search-bar button:hover, .search-bar .new-gatepass-btn:hover {
            background: #b71c1c;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
        }
        .gatepass-card {
            background: #181818;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            padding: 1.5rem;
            width: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .gatepass-card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 24px rgba(229,57,53,0.3);
            z-index: 2;
        }
        .gatepass-card h3 {
            color: #e53935;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }
        .gatepass-details {
            width: 100%;
            margin-bottom: 1rem;
        }
        .gatepass-details p {
            margin: 0.3rem 0;
            font-size: 0.98rem;
        }
        .qr-box {
            margin-top: 1rem;
            background: #222;
            padding: 1rem;
            border-radius: 8px;
        }
        .print-btn {
            margin-top: 1rem;
            background: #e53935;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .print-btn:hover {
            background: #b71c1c;
        }
        @media (max-width: 700px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <span class="user-name"><?php echo htmlspecialchars($username['username'] ?? $username['name'] ?? $username); ?></span>
        <form action="../Controller/logout.php" method="POST" style="margin:0;">
            <button type="submit" class="logout-btn">Déconnexion</button>
        </form>
    </div>
    <div class="search-bar">
        <a href="GatePassForm.php" class="new-gatepass-btn">Nouveau GatePass</a>
        <form method="GET" action="" style="display: flex; align-items: center;">
            <input type="date" name="search_date" value="<?php echo htmlspecialchars($search_date); ?>">
            <button type="submit">Rechercher</button>
        </form>
    </div>
    <div class="cards-container">
        <?php foreach ($gatepasses as $gp): ?>
            <div class="gatepass-card" id="card-<?php echo htmlspecialchars($gp['GATEPASS_ID']); ?>">
                <h3>GatePass #<?php echo htmlspecialchars($gp['id'] ?? ''); ?></h3>
                <div class="gatepass-details">
                    <p><strong>ID HOD/Manager:</strong> <?php echo htmlspecialchars($gp['ID_HOD']); ?></p>
                    <p><strong>Nom HOD/Manager:</strong> <?php echo htmlspecialchars($gp['NAME_HOD']); ?></p>
                    <p><strong>ID Supervisor:</strong> <?php echo htmlspecialchars($gp['ID_SUPERVISOR']); ?></p>
                    <p><strong>Nom Supervisor:</strong> <?php echo htmlspecialchars($gp['NAME_SUPERVISOR']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($gp['DESCRIPTION']); ?></p>
                    <p><strong>Quantité:</strong> <?php echo htmlspecialchars($gp['QUANTITY']); ?></p>
                    <p><strong>Destination:</strong> <?php echo htmlspecialchars($gp['Destination']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($gp['CREATED_AT'] ?? ''); ?></p>
                </div>
                <div class="qr-box">
                    <div id="qr-<?php echo htmlspecialchars($gp['GATEPASS_ID']); ?>"></div>
                </div>
                <button class="print-btn"><a href="printgatepass.php?gatepassid=<?php echo htmlspecialchars($gp['GATEPASS_ID']);?>">Imprimer</a></button>
            </div>
        <?php endforeach; ?>
    </div>
    <script>
        <?php foreach ($gatepasses as $gp): 
            $qrData = json_encode([
                'id_hod_manager' => $gp['ID_HOD'],
                'name_hod_manager' => $gp['NAME_HOD'],
                'id_supervisor' => $gp['ID_SUPERVISOR'],
                'name_supervisor' => $gp['NAME_SUPERVISOR'],
                'description' => $gp['DESCRIPTION'],
                'quantity' => $gp['QUANTITY'],
                'destination' => $gp['Destination'],
                'created_at' => $gp['CREATED_AT'] ?? ''
            ]);
        ?>
        new QRCode(document.getElementById('qr-<?php echo htmlspecialchars($gp['GATEPASS_ID']); ?>'), {
            text: <?php echo json_encode($qrData); ?>,
            width: 200,
            height: 200,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });
        console.log(<?php echo json_encode($qrData); ?>);
        <?php endforeach; ?>

        function printCard(cardId) {
            var card = document.getElementById(cardId);
            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><title>Impression GatePass</title>');
            printWindow.document.write('<style>body{font-family:Arial,sans-serif;background:#fff;color:#000;} .gatepass-card{background:#fff;padding:2rem;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.1);width:320px;margin:auto;} .gatepass-details p{margin:0.3rem 0;} .qr-box{margin-top:1rem;}</style>');
            printWindow.document.write('</head><body >');
            printWindow.document.write(card.outerHTML);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function(){ printWindow.print(); printWindow.close(); }, 500);
        }
    </script>
</body>
</html>