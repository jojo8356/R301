<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
    <?php
    $x = 2;
    $y = 4;
    $z = 0;
    $msg = "bonjour à tous";
    define('TAUX_TVA', 0.20);
    $titre = "Mon Titre";
    $paragraphe = "Bonjour à tous";
    ?>
</head>

<body>
    <h1>4 Introduction au PHP</h1>
    <?php
    echo "<h1>$titre</h1>";
    echo "<p>$paragraphe</p>";
    echo "<ul><li>Item 1</li><li>Item 2</li></ul>";
    ?>
    <?php
    print "<h2>Sous-titre</h2>";
    print "<p>Un paragraphe affiché avec print.</p>";
    ?>
    <?php echo $msg; ?>
    <?php
    $z = $x * $y;
    echo "<ul><li>x = $x</li><li>y = $y</li><li>z = $z</li><li>$x fois $y = $z</li></ul>";
    $chaine_simple = 'Bonjour';
    $chaine_double = "Bonjour";
    /* 
    Les deux syntaxes sont valides, mais les guillemets doubles permettent l'interprétation des variables et des séquences d'échappement, contrairement aux guillemets simples.
    */
    echo "Je m’appelle Martin";
    ?>
    <table style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 14px">
        <thead>
            <tr>
                <th style="background-color: #f1f5f9; color: #1e293b; text-align: left; padding: 8px; font-weight: bold; border: 1px solid #e2e8f0"></th>
                <th style="background-color: #f1f5f9; color: #1e293b; text-align: left; padding: 8px; font-weight: bold; border: 1px solid #e2e8f0">echo</th>
                <th style="background-color: #f1f5f9; color: #1e293b; text-align: left; padding: 8px; font-weight: bold; border: 1px solid #e2e8f0">print</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Nature</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Construct de langage (pas une fonction)</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Construct de langage (pas une fonction)</td>
            </tr>
            <tr>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Nombre d&#039;arguments</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Plusieurs : echo &quot;a&quot;, &quot;b&quot;, &quot;c&quot;;</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Un seul : print &quot;a&quot;;</td>
            </tr>
            <tr>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Valeur de retour</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Aucune (void)</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Retourne 1</td>
            </tr>
            <tr>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Vitesse</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Légèrement plus rapide</td>
                <td style="color: #334155; text-align: left; padding: 8px; border: 1px solid #e2e8f0">Légèrement plus lent</td>
            </tr>
        </tbody>
    </table>
    <br />
    <h1>5 Manipulation de chaînes de caractères</h1>
    <table>
        <thead>
            <tr>
                <th>N°</th>
                <th>Fonction</th>
                <th>Rôle / Description</th>
                <th>Exemple d'utilisation (PHP)</th>
            </tr>
        </thead>
        <tbody>
            <!-- 1. strlen -->
            <tr>
                <td>1</td>
                <td class="function-name">strlen()</td>
                <td>Calcule et retourne la longueur d'une chaîne de caractères (nombre de caractères/octets).</td>
                <td>
                    <pre><code>$texte = "Bonjour tout le monde !";
$longueur = strlen($texte);

echo $longueur; 
<span class="comment">// Affiche : 23</span></code></pre>
                </td>
            </tr>

            <!-- 2. strpos -->
            <tr>
                <td>2</td>
                <td class="function-name">strpos()</td>
                <td>Cherche la position de la première occurrence d'une sous-chaîne. Retourne <code>false</code> si non trouvée. Index commence à 0.</td>
                <td>
                    <pre><code>$texte = "Apprendre le PHP c'est génial";
$position = strpos($texte, "PHP");

echo $position; 
<span class="comment">// Affiche : 13</span></code></pre>
                </td>
            </tr>

            <!-- 3. strstr -->
            <tr>
                <td>3</td>
                <td class="function-name">strstr()</td>
                <td>Cherche la première occurrence d'une sous-chaîne et retourne le reste de la chaîne à partir de celle-ci (inclus).</td>
                <td>
                    <pre><code>$email = "jean.dupont@example.com";
$domaine = strstr($email, '@');

echo $domaine; 
<span class="comment">// Affiche : @example.com</span></code></pre>
                </td>
            </tr>

            <!-- 4. substr -->
            <tr>
                <td>4</td>
                <td class="function-name">substr()</td>
                <td>Extrait et retourne une partie d'une chaîne selon une position de départ et une longueur donnée.</td>
                <td>
                    <pre><code>$texte = "Développement";
<span class="comment">// Extraire 4 caractères à partir de l'index 0</span>
$extrait = substr($texte, 0, 4);

echo $extrait; 
<span class="comment">// Affiche : Déve</span></code></pre>
                </td>
            </tr>

            <!-- 5. str_replace -->
            <tr>
                <td>5</td>
                <td class="function-name">str_replace()</td>
                <td>Remplace toutes les occurrences d'un texte recherché par un autre texte dans une chaîne donnée.</td>
                <td>
                    <pre><code>$phrase = "J'aime les chats. Les chats sont mignons.";
$nouvellePhrase = str_replace("chats", "chiens", $phrase);

