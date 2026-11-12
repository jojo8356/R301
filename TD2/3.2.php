<?php
// =========================================================================
// 1. Définition de la fonction (votre algorithme)
// =========================================================================
function count_phrases($phrase) {
    $count = 0;

    for ($i = 0; $i < strlen($phrase); $i++) {
        if ($phrase[$i] == ".") {
            $count++;
        }
    }

    return $count;
}

// =========================================================================
// 2. Jeu de tests
// =========================================================================
$tests = [
    [
        "desc"     => "Texte classique avec 3 phrases (cas du sujet)",
        "input"    => "Je test quelquechose. Je test autrechose. Je test encore autre chose.",
        "expected" => 3
    ],
    [
        "desc"     => "Une seule phrase terminée par un point",
        "input"    => "Bonjour tout le monde.",
        "expected" => 1
    ],
    [
        "desc"     => "Texte sans aucun point",
        "input"    => "Bonjour tout le monde sans point",
        "expected" => 0
    ],
    [
        "desc"     => "Chaîne vide",
        "input"    => "",
        "expected" => 0
    ],
    [
        "desc"     => "Un seul caractère point",
        "input"    => ".",
        "expected" => 1
    ],
    [
        "desc"     => "Texte avec des points de suspension (3 points)",
        "input"    => "A suivre...",
        "expected" => 3
    ],
    [
        "desc"     => "Plusieurs phrases courtes collées",
        "input"    => "Un.Deux.Trois.Quatre.",
        "expected" => 4
    ]
];

// Initialisation des compteurs
$reussis = 0;
$total = count($tests);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 3.2 : Comptage de phrases</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 3.2</h1>
        <p class="subtitle">Comptage du nombre de phrases dans une chaîne de caractères</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Fonctionnement</h2>
            <ul>
                <li><strong>Objectif :</strong> Déterminer le nombre de phrases présentes dans un texte.</li>
                <li><strong>Implémentation :</strong> Parcours itératif de la chaîne caractère par caractère pour détecter les séparateurs de phrases (points).</li>
                <li><strong>Consigne :</strong> Pas de fonctions toutes faites (pas de regex complexe, pas d'utilisation de fonctions natives avancées).</li>
            </ul>
        </section>

        <!-- Tableau des résultats de tests -->
        <section class="card">
            <h2>🧪 Rapport des tests unitaires (<code>count_phrases</code>)</h2>
            
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Chaîne testée</th>
                        <th>Attendu</th>
                        <th>Obtenu</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tests as $index => $test) : 
                        $resultat = count_phrases($test["input"]);
                        $succes = ($resultat === $test["expected"]);
                        if ($succes) { $reussis++; }
                    ?>
                        <tr class="<?= $succes ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><?= htmlspecialchars($test["desc"]) ?></td>
                            <td>
                                <code><?= $test["input"] === "" ? "<em>[Chaîne vide]</em>" : htmlspecialchars($test["input"]) ?></code>
                            </td>
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

        <!-- Résumé final -->
        <section class="summary-box <?= ($reussis === $total) ? 'summary-success' : 'summary-danger' ?>">
            <h3>Résultat global : <?= $reussis ?> / <?= $total ?> test(s) validé(s) (<?= round(($reussis / $total) * 100) ?>%)</h3>
            <p>
                <?= ($reussis === $total) 
                    ? "🎉 Félicitations, tous les tests sont passés avec succès !" 
                    : "⚠️ Attention, certains tests ont échoué. Veuillez revoir l'algorithme." ?>
            </p>
        </section>

    </main>

</body>
</html>