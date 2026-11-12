#!/usr/bin/env php
<?php
/**
 * size.php — version simplifiée de la commande shell size (R301 · TD4 · exo 6).
 *
 * Usage :
 *   php size.php    -> affiche la taille totale du répertoire courant
 *
 * On parcourt toute l'arborescence sous le répertoire courant et on
 * additionne la taille (filesize) de chaque fichier trouvé.
 */

/**
 * Calcule récursivement la taille totale d'un répertoire (en octets).
 */
function taille_repertoire(string $repertoire): int
{
    $taille = 0;
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        $chemin = $repertoire . '/' . $entree;
        if (is_dir($chemin)) {
            // C'est un dossier : on descend dedans (récursivité !)
            $taille += taille_repertoire($chemin);
        } elseif (is_file($chemin)) {
            // C'est un fichier : on ajoute sa taille
            $taille += filesize($chemin);
        }
    }
    return $taille;
}

/** Transforme un nombre d'octets en taille lisible (o, Ko, Mo, Go). */
function formater_taille(int $octets): string
{
    $unites = ['o', 'Ko', 'Mo', 'Go'];
    $i = 0;
    $taille = (float) $octets;
    while ($taille >= 1024 && $i < count($unites) - 1) {
        $taille /= 1024;
        $i++;
    }
    return ($i === 0)
        ? $octets . ' o'
        : number_format($taille, 2, ',', ' ') . ' ' . $unites[$i];
}

// On lance le calcul uniquement en ligne de commande
if (php_sapi_name() === 'cli' && isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    $taille = taille_repertoire('.');
    echo "Taille totale du répertoire courant :\n";
    echo "- $taille octets\n";
    echo '- ' . formater_taille($taille) . "\n";
}
