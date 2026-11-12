<?php
// =========================================================================
// 1. Algorithme du générateur de mot de passe
// =========================================================================
function genererMotDePasse(string $nom) {
    $longueurNom = strlen($nom);

    // Règle : Le nom doit faire au moins 6 caractères
    if ($longueurNom < 6) {
        return false;
    }

    // 1. Tirer 4 lettres au hasard dans le nom
    $lettres = "";
    for ($i = 0; $i < 4; $i++) {
        $indexAleatoire = rand(0, $longueurNom - 1);
        $lettres .= $nom[$indexAleatoire];
    }

    // 2. Tirer 4 chiffres au hasard entre 0 et 9
    $chiffres = "";
    for ($i = 0; $i < 4; $i++) {
        $chiffres .= rand(0, 9);
    }

    return $lettres . $chiffres;
}

// =========================================================================
// 2. Traitement du formulaire ($_GET)
// =========================================================================
$nomSaisi = isset($_GET['nom']) ? trim($_GET['nom']) : '';
$motDePasseGenere = null;
$erreur = null;

if (isset($_GET['nom'])) {
    if (strlen($nomSaisi) < 6) {
        $erreur = "Le nom saisi comporte seulement " . strlen($nomSaisi) . " caractère(s). Le minimum requis est de 6 caractères.";
    } else {
        $motDePasseGenere = genererMotDePasse($nomSaisi);
    }
}

// =========================================================================
// 3. Suite de tests automatisés (vérification des propriétés)
// =========================================================================
$tests = [
    [
        "desc"     => "Nom valide de 9 caractères ('Alexandre')",
        "input"    => "Alexandre",
        "verifier" => function($res, $nom) {
            return $res !== false && strlen($res) === 8 && ctype_digit(substr($res, 4));
        },
        "attendu"  => "8 car. (4 lettres + 4 chiffres)"
    ],
    [
        "desc"     => "Nom valide de exactement 6 caractères ('Dupont')",
        "input"    => "Dupont",
        "verifier" => function($res, $nom) {
            return $res !== false && strlen($res) === 8 && ctype_digit(substr($res, 4));
        },
        "attendu"  => "8 car. (4 lettres + 4 chiffres)"
    ],
    [
        "desc"     => "Nom trop court : 5 caractères ('Court')",
        "input"    => "Court",
        "verifier" => function($res, $nom) {
            return $res === false;
        },
        "attendu"  => "Échec (nom < 6 car.)"
    ],
    [
        "desc"     => "Nom trop court : 1 caractère ('A')",
        "input"    => "A",
        "verifier" => function($res, $nom) {
            return $res === false;
        },
        "attendu"  => "Échec (nom < 6 car.)"
    ],
    [
        "desc"     => "Chaîne vide",
        "input"    => "",
        "verifier" => function($res, $nom) {
            return $res === false;
        },
        "attendu"  => "Échec (nom < 6 car.)"
    ]
];

$reussis = 0;
$total = count($tests);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 3.5 : Générateur de mot de passe</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 3.5</h1>
        <p class="subtitle">Génération dynamique de mot de passe aléatoire (4 lettres + 4 chiffres)</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Spécifications</h2>
            <ul>
                <li><strong>Nom d'origine :</strong> Doit comporter au minimum <strong>6 caractères</strong>.</li>
                <li><strong>Format généré :</strong> Exactement <strong>8 caractères</strong> (4 lettres piochées aléatoirement dans le nom + 4 chiffres générés avec <code>rand()</code>).</li>
            </ul>
        </section>

        <!-- Formulaire de génération interactive (GET) -->
        <section class="card">
            <h2>🔑 Générateur interactif</h2>
            
            <form method="GET" action="" style="margin-top: 15px;">
                <div style="margin-bottom: 15px;">
                    <label for="nom" style="display: block; font-weight: bold; margin-bottom: 5px;">Nom de base :</label>
                    <input 
                        type="text" 
                        id="nom" 
                        name="nom" 
                        value="<?= htmlspecialchars($nomSaisi) ?>" 
                        placeholder="Ex: Alexandre, Dupont, Martin..." 
                        style="width: 100%; max-width: 400px; padding: 8px 12px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                        required
                    >
                </div>
                <button type="submit" style="background-color: #2ecc71; color: white; border: none; padding: 10px 18px; border-radius: 4px; font-size: 1rem; cursor: pointer; font-weight: bold;">
                    ⚡ Générer le mot de passe
                </button>
            </form>

            <!-- Résultat du formulaire -->
            <?php if ($motDePasseGenere !== null) : ?>
                <div style="margin-top: 20px; padding: 15px; background: #e8f8f5; border-left: 5px solid #2ecc71; border-radius: 4px;">
                    <p style="margin: 0; font-size: 1.1rem;">
                        Mot de passe généré pour <strong>« <?= htmlspecialchars($nomSaisi) ?> »</strong> : 
                        <code style="font-size: 1.3rem; font-weight: bold; color: #27ae60;"><?= htmlspecialchars($motDePasseGenere) ?></code>
                    </p>
                </div>
            <?php elseif ($erreur !== null) : ?>
                <div style="margin-top: 20px; padding: 15px; background: #fdf2e9; border-left: 5px solid #e67e22; border-radius: 4px; color: #d35400;">
                    <p style="margin: 0;"><strong>Erreur :</strong> <?= htmlspecialchars($erreur) ?></p>
                </div>
            <?php endif; ?>
        </section>

        <!-- Tableau des tests unitaires -->
        <section class="card">
            <h2>🧪 Rapport des tests unitaires</h2>
            
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Nom d'entrée</th>
                        <th>Résultat obtenu</th>
                        <th>Comportement attendu</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tests as $index => $test) : 
                        $res = genererMotDePasse($test["input"]);
                        $succes = $test["verifier"]($res, $test["input"]);
                        if ($succes) { $reussis++; }
                    ?>
                        <tr class="<?= $succes ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><?= htmlspecialchars($test["desc"]) ?></td>
                            <td>
                                <code><?= $test["input"] === "" ? "<em>[Chaîne vide]</em>" : htmlspecialchars($test["input"]) ?></code>
                            </td>
                            <td>
                                <?php if ($res === false) : ?>
                                    <em style="color: #7f8c8d;">false (refusé)</em>
                                <?php else : ?>
                                    <code><?= htmlspecialchars($res) ?></code>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($test["attendu"]) ?></td>
                            <td>
                                <?php if ($succes) : ?>
                                    <span class="badge badge-success">✓ OK</span>
                                <?php else : ?>
                                    <span class="badge badge-danger">✗ FAIL</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Résumé final -->
        <section class="summary-box <?= ($reussis === $total) ? 'summary-success' : 'summary-danger' ?>">
            <h3>Résultat global : <?= $reussis ?> / <?= $total ?> test(s) validé(s) (<?= round(($reussis / $total) * 100) ?>%)</h3>
            <p>
                <?= ($reussis === $total) 
                    ? "🎉 Félicitations, toutes les contraintes de génération sont validées !" 
                    : "⚠️ Attention, certains tests ont échoué." ?>
            </p>
        </section>

    </main>

</body>
</html>
