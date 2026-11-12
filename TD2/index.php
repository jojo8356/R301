<?php
// On récupère l'identifiant de session ou utilisateur à partir du chemin système pour personnaliser
$user = "pj509414"; 

// =========================================================================
// Test d'inclusion pour la variable globale (Question 4.1)
// On utilise la mise en mémoire tampon pour inclure 4.php sans afficher son HTML
// =========================================================================
ob_start();
include_once("4.php");
ob_end_clean();

// On vérifie si la variable globale x définie dans 4.php est bien accessible ici
$global_x_valeur = isset($GLOBALS['x']) ? $GLOBALS['x'] : 'Non définie';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>R301 - TD n°2 (Plateforme de livrables)</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <!-- Barre de navigation supérieure -->
    <nav class="navbar">
        <div class="nav-container">
            <span class="nav-logo">R301 - TD2</span>
            <ul class="nav-links">
                <li><a href="index.php" class="active">Accueil</a></li>
                <li class="dropdown">
                    <a href="#">Partie 3 (Chaînes) ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="3.1.php">3.1. Compter Mots</a></li>
                        <li><a href="3.2.php">3.2. Compter Phrases</a></li>
                        <li><a href="3.3.php">3.3. Inverser Mots</a></li>
                        <li><a href="3.4.php">3.4. Table Associative</a></li>
                        <li><a href="3.5.php">3.5. Mot de Passe</a></li>
                    </ul>
                </li>
                <li><a href="4.php">Partie 4 (Superglobales)</a></li>
                <li><a href="5.php">Partie 5 (Dates & Heures)</a></li>
            </ul>
        </div>
    </nav>

    <header class="main-header" style="margin-top: 40px;">
        <h1>Programmation Web « Côté Serveur »</h1>
        <p class="subtitle">R301 - Travaux Dirigés n°2 (Séance 1)</p>
        <div class="user-badge">Étudiant : <code><?= htmlspecialchars($user) ?></code></div>
    </header>

    <main class="container">

        <!-- Zone d'information et test de la variable globale -->
        <section class="card info-box">
            <h2>🧪 Test d'intégration de la variable globale <code>$GLOBALS</code></h2>
            <p>
                La consigne demande de vérifier que la variable globalisée dans un fichier est lisible depuis l'index.
            </p>
            <div style="margin-top: 15px; padding: 12px; background: #e8f8f5; border-left: 5px solid #2ecc71; border-radius: 4px;">
                Résultat de l'analyse : 
                <strong>
                    <?php if ($global_x_valeur === 10) : ?>
                        <span style="color: #27ae60;">[✔ SUCCÈS]</span> Le fichier <code>index.php</code> confirme que <code>$GLOBALS['x']</code> vaut bien <code style="font-size: 1.1rem;"><?= $global_x_valeur ?></code> (déclarée dans 4.php).
                    <?php else : ?>
                        <span style="color: #c0392b;">[✗ ERREUR]</span> Impossible de récupérer <code>$GLOBALS['x']</code>.
                    <?php endif; ?>
                </strong>
            </div>
        </section>

        <!-- Grille de navigation vers les exercices -->
        <h2 style="margin: 30px 0 15px; color: #2c3e50;">📁 Accès rapide aux exercices</h2>
        
        <div class="grid-exercises">
            
            <!-- Carte 3.1 -->
            <a href="3.1.php" class="exercise-card">
                <div class="card-num">Exo 3.1</div>
                <h3>Compter les mots</h3>
                <p>Analyse d'une phrase et comptage du nombre de mots (gestion de l'apostrophe).</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 3.2 -->
            <a href="3.2.php" class="exercise-card">
                <div class="card-num">Exo 3.2</div>
                <h3>Compter les phrases</h3>
                <p>Détection des délimiteurs de phrases pour dénombrer les propositions.</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 3.3 -->
            <a href="3.3.php" class="exercise-card">
                <div class="card-num">Exo 3.3</div>
                <h3>Inverser les mots</h3>
                <p>Retournement de l'ordre d'apparition des mots au sein d'une phrase.</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 3.4 -->
            <a href="3.4.php" class="exercise-card">
                <div class="card-num">Exo 3.4</div>
                <h3>Table associative</h3>
                <p>Calcul de statistiques exhaustives d'un texte (ponctuation complexe et UTF-8).</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 3.5 -->
            <a href="3.5.php" class="exercise-card">
                <div class="card-num">Exo 3.5</div>
                <h3>Générateur de mot de passe</h3>
                <p>Formulaire de génération de mot de passe à l'aide de clés aléatoires.</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 4 -->
            <a href="4.php" class="exercise-card highlight">
                <div class="card-num">Exo 4</div>
                <h3>Superglobales</h3>
                <p>Étude des tables <code>$GLOBALS</code>, <code>$_SERVER</code> et <code>$_ENV</code> de PHP.</p>
                <span class="card-btn">Lancer →</span>
            </a>

            <!-- Carte 5 -->
            <a href="5.php" class="exercise-card highlight">
                <div class="card-num">Exo 5</div>
                <h3>Dates et mktime</h3>
                <p>Instanciation de dates personnalisées et gestion des fuseaux horaires locaux.</p>
                <span class="card-btn">Lancer →</span>
            </a>

        </div>

    </main>

    <footer style="text-align: center; padding: 40px 0; color: #7f8c8d; font-size: 0.9rem;">
        <p>IUT Nice Côte d'Azur - Département Informatique</p>
    </footer>

</body>
</html>