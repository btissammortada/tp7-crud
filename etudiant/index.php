
<?php
require_once "../database/connexion.php";

$sql = "SELECT e.*, f.nom AS nom_formation
        FROM etudiant e
        JOIN formation f ON e.id_formation = f.id_formation
        ORDER BY e.id_etudiant DESC";

$etudiants = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>

    <style>
        body { font-family: Arial, sans-serif; background: #f1f4f9; margin: 0; padding: 30px; color: #333; }
        .container { max-width: 1100px; margin: auto; }
        h1 { color: #2456a6; text-align: center; }
        .description { text-align: center; color: #666; margin-bottom: 30px; }
        .carte { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 3px 12px #0002; overflow-x: auto; }
        .ajouter { display: inline-block; background: #2456a6; color: white; padding: 12px 18px; text-decoration: none; border-radius: 7px; margin-bottom: 20px; }
        .ajouter:hover { background: #173c78; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #2456a6; color: white; padding: 14px; text-align: left; }
        td { padding: 13px; border-bottom: 1px solid #ddd; }
        tr:hover { background: #f1f4f9; }
        .modifier { color: #2456a6; text-decoration: none; font-weight: bold; }
        .supprimer { color: #dc3545; text-decoration: none; font-weight: bold; }
        .retour { display: inline-block; margin-top: 20px; color: #2456a6; text-decoration: none; }
        table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

th, td {
    padding: 15px;
    text-align: left;
    white-space: nowrap;
}

th {
    background: #2456a6;
    color: white;
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
}

.modifier {
    background: #e5edfa;
}

.supprimer {
    background: #fde8e8;
}
    </style>
</head>

<body>
<div class="container">

    <h1>Gestion des étudiants</h1>
    <p class="description">Consulter et gérer les étudiants inscrits</p>

    <div class="carte">
        <a href="create.php" class="ajouter">+ Ajouter un étudiant</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                    <th>Formation</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($etudiants as $e): ?>
                <tr>
                    <td><?= htmlspecialchars($e['id_etudiant']) ?></td>
                    <td><?= htmlspecialchars($e['nom']) ?></td>
                    <td><?= htmlspecialchars($e['prenom']) ?></td>
                    <td><?= htmlspecialchars($e['email']) ?></td>
                    <td><?= htmlspecialchars($e['date_inscription'] ?? 'Non renseignée') ?></td>
                    <td><?= htmlspecialchars($e['nom_formation']) ?></td>
                    <td>
                        <a class="modifier" href="edit.php?id=<?= $e['id_etudiant'] ?>">Modifier</a>
                        |
                        <a class="supprimer" href="delete.php?id=<?= $e['id_etudiant'] ?>"
                           onclick="return confirm('Supprimer cet étudiant ?')">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($etudiants)): ?>
                <tr><td colspan="7">Aucun étudiant enregistré.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="../index.php" class="retour">← Retour à l'accueil</a>
</div>
</body>
</html>
