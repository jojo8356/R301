<?php
/**
 * TD3 – Exercice 3.2 : création ET traitement du formulaire dans un même fichier.
 * Le formulaire s'envoie sur lui-même (méthode GET) ;
 * la présence du bouton « envoyer » dans $_GET indique une soumission.
 */

// Liste des vins (utilisée pour générer le <select> et vérifier les valeurs reçues)
const VINS = ['St Emilion', "Château l'Hermitage", 'Entre les Deux Mers', 'Fitou', 'Bandol', 'Côte de Provence'];

/** Échappe une chaîne avant affichage HTML (protection XSS). */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

// Le formulaire a-t-il été soumis ? (le bouton submit s'appelle « envoyer »)
$formEnvoye = isset($_GET['envoyer']);

$civilite = $_GET['civilite'] ?? 'M.';
if (!in_array($civilite, ['M.', 'Mme'], true)) {
    $civilite = 'M.';
}
$nom      = trim((string)($_GET['nom'] ?? ''));
$prenom   = trim((string)($_GET['prenom'] ?? ''));
$courriel = trim((string)($_GET['courriel'] ?? ''));

// Vins choisis : on ne garde que les valeurs réellement proposées par le formulaire
$vinsChoisis = array_values(array_intersect((array)($_GET['vins'] ?? []), VINS));
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TD3 – Exercice 3.2 : formulaire + traitement (un seul fichier)</title>
  <link rel="stylesheet" href="css/td3.css?v=3" />
</head>
<body>
  <h1>TD3 – Exercice 3.2 : formulaire et traitement dans un même fichier</h1>

<?php if ($formEnvoye): ?>
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
          <td><?= $vinsChoisis ? e(implode(', ', $vinsChoisis)) : '<em>(aucun vin choisi)</em>' ?></td>
        </tr>
      </tbody>
    </table>
  </div>
<?php endif; ?>

  <!-- Le formulaire se soumet à lui-même -->
  <form action="<?= e(basename(__FILE__)) ?>" method="get">
    <fieldset>
      <legend>Vos coordonnées</legend>
      <p>
        Civilité :
        <input type="radio" id="civM" name="civilite" value="M."<?= $civilite === 'M.' ? ' checked="checked"' : '' ?> />
        <label class="inline" for="civM">M</label>

        <input type="radio" id="civMme" name="civilite" value="Mme"<?= $civilite === 'Mme' ? ' checked="checked"' : '' ?> />
        <label class="inline" for="civMme">Mme</label>
      </p>
      <p>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" value="<?= e($nom) ?>" />
      </p>
      <p>
        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="prenom" value="<?= e($prenom) ?>" />
      </p>
      <p>
        <label for="courriel">Adresse courrielle :</label>
        <input type="text" id="courriel" name="courriel" value="<?= e($courriel) ?>" />
      </p>
    </fieldset>

    <fieldset>
      <legend>Votre commande</legend>

      <!-- Accordéon cliquable : la liste des vins ne s'affiche qu'au clic -->
      <details class="accordeon-vins"<?= $vinsChoisis !== [] ? ' open' : '' ?>>
        <summary>
          <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 3h10l-1.3 6.3a4.2 4.2 0 0 1-7.4 0z"/><line x1="12" y1="13.5" x2="12" y2="20"/><line x1="8.5" y1="20" x2="15.5" y2="20"/>
          </svg>
          Choisir les vins <span class="gris">(sélection multiple)</span>
          <?= $vinsChoisis !== [] ? '<span class="compteur">' . count($vinsChoisis) . ' choisi(s)</span>' : '' ?>
          <span class="chevron" aria-hidden="true">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
          </span>
        </summary>
        <div class="accordeon-contenu">
          <label for="vins">Vins :</label>
          <select id="vins" name="vins[]" multiple="multiple" size="6">
<?php foreach (VINS as $vin): ?>
            <option value="<?= e($vin) ?>"<?= in_array($vin, $vinsChoisis, true) ? ' selected="selected"' : '' ?>><?= e($vin) ?></option>
<?php endforeach; ?>
          </select>
          <p class="aide">Astuce : maintenez <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> sur Mac) en cliquant pour choisir plusieurs vins.</p>
        </div>
      </details>
    </fieldset>

    <p>
      <input type="submit" name="envoyer" value="Commander" />
      <input type="reset" value="Effacer" />
    </p>
  </form>

  <p><a href="index.php">&larr; Retour au sommaire du TD3</a></p>
</body>
</html>
