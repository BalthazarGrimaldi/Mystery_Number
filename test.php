<?php
// déclarations :
$email_to = "josselin.lucazeau@gmail.com";
$email_subject = "Mail : Contact PROTEAM";
$nbr_error=0;
$alert_error=0;

if (isset($_POST['first_name']) ||
    isset($_POST['last_name'])||
    isset($_POST['company'])||
    isset($_POST['email_from'])||
    isset($_POST['phone_nbr'])||
    isset($_POST['message'])) {

    $first_name = $_POST['first_name']; // required
    $last_name = $_POST['last_name']; // required
    $company = $_POST['company']; // not required
    $email_from = $_POST['email_from']; // required
    $phone_nbr = $_POST['phone_nbr']; // not required
    $message = $_POST['message']; // required
// check si les champs son vides :
    if ($_POST['first_name']==null) {
        $first_name_error = " prénom manquant,";
        echo '<style>#first_name_field { border: 1px solid red;transition: 1s;}</style>';
        $nbr_error++;
    }
    else {
        $first_name_error = "";
    }
    if ($_POST['last_name']==null) {
        $last_name_error = " nom manquant,";
        echo '<style>#last_name_field { border: 1px solid red;transition: 1s;}</style>';
        $nbr_error++;
    }
    else {
        $last_name_error = "";
    }
    if ($_POST['email_from']==null) {
        $email_from_error = " email manquant,";
        echo '<style>#email_field { border: 1px solid red;transition: 1s;}</style>';
        $nbr_error++;
    }
    else {
        $email_from_error = "";
    }
    if (strlen($_POST['message'])<2) {
        $message_error =  " message manquant,";
        echo '<style>#message_field { border: 1px solid red;transition: 1s;}</style>';
        $nbr_error++;
    }
    else {
        $message_error = "";
    }
    // affiche les erreurs si il y en a  :
    if ($nbr_error!=0) {
        {
            echo "il y a $nbr_error erreur(s) : <br>";
            echo "$first_name_error
                      $last_name_error
                      $email_from_error
                      $message_error";
            echo '<style>#pop_up_erreurs { color: red;
                                               left: 450px;}
                      </style>';
        }
        // si pas d'erreur debut de la creation du mail :
        if ($nbr_error==0) {

            $email_message = "Détails du formulaire ci-dessous.\n\n";



            function clean_string($string) {
                $bad = array("content-type","bcc:","to:","cc:","href");
                return str_replace($bad,"",$string);
            }



            $email_message .= "Prénom: ".clean_string($first_name)."\n";
            $email_message .= "Nom: ".clean_string($last_name)."\n";
            $email_message .= "Entreprise: ".clean_string($company)."\n";
            $email_message .= "Email: ".clean_string($email_from)."\n";
            $email_message .= "Telephone: ".clean_string($phone_nbr)."\n";
            $email_message .= "Message : ".clean_string($message)."\n";

            // entete de l'email
            $headers = 'From: '.$email_from."\r\n".
                'Reply-To: '.$email_from."\r\n" .
                'X-Mailer: PHP/' . phpversion();
            @mail($email_to, $email_subject, $email_message, $headers);
            $mail_reponse= @mail($email_to, $email_subject, $email_message, $headers);
            //debut du captcha
            $secret = "6LcnxJ4UAAAAADGg4cEkIJPuh6udXv-ygDw-hjQX";
            $response = isset($_POST['g-recaptcha-response']);
            $remoteip = $_SERVER['REMOTE_ADDR'];

            $api_url = "https://www.google.com/recaptcha/api/siteverify?secret="
                . $secret
                . "&response=" . $response
                . "&remoteip=" . $remoteip ;

            $decode = json_decode(file_get_contents($api_url), true);

            if ($decode['success'] == true) {
                // C'est un humain
                echo "le message à été envoyé";
                echo '<style>#test { color: lime;
                                             background:transparent;
                                             border: none;
                                           }
                              </style>';
            }
            else {
                // C'est un robot ou le code de vérification est incorrecte

            }
            echo "Erreur concernant le code de vérification";
            echo '<style>#test { color: red;
                                            background:transparent;
                                            border: none;
                                          }
                             </style>';
        }
    }
}