echo $nouvellePhrase; 
<span class="comment">// Affiche : J'aime les chiens. Les chiens sont mignons.</span></code></pre>
                </td>
            </tr>

            <!-- 6. htmlentities -->
            <tr>
                <td>6</td>
                <td class="function-name">htmlentities()</td>
                <td>Convertit tous les caractères éligibles en entités HTML (protection contre les failles XSS).</td>
                <td>
                    <pre><code>$saisieUtilisateur = "&lt;script&gt;alert('Piraté !');&lt;/script&gt;";
$securise = htmlentities($saisieUtilisateur);

echo $securise; 
<span class="comment">// Code source : &amp;lt;script&amp;gt;alert('Piraté !');&amp;lt;/script&amp;gt;</span></code></pre>
                </td>
            </tr>

            <!-- 7. html_entity_decode -->
            <tr>
                <td>7</td>
                <td class="function-name">html_entity_decode()</td>
                <td>L'inverse de <code>htmlentities()</code>. Transforme les entités HTML en leurs caractères correspondants.</td>
                <td>
                    <pre><code>$texteCode = "Ceci est du texte en &amp;lt;b&amp;gt;gras&amp;lt;/b&amp;gt;.";
$texteDecode = html_entity_decode($texteCode);

echo $texteDecode; 
<span class="comment">// Affiche : Ceci est du texte en &lt;b&gt;gras&lt;/b&gt;.</span></code></pre>
                </td>
            </tr>

            <!-- 8. explode -->
            <tr>
                <td>8</td>
                <td class="function-name">explode()</td>
                <td>Découpe une chaîne de caractères en un tableau (array) à partir d'un séparateur spécifié.</td>
                <td>
                    <pre><code>$listeFruits = "Pomme,Banane,Orange,Fraise";
$tableauFruits = explode(",", $listeFruits);

print_r($tableauFruits);
<span class="comment">/* Affiche :
Array (
    [0] => Pomme
    [1] => Banane
    [2] => Orange
    [3] => Fraise
) */</span></code></pre>
                </td>
            </tr>

            <!-- 9. implode -->
            <tr>
                <td>9</td>
                <td class="function-name">implode()</td>
                <td>L'inverse de <code>explode()</code>. Rassemble les éléments d'un tableau pour former une seule chaîne avec un séparateur.</td>
                <td>
                    <pre><code>$mots = ["PHP", "est", "un", "langage", "puissant"];
$phrase = implode(" ", $mots);

