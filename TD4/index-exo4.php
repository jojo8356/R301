<?php
$titrePage = 'Exercice 4 — Manipulation de répertoires';
$pageActive = 'exo4';
require __DIR__ . '/includes/header.php';

// ---------------------------------------------------------------
// Démo en direct : créer, renommer, détruire un répertoire
// ---------------------------------------------------------------
$demo = __DIR__ . '/assets/demo-rep';
$trace = [];

@mkdir($demo, 0775);
$trace[] = ['mkdir(' . 'assets/demo-rep' . ')', is_dir($demo)];

@file_put_contents($demo . '/fichier1.txt', 'salut');
@file_put_contents($demo . '/fichier2.txt', 'ça marche');
$trace[] = ['création de 2 fichiers dedans', is_file($demo . '/fichier1.txt')];

$demo2 = __DIR__ . '/assets/demo-rep-renomme';
if (is_dir($demo2)) {
    @rmdir($demo2);
}
$renomme = @rename($demo, $demo2);
$trace[] = ['rename() vers demo-rep-renomme', $renomme && is_dir($demo2)];

// On essaie de supprimer le dossier qui contient encore des fichiers
$rmdirRate = !@rmdir($demo2);
$trace[] = ['rmdir() alors qu’il reste des fichiers', !$rmdirRate ? 'ok' : 'échec (normal !)'];

// On vide puis on supprime : là ça marche
@unlink($demo2 . '/fichier1.txt');
@unlink($demo2 . '/fichier2.txt');
$rmdirOk = @rmdir($demo2);
$trace[] = ['rmdir() une fois le dossier vide', $rmdirOk];

/** Parcourt un répertoire et liste les fichiers avec un suffixe donné. */
function listerParSuffixe(string $repertoire, string $suffixe): array
{
    $suffixe = ltrim($suffixe, '*.'); // on enlève "*." si l'utilisateur l'a mis
    $resultat = [];
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;
        if (is_file($chemin) && str_ends_with(strtolower($entree), '.' . strtolower($suffixe))) {
            $resultat[] = $entree;
        }
    }
    return $resultat;
}

/** Crée un tableau [nom => taille] pour les fichiers du répertoire. */
function fichiersTailles(string $repertoire = '.'): array
{
    $tableau = [];
    foreach (scandir($repertoire) as $entree) {
        $chemin = $repertoire . '/' . $entree;
        if (is_file($chemin)) {
            $tableau[$entree] = filesize($chemin);
        }
    }
    return $tableau;
}

/** Change les droits de tous les éléments d'un répertoire. */
function changerDroits(string $repertoire, int $droits): array
{
    $faits = [];
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;
        if (chmod($chemin, $droits)) {
            $faits[] = $entree;
        }
    }
    return $faits;
}

$fichiersTxt = listerParSuffixe(__DIR__ . '/assets', 'txt');
$fichiersPhp = listerParSuffixe(__DIR__, 'php');
$tailles = fichiersTailles(__DIR__ . '/assets');

// Démo chmod : droits avant / après sur un fichier de démo
$fichierDroits = __DIR__ . '/assets/TD3-Cars.txt';
$avant = droitsLisibles($fichierDroits);
@chmod($fichierDroits, 0664);
$apres = droitsLisibles($fichierDroits);
?>

<div class="page-head">
  <div class="badges">
    <span class="badge grad">Exercice 4</span>
    <span class="badge">Section 4 du TD</span>
    <span class="badge cyan">Démo en direct</span>
  </div>
  <h1>Manipulation de répertoires</h1>
  <p>Créer, renommer et supprimer des dossiers, lister des fichiers par suffixe, afficher un tableau
  nom/taille avec <code class="inline">print_r()</code>, et gérer les droits. Avec en bonus la question
  qui revient tout le temps&nbsp;: <strong>est-ce que les droits survivent à un transfert de serveur&nbsp;?</strong></p>
</div>

