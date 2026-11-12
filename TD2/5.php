<?php
// Définition du fuseau horaire
date_default_timezone_set('Europe/Paris');

// Tableaux de correspondance pour l'affichage en français
$joursFr = [
    1 => "Lundi", 2 => "Mardi", 3 => "Mercredi", 
    4 => "Jeudi", 5 => "Vendredi", 6 => "Samedi", 7 => "Dimanche"
];

$moisFr = [
    1 => "Janvier", 2 => "Février", 3 => "Mars", 4 => "Avril",
    5 => "Mai", 6 => "Juin", 7 => "Juillet", 8 => "Août",
    9 => "Septembre", 10 => "Octobre", 11 => "Novembre", 12 => "Décembre"
];

// 5.1 & 5.2 & 5.3 : Données actuelles
$dateDuJour    = date("d/m/Y");
$annee         = date("Y");
$moisNum       = (int)date("n");
$moisNomFr     = $moisFr[$moisNum];
$moisNomEn     = date("F");
$jourNumSem    = (int)date("N");
$jourNomFr     = $joursFr[$jourNumSem];
$jourNomEn     = date("l");
$heureCourante = date("H:i:s");

// 5.4 : Date personnalisée avec mktime(H, i, s, m, d, Y)
// Exemple : 14 Juillet 2025 à 15h30min00s
$h = 15; $i = 30; $s = 0; $m = 7; $d = 14; $y = 2025;
$timestampPerso = mktime($h, $i, $s, $m, $d, $y);
$datePersoFormatee = date("d/m/Y à H:i:s", $timestampPerso);

// =========================================================================
// Suite de tests de validation des formats
// =========================================================================
$tests = [
    [
        "desc"     => "Formatage 5.1 (Format JJ/MM/AAAA)",
        "obtenu"   => $dateDuJour,
        "succes"   => (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $dateDuJour) === 1)
    ],
    [
        "desc"     => "Formatage 5.2 (Année à 4 chiffres)",
        "obtenu"   => $annee,
        "succes"   => (strlen($annee) === 4 && is_numeric($annee))
    ],
    [
        "desc"     => "Formatage 5.3 (Format Heure HH:MM:SS)",
        "obtenu"   => $heureCourante,
        "succes"   => (preg_match('/^\d{2}:\d{2}:\d{2}$/', $heureCourante) === 1)
    ],
    [
        "desc"     => "Création mktime 5.4 (14/07/2025 15:30:00)",
        "obtenu"   => $datePersoFormatee,
        "succes"   => ($datePersoFormatee === "14/07/2025 à 15:30:00")
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
    <title>TD2 - Exercice 5 : Fonctions date et mktime</title>
    <link rel="stylesheet" href="css/td2.css">
</head>
<body>

    <header class="main-header">
        <h1>R301 - TD n°2 : Exercice 5</h1>
        <p class="subtitle">Gestion du temps et formatage avec <code>date()</code> et <code>mktime()</code></p>
    </header>

    <main class="container">

        <!-- Informations & consignes -->
        <section class="card info-box">
            <h2>ℹ️ Fuseau horaire & Paramètres</h2>
            <ul>
                <li><strong>Fuseau configuré :</strong> <code><?= date_default_timezone_get() ?></code></li>
                <li><strong>Format date :</strong> <code>d</code> (jour 01-31), <code>m</code> (mois 01-12), <code>Y</code> (année 4 chiffres), <code>H</code> (heures 00-23), <code>i</code> (minutes), <code>s</code> (secondes).</li>
                <li><strong>Prototype mktime :</strong> <code>mktime(heure, minute, seconde, mois, jour, annee)</code></li>
            </ul>
        </section>

        <!-- Résultats des questions 5.1 à 5.4 -->
        <section class="card">
            <h2>📅 Résultats des manipulations de dates</h2>

            <table class="table-tests">
                <thead>
                    <tr>
                        <th>Section</th>
                        <th>Description de la consigne</th>
                        <th>Code PHP utilisé</th>
                        <th>Résultat obtenu</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- 5.1 -->
                    <tr>
                        <td><strong>5.1</strong></td>
                        <td>Date du jour complète</td>
                        <td><code>date("d/m/Y")</code></td>
                        <td><strong>Bonjour nous sommes le <?= $dateDuJour ?></strong></td>
                    </tr>

                    <!-- 5.2 -->
                    <tr>
                        <td rowspan="3"><strong>5.2</strong></td>
                        <td>Année courante</td>
                        <td><code>date("Y")</code></td>
                        <td><strong><?= $annee ?></strong></td>
                    </tr>
                    <tr>
                        <td>Mois courant</td>
                        <td><code>date("m")</code> & <code>date("F")</code></td>
                        <td><strong><?= $moisNomFr ?></strong> (numéro : <?= date("m") ?>, EN : <?= $moisNomEn ?>)</td>
                    </tr>
                    <tr>
                        <td>Jour de la semaine</td>
                        <td><code>date("l")</code> & <code>date("N")</code></td>
                        <td><strong><?= $jourNomFr ?></strong> (numéro ISO : <?= $jourNumSem ?>, EN : <?= $jourNomEn ?>)</td>
                    </tr>

                    <!-- 5.3 -->
                    <tr>
                        <td><strong>5.3</strong></td>
                        <td>Heure actuelle (24h)</td>
                        <td><code>date("H:i:s")</code></td>
                        <td><code><?= $heureCourante ?></code></td>
                    </tr>

                    <!-- 5.4 -->
                    <tr>
                        <td><strong>5.4</strong></td>
                        <td>Date personnalisée (<code>mktime</code>)</td>
                        <td><code>mktime(15, 30, 0, 7, 14, 2025)</code></td>
                        <td><strong style="color: #2980b9;"><?= $datePersoFormatee ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Suite de tests unitaires -->
        <section class="card">
            <h2>🧪 Contrôle de conformité des formats</h2>
            
            <table class="table-tests">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vérification</th>
                        <th>Valeur générée</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tests as $index => $test) : 
                        if ($test["succes"]) { $reussis++; }
                    ?>
                        <tr class="<?= $test["succes"] ? 'row-success' : 'row-danger' ?>">
                            <td><strong><?= $index + 1 ?></strong></td>
                            <td><?= htmlspecialchars($test["desc"]) ?></td>
                            <td><code><?= htmlspecialchars($test["obtenu"]) ?></code></td>
                            <td>
                                <?php if ($test["succes"]) : ?>
                                    <span class="badge badge-success">✓ CONFORME</span>
                                <?php else : ?>
                                    <span class="badge badge-danger">✗ NON CONFORME</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Résumé final -->
        <section class="summary-box <?= ($reussis === $total) ? 'summary-success' : 'summary-danger' ?>">
            <h3>Bilan : <?= $reussis ?> / <?= $total ?> formats validés</h3>
            <p>
                <?= ($reussis === $total) 
                    ? "🎉 Toutes les dates et tous les formats ont été instanciés correctement !" 
                    : "⚠️ Certains formats de date comportent des anomalies." ?>
            </p>
        </section>

    </main>

</body>
</html>