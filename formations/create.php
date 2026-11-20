
<?php
require_once "../database/connexion.php";

// Ajouter une formation
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = trim($_POST["nom"]);
    $description = trim($_POST["description"]);
    $duree = trim($_POST["duree"]);
    $niveau = trim($_POST["niveau"]);

    $sql = "INSERT INTO formation (nom, description, duree, niveau)
            VALUES (?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $description, $duree, $niveau]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ajouter une formation</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f4f9;
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 650px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2456a6;
            margin-bottom: 10px;
        }

        .header p {
            color: #777;
        }

        .formulaire {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 4px 18px #0002;
            border-top: 5px solid #2456a6;
        }

        .formulaire h2 {
            color: #2456a6;
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 9px;
            font-weight: bold;
            color: #344563;
        }

        input, textarea, select {
            width: 100%;
            padding: 13px;
            border: 1px solid #d5dce8;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            background: #fafcff;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
            font-family: Arial, sans-serif;
        }

        input:focus, textarea:focus, select:focus {
            border-color: #2456a6;
            box-shadow: 0 0 0 3px #2456a622;
            background: white;
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

        .btn-ajouter:hover {
            background: #173c78;
        }

        .btn-annuler {
            background: #e8edf5;
            color: #344563;
        }

        .btn-annuler:hover {
            background: #d8e0ec;
        }

        @media (max-width: 500px) {
            .formulaire {
                padding: 22px;
            }

            .boutons {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Gestion des formations</h1>
        <p>Ajouter une nouvelle formation au centre de formation</p>
    </div>

    <div class="formulaire">

        <h2>Informations de la formation</h2>

        <form method="POST">

            <div class="form-group">
                <label for="nom">Nom de la formation</label>
                <input type="text" id="nom" name="nom"
                       placeholder="Exemple : Développement Informatique"
                       required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description"
                          placeholder="Description de la formation..."
                          required></textarea>
            </div>

            <div class="form-group">
                <label for="duree">Durée</label>
                <input type="text" id="duree" name="duree"
                       placeholder="Exemple : 2 ans"
                       required>
            </div>

            <div class="form-group">
                <label for="niveau">Niveau</label>

                <select name="niveau" id="niveau" required>
                    <option value="">-- Sélectionner un niveau --</option>
                    <option value="Débutant">Débutant</option>
                    <option value="Intermédiaire">Intermédiaire</option>
                    <option value="Avancé">Avancé</option>
                </select>
            </div>

            <div class="boutons">

                <button type="submit" class="btn btn-ajouter">
                    + Ajouter la formation
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
