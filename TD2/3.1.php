<?php
// =========================================================================
// Fonction à tester (votre algorithme)
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

// Jeu de tests
$tests = [
    [
        "desc"     => "Phrase classique (cas du sujet)",
        "input"    => "Je test quelquechose c'est s'appelle",
        "expected" => 5
    ],
    [
        "desc"     => "Un seul mot",
        "input"    => "Bonjour",
        "expected" => 1
    ],
    [
        "desc"     => "Deux mots simples",
        "input"    => "Hello World",
        "expected" => 2
    ],
    [
        "desc"     => "Chaîne vide",
        "input"    => "",
        "expected" => 0
    ],
    [
        "desc"     => "Phrase avec ponctuation (sans espace avant la fin)",
        "input"    => "Il fait beau, n'est-ce pas?",
        "expected" => 5
    ],
    [
        "desc"     => "Phrase longue de 10 mots",
        "input"    => "Le langage PHP est souvent utilise pour le developpement web",
        "expected" => 10
    ]
];

// Calcul des statistiques globales
$reussis = 0;
$total = count($tests);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 3.1 : Comptage de mots</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 3.1</h1>
        <p class="subtitle">Algorithmique sur les chaînes de caractères (sans fonctions natives)</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Fonctionnement</h2>
            <ul>
                <li><strong>Consigne :</strong> Ne pas utiliser les fonctions PHP natives toutes faites (ex : <code>str_word_count()</code> ou <code>explode()</code>).</li>
                <li><strong>Règle de gestion :</strong> Les mots composés avec apostrophe comme <em>« c'est »</em> ou <em>« s'appelle »</em> comptent pour <strong>un seul mot</strong>.</li>
            </ul>
        </section>

        <!-- Tableau des résultats de tests -->
        <section class="card">
            <h2>🧪 Rapport des tests unitaires</h2>
            
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
                        $resultat = count_words($test["input"]);
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