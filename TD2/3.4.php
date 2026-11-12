<?php
// =========================================================================
// 1. Fonctions de traitement et d'analyse
// =========================================================================

function count_words($phrase) {
    $count = 0;
    if (strlen($phrase) > 0) {
        $count = 1;
    }
    for ($i = 0; $i < strlen($phrase); $i++) {
        if ($phrase[$i] == " ") {
            $count++;
        }
    }
    return $count;
}

function count_phrases($phrase) {
    $count = 0;
    for ($i = 0; $i < strlen($phrase); $i++) {
        if ($phrase[$i] == ".") {
            $count++;
        }
    }
    return $count;
}

function count_points($phrase) {
    $count = 0;
    $longueur = strlen($phrase);

    for ($i = 0; $i < $longueur; $i++) {
        if ($phrase[$i] == ".") {
            $count++;
        }
        // Cas du caractère unique de suspension "…" (3 octets consécutifs en UTF-8)
        elseif ($i + 2 < $longueur && ($phrase[$i] . $phrase[$i+1] . $phrase[$i+2] === "…")) {
            $count += 3;
            $i += 2;
        }
    }

    return $count;
}

function count_any_char($phrase, $char) {
    $count = 0;
    $longueur = strlen($phrase);
    for ($i = 0; $i < $longueur; $i++) {
        if ($phrase[$i] == $char) {
            $count++;
        }
    }
    return $count;
}

function count_three_points($phrase) {
    $count = 0;
    $longueur = strlen($phrase);
    for ($i = 0; $i < $longueur; $i++) {
        if ($i + 2 < $longueur && ($phrase[$i] . $phrase[$i+1] . $phrase[$i+2] === "…")) {
            $count++;
            $i += 2;
        }
    }
    return $count;
}

// Génération de la table associative
function get_text_stats($phrase) {
    return [
        "mots"                => count_words($phrase),
        "phrases"             => count_phrases($phrase),
        "points"              => count_points($phrase),
        "virgules"            => count_any_char($phrase, ","),
        "points_virgules"     => count_any_char($phrase, ";"),
        "exclamations"        => count_any_char($phrase, "!"),
        "interrogations"      => count_any_char($phrase, "?"),
        "trois petits points" => count_three_points($phrase)
    ];
}

// =========================================================================
// 2. Jeux de tests unitaires
// =========================================================================

$testsUnitaires = [
    [
        "fonction" => "count_points",
        "desc"     => "Points standards '.'",
        "input"    => "Un. Deux. Trois.",
        "expected" => 3,
        "run"      => fn($str) => count_points($str)
    ],
    [
        "fonction" => "count_points",
        "desc"     => "Caractère '…' unique (doit valoir 3)",
        "input"    => "À suivre…",
        "expected" => 3,
        "run"      => fn($str) => count_points($str)
    ],
    [
        "fonction" => "count_points",
        "desc"     => "Mélange '.' et '…'",
        "input"    => "Début. Attente… Fin.",
        "expected" => 5,
        "run"      => fn($str) => count_points($str)
    ],
    [
        "fonction" => "count_any_char",
        "desc"     => "Comptage des virgules ','",
        "input"    => "pomme, poire, banane, orange",
        "expected" => 3,
        "run"      => fn($str) => count_any_char($str, ",")
    ],
    [
        "fonction" => "count_any_char",
        "desc"     => "Comptage des points-virgules ';'",
        "input"    => "\$a = 1; \$b = 2; \$c = 3;",
        "expected" => 3,
        "run"      => fn($str) => count_any_char($str, ";")
    ],
    [
        "fonction" => "count_any_char",
        "desc"     => "Comptage des points d'exclamation '!'",
        "input"    => "Bravo ! Super ! Génial !",
        "expected" => 3,
        "run"      => fn($str) => count_any_char($str, "!")
    ],
    [
        "fonction" => "count_any_char",
        "desc"     => "Caractère absent",
        "input"    => "Phrase sans point d'interrogation",
        "expected" => 0,
        "run"      => fn($str) => count_any_char($str, "?")
    ],
    [
        "fonction" => "count_three_points",
        "desc"     => "Détection de '…' (1 seul symbole)",
        "input"    => "Et voilà…",
        "expected" => 1,
        "run"      => fn($str) => count_three_points($str)
    ],
    [
        "fonction" => "count_three_points",
        "desc"     => "Points classiques '...' (ne doit pas compter '…')",
        "input"    => "Trois points classiques...",
        "expected" => 0,
        "run"      => fn($str) => count_three_points($str)
    ],
    [
        "fonction" => "count_three_points",
        "desc"     => "Deux fois le symbole '…'",
        "input"    => "Attends… quoi…",
        "expected" => 2,
        "run"      => fn($str) => count_three_points($str)
    ]
];

