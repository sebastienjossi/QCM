<?php

$idQCM = filter_input(INPUT_GET, 'idQ', FILTER_SANITIZE_NUMBER_INT); //id du QCM
$numQuestion = filter_input(INPUT_GET, 'numQ', FILTER_SANITIZE_NUMBER_INT); //num de la question dans le QCM

if (!isset($idQCM) || $idQCM == null) {
    header("Location: BACK.php"); //Renvoyer à la page de sélection de QCM
    exit();
}

if (!isset($numQuestion) || $numQuestion == null) {
    header("Location: index.php?&&idQ=" . $idQCM . "&&numQ=1");
    exit();
}
require_once './qcmDao.inc.php';
$nomQCM = QcmDao::GetQcmById($idQCM)[0]['name'];
if (!isset($nomQCM)) {
    header("Location: BACK.php"); //Renvoyer à la page de sélection de QCM
    exit();
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Vous faites le QCM "<?php echo $nomQCM; ?>"</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div id="content">
            <header><?php echo "Question No" . $numQuestion; ?></header>
            <div id="question">Question: <?php echo QcmDao::GetQuestionsByIdQcm($idQCM)[0]['question']; ?></div>
            <div class="reponses">bla</div>
            <div class="reponses">bla</div>
            <div class="reponses">bla</div>
            <nav id="navPassQCM"><div id="back">Précédent</div><div id="next">Suivant</div></nav>  
        </div>
    </body>
</html>
