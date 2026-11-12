<?php
// Exercice 5 : verifier sur chaque page que c'est bien l'utilisateur connecte

// Il faut une session pour savoir qui est connecte
session_start();

require_once "users.php";

// Fonction qui teste si l'utilisateur est bien connecte
function est_connecte()
{
    if (isset($_SESSION["email"]) && $_SESSION["email"] != "") {
        return true;
    }
    return false;
}

// Fonction appelee en haut de chaque page protegee.
// Si la session a expire ou si la personne n'est pas autorisee,
// on la renvoie vers le formulaire de login / mot de passe.
function exiger_connexion()
{
    if (!est_connecte()) {
        header("Location: login.php");
        exit;
    }
}
