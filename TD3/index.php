<?php
/**
 * TD3 - Génération et traitement des formulaires HTML en PHP
 * Page sommaire du TD (point d'entrée du dossier TD3/).
 * Design inspiré des tendances 2025-2026 : bento grid, glassmorphism,
 * bordures en dégradé et effets de survol animés.
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TD3 – Formulaires HTML / PHP · R301</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/td3.css?v=3" />
</head>
<body class="accueil">

  <header class="topbar">
    <span class="marque">
      <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 2l2.2 6.6L21 11l-6.8 2.4L12 20l-2.2-6.6L3 11l6.8-2.4z"/>
      </svg>
      R301 · TD3
    </span>
    <span class="topbar-note">Université Côte d'Azur — Programmation Web « Côté Serveur »</span>
  </header>

  <main class="wrap">

    <!-- ===================== HERO ===================== -->
    <section class="hero">
      <p class="sur-titre">Séance 3 · Formulaires</p>
      <h1>TD3 — Génération et traitement<br />des <span class="degrade">formulaires HTML en PHP</span></h1>
      <p class="lead">
        Créer, vérifier, filtrer et traiter les champs d'un formulaire avant de les utiliser :
        validation côté serveur, expressions régulières et lecture / écriture de fichiers de données.
      </p>
      <ul class="stats">
        <li><strong>2</strong> exercices</li>
        <li><strong>6</strong> livrables</li>
        <li>Méthodes <strong>GET</strong> &amp; <strong>POST</strong></li>
      </ul>
    </section>

    <!-- ===================== EXERCICE 3 ===================== -->
    <section class="groupe">
      <div class="groupe-titre">
        <h2>Exercice 3 — Formulaire d'achat de vins</h2>
        <p>Méthode GET · 5 versions, du formulaire statique au filtrage complet</p>
      </div>

      <div class="grille">

        <a class="carte" href="index-exo3-1.html" style="--d:.02s">
          <div class="carte-haut">
            <span class="num">3.1</span>
            <span class="badge badge-get">GET</span>
          </div>
          <span class="icone">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="9" x2="17" y2="9"/><line x1="7" y1="13" x2="13" y2="13"/><line x1="7" y1="17" x2="11" y2="17"/>
            </svg>
          </span>
          <h3>Formulaire HTML séparé</h3>
          <p>Création du formulaire de commande (champs texte, boutons radio, sélecteur multiple) puis traitement dans un script dédié.</p>
          <div class="pied-carte">
            <div class="tags"><span>HTML</span><span>$_GET</span></div>
            <span class="fleche">Ouvrir
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>

        <a class="carte" href="index-exo3-2.php" style="--d:.08s">
          <div class="carte-haut">
            <span class="num">3.2</span>
            <span class="badge badge-get">GET</span>
          </div>
          <span class="icone">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M4 12a8 8 0 0 1 14-5"/><polyline points="18 3 18 7 14 7"/><path d="M20 12a8 8 0 0 1-14 5"/><polyline points="6 21 6 17 10 17"/>
            </svg>
          </span>
          <h3>Formulaire auto-soumis</h3>
          <p>Création et traitement réunis dans un même fichier PHP : la page s'envoie les données à elle-même.</p>
          <div class="pied-carte">
            <div class="tags"><span>Formulaire</span><span>Traitement</span></div>
            <span class="fleche">Ouvrir
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>

        <a class="carte" href="index-exo3-3.php" style="--d:.14s">
          <div class="carte-haut">
            <span class="num">3.3</span>
            <span class="badge badge-get">GET</span>
          </div>
          <span class="icone">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M12 3l7 3v5c0 4.5-3 8-7 10-4-2-7-5.5-7-10V6z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="16.5" x2="12" y2="16.51"/>
            </svg>
          </span>
          <h3>Champs obligatoires</h3>
          <p>Vérification côté serveur du nom, du prénom et du courriel, avec erreurs en rouge et formulaire « collant ».</p>
          <div class="pied-carte">
            <div class="tags"><span>Validation</span><span>Sticky form</span></div>
            <span class="fleche">Ouvrir
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>

        <a class="carte" href="index-exo3-4.php" style="--d:.20s">
          <div class="carte-haut">
            <span class="num">3.4</span>
            <span class="badge badge-get">GET</span>
          </div>
          <span class="icone">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <polygon points="4 5 20 5 13 12 13 19 11 20 11 12"/>
            </svg>
          </span>
          <h3>Filtrage avec preg_match()</h3>
          <p>Le nom et le prénom sont filtrés par expression régulière : lettres, espaces et tirets uniquement.</p>
          <div class="pied-carte">
            <div class="tags"><span>preg_match()</span><span>Regex</span></div>
            <span class="fleche">Ouvrir
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>

        <a class="carte" href="index-exo3-5.php" style="--d:.26s">
          <div class="carte-haut">
            <span class="num">3.5</span>
            <span class="badge badge-get">GET</span>
          </div>
          <span class="icone">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>
            </svg>
          </span>
          <h3>Contrôle du courriel</h3>
          <p>Filtrage des caractères autorisés puis vérification de la cohérence de l'adresse par une fonction dédiée.</p>
          <div class="pied-carte">
            <div class="tags"><span>strpos()</span><span>Confirmation</span></div>
            <span class="fleche">Ouvrir
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
          </div>
        </a>

      </div>
    </section>

    <!-- ===================== EXERCICE 4 ===================== -->
    <section class="groupe">
      <div class="groupe-titre">
        <h2>Exercice 4 — Génération dynamique</h2>
        <p>Méthode POST · formulaire construit à partir de données préexistantes</p>
      </div>

      <div class="grille">
        <a class="carte carte--large" href="index-exo4.php" style="--d:.32s">
          <div class="carte-large-contenu">
            <div class="carte-haut">
              <span class="num">4</span>
              <span class="badge badge-post">POST</span>
            </div>
            <span class="icone icone--grande">
              <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 11l1.7-4.2A2 2 0 0 1 8.6 5.5h6.8a2 2 0 0 1 1.9 1.3L19 11"/><path d="M4 11h16a1 1 0 0 1 1 1v4h-2.2"/><path d="M4 12v4h2.3"/><circle cx="8.5" cy="16.5" r="2"/><circle cx="15.5" cy="16.5" r="2"/><line x1="10.5" y1="16.5" x2="13.5" y2="16.5"/>
              </svg>
            </span>
            <h3>Parc automobile — <code>TD3-Cars.txt</code></h3>
            <p>
              Le formulaire est entièrement déduit de la lecture du fichier de données :
              les modèles et prix sont classés par marque, modifiables (champs numériques pour les prix),
              supprimables en vidant le champ modèle, et un nouveau modèle peut être ajouté.
              Chaque envoi déclenche une séquence écriture / lecture du fichier avec
              <code>fgetcsv()</code> et <code>fputcsv()</code>.
            </p>
            <div class="pied-carte">
              <div class="tags"><span>fgetcsv()</span><span>fputcsv()</span><span>Écriture / lecture</span></div>
              <span class="fleche">Ouvrir
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
              </span>
            </div>
          </div>
        </a>
      </div>
    </section>

    <footer class="pied-page">
      <p>R301 · TD3 — Les livrables de chaque TD sont à déposer sur le serveur dans le dossier correspondant.</p>
    </footer>

  </main>
</body>
</html>
