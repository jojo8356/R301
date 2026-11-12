<?php
// Exercice 3 : afficher les variables de session + un compteur de vues

session_start();

// Compteur en variable de session :
// il compte le nombre de fois que la page a ete vue
if (isset($_SESSION["compteur"])) {
    $_SESSION["compteur"] = $_SESSION["compteur"] + 1;
} else {
    $_SESSION["compteur"] = 1;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Afficher les variables de session</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Afficher les variables de session</h1>

<h2>Variables de session</h2>
<pre><?php print_r($_SESSION); ?></pre>

<h2>Compteur</h2>
<p>Vous avez vu cette page <strong><?php echo $_SESSION["compteur"]; ?></strong> fois.</p>

<p><a href="menu.html">Retour au menu</a></p>

</body>
</html>
