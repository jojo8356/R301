#!/usr/bin/env php
<?php
/**
 * ls.php — version simplifiée de la commande shell ls (R301 · TD4 · exo 5).
 *
 * Usage :
 *   php ls.php             -> liste tout le contenu du répertoire courant
 *   php ls.php jpg txt rar -> liste les fichiers qui finissent par .jpg, .txt, .rar
 *
 * Rappel : le tableau $argv contient les arguments passés au script.
 *   php ls.php jpg txt  =>  $argv[0] = "ls.php", $argv[1] = "jpg", $argv[2] = "txt"
 */

/**
 * Liste les fichiers du répertoire courant, filtrés par suffixe.
 *
 * @param string $repertoire Le dossier à parcourir
 * @param array  $suffixes   Les suffixes demandés (ex : ['jpg', 'txt'])
 *                           S'il est vide, on renvoie tout le contenu.
 * @return array Sans suffixe : liste simple des noms.
 *               Avec suffixes : [suffixe => [fichiers...]]
 */
function ls_fichiers(string $repertoire, array $suffixes = []): array
{
    $fichiers = [];
    foreach (scandir($repertoire) as $entree) {
        if ($entree === '.' || $entree === '..') {
            continue;
        }
        if (is_file($repertoire . '/' . $entree)) {
            $fichiers[] = $entree;
        }
    }
    sort($fichiers); // pour un affichage dans l'ordre alphabétique

    if ($suffixes === []) {
        return $fichiers;
    }

    // On classe les fichiers par suffixe demandé (dans l'ordre des arguments)
    $parSuffixe = [];
    foreach ($suffixes as $suffixe) {
        $parSuffixe[$suffixe] = [];
    }
    foreach ($fichiers as $fichier) {
        foreach ($suffixes as $suffixe) {
            if (str_ends_with(strtolower($fichier), '.' . strtolower($suffixe))) {
                $parSuffixe[$suffixe][] = $fichier;
            }
        }
    }
    return $parSuffixe;
}

// On lance l'affichage uniquement quand le script est exécuté en ligne de commande
if (php_sapi_name() === 'cli' && isset($argv[0]) && realpath($argv[0]) === __FILE__) {
    $suffixes = array_slice($argv, 1); // tout sauf le nom du script
    $resultat = ls_fichiers('.', $suffixes);

    if ($suffixes === []) {
        // Aucun argument : on liste tout
        foreach ($resultat as $fichier) {
            echo $fichier, "\n";
        }
    } else {
        foreach ($resultat as $suffixe => $fichiers) {
            if ($fichiers === []) {
                echo $suffixe, " : no file found\n";
            } else {
                foreach ($fichiers as $fichier) {
                    echo $fichier, "\n";
                }
            }
        }
    }
}
