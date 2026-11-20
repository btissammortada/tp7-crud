
<?php
require_once "../database/connexion.php";

$sql = "SELECT * FROM formation ORDER BY id_formation DESC";
$formations = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des formations</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            color: #2456a6;
            text-align: center;
        }

        .description {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
        }

        .carte {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0002;
            overflow-x: auto;
        }

        .ajouter {
            display: inline-block;
            background: #2456a6;
            color: white;
            padding: 12px 18px;
            text-decoration: none;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .ajouter:hover {
            background: #173c78;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        th {
            background: #2456a6;
            color: white;
        }

        td {
            border-bottom: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background: #f7f9fc;
        }

        tbody tr:hover {
            background: #eaf1fc;
        }

        .modifier, .supprimer {
            display: inline-block;
            padding: 7px 10px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
        }

        .modifier {
            color: #2456a6;
            background: #e5edfa;
        }

        .supprimer {
            color: #dc3545;
            background: #fde8e8;
            border: none;
            font-size: 14px;
        }

        .retour {
            display: inline-block;
            margin-top: 20px;
            color: #2456a6;
            text-decoration: none;
        }

        form {
            display: inline;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Gestion des formations</h1>
    <p class="description">Consulter et gérer les formations proposées</p>

    <div class="carte">

        <a href="create.php" class="ajouter">+ Ajouter une formation</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Durée</th>
                    <th>Niveau</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($formations as $f): ?>

                <tr>
                    <td><?= htmlspecialchars($f['id_formation']) ?></td>
                    <td><?= htmlspecialchars($f['nom']) ?></td>
                    <td><?= htmlspecialchars($f['description']) ?></td>
                    <td><?= htmlspecialchars($f['duree']) ?></td>
                    <td><?= htmlspecialchars($f['niveau']) ?></td>

                    <td>

                        <a class="modifier"
                           href="edit.php?id=<?= urlencode($f['id_formation']) ?>">
                           Modifier
                        </a>

                        <form method="POST" action="delete.php"
      onsubmit="return confirm('Voulez-vous vraiment supprimer cette formation ?')">

    <input type="hidden" name="id"
           value="<?= htmlspecialchars($f['id_formation']) ?>">

    <button type="submit" class="supprimer">
        Supprimer
    </button>

</form>

                    </td>
                </tr>

                <?php endforeach; ?>

                <?php if (empty($formations)): ?>
                    <tr>
                        <td colspan="6">Aucune formation enregistrée.</td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>

    </div>

    <a href="../index.php" class="retour">← Retour à l'accueil</a>

</div>

</body>
</html>
