<?php
$titrePage = 'Exercice 3 — Lecture et écriture de fichiers';
$pageActive = 'exo3';
require __DIR__ . '/includes/header.php';

// ---------------------------------------------------------------
// Le code "réponse" est aussi exécuté ici pour la démo en direct.
// ---------------------------------------------------------------
$cheminCars = __DIR__ . '/assets/TD3-Cars.txt';

/** Ouvre un fichier et renvoie le pointeur, ou false si ça ne marche pas. */
function ouvrirFichier(string $chemin)
{
    $pointeur = fopen($chemin, 'r');
    return $pointeur; // false si l'ouverture a échoué
}

/** Récupère la liste des marques présentes dans le fichier. */
function getMarques(string $chemin): array
{
    $fichier = fopen($chemin, 'r');
    if ($fichier === false) {
        return [];
    }
    $marques = [];
    while (($ligne = fgetcsv($fichier, 0, ';', '"', '')) !== false) {
        if (count($ligne) < 2) {
            continue;
        }
        $marque = trim($ligne[0]);
        if ($marque !== '' && !in_array($marque, $marques, true)) {
            $marques[] = $marque;
        }
    }
    fclose($fichier);
    return $marques;
}

/** Récupère la liste des modèles présents dans le fichier. */
function getModeles(string $chemin): array
{
    $fichier = fopen($chemin, 'r');
    if ($fichier === false) {
        return [];
    }
    $modeles = [];
    while (($ligne = fgetcsv($fichier, 0, ';', '"', '')) !== false) {
        if (count($ligne) < 2) {
            continue;
        }
        $modele = trim($ligne[1]);
        if ($modele !== '' && !in_array($modele, $modeles, true)) {
            $modeles[] = $modele;
        }
    }
    fclose($fichier);
    return $modeles;
}

// Le tableau des voitures repris des TD précédents
$voitures = [
    ['marque' => 'Renault', 'modele' => 'Clio', 'annee' => 2019, 'couleur' => 'Gris'],
    ['marque' => 'Renault', 'modele' => 'Megane', 'annee' => 2021, 'couleur' => 'Bleu'],
    ['marque' => 'Peugeot', 'modele' => '208', 'annee' => 2020, 'couleur' => 'Rouge'],
    ['marque' => 'Peugeot', 'modele' => '3008', 'annee' => 2022, 'couleur' => 'Noir'],
    ['marque' => 'Citroen', 'modele' => 'C3', 'annee' => 2018, 'couleur' => 'Blanc'],
    ['marque' => 'Volkswagen', 'modele' => 'Golf', 'annee' => 2021, 'couleur' => 'Gris'],
    ['marque' => 'Toyota', 'modele' => 'Yaris', 'annee' => 2023, 'couleur' => 'Bleu'],
    ['marque' => 'Audi', 'modele' => 'A3', 'annee' => 2022, 'couleur' => 'Noir'],
];

// Écriture du tableau en TSV avec fputcsv()
$cheminTsv = __DIR__ . '/assets/voitures.tsv';
$tsv = fopen($cheminTsv, 'w');
if ($tsv !== false) {
    fputcsv($tsv, ['Marque', 'Modèle', 'Année', 'Couleur'], "\t", escape: '');
    foreach ($voitures as $voiture) {
        fputcsv($tsv, $voiture, "\t", escape: '');
    }
    fclose($tsv);
}

// Démos
$pointeur = ouvrirFichier($cheminCars);
$ouvertureOk = ($pointeur !== false);
if ($ouvertureOk) {
    fclose($pointeur);
}
$marques = getMarques($cheminCars);
$modeles = getModeles($cheminCars);
$contenuTsv = @file_get_contents($cheminTsv) ?: '';
?>

<div class="page-head">
  <div class="badges">
    <span class="badge grad">Exercice 3</span>
    <span class="badge">Section 3 du TD</span>
    <span class="badge cyan">Démo en direct</span>
  </div>
  <h1>Lecture et écriture de fichiers</h1>
  <p>On ouvre le fameux fichier <code class="inline">TD3-Cars.txt</code>, on lit les marques et les modèles,
  puis on réécrit notre tableau des voitures dans un fichier <strong>.tsv</strong> avec
  <code class="inline">fputcsv()</code>.</p>
</div>

