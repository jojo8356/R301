<?php
// Petite liste d'utilisateurs pour le TD.
// Le login est l'adresse courrielle (email) de l'utilisateur.
// email => mot de passe

function get_utilisateurs()
{
    $utilisateurs = array(
        "etudiant@example.com" => "php2024",
        "prof@example.com" => "r301"
    );
    return $utilisateurs;
}
