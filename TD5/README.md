# R301 - TD n°5 : sessions PHP, cookies et email

Dans ce TD on apprend à utiliser les **sessions** et les **cookies** en PHP.
J'ai fait tous les exercices du PDF (`R301-TD5-v1.1.pdf`) avec du code simple.

## Comment lancer le site

Il faut Node.js. Ensuite :

```bash
npm install      # installe PHP WebAssembly
npm start        # demarre le serveur
```

Puis on ouvre la page :

```
http://localhost:8080/menu.html
```

PHP tourne avec **PHP WebAssembly** (le paquet npm `@php-wasm/node`),
donc on n'a pas besoin d'installer PHP ni Apache sur l'ordinateur.
Le petit serveur Node (`server.mjs`) sert juste les fichiers PHP au navigateur.

## Les fichiers

### Partie 1 : les sessions

| Fichier | Ce qu'il fait |
| --- | --- |
| `menu.html` | Le menu du TP. Il utilise `style.css` pour être horizontal. |
| `style.css` | La feuille de style qui met le menu à l'horizontal. |
| `open_session.php` | Exercice 1. Appelle `session_start()` pour créer ou reprendre une session, puis affiche le formulaire nom / prénom. |
| `create_session.php` | Exercice 2. Enregistre le nom et le prénom dans `$_SESSION` et affiche les variables de session. |
| `display_session.php` | Exercice 3. Affiche les variables de session et compte le nombre de fois que la page a été vue. |
| `destroy_session.php` | Exercice 4. Supprime les variables de session avec `session_destroy()`. |

**Comment j'ai testé :**

1. Je clique sur « Ouvrir une session » : PHP me donne un identifiant de session (SID)
   et le stocke dans un cookie `PHPSESSID`.
2. Je remplis le formulaire, les informations partent dans `create_session.php`
   et se retrouvent dans `$_SESSION`.
3. J'ouvre « Afficher variables de session » : je vois les mêmes variables
   (donc elles sont bien globales au site) et le compteur augmente de 1 à chaque fois.
4. Je clique sur « Détruire variables de session » : le tableau `$_SESSION` est vide.

### Partie 2 : cookies et email

| Fichier | Ce qu'il fait |
| --- | --- |
| `users.php` | Une petite liste d'utilisateurs (login = email). |
| `auth.php` | Exercice 5. Les fonctions `est_connecte()` et `exiger_connexion()`. |
| `login.php` | Exercice 5. Le formulaire de login / mot de passe et la création des cookies. |
| `accueil.php` | Une page protégée : elle appelle `exiger_connexion()` au début. |
| `logout.php` | Déconnexion : détruit la session et supprime les cookies. |
| `mot_de_passe_oublie.php` | Exercice 6. La fonction `envoyer_mot_de_passe()` qui envoie le mot de passe par email. |

**Le login est l'adresse email.** Pour se connecter dans le TD :

```
email          : etudiant@example.com
mot de passe   : php2024
```

## Comment tester les cookies

- Le cookie garde le login et le mot de passe **pendant 1 mois**
  (ligne `$duree_cookie = 30 * 24 * 60 * 60;` dans `login.php`).
  Comme ça, quand on revient sur le site, on est reconnecté automatiquement.
- Pour l'exercice « cookie de 30 secondes », il faut remplacer cette ligne par :

```php
$duree_cookie = 30;
```

Ensuite on se connecte, on attend 31 secondes, et on voit que le site
redemande le login : le cookie a bien expiré.

## Le mot de passe oublié

La fonction `envoyer_mot_de_passe($email)` utilise `mail()` pour envoyer
le mot de passe par courrier électronique.
Comme le serveur de test n'a pas de messagerie, le courriel est aussi écrit
dans le dossier `emails/` pour pouvoir vérifier que la fonction marche.

## Remarque

Garder le mot de passe dans un cookie en clair, ce n'est pas sécurisé.
C'est juste ce que demande l'énoncé du TD. Dans un vrai site on ne le fait pas.
