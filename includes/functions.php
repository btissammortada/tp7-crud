
<?php

function securiser($valeur) {
    return htmlspecialchars((string)$valeur, ENT_QUOTES, 'UTF-8');
}

function compterElements($pdo, $table) {
    $tablesAutorisees = ["formations", "etudiants", "modules"];

    if (!in_array($table, $tablesAutorisees, true)) {
        return 0;
    }

    $sql = "SELECT COUNT(*) FROM " . $table;
    return $pdo->query($sql)->fetchColumn();
}

function obtenirFormations($pdo) {
    $sql = "SELECT * FROM formations ORDER BY id_formation DESC";
    return $pdo->query($sql)->fetchAll();
}

function obtenirEtudiants($pdo) {
    $sql = "SELECT e.*, f.nom AS formation
            FROM etudiants e
            INNER JOIN formations f
            ON e.id_formation = f.id_formation
            ORDER BY e.id_etudiant DESC";

    return $pdo->query($sql)->fetchAll();
}

function obtenirModules($pdo) {
    $sql = "SELECT m.*, f.nom AS formation
            FROM modules m
            INNER JOIN formations f
            ON m.id_formation = f.id_formation
            ORDER BY m.id_module DESC";

    return $pdo->query($sql)->fetchAll();
}

?>
