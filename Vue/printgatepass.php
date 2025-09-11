<?php
session_start();
if (empty($_SESSION["user"]) || empty($_GET['gatepassid'])) {
    header("Location: ../index.php");
    exit();
}
$username = $_SESSION["user"];

// Exemple de récupération d'un gatepass (à adapter selon ton code)
require_once(__DIR__ . '/../Model/User.php');
require_once(__DIR__ . '/../config/db.php');
$database = new Database();
$db = $database->getConnection();
$user = new User($db);

// Ici, récupère le gatepass à afficher (par exemple via $_GET['id'])
$gatepass_id = $_GET['gatepassid'] ?? null;
$gatepass = null;
if ($gatepass_id) {
    $gatepass = $user->getGatePassById($gatepass_id); // À adapter selon ta méthode
}
//print($gatepass);
// Images à utiliser pour le header et le footer
$header_img = "../assets/img/header.jpg"; // Mets le chemin de ton image
$footer_img = "../assets/img/footer.jpg"; // Mets le chemin de ton image
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Détail GatePass</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            margin: 0;
            background: #ffffffff;
            color: #fff;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header-img {
            width: 100vw;
            height: 180px;
            object-fit: cover;
            display: block;
        }

        .main-content {
            flex: 1;
            padding: 2rem 0 2rem 0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .user-bar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 1rem 2rem 0 0;
        }

        .user-name {
            color: #fff;
            background: #181818;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-weight: bold;
        }

        .gatepass-details-box {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 3rem;
            margin-top: 2rem;
        }

        .gatepass-labels {
            background: #181818;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 2rem;
            min-width: 320px;
        }

        .gatepass-labels p {
            margin: 1rem 0;
            font-size: 1.05rem;
        }

        .qr-box {
            background: #222;
            padding: 1rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 200px;
            min-height: 200px;
        }

        .signature-label {
            position: absolute;
            right: 2rem;
            bottom: 2rem;
            background: #181818;
            color: #fff;
            padding: 0.7rem 2rem;
            border-radius: 8px;
            font-size: 1.1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header {
            background-image: url('../assets/img/header.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 250px;
            background-position: center;
        }

        .footer {
            background-image: url('../assets/img/footer.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100vw;
            height: 250px;
            background-position: center;
        }

        @media (max-width: 900px) {
            .gatepass-details-box {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }

            .signature-label {
                position: static;
                margin: 2rem auto 0 auto;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="header"></div>
    <div class="main-content">
        <div class="user-bar">
            <span
                class="user-name"><?php echo htmlspecialchars($username['username'] ?? $username['name'] ?? $username); ?></span>
        </div>
        <div class="gatepass-details-box">
            <div class="gatepass-labels">
                <?php if ($gatepass): ?>
                    <p><strong>ID HOD/Manager:</strong> <?php echo htmlspecialchars($gatepass['ID_HOD']); ?></p>
                    <p><strong>Nom HOD/Manager:</strong> <?php echo htmlspecialchars($gatepass['NAME_HOD']); ?></p>
                    <p><strong>ID Supervisor:</strong> <?php echo htmlspecialchars($gatepass['ID_SUPERVISOR']); ?></p>
                    <p><strong>Nom Supervisor:</strong> <?php echo htmlspecialchars($gatepass['NAME_SUPERVISOR']); ?></p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($gatepass['DESCRIPTION']); ?></p>
                    <p><strong>Quantité:</strong> <?php echo htmlspecialchars($gatepass['QUANTITY']); ?></p>
                    <p><strong>Destination:</strong> <?php echo htmlspecialchars($gatepass['Destination']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($gatepass['CREATED_AT'] ?? ''); ?></p>
                <?php else: ?>
                    <p>Aucun gatepass trouvé.</p>
                <?php endif; ?>
            </div>
            <div class="qr-box">
                <div id="qr-code"></div>
            </div>
        </div>
        <div class="signature-label">
            Signature
        </div>
    </div>
    <div class="footer"></div>
    <script>
        <?php if ($gatepass):
            $qrData = json_encode([
                'id_hod_manager' => $gatepass['ID_HOD'],
                'name_hod_manager' => $gatepass['NAME_HOD'],
                'id_supervisor' => $gatepass['ID_SUPERVISOR'],
                'name_supervisor' => $gatepass['NAME_SUPERVISOR'],
                'description' => $gatepass['DESCRIPTION'],
                'quantity' => $gatepass['QUANTITY'],
                'destination' => $gatepass['Destination'],
                'created_at' => $gatepass['CREATED_AT'] ?? ''
            ]);
            ?>
            new QRCode(document.getElementById('qr-code'), {
                text: <?php echo json_encode($qrData); ?>,
                width: 200,
                height: 200,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        <?php endif; ?>

        window.addEventListener("load", function() {
            window.print();
        });
    </script>
</body>