<?php
/**
 * TD3 – Exercice 4 : génération dynamique d'un formulaire à partir de données
 * préexistantes lues dans le fichier TD3-Cars.txt (méthode POST).
 *
 *  - Le formulaire est toujours construit à partir du CONTENU DU FICHIER.
 *  - Modifier un modèle ou un prix met à jour le fichier.
 *  - Vider le champ « modèle » d'une ligne la supprime du fichier.
 *  - Remplir « nouveau modèle » + « nouveau prix » ajoute une ligne au fichier.
 *
 * Le fichier est lu / écrit avec fgetcsv() et fputcsv() (séparateur : tabulation).
 */

const FICHIER = __DIR__ . '/TD3-Cars.txt';
const SEP = "\t"; // séparateur du fichier de données

/** Échappe une chaîne avant affichage HTML (protection XSS). */
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/**
 * Lecture du fichier de données avec fgetcsv().
 * @return array [ 'Marque' => [ ['modele'=>..., 'min'=>..., 'max'=>...], ... ], ... ]
 */
function lireVoitures(string $fichier): array
{
    $voitures = [];
    if (is_file($fichier) && ($fp = fopen($fichier, 'r')) !== false) {
        // Note : le 5e argument '' (escape) est recommandé depuis PHP 8.4
        while (($ligne = fgetcsv($fp, 0, SEP, '"', '')) !== false) {
            $ligne = array_map('trim', $ligne); // nettoie les espaces parasites
            // On ignore la ligne d'en-tête et les lignes vides / incomplètes
            if (count($ligne) < 4 || $ligne[0] === '' || strtolower($ligne[0]) === 'marque') {
                continue;
            }
            [$marque, $modele, $prixMin, $prixMax] = $ligne;
            $voitures[$marque][] = ['modele' => $modele, 'min' => $prixMin, 'max' => $prixMax];
        }
        fclose($fp);
    }
    return $voitures;
}

/**
 * Écriture du fichier de données avec fputcsv().
 */
function ecrireVoitures(string $fichier, array $voitures): bool
{
    // Si le fichier existe mais n'est pas accessible en écriture (ex. copie
    // avec des droits en lecture seule), on tente de corriger les droits
    if (is_file($fichier) && !is_writable($fichier)) {
        @chmod($fichier, 0664);
    }
    if (($fp = fopen($fichier, 'w')) === false) {
        return false;
    }
    fputcsv($fp, ['Marque', 'Modele', 'PrixMin', 'PrixMax'], SEP, '"', '');
    foreach ($voitures as $marque => $modeles) {
        foreach ($modeles as $m) {
            fputcsv($fp, [$marque, $m['modele'], $m['min'], $m['max']], SEP, '"', '');
        }
    }
    fclose($fp);
    return true;
}

// ======================= Traitement (méthode POST) =======================
$messages = []; // actions réalisées (affichées en vert)
$erreurs  = []; // anomalies constatées (affichées en rouge)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $avant = lireVoitures(FICHIER);
    $apres = [];

    // 1) Modèles existants : mise à jour ou suppression
    foreach ((array)($_POST['cars'] ?? []) as $marque => $lignes) {
        if (!isset($avant[$marque])) {
            continue; // sécurité : marque inconnue dans le fichier d'origine
        }
        foreach ((array)$lignes as $i => $l) {
            $orig   = $avant[$marque][$i] ?? null;
            $modele = trim((string)($l['modele'] ?? ''));
            $min    = trim((string)($l['prixmin'] ?? ''));
            $max    = trim((string)($l['prixmax'] ?? ''));

            // Champ texte du modèle vide => la ligne est retirée du formulaire et du fichier
            if ($modele === '') {
                if ($orig !== null) {
                    $messages[] = "Suppression : {$marque} « {$orig['modele']} ».";
                }
                continue;
            }

            // Les champs de prix doivent être numériques
            if (!ctype_digit($min) || !ctype_digit($max)) {
                $erreurs[] = "Prix invalides pour {$marque} « {$modele} » : entiers positifs attendus, ligne non modifiée.";
                if ($orig !== null) {
                    $apres[$marque][] = $orig; // on conserve les anciennes valeurs
                }
                continue;
            }

            // Valeurs différentes des précédentes => rafraîchissement
            if ($orig !== null
                && ($orig['modele'] !== $modele || (string)$orig['min'] !== $min || (string)$orig['max'] !== $max)) {
                $messages[] = "Mise à jour : {$marque} « {$orig['modele']} » ({$orig['min']}–{$orig['max']} €) "
                            . "&rarr; « {$modele} » ({$min}–{$max} €).";
            }
            $apres[$marque][] = ['modele' => $modele, 'min' => (int)$min, 'max' => (int)$max];
        }
    }

    // 2) Saisie d'un nouveau modèle
    $nMarque = trim((string)($_POST['new_marque'] ?? ''));
    $nModele = trim((string)($_POST['new_modele'] ?? ''));
    $nPrix   = trim((string)($_POST['new_prix'] ?? ''));

    if ($nModele !== '' || $nPrix !== '') {
        if ($nModele === '' || !ctype_digit($nPrix)) {
            $erreurs[] = 'Ajout impossible : renseignez le nouveau modèle ET un prix entier positif.';
        } elseif (!isset($avant[$nMarque])) {
            $erreurs[] = "Ajout impossible : la marque « {$nMarque} » n'existe pas dans le fichier.";
        } else {
            // L'énoncé ne prévoit qu'un seul prix : il est affecté à PrixMin et PrixMax
            $apres[$nMarque][] = ['modele' => $nModele, 'min' => (int)$nPrix, 'max' => (int)$nPrix];
            $messages[] = "Ajout : {$nMarque} « {$nModele} » à {$nPrix} €.";
        }
    }

    // 3) Séquence écriture / lecture : le fichier est réécrit puis relu,
    //    le formulaire ci-dessous est toujours déduit de la lecture du fichier.
    if (!ecrireVoitures(FICHIER, $apres)) {
        $messages = [];
        $erreurs[] = "Écriture impossible dans « TD3-Cars.txt » : vérifiez les droits du fichier (chmod 664). Aucune modification n'a été enregistrée.";
    }
}