echo $phrase; 
<span class="comment">// Affiche : PHP est un langage puissant</span></code></pre>
                </td>
            </tr>

            <!-- 10. addslashes -->
            <tr>
                <td>10</td>
                <td class="function-name">addslashes()</td>
                <td>Ajoute des antislashs <code>\</code> devant les caractères spéciaux (<code>'</code>, <code>"</code>, <code>\</code>, NULL).</td>
                <td>
                    <pre><code>$chaine = "C'est l'histoire d'un \"programmeur\".";
$chaineEchappee = addslashes($chaine);

echo $chaineEchappee; 
<span class="comment">// Affiche : C\'est l\'histoire d\'un \"programmeur\".</span></code></pre>
                </td>
            </tr>
        </tbody>
    </table>
    <h1> 6 Manipulation de tableaux</h1>
    <?php
    $Marques = [
        [
            "Nom" => "Renault",
            "Modeles" => [
                ["Nom" => "Twingo", "PrixMin" => 9999,  "PrixMax" => 14999],
                ["Nom" => "Clio",   "PrixMin" => 11999, "PrixMax" => 18999],
                ["Nom" => "Mégane", "PrixMin" => 13999, "PrixMax" => 22999],
                ["Nom" => "Laguna", "PrixMin" => 18000, "PrixMax" => 30000]
            ]
        ],
        [
            "Nom" => "Peugeot",
            "Modeles" => [
                ["Nom" => "108", "PrixMin" => 9500,  "PrixMax" => 16000],
                ["Nom" => "208", "PrixMin" => 11500, "PrixMax" => 18500],
                ["Nom" => "308", "PrixMin" => 14000, "PrixMax" => 24000],
                ["Nom" => "408", "PrixMin" => 19000, "PrixMax" => 32000]
            ]
        ],
        [
            "Nom" => "VW",
            "Modeles" => [
                ["Nom" => "Lupo",   "PrixMin" => 9900,  "PrixMax" => 17900],
                ["Nom" => "Polo",   "PrixMin" => 14000, "PrixMax" => 21000],
                ["Nom" => "Golf",   "PrixMin" => 16000, "PrixMax" => 29000],
                ["Nom" => "Passat", "PrixMin" => 22000, "PrixMax" => 35000]
            ]
        ]
    ];
    ?>
    <div class="section">
        <h2>1. Affichage avec <code>print_r()</code></h2>
        <pre><?php print_r($Marques); ?></pre>
    </div>

    <div class="section modeles">
        <h2>2. Affichage HTML avec boucle <code>foreach</code></h2>
        <?php foreach ($Marques as $marque): ?>
            <div>
                <h3><?= $marque['Nom'] ?></h3>
                <table>
                    <?php foreach ($marque['Modeles'] as $modele): ?>
                        <tr>
                            <td style="width: 100px;"><?= $modele['Nom'] ?></td>
                            <td style="width: 80px;"><?= $modele['PrixMin'] ?></td>
                            <td style="width: 80px;"><?= $modele['PrixMax'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="section modeles">
        <h2>3. Affichage HTML avec boucle <code>for</code></h2>
        <?php
        $nbMarques = count($Marques);
        for ($i = 0; $i < $nbMarques; $i++):
        ?>
            <div>
                <h3><?= $Marques[$i]['Nom'] ?></h3>
                <table>
                    <?php
                    $nbModeles = count($Marques[$i]['Modeles']);
                    for ($j = 0; $j < $nbModeles; $j++):
                    ?>
                        <tr>
                            <td style="width: 100px;"><?= $Marques[$i]['Modeles'][$j]['Nom'] ?></td>
                            <td style="width: 80px;"><?= $Marques[$i]['Modeles'][$j]['PrixMin'] ?></td>
                            <td style="width: 80px;"><?= $Marques[$i]['Modeles'][$j]['PrixMax'] ?></td>
                        </tr>
                    <?php endfor; ?>
                </table>
            </div>
        <?php endfor; ?>
    </div>

    <div class="section">
        <h2>4. Application des fonctions de traitement</h2>

        <!-- count() -->
        <div class="fonction-demo">
            <strong>count() :</strong><br>
            Nombre de marques : <?= count($Marques) ?><br>
            Nombre de modèles chez Renault : <?= count($Marques[0]['Modeles']) ?>
        </div>

        <!-- implode() -->
        <?php
        // Extraire les noms des modèles Renault dans un tableau simple pour la démo
        $modelesRenault = [];
        foreach ($Marques[0]['Modeles'] as $m) {
            $modelesRenault[] = $m['Nom'];
        }
        $chaineModeles = implode(" - ", $modelesRenault);
        ?>
        <div class="fonction-demo">
            <strong>implode() :</strong> Transforme le tableau des modèles Renault en chaîne.<br>
            Résultat : <em><?= $chaineModeles ?></em>
        </div>

        <!-- explode() -->
        <?php $nouveauTableau = explode(" - ", $chaineModeles); ?>
        <div class="fonction-demo">
            <strong>explode() :</strong> Re-transforme la chaîne précédente en tableau.<br>
            <pre><?php print_r($nouveauTableau); ?></pre>
        </div>

        <!-- str_split() -->
        <?php $caracteresMarque = str_split($Marques[0]['Nom']); ?>
        <div class="fonction-demo">
            <strong>str_split() :</strong> Découpe le nom "Renault" lettre par lettre.<br>
            <pre><?php print_r($caracteresMarque); ?></pre>
        </div>

        <!-- array_push() -->
        <?php
        // Copie de travail pour ne pas altérer la structure originale
        $copieRenault = $Marques[0]['Modeles'];
        array_push($copieRenault, ["Nom" => "Austral", "PrixMin" => 35000, "PrixMax" => 45000]);
        ?>
        <div class="fonction-demo">
            <strong>array_push() :</strong> Ajoute le modèle "Austral" à la fin des modèles Renault.<br>
            Dernier élément ajouté : <?= $copieRenault[count($copieRenault) - 1]['Nom'] ?>
        </div>

        <!-- array_pop() -->
        <?php
        $elementRetire = array_pop($copieRenault);
        ?>
        <div class="fonction-demo">
            <strong>array_pop() :</strong> Supprime et retourne le dernier élément du tableau précédent.<br>
            Élément retiré : <?= $elementRetire['Nom'] ?>
        </div>

        <!-- sort() -->
        <?php
        $listeModelesVW = ["Lupo", "Polo", "Golf", "Passat"];
        sort($listeModelesVW);
        ?>
        <div class="fonction-demo">
            <strong>sort() :</strong> Trie les modèles VW par ordre alphabétique croissant.<br>
            <pre><?php print_r($listeModelesVW); ?></pre>
        </div>

        <!-- rsort() -->
        <?php
        rsort($listeModelesVW);
        ?>
        <div class="fonction-demo">
            <strong>rsort() :</strong> Trie les modèles VW par ordre alphabétique décroissant.<br>
            <pre><?php print_r($listeModelesVW); ?></pre>
        </div>

        <!-- arsort() -->
        <?php
        // Création d'un tableau associatif [Nom du modèle => Prix minimum]
        $prixMinPeugeot = [
            "108" => 9500,
            "208" => 11500,
            "308" => 14000,
            "408" => 19000
        ];
        // Modifions une valeur pour rendre le tri intéressant
        $prixMinPeugeot["308"] = 25000;

        // arsort trie par valeur en ordre décroissant tout en conservant les clés
        arsort($prixMinPeugeot);
        ?>
        <div class="fonction-demo">
            <strong>arsort() :</strong> Trie un tableau associatif (Modèle => Prix) par valeur décroissante en conservant les clés associées.<br>
            <pre><?php print_r($prixMinPeugeot); ?></pre>
        </div>
    </div>

</body>

</html>