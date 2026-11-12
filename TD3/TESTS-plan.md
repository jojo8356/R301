# TD3 – Plan de tests (cas d'utilisation)

## Pré-requis avant de commencer

1. Lancer le serveur : `php -S localhost:8000 -t TD3` puis ouvrir `http://localhost:8000/`
2. Restaurer le fichier de données vierge avant les tests de l'exercice 4 :
   `cp uploads/R301-TD3-Cars.txt TD3/TD3-Cars.txt`
3. Avoir les outils développeur du navigateur (F12) sous la main pour vérifier les URL et la méthode HTTP.

---

## Exercice 3.1 — Formulaire HTML séparé + traitement GET

| N° | Action | Résultat attendu |
|---|---|---|
| 3.1-T1 | Ouvrir `index-exo3-1.html` | Formulaire affiché : 3 champs texte, radios M/Mme (M coché), accordéon vins **fermé**, boutons Commander / Effacer |
| 3.1-T2 | Cliquer sur la barre « Choisir les vins » | L'accordéon s'ouvre (chevron pivoté), le `<select multiple>` affiche les 6 vins ; un second clic le referme |
| 3.1-T3 | Tout remplir + choisir 2 vins (Ctrl+clic) → Commander | Page `index-exo3-1.php` : récapitulatif avec toutes les valeurs, « Fitou, Bandol » ; **paramètres visibles dans l'URL** (preuve de la méthode GET) |
| 3.1-T4 | Soumettre sans choisir de vin | Récapitulatif affiche « (aucun vin choisi) », aucune erreur PHP |
| 3.1-T5 | Soumettre tous les champs vides | Récapitulatif affiché avec des valeurs vides (aucune validation exigée à ce stade) |
| 3.1-T6 | Saisir `<script>alert('x')</script>` dans le nom | Le texte s'affiche tel quel (balises échappées), **aucune alerte ne s'ouvre** → `htmlspecialchars()` efficace |
| 3.1-T7 | Ouvrir directement `index-exo3-1.php` (sans paramètres) | Message rouge « Aucune donnée reçue » + lien vers le formulaire |
| 3.1-T8 | Cliquer sur Effacer | Tous les champs sont réinitialisés |

## Exercice 3.2 — Création et traitement dans un même fichier

| N° | Action | Résultat attendu |
|---|---|---|
| 3.2-T1 | Ouvrir `index-exo3-2.php` | Formulaire seul, **aucun** récapitulatif (premier affichage) |
| 3.2-T2 | Remplir + choisir des vins → Commander | URL de la même page + paramètres (`envoyer=Commander` visible) ; récapitulatif affiché **au-dessus du formulaire** |
| 3.2-T3 | Après soumission, regarder le formulaire | Champs **pré-remplis** avec les valeurs saisies, vins présélectionnés, accordéon rouvert avec badge « n choisi(s) » |
| 3.2-T4 | Modifier l'URL : `vins[]=Whisky` (vin hors liste) | Valeur inconnue ignorée, seuls les vins autorisés sont retenus |
| 3.2-T5 | Lien « Retour au sommaire » | Retour à `index.php` |

## Exercice 3.3 — Champs obligatoires

| N° | Action | Résultat attendu |
|---|---|---|
| 3.3-T1 | Soumettre tout vide | **Bloc d'erreur rouge en entête** listant les 3 champs obligatoires ; le formulaire reste affiché |
| 3.3-T2 | Remplir uniquement le nom → Commander | 2 erreurs restantes (prénom, courriel) ; le nom saisi est **conservé** dans son champ |
| 3.3-T3 | Saisir uniquement des espaces dans le nom | Champ considéré comme vide (`trim()`) → erreur |
| 3.3-T4 | Tout remplir correctement | Récapitulatif + message vert « Formulaire complet », plus aucune erreur |
| 3.3-T5 | Provoquer une erreur puis corriger | Après correction, le bloc rouge disparaît |

## Exercice 3.4 — Filtrage nom / prénom avec preg_match()

| N° | Saisie | Résultat attendu |
|---|---|---|
| 3.4-T1 | nom=`Dupont`, prénom=`Jean-Pierre` | Acceptés (lettres + tiret) |
| 3.4-T2 | nom=`Le Goff` | Accepté (espace autorisé) |
| 3.4-T3 | nom=`Dup0nt` ou prénom=`Marie2` | Erreur rouge : « ne doit contenir que des lettres, des espaces ou des tirets » |
| 3.4-T4 | nom=`O'Neil` | Refusé (apostrophe non autorisée par le masque) |
| 3.4-T5 | nom=`Élodie` | Refusé par le masque strict (accents — voir le commentaire sur le masque alternatif `/^[A-Za-zÀ-ÖØ-öø-ÿ' -]+$/u`) |
| 3.4-T6 | Champs vides + valeurs invalides mélangées | Messages d'erreur **cumulés**, saisies conservées dans le formulaire |

