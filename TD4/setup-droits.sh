#!/usr/bin/env bash
# =============================================================
# setup-droits.sh — TD4 (R301)
# À relancer sur CHAQUE serveur après un transfert / déploiement.
#
# Pourquoi ? Les droits (chmod) et surtout les ACL (setfacl) sont
# stockés dans les métadonnées du système de fichiers : ils ne
# suivent PAS git, zip, ftp, ni même souvent scp.
# =============================================================

cd "$(dirname "$0")" || exit 1

echo "1) Droits classiques (le socle)"
find assets -type d -exec chmod 775 {} \;   # dossiers : www-data peut écrire
find assets -type f -exec chmod 664 {} \;   # fichiers : lecture + écriture
chmod 644 *.php css/*.css 2>/dev/null      # le code : lecture seule suffit

echo "2) ACL ciblée sur le fichier des voitures"
if command -v setfacl >/dev/null 2>&1; then
    setfacl -m u:www-data:rw assets/TD3-Cars.txt
    setfacl -R -m u:www-data:rwX assets 2>/dev/null
    echo "   ACL posées pour www-data (rw)."
else
    echo "   setfacl absent : installez acl ou utilisez chmod/chown."
fi

echo "3) Vérification"
ls -l assets/TD3-Cars.txt
command -v getfacl >/dev/null 2>&1 && getfacl assets/TD3-Cars.txt

echo "Terminé ✓ — droits et ACL appliqués pour le serveur web."
