<?php
/**
 * TD3 – Exercice 3.5 : filtrage de l'adresse courrielle avec preg_match()
 * + vérification de sa cohérence par une fonction dédiée.
 *
 *  - caractères autorisés : lettres, chiffres, - _ @ .
 *  - cohérence : présence d'un « @ » et d'un « . »,
 *    au moins 2 caractères avant le « @ »,
 *    au moins 2 caractères entre le « @ » et le « . ».
 *
 * Si tous les tests passent : affichage du message de confirmation,
 * sinon : message d'erreur « ad-hoc » en rouge en entête du formulaire.
 */
const VINS = ['St Emilion', "Château l'Hermitage", 'Entre les Deux Mers', 'Fitou', 'Bandol', 'Côte de Provence'];

/** Échappe une chaîne avant affichage HTML (protection XSS). */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/**
 * Analyse la cohérence d'une adresse courrielle.
 * @return bool true si l'adresse est cohérente, false sinon.
 */
function courrielCoherent(string $courriel): bool
{
    // Il doit exister un « @ » dans la chaîne, précédé d'au moins 2 caractères
    $posArrobase = strpos($courriel, '@');
    if ($posArrobase === false || $posArrobase < 2) {
        return false;
    }

    // Il doit exister un « . » situé après le « @ »
    $posPoint = strrpos($courriel, '.');
    if ($posPoint === false || $posPoint <= $posArrobase) {
        return false;
    }

    // Le « @ » et le « . » doivent être séparés d'au moins 2 caractères
    // (distance >= 3 : ex. « ab@cd.ef » -> positions 2 et 5 -> 2 caractères entre eux)
    if ($posPoint - $posArrobase < 3) {
        return false;
    }

    return true;
}

$formEnvoye = isset($_GET['envoyer']);

$civilite = $_GET['civilite'] ?? 'M.';
if (!in_array($civilite, ['M.', 'Mme'], true)) {
    $civilite = 'M.';
}
$nom      = trim((string)($_GET['nom'] ?? ''));
$prenom   = trim((string)($_GET['prenom'] ?? ''));
$courriel = trim((string)($_GET['courriel'] ?? ''));
$vinsChoisis = array_values(array_intersect((array)($_GET['vins'] ?? []), VINS));

// ---------- Vérifications + filtrages ----------
$erreurs = [];
if ($formEnvoye) {
    // Champs obligatoires (exercice 3.3)
    if ($nom === '') {
        $erreurs[] = 'Le nom est obligatoire.';
    }
    if ($prenom === '') {
        $erreurs[] = 'Le prénom est obligatoire.';
    }
    if ($courriel === '') {
        $erreurs[] = "L'adresse courrielle est obligatoire.";
    }

    // Filtrage du nom et du prénom (exercice 3.4)
    if ($nom !== '' && !preg_match('/^[A-Za-z -]+$/', $nom)) {
        $erreurs[] = 'Le nom ne doit contenir que des lettres, des espaces ou des tirets.';
    }
    if ($prenom !== '' && !preg_match('/^[A-Za-z -]+$/', $prenom)) {
        $erreurs[] = 'Le prénom ne doit contenir que des lettres, des espaces ou des tirets.';
    }

    // Filtrage de l'adresse courrielle (exercice 3.5)
    if ($courriel !== '') {
        if (!preg_match('/^[A-Za-z0-9._@-]+$/', $courriel)) {
            $erreurs[] = "L'adresse courrielle contient des caractères interdits (autorisés : lettres, chiffres, - _ @ .).";
        } elseif (!courrielCoherent($courriel)) {
            $erreurs[] = "L'adresse courrielle n'est pas cohérente : il faut un « @ » précédé d'au moins 2 caractères, "
                       . "et un « . » situé au moins 2 caractères après le « @ ».";
        }
    }
}

$formValide = $formEnvoye && $erreurs === [];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TD3 – Exercice 3.5 : filtrage et cohérence de l'adresse courrielle</title>
  <link rel="stylesheet" href="css/td3.css?v=3" />
</head>
<body>
  <h1>TD3 – Exercice 3.5 : filtrage et cohérence de l'adresse courrielle</h1>

<?php if ($formValide): ?>
  <!-- Tous les tests sont positifs : message de confirmation -->
  <div class="confirmation">
    <p>
      Bonjour <strong><?= e($civilite) ?></strong> <strong><?= e($prenom) ?></strong> <strong><?= e($nom) ?></strong>,<br />
      nous vous remercions d'avoir effectué la commande suivante :<br />
      <strong><?= $vinsChoisis ? e(implode(', ', $vinsChoisis)) : '<em>(aucun vin choisi)</em>' ?></strong><br />
      Un courriel de confirmation vous a été envoyé à l'adresse : <strong><?= e($courriel) ?></strong>
    </p>
  </div>
  <p><a href="<?= e(basename(__FILE__)) ?>">Nouvelle commande</a></p>
<?php else: ?>

  <?php if ($formEnvoye && $erreurs !== []): ?>
  <!-- Message d'erreur « ad-hoc » affiché en rouge en entête du formulaire -->
  <div class="erreur">
    Formulaire invalide : merci de corriger les points suivants.
    <ul>
      <?php foreach ($erreurs as $message): ?>
      <li><?= e($message) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php endif; ?>

  <form action="<?= e(basename(__FILE__)) ?>" method="get">
    <fieldset>
      <legend>Vos coordonnées (<span class="obligatoire">*</span> : obligatoire)</legend>
      <p>
        Civilité :
        <input type="radio" id="civM" name="civilite" value="M."<?= $civilite === 'M.' ? ' checked="checked"' : '' ?> />
        <label class="inline" for="civM">M</label>

        <input type="radio" id="civMme" name="civilite" value="Mme"<?= $civilite === 'Mme' ? ' checked="checked"' : '' ?> />
        <label class="inline" for="civMme">Mme</label>
      </p>
      <p>
        <label for="nom">Nom <span class="obligatoire">*</span> :</label>
        <input type="text" id="nom" name="nom" value="<?= e($nom) ?>" />
      </p>
      <p>
        <label for="prenom">Prénom <span class="obligatoire">*</span> :</label>
        <input type="text" id="prenom" name="prenom" value="<?= e($prenom) ?>" />
      </p>
      <p>
        <label for="courriel">Adresse courrielle <span class="obligatoire">*</span> :</label>
        <input type="text" id="courriel" name="courriel" value="<?= e($courriel) ?>" />
        <small>(lettres, chiffres, - _ @ .)</small>
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
<?php endif; ?>

  <p><a href="index.php">&larr; Retour au sommaire du TD3</a></p>
</body>
</html>
