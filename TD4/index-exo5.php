<?php
$titrePage = 'Exercice 5 — Commande shell ls.php';
$pageActive = 'exo5';
require __DIR__ . '/includes/header.php';

require __DIR__ . '/ls.php'; // pour réutiliser ls_fichiers()

// Démo en direct sur le dossier de l'exemple du TD (assets/demo-ls)
$demo = __DIR__ . '/assets/demo-ls';
$suffixes = ['jpg', 'txt', 'rar', 'gif', 'tgz'];
$resultat = ls_fichiers($demo, $suffixes);

// Reconstitution de la sortie attendue dans l'énoncé
$sortie = [];
foreach ($resultat as $suffixe => $fichiers) {
    if ($fichiers === []) {
        $sortie[] = "err : $suffixe : no file found";
    } else {
        foreach ($fichiers as $f) {
            $sortie[] = "out : $f";
        }
    }
}
?>

<div class="page-head">
  <div class="badges">
    <span class="badge grad">Exercice 5</span>
    <span class="badge">Section 5 du TD</span>
    <span class="badge cyan">Commande shell</span>
  </div>
  <h1>Création d’une commande shell&nbsp;: <code class="inline">ls.php</code></h1>
  <p>On programme notre propre <code class="inline">ls</code> en PHP&nbsp;: il affiche les fichiers du dossier
  courant dont on passe les <strong>suffixes en arguments</strong>. Pour ça on utilise le tableau
  <code class="inline">$argv</code>, qui contient tout ce qu’on tape après <code class="inline">php ls.php</code>.</p>
</div>

<div class="qa">
  <?php question('Comment ça marche, le tableau <code>$argv</code>&nbsp;?'); ?>
  <?php reponse('
    <p>Quand on lance un script en ligne de commande, PHP remplit <code>$argv</code> avec tous les arguments
    tapés après le nom du script. Exemple&nbsp;:</p>
    <p><code>php script.php 1 2 3</code> → <code>$argv[0] = "script.php"</code>,
    <code>$argv[1] = 1</code>, <code>$argv[2] = 2</code>, <code>$argv[3] = 3</code>…</p>
    <p>Du coup dans notre <code>ls.php</code>, <code>array_slice($argv, 1)</code> nous donne juste la liste
    des suffixes demandés (on saute le nom du script).</p>
  '); ?>
</div>

<div class="qa">
  <?php question('Programmer la commande <code>ls.php</code> qui affiche les fichiers du répertoire courant dont on passe le suffixe en argument.'); ?>
  <?php reponse('
    <p>On parcourt le dossier avec <code>scandir()</code>, on trie les noms avec <code>sort()</code>, puis
    pour chaque suffixe demandé on garde les fichiers qui finissent par <code>.suffixe</code>
    (avec <code>str_ends_with()</code>). Si un suffixe ne trouve rien, on affiche
    <code>tgz : no file found</code> comme dans l’énoncé.</p>
    <p>Si aucun argument n’est passé, on affiche simplement <strong>tout le contenu</strong> du dossier.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function ls_fichiers(string $repertoire, array $suffixes = []): array
{
    $fichiers = [];
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        if (is_file($repertoire . '/' . $entree)) {
            $fichiers[] = $entree;
        }
    }
    sort($fichiers);

    if ($suffixes === []) {
        return $fichiers; // aucun filtre : tout le dossier
    }

    $parSuffixe = [];
    foreach ($suffixes as $suffixe) {
        $parSuffixe[$suffixe] = [];
    }
    foreach ($fichiers as $fichier) {
        foreach ($suffixes as $suffixe) {
            if (str_ends_with(strtolower($fichier), '.' . strtolower($suffixe))) {
                $parSuffixe[$suffixe][] = $fichier;
            }
        }
    }
    return $parSuffixe;
}

// --- partie "commande" ---
$suffixes = array_slice($argv, 1); // les arguments sauf le nom du script
$resultat = ls_fichiers('.', $suffixes);

if ($suffixes === []) {
    foreach ($resultat as $fichier) {
        echo $fichier, "\n";
    }
} else {
    foreach ($resultat as $suffixe => $fichiers) {
        if ($fichiers === []) {
            echo $suffixe, " : no file found\n";
        } else {
            foreach ($fichiers as $fichier) {
                echo $fichier, "\n";
            }
        }
    }
}
PHP, 'ls.php · le script complet'); ?>
</div>

<div class="qa">
  <?php question('Vérification avec l’exemple du TD (dossier contenant archive1.rar, exemple1.txt, img1.gif…).'); ?>
  <?php reponse('
    <p>On a recréé le dossier de l’énoncé dans <code>assets/demo-ls/</code>. En tapant
    <code>php ls.php jpg txt rar gif tgz</code>, on obtient exactement la sortie attendue&nbsp;:
    les fichiers groupés par suffixe dans l’ordre des arguments, et
    <code>tgz : no file found</code> à la fin car il n’y a pas de fichier .tgz.</p>
  '); ?>

  <?php afficherTerminal(array_merge(['cmd : php ls.php jpg txt rar gif tgz'], $sortie), 'Terminal · exécution réelle dans assets/demo-ls'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Contenu du dossier de démo</div>
    <pre><?= htmlspecialchars(implode("\n", array_values(ls_fichiers($demo)))) ?></pre>
    <p style="margin:.75rem 0 0; color: var(--muted); font-size:.92rem">
      Sans argument, <code>php ls.php</code> affiche cette liste complète. Testable pour de vrai
      en ligne de commande&nbsp;: <code>php ls.php jpg txt rar gif tgz</code>.
    </p>
  </div>
</div>

<div class="pager">
  <a href="index-exo4.php"><div class="dir">← Précédent</div><div class="name">Exercice 4 · Répertoires</div></a>
  <a class="next" href="index-exo6.php"><div class="dir">Suivant →</div><div class="name">Exercice 6 · size.php</div></a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