// Test global d'intégration
$testGlobalTexte = "Salut, comment vas-tu ? Bien ; et toi ! Attends… oui. Fin.";
$testGlobalExpected = [
    "mots"                => 12,
    "phrases"             => 2,
    "points"              => 5,
    "virgules"            => 1,
    "points_virgules"     => 1,
    "exclamations"        => 1,
    "interrogations"      => 1,
    "trois petits points" => 1
];

$statsObtenues = get_text_stats($testGlobalTexte);
$reussisUnitaires = 0;
$totalUnitaires = count($testsUnitaires);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 3.4 : Statistiques & Table Associative</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 3.4</h1>
        <p class="subtitle">Analyse d'un texte et stockage dans un tableau associatif</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Fonctionnement</h2>
            <ul>
                <li><strong>Objectif :</strong> Recenser et stocker dans une table associative le nombre de mots, phrases, points, virgules, points-virgules, exclamations, interrogations et ellipses.</li>
                <li><strong>Précision technique :</strong> Gestion du caractère UTF-8 spécial <code>…</code> (composé de 3 octets en mémoire).</li>
            </ul>
        </section>

        <!-- 1. Tests Unitaires -->
        <section class="card">
            <h2>🧪 1. Tests unitaires des fonctions spécialisées</h2>
            
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fonction</th>
                        <th>Description</th>
                        <th>Chaîne testée</th>
                        <th>Attendu</th>
                        <th>Obtenu</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($testsUnitaires as $index => $test) : 
                        $resultat = $test["run"]($test["input"]);
                        $succes = ($resultat === $test["expected"]);
                        if ($succes) { $reussisUnitaires++; }
                    ?>
                        <tr class="<?= $succes ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><code><?= htmlspecialchars($test["fonction"]) ?></code></td>
                            <td><?= htmlspecialchars($test["desc"]) ?></td>
                            <td><code><?= htmlspecialchars($test["input"]) ?></code></td>
                            <td><strong><?= $test["expected"] ?></strong></td>
                            <td><strong><?= $resultat ?></strong></td>
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

        <!-- 2. Test Global d'Intégration -->
        <section class="card">
            <h2>📊 2. Test global d'intégration (Table associative)</h2>
            <p><strong>Texte testé :</strong> <code><?= htmlspecialchars($testGlobalTexte) ?></code></p>
            <br>
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>Clé associative</th>
                        <th>Attendu</th>
                        <th>Obtenu</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $globalSuccess = true;
                    foreach ($testGlobalExpected as $cle => $attendu) : 
                        $obtenu = $statsObtenues[$cle];
                        $succes = ($obtenu === $attendu);
                        if (!$succes) { $globalSuccess = false; }
                    ?>
                        <tr class="<?= $succes ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= htmlspecialchars($cle) ?></strong></td>
                            <td><strong><?= $attendu ?></strong></td>
                            <td><strong><?= $obtenu ?></strong></td>
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
        <?php $toutReussi = ($reussisUnitaires === $totalUnitaires) && $globalSuccess; ?>
        <section class="summary-box <?= $toutReussi ? 'summary-success' : 'summary-danger' ?>">
            <h3>Résultat global : <?= $reussisUnitaires ?> / <?= $totalUnitaires ?> tests unitaires validés</h3>
            <p>
                <?= $toutReussi 
                    ? "🎉 Félicitations, tous les tests unitaires et la table associative sont validés !" 
                    : "⚠️ Attention, un ou plusieurs tests ont échoué." ?>
            </p>
        </section>

    </main>

</body>
</html>