<?php
// =========================================================================
// 4.1. Manipulation de $GLOBALS
// =========================================================================
$GLOBALS['x'] = 10;

// Fonction de test pour vérifier la portée globale
function verifierGlobalScope() {
    // Une variable locale normale $x ne serait pas accessible ici,
    // mais $GLOBALS['x'] est accessible partout sans le mot-clé 'global'.
    if (isset($GLOBALS['x']) && $GLOBALS['x'] === 10) {
        return "Accessible depuis la fonction avec la valeur : " . $GLOBALS['x'];
    }
    return "Non accessible";
}

$testGlobalReussi = (verifierGlobalScope() === "Accessible depuis la fonction avec la valeur : 10");

// =========================================================================
// 4.2. Liste des variables $_SERVER demandées
// =========================================================================
$serverVariables = [
    [
        "nom"         => "SERVER_ADDR",
        "description" => "Adresse IP du serveur web hébergeant le script",
        "valeur"      => $_SERVER['SERVER_ADDR'] ?? 'Non défini (courant sur certains serveurs locaux)'
    ],
    [
        "nom"         => "HTTP_HOST",
        "description" => "Nom d'hôte (domaine ou IP + port) fourni dans l'en-tête de la requête",
        "valeur"      => $_SERVER['HTTP_HOST'] ?? 'Non défini'
    ],
    [
        "nom"         => "REMOTE_ADDR",
        "description" => "Adresse IP du client (visiteur) qui consulte la page",
        "valeur"      => $_SERVER['REMOTE_ADDR'] ?? 'Non défini'
    ],
    [
        "nom"         => "HTTP_USER_AGENT",
        "description" => "Chaîne identifiant le navigateur, le moteur et l'OS du client",
        "valeur"      => $_SERVER['HTTP_USER_AGENT'] ?? 'Non défini'
    ],
    [
        "nom"         => "REQUEST_METHOD",
        "description" => "Méthode HTTP employée pour accéder à la page",
        "valeur"      => $_SERVER['REQUEST_METHOD'] ?? 'Non défini'
    ]
];

// =========================================================================
// 4.3. Analyse de $_ENV
// =========================================================================
$envVide = empty($_ENV);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 4 : Superglobales $GLOBALS, $_SERVER, $_ENV</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 4</h1>
        <p class="subtitle">Exploration des tables superglobales en PHP</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Contexte</h2>
            <ul>
                <li><strong>Superglobales :</strong> Tableaux associatifs prédéfinis automatiquement disponibles dans tous les contextes d'exécution (scripts, fonctions, classes).</li>
                <li><strong>Sécurité :</strong> Les valeurs venant de <code>$_SERVER</code> (ex: <code>HTTP_USER_AGENT</code>) doivent toujours être protégées par <code>htmlspecialchars()</code> lors de l'affichage HTML.</li>
            </ul>
        </section>

        <!-- 4.1. Vérification de $GLOBALS -->
        <section class="card">
            <h2>4.1. Vérification de la table <code>$GLOBALS</code></h2>
            <p>Déclaration effectuée au niveau racine : <code>$GLOBALS['x'] = 10;</code></p>
            <br>
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>Contexte</th>
                        <th>Résultat d'accès</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="<?= $testGlobalReussi ? 'row-success' : 'row-danger' ?>">
                        <td><strong>Accès interne à une fonction</strong></td>
                        <td><?= htmlspecialchars(verifierGlobalScope()) ?></td>
                        <td>
                            <?php if ($testGlobalReussi) : ?>
                                <span class="badge badge-success">✓ VALIDÉ</span>
                            <?php else : ?>
                                <span class="badge badge-danger">✗ ÉCHEC</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- 4.2. Données de la table $_SERVER -->
        <section class="card">
            <h2>4.2. Informations réseau et système (<code>$_SERVER</code>)</h2>
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>Variable</th>
                        <th>Description</th>
                        <th>Valeur détectée</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($serverVariables as $var) : ?>
                        <tr>
                            <td><code>$_SERVER['<?= htmlspecialchars($var["nom"]) ?>']</code></td>
                            <td><?= htmlspecialchars($var["description"]) ?></td>
                            <td>
                                <code><?= htmlspecialchars($var["valeur"]) ?></code>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- 4.3. Variables d'environnement $_ENV -->
        <section class="card">
            <h2>4.3. Variables d'environnement (<code>$_ENV</code>)</h2>
            
            <?php if ($envVide) : ?>
                <div style="padding: 12px; background: #fff3cd; border-left: 5px solid #ffc107; border-radius: 4px; color: #856404; margin-bottom: 15px;">
                    <strong>Remarque :</strong> La table <code>$_ENV</code> est actuellement vide.
                    <br>
                    <small>Cela est dû à la directive <code>variables_order = "GPCS"</code> dans le fichier <code>php.ini</code> (le "E" de Environment est souvent désactivé pour des raisons de performance). Pour contourner cela, PHP propose la fonction <code>getenv()</code>.</small>
                </div>

                <p><strong>Exemple via <code>getenv('PATH')</code> :</strong></p>
                <pre style="background: #2c3e50; color: #ecf0f1; padding: 12px; border-radius: 6px; overflow-x: auto; font-size: 0.85rem;"><?= htmlspecialchars((string)getenv('PATH')) ?></pre>
            <?php else : ?>
                <pre style="background: #2c3e50; color: #ecf0f1; padding: 12px; border-radius: 6px; overflow-x: auto; font-size: 0.85rem;"><?= htmlspecialchars(print_r($_ENV, true)) ?></pre>
            <?php endif; ?>
        </section>

        <!-- Résumé final -->
        <section class="summary-box summary-success">
            <h3>Variables superglobales inspectées avec succès !</h3>
            <p>Les données réseau, client et d'environnement ont bien été récupérées et formatées.</p>
        </section>

    </main>

</body>
</html>