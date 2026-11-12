<?php
/**
 * TD3 – Exercice 3.1 : traitement du formulaire (méthode GET).
 * Ce script reçoit et affiche les données envoyées par index-exo3-1.html.
 */

/** Échappe une chaîne avant affichage HTML (protection XSS). */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Récupération des champs du tableau superglobal $_GET
// (l'opérateur ?? évite les « undefined index » si un champ est absent)
$civilite = $_GET['civilite'] ?? '';
$nom      = $_GET['nom'] ?? '';
$prenom   = $_GET['prenom'] ?? '';
$courriel = $_GET['courriel'] ?? '';

// Le sélecteur multiple envoie un tableau vins[] ; sécurité si absent/altéré
$vins = $_GET['vins'] ?? [];
if (!is_array($vins)) {
    $vins = [$vins];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TD3 – Exercice 3.1 : données reçues</title>
  <link rel="stylesheet" href="css/td3.css?v=3" />
</head>
<body>
  <h1>TD3 – Exercice 3.1 : données reçues (méthode GET)</h1>

<?php if (empty($_GET)): ?>
  <p class="erreur">Aucune donnée reçue : le formulaire n'a pas été soumis.</p>
  <p><a href="index-exo3-1.html">Remplir le formulaire</a></p>
<?php else: ?>
  <div class="recapitulatif">
    <table>
      <thead>
        <tr><th>Champ du formulaire</th><th>Valeur reçue dans <code>$_GET</code></th></tr>
      </thead>
      <tbody>
        <tr><td>civilite</td><td><?= e($civilite) ?></td></tr>
        <tr><td>nom</td><td><?= e($nom) ?></td></tr>
        <tr><td>prenom</td><td><?= e($prenom) ?></td></tr>
        <tr><td>courriel</td><td><?= e($courriel) ?></td></tr>
        <tr>
          <td>vins[]</td>
          <td><?= $vins ? e(implode(', ', $vins)) : '<em>(aucun vin choisi)</em>' ?></td>
        </tr>
      </tbody>
    </table>
    <p>Remarque : la méthode GET rend les données visibles dans l'URL
       (regardez la barre d'adresse du navigateur).</p>
  </div>
  <p>
    <a href="index-exo3-1.html">&larr; Retour au formulaire</a> |
    <a href="index.php">Sommaire du TD3</a>
  </p>
<?php endif; ?>
</body>
</html>
