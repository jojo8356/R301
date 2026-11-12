<?php
// Exercice 4 : detruire les variables de session

session_start();

// On supprime toutes les variables de session
$_SESSION = array();

// On detruit la session avec la fonction PHP session_destroy()
session_destroy();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Detruire les variables de session</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Detruire les variables de session</h1>

<p>La session a ete detruite avec <strong>session_destroy()</strong>.</p>

<h2>Contenu du tableau $_SESSION apres destruction</h2>
<pre><?php print_r($_SESSION); ?></pre>

<p><a href="menu.html">Retour au menu</a></p>

</body>
</html>
