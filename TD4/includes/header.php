<?php
/**
 * En-tête commun à toutes les pages du TD4.
 * Variables attendues avant l'include :
 *   - $titrePage  : titre affiché dans l'onglet
 *   - $pageActive : clé de la page courante (accueil, exo3, exo4, exo5, exo6)
 */

// Palette sombre pour l'auto-coloration de syntaxe de PHP (highlight_string)
ini_set('highlight.comment', '#7ee787');
ini_set('highlight.default', '#e6edf3');
ini_set('highlight.html', '#8b949e');
ini_set('highlight.keyword', '#ff7b72');
ini_set('highlight.string', '#a5d6ff');

/**
 * Affiche un bloc de code joli (coloration syntaxique PHP).
 */
function afficherCode(string $code, ?string $titre = null): void
{
    $code = preg_replace('/^\n+|\s+$/', '', $code);
    $html = highlight_string($code, true);
    echo '<div class="code-block">';
    if ($titre !== null) {
        echo '<div class="code-bar"><span class="code-dot"></span>';
        echo '<span class="code-title">' . htmlspecialchars($titre) . '</span>';
        echo '<button type="button" class="copy-btn" onclick="copierCode(this)">Copier</button></div>';
    }
    echo $html;
    echo '</div>';
}

/**
 * Affiche un bloc style "terminal".
 * Chaque ligne peut être préfixée par "cmd : ", "out : " ou "err : " pour la couleur.
 */
function afficherTerminal(array $lignes, string $titre = 'Terminal'): void
{
    echo '<div class="terminal"><div class="code-bar"><span class="code-dot"></span>';
    echo '<span class="code-title">' . htmlspecialchars($titre) . '</span></div><pre>';
    foreach ($lignes as $ligne) {
        $classe = 'out';
        $texte = $ligne;
        if (str_starts_with($ligne, 'cmd : ')) { $classe = 'cmd'; $texte = substr($ligne, 6); }
        elseif (str_starts_with($ligne, 'err : ')) { $classe = 'err'; $texte = substr($ligne, 6); }
        echo '<span class="' . $classe . '">' . htmlspecialchars($texte) . '</span>' . "\n";
    }
    echo '</pre></div>';
}

/** Affiche une question du TD. */
function question(string $texte): void
{
    echo '<div class="q"><span class="q-label">Question</span><p>' . $texte . '</p></div>';
}

/** Affiche la réponse (style étudiant). */
function reponse(string $html): void
{
    echo '<div class="reponse"><span class="reponse-label">Réponse</span><div>' . $html . '</div></div>';
}

/** Retourne les droits Unix lisibles d'un fichier (ex : 0644). */
function droitsLisibles(string $chemin): string
{
    return substr(sprintf('%04o', fileperms($chemin)), -4);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($titrePage ?? 'TD4') ?> · R301</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800;850&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/td4.css">
</head>
<body>
<header class="nav">
  <div class="nav-inner">
    <a class="brand" href="index.php"><span class="logo">📁</span> R301 · TD4</a>
    <nav class="nav-links">
      <a class="nav-link<?= ($pageActive ?? '') === 'accueil' ? ' active' : '' ?>" href="index.php">Accueil</a>
      <a class="nav-link<?= ($pageActive ?? '') === 'exo3' ? ' active' : '' ?>" href="index-exo3.php">Exo 3 · Fichiers</a>
      <a class="nav-link<?= ($pageActive ?? '') === 'exo4' ? ' active' : '' ?>" href="index-exo4.php">Exo 4 · Répertoires</a>
      <a class="nav-link<?= ($pageActive ?? '') === 'exo5' ? ' active' : '' ?>" href="index-exo5.php">Exo 5 · ls.php</a>
      <a class="nav-link<?= ($pageActive ?? '') === 'exo6' ? ' active' : '' ?>" href="index-exo6.php">Exo 6 · size.php</a>
    </nav>
  </div>
</header>
<main class="container">
