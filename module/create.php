
<?php
require_once "../database/connexion.php";

// Récupérer les formations
$formations = $pdo->query("SELECT * FROM formation ORDER BY nom ASC")->fetchAll();

// Ajouter un module
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"]);
    $volume_horaire = trim($_POST["volume_horaire"]);
    $coefficient = trim($_POST["coefficient"]);
    $id_formation = $_POST["id_formation"];

    $sql = "INSERT INTO module (nom, volume_horaire, coefficient, id_formation)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $volume_horaire, $coefficient, $id_formation]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un module</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container { max-width: 650px; margin: auto; }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        h1 { color: #2456a6; }
        .header p { color: #777; }

        .formulaire {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 18px #0002;
            border-top: 5px solid #2456a6;
        }

        h2 {
            color: #2456a6;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group { margin-bottom: 22px; }

        label {
            display: block;
            margin-bottom: 9px;
            font-weight: bold;
            color: #344563;
        }

        input, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #d5dce8;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background: #fafcff;
        }

        input:focus, select:focus {
            border-color: #2456a6;
            box-shadow: 0 0 0 3px #2456a622;
        }

        .boutons {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-size: 15px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-ajouter {
            background: #2456a6;
            color: white;
        }

        .btn-ajouter:hover { background: #173c78; }

        .btn-annuler {
            background: #e8edf5;
            color: #344563;
        }

        .btn-annuler:hover { background: #d8e0ec; }

        @media (max-width: 500px) {
            .formulaire { padding: 22px; }
            .boutons { flex-direction: column; }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Gestion des modules</h1>
        <p>Ajouter un nouveau module au centre de formation</p>
    </div>

    <div class="formulaire">

        <h2>Informations du module</h2>

        <form method="POST">

            <div class="form-group">
                <label for="nom">Nom du module</label>
                <input type="text" id="nom" name="nom" required>
            </div>

            <div class="form-group">
                <label for="volume_horaire">Volume horaire</label>
                <input type="number" id="volume_horaire"
                       name="volume_horaire" min="1" required>
            </div>

            <div class="form-group">
                <label for="coefficient">Coefficient</label>
                <input type="number" id="coefficient"
                       name="coefficient" min="1" step="any" required>
            </div>

            <div class="form-group">
                <label for="id_formation">Choisir une formation</label>

                <select name="id_formation" id="id_formation" required>
                    <option value="">-- Choisir une formation --</option>

                    <?php foreach ($formations as $f): ?>
                        <option value="<?= htmlspecialchars($f['id_formation']) ?>">
                            <?= htmlspecialchars($f['nom']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="boutons">
                <button type="submit" class="btn btn-ajouter">
                    + Ajouter le module
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
