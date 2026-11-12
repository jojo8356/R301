<?php
// Exercice 5 : une page du site qui exige que l'utilisateur soit connecte

require_once "auth.php";

// Si la session a expire ou si la personne n'est pas autorisee,
// cette fonction la renvoie vers login.php
exiger_connexion();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Accueil</h1>

<p>Bonjour <strong><?php echo $_SESSION["email"]; ?></strong>, vous etes bien connecte.</p>

<p>Cette page est reservee aux utilisateurs autorises.</p>

<p><a href="logout.php">Se deconnecter</a></p>

</body>
</html>
