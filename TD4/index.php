<?php
$titrePage = 'Accueil — Manipulation de fichiers et de répertoires';
$pageActive = 'accueil';
require __DIR__ . '/includes/header.php';
?>

<section class="hero">
  <div class="badges">
    <span class="badge grad">R301 · Programmation Web</span>
    <span class="badge">TD n°4 · Séance 4</span>
    <span class="badge green">PHP <?= PHP_VERSION ?></span>
    <span class="badge cyan">100 % démos live</span>
  </div>
  <h1>Manipulation de <span class="grad-text">fichiers</span> et de<br><span class="grad-text">répertoires</span> en PHP</h1>
  <p class="lead">
    Bienvenue sur notre mini-application du TD4&nbsp;! Ici on lit, on écrit, on crée des dossiers,
    on gère les droits… et on code même nos petites commandes shell <code class="inline">ls</code>
    et <code class="inline">size</code>. Toutes les réponses du TD sont sur les pages ci-dessous,
    expliquées simplement, avec le code qui tourne vraiment sur le serveur.
  </p>
  <div class="actions">
    <a class="btn btn-primary" href="index-exo3.php">Commencer par l’exercice 3 →</a>
    <a class="btn btn-ghost" href="TD4-projet.zip" download>⬇ Télécharger le projet (.zip)</a>
    <a class="btn btn-ghost" href="#les-exercices">Voir tous les exercices</a>
    <a class="btn btn-ghost" href="#droits-acl">Droits &amp; transfert de serveur</a>
  </div>
</section>

<section class="section" id="les-exercices">
  <h2 class="section-title">Les exercices du TD</h2>
  <p class="section-sub">Clique sur un bouton pour ouvrir l’exercice correspondant : question, réponse, code et démonstration.</p>

  <div class="grid">
    <a class="exo-card" href="index-exo3.php">
      <div class="exo-num">3</div>
      <h3>Lecture et écriture de fichiers</h3>
      <p>On ouvre <strong>TD3-Cars.txt</strong> avec <code class="inline">fopen()</code>, on récupère les marques
      et les modèles, puis on réécrit le tableau des voitures en <strong>.tsv</strong> avec
      <code class="inline">fputcsv()</code>.</p>
      <div class="tags"><span class="badge amber">fopen</span><span class="badge amber">fgetcsv</span><span class="badge amber">fputcsv</span></div>
      <span class="go">Ouvrir l’exercice <span class="arrow">→</span></span>
    </a>

    <a class="exo-card" href="index-exo4.php">
      <div class="exo-num">4</div>
      <h3>Manipulation de répertoires</h3>
      <p>Créer, renommer et supprimer un dossier (<code class="inline">mkdir</code>,
      <code class="inline">rename</code>, <code class="inline">rmdir</code>), lister des fichiers par suffixe,
      afficher un tableau nom/taille et changer les droits.</p>
      <div class="tags"><span class="badge amber">mkdir</span><span class="badge amber">rmdir</span><span class="badge amber">chmod</span></div>
      <span class="go">Ouvrir l’exercice <span class="arrow">→</span></span>
    </a>

    <a class="exo-card" href="index-exo5.php">
      <div class="exo-num">5</div>
      <h3>Commande shell : ls.php</h3>
      <p>Notre propre commande <code class="inline">ls</code> en PHP&nbsp;: elle affiche les fichiers du dossier
      courant dont on passe les suffixes en arguments grâce au tableau <code class="inline">$argv</code>.</p>
      <div class="tags"><span class="badge amber">$argv</span><span class="badge amber">CLI</span></div>
      <span class="go">Ouvrir l’exercice <span class="arrow">→</span></span>
    </a>

    <a class="exo-card" href="index-exo6.php">
      <div class="exo-num">6</div>
      <h3>Commande shell : size.php</h3>
      <p>La commande <code class="inline">size</code> calcule la taille totale du répertoire courant
      en parcourant <strong>toute l’arborescence</strong> (récursivité).</p>
      <div class="tags"><span class="badge amber">récursivité</span><span class="badge amber">filesize</span></div>
      <span class="go">Ouvrir l’exercice <span class="arrow">→</span></span>
    </a>
  </div>
</section>

