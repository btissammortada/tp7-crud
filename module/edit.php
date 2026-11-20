
<?php
require_once "../database/connexion.php";

// Vérifier l'identifiant
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("Identifiant du module invalide.");
}

$id = (int) $_GET["id"];

// Récupérer le module
$stmt = $pdo->prepare("SELECT * FROM module WHERE id_module = ?");
$stmt->execute([$id]);
$module = $stmt->fetch();

if (!$module) {
    die("Module introuvable.");
}

// Récupérer les formations
$formations = $pdo->query("SELECT * FROM formation ORDER BY nom ASC")->fetchAll();

// Modifier le module
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"]);
    $volume_horaire = trim($_POST["volume_horaire"]);
    $coefficient = trim($_POST["coefficient"]);
    $id_formation = $_POST["id_formation"];

    $sql = "UPDATE module
            SET nom = ?, volume_horaire = ?, coefficient = ?, id_formation = ?
            WHERE id_module = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $volume_horaire, $coefficient, $id_formation, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un module</title>

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

        .btn-modifier {
            background: #2456a6;
            color: white;
        }

        .btn-modifier:hover { background: #173c78; }

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
        <p>Modifier les informations d'un module</p>
    </div>

    <div class="formulaire">

        <h2>Informations du module</h2>

        <form method="POST">

            <div class="form-group">
                <label for="nom">Nom du module</label>
                <input type="text" id="nom" name="nom"
                       value="<?= htmlspecialchars($module['nom']) ?>"
                       required>
            </div>

            <div class="form-group">
                <label for="volume_horaire">Volume horaire</label>
                <input type="number" id="volume_horaire"
                       name="volume_horaire"
                       value="<?= htmlspecialchars($module['volume_horaire']) ?>"
                       min="1" required>
            </div>

            <div class="form-group">
                <label for="coefficient">Coefficient</label>
                <input type="number" id="coefficient"
                       name="coefficient"
                       value="<?= htmlspecialchars($module['coefficient']) ?>"
                       min="1" step="any" required>
            </div>

            <div class="form-group">
                <label for="id_formation">Formation</label>

                <select name="id_formation" id="id_formation" required>

                    <?php foreach ($formations as $f): ?>
                        <option value="<?= htmlspecialchars($f['id_formation']) ?>"
                            <?= $f['id_formation'] == $module['id_formation'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['nom']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <div class="boutons">
                <button type="submit" class="btn btn-modifier">
                    Enregistrer les modifications
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