// (Re)lecture du fichier : la construction du formulaire dépend de son contenu
$stock = lireVoitures(FICHIER);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TD3 – Exercice 4 : formulaire dynamique depuis TD3-Cars.txt</title>
  <link rel="stylesheet" href="css/td3.css?v=3" />
</head>
<body>
  <h1>TD3 – Exercice 4 : formulaire dynamique (fichier <code>TD3-Cars.txt</code>)</h1>

  <p>
    Ce formulaire est généré automatiquement à partir du contenu du fichier de données.<br />
    &bull; Modifiez un modèle ou un prix puis « Envoyer » pour mettre à jour le fichier ;<br />
    &bull; cliquez sur la poubelle d'une ligne (ou videz son champ « Modèle ») pour la supprimer ;<br />
    &bull; utilisez la dernière section pour ajouter un nouveau modèle.
  </p>

<?php if ($erreurs !== []): ?>
  <div class="erreur">
    Des erreurs ont été détectées :
    <ul>
      <?php foreach ($erreurs as $message): ?>
      <li><?= e($message) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php if ($messages !== []): ?>
  <div class="info">
    Actions effectuées dans le fichier de données :
    <ul>
      <?php foreach ($messages as $message): ?>
      <li><?= $message /* contient déjà des valeurs sûres issues du fichier ou validées */ ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

  <form action="<?= e(basename(__FILE__)) ?>" method="post">
<?php foreach ($stock as $marque => $modeles): ?>
    <table>
      <caption><?= e($marque) ?></caption>
      <thead>
        <tr><th>Modèle</th><th>PrixMin</th><th>PrixMax</th><th class="col-action">Suppr.</th></tr>
      </thead>
      <tbody>
      <?php foreach ($modeles as $i => $m): ?>
        <tr>
          <td>
            <input type="text"
                   name="cars[<?= e($marque) ?>][<?= (int)$i ?>][modele]"
                   value="<?= e((string)$m['modele']) ?>" />
          </td>
          <td>
            <input type="number" min="0" step="1"
                   name="cars[<?= e($marque) ?>][<?= (int)$i ?>][prixmin]"
                   value="<?= e((string)$m['min']) ?>" />
          </td>
          <td>
            <input type="number" min="0" step="1"
                   name="cars[<?= e($marque) ?>][<?= (int)$i ?>][prixmax]"
                   value="<?= e((string)$m['max']) ?>" />
          </td>
          <td class="col-action">
            <button type="button" class="btn-suppr" title="Supprimer « <?= e((string)$m['modele']) ?> »">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/>
              </svg>
            </button>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
<?php endforeach; ?>

    <fieldset>
      <legend>Saisir un nouveau modèle :</legend>
      <label class="inline" for="new_marque">Marque :</label>
      <select id="new_marque" name="new_marque">
      <?php foreach ($stock as $marque => $modeles): ?>
        <option value="<?= e($marque) ?>"><?= e($marque) ?></option>
      <?php endforeach; ?>
      </select>
      <label class="inline" for="new_modele">Modèle :</label>
      <input type="text" id="new_modele" name="new_modele" placeholder="ex. Mégane E-Tech" />
      <label class="inline" for="new_prix">Prix :</label>
      <input type="number" id="new_prix" name="new_prix" min="0" step="1" placeholder="ex. 25000" />
    </fieldset>

    <p><input type="submit" name="envoyer" value="Envoyer" /></p>
  </form>

  <p><a href="index.php">&larr; Retour au sommaire du TD3</a></p>

  <script>
    /* Petit plus ergonomique : le bouton poubelle vide le champ « modèle » de
       la ligne puis envoie le formulaire. Côté serveur, un champ modèle vide
       déclenche la suppression de la ligne (mécanisme demandé par la consigne).
       Sans JavaScript, la suppression manuelle reste possible en vidant le champ. */
    document.querySelectorAll('.btn-suppr').forEach(function (bouton) {
      bouton.addEventListener('click', function () {
        const champModele = bouton.closest('tr').querySelector('input[type="text"]');
        if (!champModele) return;
        if (window.confirm('Supprimer le modèle « ' + champModele.value + ' » ?')) {
          champModele.value = '';
          bouton.closest('form').submit();
        }
      });
    });
  </script>
</body>
</html>
