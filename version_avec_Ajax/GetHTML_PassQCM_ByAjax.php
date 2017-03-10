<?php

require_once 'qcm.controller.php';

$idQCM = $_POST['idQ'];
$numQuestion = $_POST['numQ'];

$qcm = new QcmController($idQCM);

if ($numQuestion > $qcm->MaxQuestion($numQuestion)) {
    echo "C'est terminé !";
} else {
    echo $qcm->GetHTMLCode($numQuestion);
}