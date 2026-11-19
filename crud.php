
<?php
require_once __DIR__ . "/database/connexion.php";

$config = [
    "formations" => [
        "table" => "formations",
        "id" => "id_formation",
        "titre" => "Formations",
        "champs" => [
            "nom" => ["Nom", "text"],
            "description" => ["Description", "textarea"],
            "duree" => ["Durée (mois)", "number"],
            "niveau" => ["Niveau", "text"]
        ]
    ],

    "etudiants" => [
        "table" => "etudiants",
        "id" => "id_etudiant",
        "titre" => "Étudiants",
        "champs" => [
            "nom" => ["Nom", "text"],
            "prenom" => ["Prénom", "text"],
            "email" => ["Email", "email"],
            "date_inscription" => ["Date d'inscription", "date"],
            "id_formation" => ["Formation", "formation"]
        ]
    ],

    "modules" => [
        "table" => "modules",
        "id" => "id_module",
        "titre" => "Modules",
        "champs" => [
            "nom" => ["Nom", "text"],
            "volume_horaire" => ["Volume horaire", "number"],
            "coefficient" => ["Coefficient", "number"],
            "id_formation" => ["Formation", "formation"]
        ]
    ]
];

$entite = $_GET["entite"] ?? ($entite ?? "");

if (!isset($config[$entite])) {
    die("Entité inconnue.");
}

$c = $config[$entite];
$table = $c["table"];
$id = $c["id"];
$champs = $c["champs"];

function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, "UTF-8");
}

function listeFormations($pdo) {
    return $pdo->query(
        "SELECT id_formation, nom FROM formations ORDER BY nom"
    )->fetchAll();
}

function afficherChamp($nom, $info, $valeur, $pdo) {
    [$label, $type] = $info;

    echo "<label>" . h($label) . "</label>";

    if ($type === "formation") {
        echo '<select name="' . h($nom) . '" required>';

        foreach (listeFormations($pdo) as $f) {
            $selected = ((string)$valeur === (string)$f["id_formation"])
                ? "selected" : "";

            echo '<option value="' . h($f["id_formation"]) . '" '
                . $selected . '>' . h($f["nom"]) . '</option>';
        }

        echo '</select>';

    } elseif ($type === "textarea") {
        echo '<textarea name="' . h($nom) . '" rows="4">'
            . h($valeur) . '</textarea>';

    } else {
        echo '<input type="' . h($type) . '" name="' . h($nom)
            . '" value="' . h($valeur) . '" required>';
    }

    echo "<br><br>";
}

$action = $_GET["action"] ?? "liste";

if ($action === "supprimer") {

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $idValue = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

        if ($idValue) {
            $stmt = $pdo->prepare(
                "DELETE FROM $table WHERE $id = ?"
            );

            $stmt->execute([$idValue]);
        }

        header("Location: /tp7-crud/crud.php?entite=" . urlencode($entite));
        exit;
    }
}

if ($action === "ajouter" || $action === "modifier") {

    $idValue = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
    $donnees = [];

    if ($action === "modifier") {

        if (!$idValue) {
            die("Identifiant invalide.");
        }

        $stmt = $pdo->prepare(
            "SELECT * FROM $table WHERE $id = ?"
        );

        $stmt->execute([$idValue]);
        $donnees = $stmt->fetch();

        if (!$donnees) {
            die("Enregistrement introuvable.");
        }
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $valeurs = [];

        foreach ($champs as $nom => $info) {

            $valeur = trim($_POST[$nom] ?? "");

            if ($valeur === "") {
                die("Tous les champs sont obligatoires.");
            }

            if ($info[1] === "email" &&
                !filter_var($valeur, FILTER_VALIDATE_EMAIL)) {
                die("Adresse email invalide.");
            }

            if (in_array($info[1], ["number", "formation"], true)
                && !is_numeric($valeur)) {
                die("Valeur numérique invalide.");
            }

            if ($info[1] === "formation") {
                $check = $pdo->prepare(
                    "SELECT COUNT(*) FROM formations WHERE id_formation = ?"
                );
                $check->execute([$valeur]);

                if (!$check->fetchColumn()) {
                    die("Formation inexistante.");
                }
            }

            $valeurs[$nom] = $valeur;
        }

        if ($action === "ajouter") {

            $colonnes = implode(", ", array_keys($valeurs));

            $placeholders = implode(
                ", ",
                array_fill(0, count($valeurs), "?")
            );

            $sql = "INSERT INTO $table ($colonnes)
                    VALUES ($placeholders)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array_values($valeurs));

        } else {

            $sets = [];

            foreach (array_keys($valeurs) as $nom) {
                $sets[] = "$nom = ?";
            }

            $sql = "UPDATE $table SET "
                . implode(", ", $sets)
                . " WHERE $id = ?";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ...array_values($valeurs),
                $idValue
            ]);
        }

        header("Location: /tp7-crud/crud.php?entite=" . urlencode($entite));
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
<meta charset="UTF-8">
<title>Gestion des <?= h($c["titre"]) ?></title>

<style>

