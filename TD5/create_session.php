<?php
// Exercice 2 : creer une session avec les donnees du formulaire

// On reprend la session ouverte par open_session.php
session_start();

// Si le formulaire a ete envoye, on garde les informations
// dans des variables de session
if (isset($_POST["nom"]) && isset($_POST["prenom"])) {
    $_SESSION["nom"] = $_POST["nom"];
    $_SESSION["prenom"] = $_POST["prenom"];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Creer une session</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Creer une session</h1>

<p>Les donnees du formulaire sont enregistrees dans la session :</p>

<ul>
    <li>Nom : <strong><?php echo $_SESSION["nom"]; ?></strong></li>
    <li>Prenom : <strong><?php echo $_SESSION["prenom"]; ?></strong></li>
</ul>

<h2>Contenu du tableau $_SESSION</h2>
<pre><?php print_r($_SESSION); ?></pre>

<!-- Lien pour revenir au menu principal -->
<p><a href="menu.html">Retour au menu principal</a></p>

</body>
</html>
