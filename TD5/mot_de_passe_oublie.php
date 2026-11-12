<?php
// Exercice 6 : mot de passe oublie
// On cree une fonction qui envoie le mot de passe par courrier electronique

require_once "users.php";

// Fonction qui envoie le mot de passe a l'utilisateur par email
function envoyer_mot_de_passe($email)
{
    $utilisateurs = get_utilisateurs();

    // Si l'email n'existe pas dans la liste, on renvoie false
    if (!isset($utilisateurs[$email])) {
        return false;
    }

    $mot_de_passe = $utilisateurs[$email];

    $sujet = "Votre mot de passe";
    $message = "Bonjour,\n";
    $message .= "Voici votre mot de passe : " . $mot_de_passe . "\n";

    // La fonction mail() envoie le courriel
    $ok = mail($email, $sujet, $message);

    if (!$ok) {
        // Sur ce serveur de test il n'y a pas de messagerie,
        // alors on ecrit le courriel dans un fichier pour verifier
        // que la fonction marche bien.
        if (!is_dir("emails")) {
            mkdir("emails");
        }
        file_put_contents("emails/" . $email . ".txt", $sujet . "\n" . $message);
    }

    return true;
}

$message = "";

// Si le formulaire a ete envoye
if (isset($_POST["email"])) {
    if (envoyer_mot_de_passe($_POST["email"])) {
        $message = "Le mot de passe a ete envoye par courrier electronique a " . $_POST["email"] . ".";
    } else {
        $message = "Cet email n'existe pas.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Mot de passe oublie</h1>

<?php if ($message != "") { ?>
    <p><?php echo $message; ?></p>
<?php } ?>

<form method="post" action="mot_de_passe_oublie.php">
    <label>Votre login (email) :
        <input type="email" name="email" required>
    </label>
    <button type="submit">Envoyer le mot de passe</button>
</form>

<p><a href="login.php">Retour a la connexion</a></p>

</body>
</html>
