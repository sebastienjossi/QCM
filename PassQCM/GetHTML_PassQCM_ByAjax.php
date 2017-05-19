<?php
/*Durrenmatt Cédric*/
require_once 'qcm.controller.php';

$action = $_POST['action'];
if (strtolower($action) === "getmaxquestion") {
    GetMaxQuestion();
} else {
    GetInfos();
}

function GetMaxQuestion() {
    $idQCM = $_POST['idQ'];

    $qcm = QcmController::GetQcmController($idQCM);
    echo $qcm->MaxQuestion();
}

function GetInfos() {
    $idQCM = $_POST['idQ'];
    $numQuestion = $_POST['numQ'];

    $qcm = QcmController::GetQcmController($idQCM);
    echo $qcm->GetHTMLCode($numQuestion);
}
