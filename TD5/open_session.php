<?php
// Exercice 1 : ouvrir une session

// On demarre la session.
// Si aucune session n'existe, PHP en cree une nouvelle.
// Si une session existe deja, PHP la restaure grace a son identifiant (SID).
session_start();

// On prepare le formulaire avec les valeurs deja enregistrees en session (s'il y en a)
$nom = "";
$prenom = "";
if (isset($_SESSION["nom"])) {
    $nom = $_SESSION["nom"];
}
if (isset($_SESSION["prenom"])) {
    $prenom = $_SESSION["prenom"];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ouvrir une session</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Ouvrir une session</h1>

<p>La session est ouverte. Son identifiant (SID) est : <strong><?php echo session_id(); ?></strong></p>

<!-- Le formulaire envoie les donnees a create_session.php -->
<form method="post" action="create_session.php">
    <label>Nom :
        <input type="text" name="nom" value="<?php echo $nom; ?>">
    </label>
    <label>Prenom :
        <input type="text" name="prenom" value="<?php echo $prenom; ?>">
    </label>
    <button type="submit">Envoyer</button>
</form>

<p><a href="menu.html">Retour au menu</a></p>

</body>
</html>
