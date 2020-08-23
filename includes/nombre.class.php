<?php
session_start();
define("RANDOM_NUMBER_MAXIMUM", 100);
define("RANDOM_NUMBER_MINIMUM", 1);

function nombre_utilisateur() {
    return isset($_POST['guess']);
}

function utilisateur_a_bien_devine() {
    return choix_utilisateur() == nombre_secret();
}

function nombre_trop_haut() {
    return choix_utilisateur() > nombre_secret();
}

function nombre_trop_bas() {
    return choix_utilisateur() < nombre_secret();
}

function chance_max(){
    return nombre_chance() == 0;
}

function utilisateur_demand_reset() {
    return isset($_POST['reset']);
}

function condition_recuperation($hash, $key) {
    if (isset($hash[$key])) {
        return $hash[$key];
    } else {
        return false;
    }
}


function choix_utilisateur() {
    return condition_recuperation($_POST, 'user_guess');
}

function nombre_secret() {
    return condition_recuperation($_SESSION, 'secret_number');
}

function nombre_secret_non_definit() {
    return !isset($_SESSION['secret_number']);
}

function reset_nombre_secret() {
    $_SESSION['secret_number'] = rand(RANDOM_NUMBER_MINIMUM, RANDOM_NUMBER_MAXIMUM);
}

function reset_compteur_coups() {
    $_SESSION['guess_count'] = 0;
}

function reset_nombre_chance() {
    $_SESSION['nbr_chance'] = 10;
}

function diminuer_nombre_chance() {
    $_SESSION['nbr_chance']--;
}

function augmenter_compteur_coups() {
    $_SESSION['guess_count']++;
}

function nombre_de_coups() {
    return condition_recuperation($_SESSION, 'guess_count');
}
function nombre_chance() {
    return condition_recuperation($_SESSION, 'nbr_chance');
}
?>