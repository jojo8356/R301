<?php
/**
 * =========================================================================
 * 1. Algorithme : Inversion de l'ordre des mots
 * =========================================================================
 * Utilise uniquement des boucles, des tableaux simples et strlen().
 * Pas de explode(), implode(), strrev() ou array_reverse().
 */
function reverse_words($phrase) {
    $taille = strlen($phrase);
    
    // Cas de la chaîne vide
    if ($taille === 0) {
        return "";
    }

    $listeMots = [];
    $strTmp = "";

    // 1. Découpage des mots caractère par caractère
    for ($i = 0; $i < $taille; $i++) {
        if ($phrase[$i] != " ") {
            $strTmp .= $phrase[$i];
        }
        
        // Fin de mot détectée (espace ou dernier caractère)
        if ($phrase[$i] == " " || ($i == $taille - 1 && $phrase[$i] != " ")) {
            if ($strTmp != "") {
                $listeMots[] = $strTmp;
                $strTmp = "";
            }
        }
    }

    $nbMots = count($listeMots);
    if ($nbMots === 0) {
        return "";
    }

    // 2. Inversion de la liste des mots (parcours à l'envers)
    $listeMotsInverse = [];
    for ($i = $nbMots - 1; $i >= 0; $i--) {
        $listeMotsInverse[] = $listeMots[$i];
    }

    // 3. Reconstruction de la chaîne de caractères
    $phraseInverse = "";
    for ($i = 0; $i < $nbMots; $i++) {
        $phraseInverse .= $listeMotsInverse[$i];
        
        // On ajoute un espace uniquement ENTRE les mots
        if ($i < $nbMots - 1) {
            $phraseInverse .= " ";
        }
    }

    return $phraseInverse;
}

// =========================================================================
// 2. Suite de tests complets
// =========================================================================
$tests = [
    [
        "desc"     => "Phrase classique (cas du sujet)",
        "input"    => "Je test quelquechose c'est s'appelle",
        "expected" => "s'appelle c'est quelquechose test Je"
    ],
    [
        "desc"     => "Deux mots simples",
        "input"    => "Hello World",
        "expected" => "World Hello"
    ],
    [
        "desc"     => "Un seul mot (doit rester identique)",
        "input"    => "Bonjour",
        "expected" => "Bonjour"
    ],
    [
        "desc"     => "Chaîne vide",
        "input"    => "",
        "expected" => ""
    ],
    [
        "desc"     => "Phrase avec chiffres",
        "input"    => "1 2 3 4 5",
        "expected" => "5 4 3 2 1"
    ],
    [
        "desc"     => "Mots d'une seule lettre",
        "input"    => "a b c d",
        "expected" => "d c b a"
    ],
    [
        "desc"     => "Palindrome de mots (doit donner la même chose)",
        "input"    => "un deux trois deux un",
        "expected" => "un deux trois deux un"
    ],
    [
        "desc"     => "Phrase avec apostrophes",
        "input"    => "L'arbre est vert",
        "expected" => "vert est L'arbre"
    ],
    [
        "desc"     => "Deux mots identiques",
        "input"    => "non non",
        "expected" => "non non"
    ],
    [
        "desc"     => "Phrase longue",
        "input"    => "PHP est un langage de programmation web",
        "expected" => "web programmation de langage un est PHP"
    ]
];

// Initialisation des statistiques
$reussis = 0;
$total = count($tests);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TD2 - Exercice 3.3 : Inversion des mots</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 3.3</h1>
        <p class="subtitle">Inversion de l'ordre des mots d'une phrase</p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Règles & Fonctionnement</h2>
            <ul>
                <li><strong>Objectif :</strong> Inverser l'ordre des mots d'une phrase tout en conservant l'ordre interne des lettres de chaque mot.</li>
                <li><strong>Contrainte pédagogique :</strong> Réalisé sans fonctions PHP prédéfinies (ni <code>explode()</code>, ni <code>array_reverse()</code>, ni <code>implode()</code>).</li>
                <li><strong>Précision :</strong> Les espaces en trop ne sont ni ajoutés au début ni à la fin de la phrase générée.</li>
            </ul>
        </section>

        <!-- Tableau des résultats de tests -->
        <section class="card">
            <h2>🧪 Rapport des tests unitaires (<code>reverse_words</code>)</h2>
            
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Chaîne initiale</th>
                        <th>Attendu</th>
                        <th>Obtenu</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tests as $index => $test) : 
                        $resultat = reverse_words($test["input"]);
                        $succes = ($resultat === $test["expected"]);
                        if ($succes) { $reussis++; }
                    ?>
                        <tr class="<?= $succes ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><?= htmlspecialchars($test["desc"]) ?></td>
                            <td>
                                <code><?= $test["input"] === "" ? "<em>[Chaîne vide]</em>" : htmlspecialchars($test["input"]) ?></code>
                            </td>
                            <td>
                                <code><?= $test["expected"] === "" ? "<em>[Chaîne vide]</em>" : htmlspecialchars($test["expected"]) ?></code>
                            </td>
                            <td>
                                <code><?= $resultat === "" ? "<em>[Chaîne vide]</em>" : htmlspecialchars($resultat) ?></code>
                            </td>
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