## Exercice 3.5 — Filtrage et cohérence du courriel

| N° | Courriel saisi | Résultat attendu |
|---|---|---|
| 3.5-T1 | `jean.dupont@etu.fr` | ✅ Valide → **message de confirmation** avec valeurs en gras |
| 3.5-T2 | `ab@cd.ef` | ✅ Valide (cas limite : exactement 2 caractères avant `@` et 2 entre `@` et `.`) |
| 3.5-T3 | `a@cd.ef` | ❌ Refusé : moins de 2 caractères avant le `@` |
| 3.5-T4 | `ab@c.def` | ❌ Refusé : `@` et `.` séparés de moins de 2 caractères |
| 3.5-T5 | `ab@cd` | ❌ Refusé : pas de point |
| 3.5-T6 | `abcd.ef` | ❌ Refusé : pas de `@` |
| 3.5-T7 | `jean dupont@etu.fr` | ❌ Refusé : espace = **caractère interdit** (message de filtrage, pas de cohérence) |
| 3.5-T8 | `jean@étu.fr` | ❌ Refusé : accent interdit par le masque |
| 3.5-T9 | champ vide | ❌ Refusé : « adresse courrielle obligatoire » |
| 3.5-T10 | Données valides complètes (Mme, Marie, Durand, 2 vins) | Message exact : « Bonjour **Mme** **Marie** **Durand**, nous vous remercions… » + vins en gras + courriel en gras ; formulaire remplacé par la confirmation + lien « Nouvelle commande » |
| 3.5-T11 | Données invalides | Message d'erreur **rouge en entête du formulaire**, saisies conservées, civilité conservée |

## Exercice 4 — Formulaire dynamique (POST + fgetcsv/fputcsv)

**Pré-condition : restaurer le fichier `TD3-Cars.txt` vierge.**

| N° | Action | Résultat attendu |
|---|---|---|
| 4-T1 | Ouvrir `index-exo4.php` | 3 tableaux (Renault ×4, Peugeot ×4, VW ×4) ; ligne d'en-tête du fichier **non affichée** ; prix en `<input type="number">` ; select avec les 3 marques |
| 4-T2 | Twingo : PrixMax `14999` → `13500` → Envoyer | Message vert « Mise à jour » ; la valeur 13500 est affichée **et écrite dans le fichier** |
| 4-T3 | Vider le champ modèle de « Clio » → Envoyer | Message « Suppression » ; la ligne disparaît du tableau **et du fichier** |
| 4-T4 | Nouveau modèle : marque `VW`, modèle `T-Roc`, prix `24000` → Envoyer | Message « Ajout » ; nouvelle ligne dans le tableau VW ; fichier : `VW T-Roc 24000 24000` (le prix unique alimente PrixMin et PrixMax) |
| 4-T5 | Nouveau modèle rempli **sans** prix (ou l'inverse) → Envoyer | Erreur rouge « renseignez le modèle ET un prix » ; aucun ajout |
| 4-T6 | Prix `abc` sur une ligne existante → Envoyer | Erreur rouge (entiers positifs attendus) ; la ligne garde ses **anciennes valeurs** dans le fichier |
| 4-T7 | Laisser les champs « nouveau modèle » vides → Envoyer | Aucune action, aucun message d'erreur |
| 4-T8 | 1 modification + 1 suppression + 1 ajout dans le même envoi | Les 3 actions listées dans les messages ; fichier cohérent avec le formulaire |
| 4-T9 | Recharger la page (F5) après modifications | Le formulaire reflète exactement le contenu du fichier (séquence écriture → relecture) |
| 4-T10 | Regarder l'URL après envoi | **Aucun paramètre visible** (preuve de la méthode POST) |
| 4-T11 | Ouvrir `TD3-Cars.txt` sur le disque | En-tête + lignes à jour, séparateur tabulation conservé |

## Tests transverses (toutes les pages)

| N° | Test | Résultat attendu |
|---|---|---|
| X-T1 | Injection `<b>`, `<script>` dans chaque champ texte | Toujours échappé à l'affichage (pas de HTML interprété) |
| X-T2 | Appel direct des scripts sans paramètres dans l'URL | Aucune notice / warning « undefined array key » |
| X-T3 | `php -l` sur chaque fichier | « No syntax errors detected » partout |
| X-T4 | Liens de navigation (retour sommaire, liens entre pages) | Tous fonctionnels |
| X-T5 | Formulaire soumis deux fois de suite (F5 après envoi) | Comportement stable, pas d'effet de bord |