body {
    font-family: Arial, sans-serif;
    background: #eef3f9;
    margin: 0;
    padding: 35px 20px;
    color: #26364a;
}

.container {
    background: white;
    padding: 35px;
    border-radius: 12px;
    max-width: 1100px;
    margin: 25px auto;
    box-shadow: 0 4px 18px rgba(0,0,0,0.07);
}

h1 {
    text-align: center;
    color: #183b68;
    margin-bottom: 30px;
    font-size: 28px;
}

h2 {
    color: #2456a6;
    margin: 25px 0;
    border-bottom: 2px solid #e5edf7;
    padding-bottom: 12px;
}

label {
    display: block;
    font-weight: bold;
    color: #344968;
    margin: 15px 0 8px;
}

input, textarea, select {
    display: block;
    width: 100%;
    max-width: 500px;
    padding: 12px;
    border: 1px solid #ccd6e3;
    border-radius: 7px;
    font-size: 15px;
    box-sizing: border-box;
    background: #fbfdff;
}

input:focus, textarea:focus, select:focus {
    outline: none;
    border-color: #2456a6;
    box-shadow: 0 0 5px rgba(36,86,166,0.2);
}

textarea {
    resize: vertical;
}

table {
    border-collapse: collapse;
    width: 100%;
    margin-top: 25px;
    background: white;
}

th, td {
    border: 1px solid #e0e6ef;
    padding: 13px;
    text-align: left;
}

th {
    background: #183b68;
    color: white;
}

tr:nth-child(even) {
    background: #f5f8fc;
}

a, button {
    display: inline-block;
    padding: 11px 17px;
    margin: 5px;
    border: none;
    border-radius: 7px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    text-align: center;
    font-weight: bold;
}

a {
    background: #2456a6;
    color: white;
}

a:hover {
    background: #183b68;
}

button {
    background: #198754;
    color: white;
}

button:hover {
    background: #146c43;
}

form {
    margin-top: 20px;
}

@media (max-width: 700px) {
    .container {
        padding: 15px;
        overflow-x: auto;
    }

    table {
        min-width: 650px;
    }
}


</style>
</head>

<body>

<div class="container">

<h1>Gestion des <?= h($c["titre"]) ?></h1>

<a href="/tp7-crud/index.php">Accueil</a>

<a href="/tp7-crud/crud.php?entite=<?= urlencode($entite) ?>&action=liste">
    Liste
</a>

<?php if ($action === "ajouter" || $action === "modifier"): ?>

<h2>
<?= $action === "ajouter" ? "Ajouter" : "Modifier" ?>
</h2>

<form method="POST">

<?php
foreach ($champs as $nom => $info) {
    afficherChamp($nom, $info, $donnees[$nom] ?? "", $pdo);
}
?>

<button type="submit">Enregistrer</button>

<a href="/tp7-crud/crud.php?entite=<?= h($entite) ?>">
    Annuler
</a>

</form>

<?php elseif ($action === "supprimer"): ?>

<h2>Confirmer la suppression</h2>

<form method="POST">

<input type="hidden" name="id"
value="<?= h($_GET["id"] ?? "") ?>">

<p>Voulez-vous vraiment supprimer cet enregistrement ?</p>

<button type="submit">Oui, supprimer</button>

<a href="/tp7-crud/crud.php?entite=<?= h($entite) ?>">
    Annuler
</a>

</form>

<?php else: ?>

<a href="/tp7-crud/crud.php?entite=<?= h($entite) ?>&action=ajouter">
    Ajouter un nouvel élément
</a>

<?php
$sql = "SELECT * FROM $table ORDER BY $id DESC";
$donnees = $pdo->query($sql)->fetchAll();
?>

<table>

<thead>
<tr>

<?php foreach ($champs as $info): ?>
<th><?= h($info[0]) ?></th>
<?php endforeach; ?>

<th>Actions</th>

</tr>
</thead>

<tbody>

<?php foreach ($donnees as $ligne): ?>

<tr>

<?php foreach ($champs as $nom => $info): ?>

<td>

<?php
if ($nom === "id_formation" && $entite !== "formations") {

    $stmt = $pdo->prepare(
        "SELECT nom FROM formations WHERE id_formation = ?"
    );

    $stmt->execute([$ligne[$nom]]);

    echo h($stmt->fetchColumn() ?: "Inconnue");

} else {

    echo h($ligne[$nom] ?? "");
}
?>

</td>

<?php endforeach; ?>

<td>

<a href="/tp7-crud/crud.php?entite=<?= h($entite) ?>&action=modifier&id=<?= h($ligne[$id]) ?>">
Modifier
</a>

<a href="/tp7-crud/crud.php?entite=<?= h($entite) ?>&action=supprimer&id=<?= h($ligne[$id]) ?>">
Supprimer
</a>

</td>

</tr>

<?php endforeach; ?>

<?php if (!$donnees): ?>

<tr>
<td colspan="<?= count($champs) + 1 ?>">
Aucune donnée.
</td>
</tr>

<?php endif; ?>

</tbody>
</table>

<?php endif; ?>

</div>

</body>
</html>
