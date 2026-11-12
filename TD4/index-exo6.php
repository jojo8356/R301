<?php
$titrePage = 'Exercice 6 — Commande shell size.php';
$pageActive = 'exo6';
require __DIR__ . '/includes/header.php';

require __DIR__ . '/size.php'; // pour réutiliser taille_repertoire() et formater_taille()

// Démos en direct
$tailleAssets = taille_repertoire(__DIR__ . '/assets');
$tailleTd = taille_repertoire(__DIR__);
$tailleDemo = taille_repertoire(__DIR__ . '/assets/demo-ls');
?>

<div class="page-head">
  <div class="badges">
    <span class="badge grad">Exercice 6</span>
    <span class="badge">Section 6 du TD</span>
    <span class="badge cyan">Commande shell</span>
  </div>
  <h1>Création d’une commande shell&nbsp;: <code class="inline">size.php</code></h1>
  <p>La commande <code class="inline">size</code> calcule la <strong>taille totale du répertoire courant</strong>.
  Attention, il faut parcourir <strong>toute l’arborescence</strong>&nbsp;: les sous-dossiers comptent aussi&nbsp;!
  C’est l’occasion de faire de la <strong>récursivité</strong>.</p>
</div>

<div class="qa">
  <?php question('Comment calculer la taille d’un dossier et de tout ce qu’il contient&nbsp;?'); ?>
  <?php reponse('
    <p>Un dossier n’a pas vraiment de « taille »&nbsp;: c’est la somme des tailles de tous les fichiers
    qu’il contient, <strong>et de tous les fichiers dans ses sous-dossiers</strong>, et ainsi de suite.</p>
    <p>On écrit donc une fonction qui <em>s’appelle elle-même</em>&nbsp;: c’est la récursivité. Pour chaque entrée,
    si c’est un <strong>dossier</strong> on rappelle la fonction dessus&nbsp;; si c’est un <strong>fichier</strong>,
    on ajoute <code>filesize()</code> au total.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
/**
 * Calcule récursivement la taille totale d'un répertoire (en octets).
 */
function taille_repertoire(string $repertoire): int
{
    $taille = 0;

    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;

        if (is_dir($chemin)) {
            // C'est un dossier : on descend dedans (récursivité !)
            $taille += taille_repertoire($chemin);
        } elseif (is_file($chemin)) {
            // C'est un fichier : on ajoute sa taille
            $taille += filesize($chemin);
        }
    }
    return $taille;
}

// --- partie "commande" ---
$taille = taille_repertoire('.');
echo "Taille totale du répertoire courant : $taille octets\n";
PHP, 'size.php · le script complet (cœur récursif)'); ?>
</div>

<div class="qa">
  <?php question('Rendre la taille lisible (octets, Ko, Mo…).'); ?>
  <?php reponse('
    <p>Un nombre d’octets comme <code>48219</code>, ça ne parle à personne. On le divise par 1024 tant qu’il
    est grand, en changeant l’unité à chaque fois (o → Ko → Mo → Go), et on arrondit à 2 décimales.
    Petit bonus propre, c’est plus joli à l’affichage.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function formater_taille(int $octets): string
{
    $unites = ['o', 'Ko', 'Mo', 'Go'];
    $i = 0;
    $taille = (float) $octets;

    while ($taille >= 1024 && $i < count($unites) - 1) {
        $taille /= 1024;
        $i++;
    }
    return ($i === 0)
        ? $octets . ' o'
        : number_format($taille, 2, ',', ' ') . ' ' . $unites[$i];
}
PHP, 'size.php · fonction formater_taille()'); ?>
</div>

<div class="qa">
  <?php question('Test de la commande sur les dossiers du projet.'); ?>
  <?php reponse('
    <p>La fonction tourne vraiment sur le serveur&nbsp;: ci-dessous les tailles calculées en direct sur
    <code>assets/</code> (avec tous ses sous-dossiers) et sur tout le dossier TD4. En ligne de commande,
    il suffit de taper <code>php size.php</code> pour obtenir le même genre de résultat.</p>
  '); ?>

  <?php afficherTerminal([
    'cmd : php size.php',
    'out : Taille totale du répertoire courant :',
    'out : - ' . $tailleTd . ' octets',
    'out : - ' . formater_taille($tailleTd),
  ], 'Terminal · sortie attendue de size.php'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — calculs réels</div>
    <p style="margin:.25rem 0">
      <span class="pill ok">assets/ (récursif)</span>
      <code><?= $tailleAssets ?> octets</code> ≈ <strong><?= formater_taille($tailleAssets) ?></strong>
    </p>
    <p style="margin:.45rem 0">
      <span class="pill ok">assets/demo-ls/</span>
      <code><?= $tailleDemo ?> octets</code> ≈ <strong><?= formater_taille($tailleDemo) ?></strong>
    </p>
    <p style="margin:.45rem 0">
      <span class="pill ok">TD4 complet (récursif)</span>
      <code><?= $tailleTd ?> octets</code> ≈ <strong><?= formater_taille($tailleTd) ?></strong>
    </p>
    <p style="margin:.75rem 0 0; color: var(--muted); font-size:.92rem">
      Le total de <code>assets/</code> inclut bien les fichiers de <code>assets/demo-ls/</code> —
      c’est ça, la récursivité. 👌
    </p>
  </div>
</div>

<div class="pager">
  <a href="index-exo5.php"><div class="dir">← Précédent</div><div class="name">Exercice 5 · ls.php</div></a>
  <a class="next" href="index.php"><div class="dir">Terminé →</div><div class="name">Retour à l’accueil</div></a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
