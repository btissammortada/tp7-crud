
<?php
require_once "../database/connexion.php";

// Vérifier l'identifiant
if (!isset($_POST["id"]) || !is_numeric($_POST["id"])) {
    die("Identifiant du module invalide.");
}

$id = (int) $_POST["id"];

// Récupérer le module
$sql = "SELECT m.*, f.nom AS nom_formation
        FROM module m
        JOIN formation f ON m.id_formation = f.id_formation
        WHERE m.id_module = ?";

$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$module = $stmt->fetch();

if (!$module) {
    die("Module introuvable.");
}

// Confirmer la suppression
if (isset($_POST["confirmer"])) {

    $stmt = $pdo->prepare("DELETE FROM module WHERE id_module = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer un module</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 550px;
            margin: 70px auto;
        }

        .carte {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 18px #0002;
            text-align: center;
            border-top: 5px solid #dc3545;
        }

        .icone {
            font-size: 55px;
            margin-bottom: 15px;
        }

        h1 {
            color: #2456a6;
            margin-bottom: 15px;
        }

        .message {
            color: #666;
            line-height: 1.7;
        }

        .information {
            background: #f1f4f9;
            padding: 18px;
            border-radius: 8px;
            margin: 25px 0;
            text-align: left;
        }

        .information p { margin: 8px 0; }

        .boutons {
            display: flex;
            gap: 12px;
            margin-top: 25px;
        }

        .btn {
            flex: 1;
            padding: 13px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-supprimer {
            background: #dc3545;
            color: white;
        }

        .btn-supprimer:hover { background: #b02a37; }

        .btn-annuler {
            background: #2456a6;
            color: white;
        }

        .btn-annuler:hover { background: #173c78; }

        @media (max-width: 450px) {
            .boutons { flex-direction: column; }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="carte">

        <div class="icone">⚠️</div>

        <h1>Confirmer la suppression</h1>

        <p class="message">
            Êtes-vous sûr de vouloir supprimer ce module ?
            Cette action est définitive.
        </p>

        <div class="information">

            <p><strong>Nom :</strong>
                <?= htmlspecialchars($module['nom']) ?></p>

            <p><strong>Volume horaire :</strong>
                <?= htmlspecialchars($module['volume_horaire']) ?> heures</p>

            <p><strong>Coefficient :</strong>
                <?= htmlspecialchars($module['coefficient']) ?></p>

            <p><strong>Formation :</strong>
                <?= htmlspecialchars($module['nom_formation']) ?></p>

        </div>

        <form method="POST">

            <input type="hidden" name="id"
                   value="<?= htmlspecialchars($id) ?>">

            <div class="boutons">

                <button type="submit" name="confirmer"
                        class="btn btn-supprimer">
                    Oui, supprimer
                </button>

                <a href="index.php" class="btn btn-annuler">
                    Annuler
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