<!-- Question 1 -->
<div class="qa">
  <?php question('Utilisez les fonctions pour créer, renommer et détruire un répertoire. <strong>Que constatez-vous&nbsp;?</strong>'); ?>
  <?php reponse('
    <p>On constate que <code>rmdir()</code> ne supprime qu’un dossier <strong>vide</strong>&nbsp;: s’il reste
    des fichiers dedans, PHP renvoie <code>false</code> avec un warning <em>Directory not empty</em> et le
    dossier reste sur place. Il faut d’abord supprimer (ou déplacer) son contenu.</p>
    <p>Pareil pour <code>mkdir()</code>&nbsp;: si le dossier existe déjà, la création échoue. Et
    <code>rename()</code> sert à la fois à renommer <em>et</em> à déplacer un dossier.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
// 1) Créer un répertoire
mkdir('assets/demo-rep');

// 2) Le renommer (et le déplacer dans le même temps)
rename('assets/demo-rep', 'assets/demo-rep-renomme');

// 3) Le détruire — mais seulement s'il est vide !
rmdir('assets/demo-rep-renomme');
PHP, 'index-exo4.php · créer, renommer, détruire'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — exécutée sur le serveur</div>
    <p style="margin:.25rem 0 0">
      <?php foreach ($trace as [$etape, $etat]): ?>
        <span class="pill <?= ($etat === true || $etat === 'ok') ? 'ok' : 'fail' ?>" style="margin:.22rem">
          <?= ($etat === true || $etat === 'ok') ? '✓' : '✗' ?> <?= htmlspecialchars($etape) ?> :
          <?= $etat === true ? 'OK' : ($etat === false ? 'échec' : htmlspecialchars((string)$etat)) ?>
        </span>
      <?php endforeach; ?>
    </p>
  </div>
</div>

<!-- Question 2 -->
<div class="qa">
  <?php question('Dans le cas où la création ne se fait pas, quelle en est la raison et comment peut-on remédier à ce problème&nbsp;?'); ?>
  <?php reponse('
    <p>Deux raisons classiques&nbsp;:</p>
    <ul>
      <li>le dossier <strong>existe déjà</strong> → <code>mkdir()</code> renvoie <code>false</code>.
      On remédie en vérifiant avant avec <code>is_dir()</code>&nbsp;;</li>
      <li>le serveur web (souvent l’utilisateur <code>www-data</code>) <strong>n’a pas les droits d’écriture</strong>
      dans le dossier parent → erreur <em>Permission denied</em>. On remédie avec <code>chmod()</code>
      (ex&nbsp;: <code>775</code>), <code>chown()</code>, ou <code>setfacl</code> (voir plus bas).</li>
    </ul>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
if (!is_dir('assets/demo-rep')) {
    // Le dossier n'existe pas encore : on peut le créer
    if (!mkdir('assets/demo-rep', 0775)) {
        // Échec = sûrement un problème de droits sur le dossier parent
        die("Permission refusée : vérifiez les droits avec chmod ou setfacl.");
    }
}
PHP, 'index-exo4.php · créer sans risque'); ?>
</div>

<!-- Question 3 -->
<div class="qa">
  <?php question('Faites une fonction permettant de parcourir un répertoire et lister les fichiers qui portent un suffixe passé en paramètre (comme <code>*.css</code>, <code>*.txt</code>, <code>*.jpg</code>…).'); ?>
  <?php reponse('
    <p>On utilise <code>scandir()</code> qui renvoie tous les noms d’un dossier (avec les petites entrées
    <code>.</code> et <code>..</code> qu’on ignore). Ensuite on teste la fin du nom avec
    <code>str_ends_with()</code>&nbsp;: si le nom finit par le suffixe demandé (ex&nbsp;: <code>.txt</code>),
    on le garde.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function listerParSuffixe(string $repertoire, string $suffixe): array
{
    $suffixe = ltrim($suffixe, '*.'); // on enlève "*." si l'utilisateur l'a mis
    $resultat = [];

    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;
        if (is_file($chemin) && str_ends_with(strtolower($entree), '.' . strtolower($suffixe))) {
            $resultat[] = $entree;
        }
    }
    return $resultat;
}

print_r(listerParSuffixe('assets', 'txt'));
PHP, 'index-exo4.php · fonction listerParSuffixe()'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — listerParSuffixe()</div>
    <p style="margin:.25rem 0"><code>listerParSuffixe('assets', 'txt')</code> :</p>
    <pre><?= htmlspecialchars(print_r($fichiersTxt, true)) ?></pre>
    <p style="margin:.75rem 0 .25rem"><code>listerParSuffixe('.', 'php')</code> (racine du TD4)&nbsp;:</p>
    <pre><?= htmlspecialchars(print_r($fichiersPhp, true)) ?></pre>
  </div>
</div>

<!-- Question 4 -->
<div class="qa">
  <?php question('Faites une fonction permettant de créer un tableau avec le nom et la taille des fichiers contenus dans le répertoire courant. Afficher ce tableau avec la fonction <code>print_r()</code>.'); ?>
  <?php reponse('
    <p>On repart de <code>scandir()</code> et on range chaque fichier dans un tableau associatif de la forme
    <code>nom&nbsp;=>&nbsp;taille</code>. La taille en octets vient de <code>filesize()</code>.
    Pour l’affichage, <code>print_r()</code> fait tout le travail.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function fichiersTailles(string $repertoire = '.'): array
{
    $tableau = [];
    foreach (scandir($repertoire) as $entree) {
        $chemin = $repertoire . '/' . $entree;
        if (is_file($chemin)) {
            $tableau[$entree] = filesize($chemin); // taille en octets
        }
    }
    return $tableau;
}

// Affichage demandé dans l'énoncé
print_r(fichiersTailles());
PHP, 'index-exo4.php · fonction fichiersTailles() + print_r()'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — print_r(fichiersTailles('assets'))</div>
    <pre><?= htmlspecialchars(print_r($tailles, true)) ?></pre>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Nom du fichier</th><th>Taille (octets)</th></tr></thead>
        <tbody>
        <?php foreach ($tailles as $nom => $taille): ?>
          <tr><td class="mono"><?= htmlspecialchars($nom) ?></td><td class="mono"><?= $taille ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Question 5 -->
<div class="qa">
  <?php question('Faites une fonction permettant de changer les droits des éléments d’un répertoire.'); ?>
  <?php reponse('
    <p>On parcourt le dossier avec <code>scandir()</code> et on applique <code>chmod()</code> sur chaque
    élément. Les droits s’écrivent en octal&nbsp;: <code>0644</code> = le propriétaire écrit et tout le monde
    lit, <code>0755</code> = pareil mais avec l’exécution (pour les dossiers).</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function changerDroits(string $repertoire, int $droits): array
{
    $faits = [];
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;
        if (chmod($chemin, $droits)) { // ex : 0644 ou 0755
            $faits[] = $entree;
        }
    }
    return $faits;
}

changerDroits('assets', 0644);
PHP, 'index-exo4.php · fonction changerDroits()'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — chmod sur assets/TD3-Cars.txt</div>
    <p style="margin:.25rem 0">
      Droits avant&nbsp;: <span class="pill warn"><?= htmlspecialchars($avant) ?></span>
      → après <code>chmod($f, 0664)</code>&nbsp;:
      <span class="pill ok"><?= htmlspecialchars($apres) ?></span>
    </p>
    <p style="margin:.55rem 0 0; color: var(--muted); font-size:.92rem">
      Lecture des droits&nbsp;: <code>substr(sprintf('%04o', fileperms($chemin)), -4)</code>.
    </p>
  </div>
</div>

<!-- Question bonus : droits et transfert -->
<div class="qa">
  <?php question('Bonus — <code>setfacl -m u:www-data:rw /…/Cars.txt</code>&nbsp;: est-ce que les droits restent quand on transfère le projet sur un autre serveur&nbsp;?'); ?>
  <?php reponse('
    <p><strong>Non, pas vraiment.</strong> <code>setfacl</code> pose des <em>ACL</em> (listes de contrôle
    d’accès) qui sont stockées dans les <strong>métadonnées du système de fichiers</strong> du serveur
    d’origine. Elles ne suivent donc pas le projet quand on le copie&nbsp;:</p>
    <ul>
      <li><code>git clone</code> → perdu (git ne garde que le bit « exécutable »)&nbsp;;</li>
      <li><code>zip</code> / copier-coller / FTP → perdu&nbsp;;</li>
      <li><code>scp</code> → garde parfois les droits <code>chmod</code> basiques, mais jamais les ACL&nbsp;;</li>
      <li><code>tar</code> → conserve les droits unix de base, pas les ACL sans options supplémentaires.</li>
    </ul>
    <p>La solution&nbsp;: mettre les commandes de droits dans un script
    (<code>setup-droits.sh</code>, fourni dans le dossier TD4) et le <strong>relancer sur chaque serveur</strong>
    après le transfert. C’est le réflexe « déploiement »&nbsp;: le code est versionné, les droits sont rejoués.</p>
  '); ?>

  <?php afficherCode(<<<'SH'
#!/usr/bin/env bash
# setup-droits.sh — à relancer sur CHAQUE serveur après un transfert
# 1) Les droits classiques (ça voyage mal aussi : on les remet à chaque fois)
find assets -type d -exec chmod 775 {} \;   # dossiers : le serveur peut écrire
find assets -type f -exec chmod 664 {} \;   # fichiers : lecture + écriture

# 2) L'ACL ciblée sur le fichier des voitures
setfacl -m u:www-data:rw assets/TD3-Cars.txt

# 3) On vérifie
getfacl assets/TD3-Cars.txt
SH, 'setup-droits.sh · droits + ACL reproductibles'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Ce qu’il faut retenir</div>
    <p style="margin:.25rem 0">
      <span class="pill fail">✗ Les ACL (setfacl) ne suivent pas les transferts</span>
      <span class="pill warn">⚠ chmod non plus via git/zip</span>
      <span class="pill ok">✓ solution : setup-droits.sh relancé à chaque déploiement</span>
    </p>
  </div>
</div>

<div class="pager">
  <a href="index-exo3.php"><div class="dir">← Précédent</div><div class="name">Exercice 3 · Fichiers</div></a>
  <a class="next" href="index-exo5.php"><div class="dir">Suivant →</div><div class="name">Exercice 5 · ls.php</div></a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