<section class="section" id="reponses-rapides">
  <h2 class="section-title">Les réponses en 30 secondes ⚡</h2>
  <p class="section-sub">Le résumé des questions qui tombent le plus souvent, répondu comme on le dirait en cours.</p>

  <div class="qa">
    <?php question('Que constatez-vous quand on crée, renomme et détruit un répertoire&nbsp;?'); ?>
    <?php reponse('
      <p>On constate que <code>rmdir()</code> ne peut supprimer qu’un dossier <strong>vide</strong>.
      S’il reste des fichiers dedans, PHP affiche un warning du type
      <code>rmdir(): Directory not empty</code> et le dossier reste là. Idem pour
      <code>mkdir()</code>&nbsp;: il refuse de créer un dossier qui existe déjà.</p>
    '); ?>
  </div>

  <div class="qa">
    <?php question('Si la création ne se fait pas, quelle est la raison et comment y remédier&nbsp;?'); ?>
    <?php reponse('
      <p>Deux raisons classiques&nbsp;:</p>
      <ul>
        <li>le dossier <strong>existe déjà</strong> → on vérifie avec <code>is_dir()</code> avant de créer&nbsp;;</li>
        <li>le serveur web (souvent <code>www-data</code>) <strong>n’a pas les droits d’écriture</strong>
        dans le dossier parent (erreur <em>Permission denied</em>) → on corrige avec
        <code>chmod()</code>, <code>chown()</code> ou <code>setfacl</code>.</li>
      </ul>
    '); ?>
  </div>

  <div class="qa">
    <?php question('Est-ce que les droits (ex : setfacl -m u:www-data:rw assets/TD3-Cars.txt) restent quand on transfère le projet sur un autre serveur&nbsp;?'); ?>
    <?php reponse('
      <p><strong>Non, pas vraiment.</strong> Les ACL posées par <code>setfacl</code> sont stockées dans les
      <strong>métadonnées du système de fichiers</strong> du serveur d’origine&nbsp;: elles ne suivent ni
      <code>git</code>, ni <code>zip</code>, ni FTP, et rarement <code>scp</code>. Même les droits
      <code>chmod</code> classiques sont souvent perdus (git ne garde que le bit « exécutable »).</p>
      <p>Du coup, une fois les fichiers copiés sur le nouveau serveur, il faut <strong>rejouer la commande</strong>
      (par exemple relancer le script <code>setup-droits.sh</code> fourni avec le TD). C’est exactement
      pour ça que ce script existe&nbsp;: il n’a qu’à être relancé après chaque déploiement.</p>
    '); ?>
  </div>

  <div class="qa">
    <?php question('Pourquoi fopen() renvoie false, et on fait quoi&nbsp;?'); ?>
    <?php reponse('
      <p>Ça veut dire que le fichier n’a pas pu être ouvert&nbsp;: mauvais chemin, fichier absent, ou pas
      les droits en lecture. Du coup on teste le retour de <code>fopen()</code>, on affiche un message
      d’erreur, et on pense à <code>fclose()</code> quand on a fini pour libérer le fichier.</p>
    '); ?>
  </div>
</section>

<section class="section" id="droits-acl">
  <div class="highlight">
    <h3>🔐 Focus droits &amp; ACL — <code class="inline">setfacl</code></h3>
    <p>La commande du TD&nbsp;: <code>setfacl -m u:www-data:rw assets/TD3-Cars.txt</code> donne
    lecture + écriture sur le fichier <strong>uniquement à l’utilisateur www-data</strong> (le serveur web),
    sans toucher aux autres utilisateurs. On vérifie avec <code>getfacl assets/TD3-Cars.txt</code>.</p>
    <p>⚠️ <strong>Est-ce que ça survit à un transfert vers un autre serveur&nbsp;?</strong>
    Non&nbsp;: les ACL sont des <em>attributs étendus</em> locaux au disque. Après un
    <code>git clone</code>, un <code>zip</code>, un FTP ou même un simple copier-coller, elles sont
    perdues. La méthode&nbsp;: mettre les commandes de droits dans un petit script
    (<code>setup-droits.sh</code>, fourni dans le dossier TD4) et le relancer sur chaque serveur.</p>
    <p>Notre script fait les deux niveaux&nbsp;:</p>
    <ul class="checklist">
      <li><strong>chmod</strong> classique (le socle)&nbsp;: dossiers en <code>755</code>, fichiers en <code>644</code>,
      <code>assets/</code> en <code>775</code> pour que le serveur puisse écrire les .tsv&nbsp;;</li>
      <li><strong>setfacl</strong> (le confort)&nbsp;: <code>u:www-data:rw</code> sur <code>assets/</code>
      et ses fichiers, pour que le serveur web écrive dedans sans pour autant ouvrir les droits à tout le monde.</li>
    </ul>
    <p style="margin-top:.9rem"><code class="inline">bash setup-droits.sh</code> → à relancer à chaque déploiement. 👍</p>
  </div>
</section>

<section class="section">
  <h2 class="section-title">La structure du livrable</h2>
  <p class="section-sub">Celle demandée dans l’énoncé&nbsp;: dossier <code class="inline">TD4</code> avec
  <code class="inline">assets/</code>, <code class="inline">css/</code>, <code class="inline">index.php</code>
  et les <code class="inline">index-exo{x}.php</code>.</p>
<?php
$arborescence = <<<TXT
TD4/
├── index.php            ← la page d’accueil (celle-ci)
├── index-exo3.php       ← exercice 3 : lecture / écriture de fichiers
├── index-exo4.php       ← exercice 4 : manipulation de répertoires
├── index-exo5.php       ← exercice 5 : commande shell ls.php
├── index-exo6.php       ← exercice 6 : commande shell size.php
├── ls.php               ← la commande ls (exécutable en ligne de commande)
├── size.php             ← la commande size (taille totale, récursive)
├── setup-droits.sh      ← le script pour remettre les droits (chmod + setfacl)
├── css/
│   └── td4.css          ← le style moderne de l’application
├── includes/
│   ├── header.php       ← en-tête + fonctions d’affichage communes
│   └── footer.php
└── assets/
    ├── TD3-Cars.txt     ← le fichier des voitures (marque;modèle)
    ├── voitures.tsv     ← généré par l’exo 3 (fputcsv)
    └── demo-ls/         ← les fichiers de l’exemple du TD pour ls.php
TXT;
afficherCode($arborescence, 'Arborescence du livrable');
?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
