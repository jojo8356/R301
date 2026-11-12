<?php
// Exercice 5 : formulaire de login / mot de passe
// Le login est l'adresse courrielle (email) de l'utilisateur

require_once "auth.php";

$message = "";

// Duree du cookie : 1 mois (30 jours)
$duree_cookie = 30 * 24 * 60 * 60;
// Pour tester l'expiration du cookie en 30 secondes,
// on remplace la ligne du dessus par :
// $duree_cookie = 30;

// Si le cookie "se souvenir de moi" existe et est valide,
// on reconnecte automatiquement l'utilisateur.
if (!est_connecte() && isset($_COOKIE["email"]) && isset($_COOKIE["mot_de_passe"])) {
    $utilisateurs = get_utilisateurs();
    $email = $_COOKIE["email"];
    if (isset($utilisateurs[$email]) && $utilisateurs[$email] == $_COOKIE["mot_de_passe"]) {
        $_SESSION["email"] = $email;
    }
}

// Si l'utilisateur est deja connecte, on va direct sur la page protegee
if (est_connecte()) {
    header("Location: accueil.php");
    exit;
}

// Si le formulaire a ete envoye, on verifie le login et le mot de passe
if (isset($_POST["email"]) && isset($_POST["mot_de_passe"])) {
    $utilisateurs = get_utilisateurs();
    $email = $_POST["email"];
    $mot_de_passe = $_POST["mot_de_passe"];

    if (isset($utilisateurs[$email]) && $utilisateurs[$email] == $mot_de_passe) {
        // Bon login : on ouvre la session pour cet utilisateur
        $_SESSION["email"] = $email;

        // On cree un cookie qui memorise le login et le mot de passe
        setcookie("email", $email, time() + $duree_cookie);
        setcookie("mot_de_passe", $mot_de_passe, time() + $duree_cookie);

        header("Location: accueil.php");
        exit;
    } else {
        $message = "Login ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Connexion</h1>

<?php if ($message != "") { ?>
    <p style="color: red;"><?php echo $message; ?></p>
<?php } ?>

<form method="post" action="login.php">
    <label>Login (votre email) :
        <input type="email" name="email" required>
    </label>
    <label>Mot de passe :
        <input type="password" name="mot_de_passe" required>
    </label>
    <button type="submit">Se connecter</button>
</form>

<p>Exemple pour le TD : etudiant@example.com / php2024</p>
<p><a href="mot_de_passe_oublie.php">Mot de passe oublie ?</a></p>

</body>
</html>
