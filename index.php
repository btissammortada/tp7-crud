
<?php
require_once __DIR__ . "/database/connexion.php";

$nbEtudiants = $pdo->query("SELECT COUNT(*) FROM etudiants")->fetchColumn();
$nbFormations = $pdo->query("SELECT COUNT(*) FROM formations")->fetchColumn();
$nbModules = $pdo->query("SELECT COUNT(*) FROM modules")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Centre de Formation</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            text-align: center;
            padding: 60px 20px;
        }

        h1 {
            color: #2456a6;
            margin-bottom: 10px;
        }

        .cartes {
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            margin-top: 50px;
        }

        .carte {
            background: white;
            width: 230px;
            padding: 30px 20px;
            border-radius: 12px;
            box-shadow: 0 3px 12px #0002;
        }

        .carte h2 {
            color: #2456a6;
        }

        .carte p {
            font-size: 18px;
        }

        .carte a {
            display: block;
            background: #2456a6;
            color: white;
            padding: 12px;
            text-decoration: none;
            border-radius: 7px;
            margin-top: 20px;
        }

        .carte a:hover {
            background: #173c78;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Gestion du Centre de Formation</h1>
    <p>Bienvenue dans votre application de gestion</p>

    <div class="cartes">

        <div class="carte">
            <h2>Étudiants</h2>
            <p><?= $nbEtudiants ?> étudiants</p>
            <a href="etudiants/index.php">Gérer les étudiants</a>
        </div>

        <div class="carte">
            <h2>Formations</h2>
            <p><?= $nbFormations ?> formations</p>
            <a href="formations/index.php">Gérer les formations</a>
        </div>

        <div class="carte">
            <h2>Modules</h2>
            <p><?= $nbModules ?> modules</p>
            <a href="modules/index.php">Gérer les modules</a>
        </div>

    </div>

</div>

</body>
</html>
