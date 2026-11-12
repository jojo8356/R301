<?php
// Deconnexion : on detruit la session et on supprime les cookies

session_start();

$_SESSION = array();
session_destroy();

// On supprime les cookies en leur donnant une date dans le passe
setcookie("email", "", time() - 3600);
setcookie("mot_de_passe", "", time() - 3600);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Deconnexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Deconnexion</h1>

<p>Vous etes deconnecte. La session et les cookies sont supprimes.</p>

<p><a href="login.php">Se reconnecter</a></p>

</body>
</html>
