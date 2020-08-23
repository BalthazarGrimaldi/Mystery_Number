<?php
require('includes/nombre.class.php');

$message_utilisateur = "J'ai choisis un nombre entre " .
    RANDOM_NUMBER_MINIMUM . " et " .
    RANDOM_NUMBER_MAXIMUM . ". Pouvez-vous le deviner ?";

$utilisateur_a_bien_devine = utilisateur_a_bien_devine();
$chance_max = chance_max();

if (nombre_utilisateur()) {
    augmenter_compteur_coups();
    diminuer_nombre_chance();

    if ($utilisateur_a_bien_devine) {
        $message_utilisateur = "Vous l'avez, vous avez mis " . nombre_de_coups() . " coups. Envie de rejouer?";
    } else if (nombre_trop_haut()) {
        $message_utilisateur = "Le nombre est plus petit.";
    } else if (nombre_trop_bas()) {
        $message_utilisateur = "Le nombre est plus grand.";
}
    if($chance_max){
        $message_utilisateur = "Vous avez atteint votre chance max, reessayez !";
    }
}

if (nombre_secret_non_definit() || utilisateur_demand_reset() || $utilisateur_a_bien_devine || $chance_max) {
    reset_nombre_secret();
    reset_compteur_coups();
    reset_nombre_chance();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Jeu du nombre secret</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="CSS/main.css">
</head>
<header>
    <nav class="navbar navbar-light bg-dark header-navigation">
        <h1 style="width: 500px;" class="mx-auto">Jeu du nombre secret</h1>
    </nav>
</header>
<body>
<div class="container-fluid m-3 jumbotron mx-auto user-message" style="width: 75%;">
    <p style="text-align: center;"><?= $message_utilisateur ?></p>

</div>
<div class="container-fluid m-5 mx-auto user-input">
    <div class="row">
        <div class="col-6">
<form method="post">
    <label class="label-deviner" for="choix_utilisateur">Vous devinez :</label>
    <input class="form-control" id="choix_utilisateur" name="user_guess" style="width: 50%;">
    <input class="btn btn-sm m-3 btn-deviner" type="submit" name="guess" value="Deviner">
    <input class="btn btn-sm btn-reset" type="submit" name="reset" value="Reset">
</form>
    </div>
<div class="col-6 nb-coups jumbotron">
    <p>Nombre de coup :</p><br>
    <p><?= nombre_de_coups() ?></p><br>
    <br>
    <hr style="background-color: #ecf0f1;">
    <p>Nombre de chances disponibles :</p><br>
    <p><?= nombre_chance() ?></p>
</div>
    </div>
</div>

<!-- décommenter pour tester seulement ;) :
        <p><strong>Nombre Secret:</strong> <?= nombre_secret() ?></p> -->
</body>
</html>