<!-- Question 1 -->
<div class="qa">
  <?php question('Ouvrir le fichier «&nbsp;TD3-Cars.txt&nbsp;» à l’aide de la fonction <code>fopen()</code>, détectez si l’ouverture se fait bien et récupérer le pointeur de fichier.'); ?>
  <?php reponse('
    <p><code>fopen()</code> renvoie un <strong>pointeur sur le fichier</strong> (un peu comme une télécommande
    pour lire/écrire dedans). Si l’ouverture rate, elle renvoie <code>false</code> — par exemple si le chemin
    est faux ou si on n’a pas les droits. Du coup on teste juste après l’appel, et on ferme le fichier avec
    <code>fclose()</code> quand on a fini.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
// On ouvre le fichier en mode "r" = lecture seule
$pointeur = fopen('assets/TD3-Cars.txt', 'r');

// On vérifie que l'ouverture s'est bien passée
if ($pointeur === false) {
    die("Impossible d'ouvrir le fichier TD3-Cars.txt !");
}

// Ici on peut lire le fichier avec le pointeur...

// Pensez toujours à fermer le fichier !
fclose($pointeur);
PHP, 'index-exo3.php · ouverture du fichier'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct</div>
    <p style="margin:.25rem 0">
      Ouverture de <code>assets/TD3-Cars.txt</code> :
      <?php if ($ouvertureOk): ?>
        <span class="pill ok">✓ fopen() a renvoyé un pointeur valide</span>
      <?php else: ?>
        <span class="pill fail">✗ fopen() a renvoyé false</span>
      <?php endif; ?>
    </p>
  </div>
</div>

<!-- Question 2 -->
<div class="qa">
  <?php question('Créez une fonction qui permet de récupérer dans le fichier la liste des marques.'); ?>
  <?php reponse('
    <p>On lit le fichier <strong>ligne par ligne</strong> avec <code>fgetcsv()</code> (le fichier est au format
    <code>marque;modèle</code>, donc le séparateur c’est <code>";"</code>). On garde le premier mot de chaque
    ligne (= la marque), et comme on ne veut pas de doublons, on vérifie avec <code>in_array()</code>
    avant d’ajouter dans le tableau.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function getMarques(string $chemin): array
{
    $fichier = fopen($chemin, 'r');
    if ($fichier === false) {
        return [];
    }

    $marques = [];
    while (($ligne = fgetcsv($fichier, 0, ';', '"', '')) !== false) {
        if (count($ligne) < 2) {
            continue; // ligne bizarre, on passe
        }
        $marque = trim($ligne[0]); // 1ère colonne = la marque
        if ($marque !== '' && !in_array($marque, $marques, true)) {
            $marques[] = $marque;
        }
    }
    fclose($fichier);
    return $marques;
}
PHP, 'index-exo3.php · fonction getMarques()'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — getMarques()</div>
    <p style="margin:.25rem 0"><?= count($marques) ?> marques trouvées dans TD3-Cars.txt :</p>
    <p><?php foreach ($marques as $m): ?><span class="badge" style="margin:.2rem"><?= htmlspecialchars($m) ?></span><?php endforeach; ?></p>
  </div>
</div>

<!-- Question 3 -->
<div class="qa">
  <?php question('Créez une fonction qui permet de récupérer dans le fichier la liste des modèles.'); ?>
  <?php reponse('
    <p>C’est la même idée que pour les marques, sauf qu’on prend la <strong>deuxième colonne</strong>
    de chaque ligne (<code>$ligne[1]</code>). Rien de compliqué, on copie-colle la fonction précédente
    et on change juste l’indice.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
function getModeles(string $chemin): array
{
    $fichier = fopen($chemin, 'r');
    if ($fichier === false) {
        return [];
    }

    $modeles = [];
    while (($ligne = fgetcsv($fichier, 0, ';', '"', '')) !== false) {
        if (count($ligne) < 2) {
            continue;
        }
        $modele = trim($ligne[1]); // 2ème colonne = le modèle
        if ($modele !== '' && !in_array($modele, $modeles, true)) {
            $modeles[] = $modele;
        }
    }
    fclose($fichier);
    return $modeles;
}
PHP, 'index-exo3.php · fonction getModeles()'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — getModeles()</div>
    <p style="margin:.25rem 0"><?= count($modeles) ?> modèles trouvés :</p>
    <p><?php foreach ($modeles as $m): ?><span class="badge" style="margin:.2rem"><?= htmlspecialchars($m) ?></span><?php endforeach; ?></p>
  </div>
</div>

<!-- Question 4 -->
<div class="qa">
  <?php question('Reprendre le tableau des voitures des TD précédents et l’écrire dans un fichier avec <code>fputcsv()</code>, les données séparées par une tabulation <code>"\\t"</code> (fichier .tsv).'); ?>
  <?php reponse('
    <p><code>fputcsv()</code> écrit une ligne de tableau dans le fichier. Le 3ème paramètre est le
    <strong>séparateur</strong>&nbsp;: on met <code>"\\t"</code> (tabulation) au lieu de la virgule,
    comme ça on obtient un vrai fichier <strong>.tsv</strong> (<em>Tabulation-Separated Values</em>).</p>
    <p>Petit piège en PHP 8.4+&nbsp;: il faut ajouter <code>escape: \'\'</code> pour éviter un message de
    dépréciation sur le paramètre d’échappement.</p>
  '); ?>

  <?php afficherCode(<<<'PHP'
<?php
// Le tableau des voitures repris des TD précédents
$voitures = [
    ['marque' => 'Renault', 'modele' => 'Clio', 'annee' => 2019, 'couleur' => 'Gris'],
    ['marque' => 'Renault', 'modele' => 'Megane', 'annee' => 2021, 'couleur' => 'Bleu'],
    ['marque' => 'Peugeot', 'modele' => '208', 'annee' => 2020, 'couleur' => 'Rouge'],
    // ... les autres voitures ...
];

$fichier = fopen('assets/voitures.tsv', 'w');
if ($fichier === false) {
    die("Impossible de créer le fichier voitures.tsv !");
}

// L'en-tête du tableau, séparé par des tabulations "\t"
fputcsv($fichier, ['Marque', 'Modèle', 'Année', 'Couleur'], "\t", escape: '');

// Puis chaque voiture, une par ligne
foreach ($voitures as $voiture) {
    fputcsv($fichier, $voiture, "\t", escape: '');
}

fclose($fichier);
PHP, 'index-exo3.php · écriture du .tsv'); ?>

  <div class="demo">
    <div class="demo-title">🧪 Démo en direct — fichier assets/voitures.tsv généré</div>
    <p style="margin:.25rem 0">
      Le fichier a bien été écrit sur le serveur
      <span class="pill ok">✓ <?= htmlspecialchars(droitsLisibles($cheminTsv)) ?> · <?= @filesize($cheminTsv) ?> octets</span>
    </p>
    <pre><?= htmlspecialchars($contenuTsv) ?></pre>
  </div>
</div>

<div class="pager">
  <a href="index.php"><div class="dir">← Précédent</div><div class="name">Accueil</div></a>
  <a class="next" href="index-exo4.php"><div class="dir">Suivant →</div><div class="name">Exercice 4 · Répertoires</div></a>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
