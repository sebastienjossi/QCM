<?php
    /*Auteur : Ricardo
    Utilité : Renvoie toutes les réponses pour un QCM donné.*/

    require_once('qcmDao.inc.php');
    $idQuestion = $_POST['idQuestion'];
    echo json_encode(QcmDao::GetAnswersByIdQuestion($idQuestion));
?>