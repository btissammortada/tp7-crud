
<?php

$host = "localhost";
$dbname = "tp7_crud";
$username = "root";
$password = "";

try {

    // Connexion à la base de données
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Gestion des erreurs SQL
    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // Récupération des résultats sous forme associative
    $pdo->setAttribute(
        PDO::ATTR_DEFAULT_FETCH_MODE,
        PDO::FETCH_ASSOC
    );

} catch (PDOException $e) {

    die("Erreur de connexion : " . $e->getMessage());

}

?>
