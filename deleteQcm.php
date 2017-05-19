<?php
    /* 
    Autheur : Ricardo
    Fonctionnalité : Supprime un QCM. Si la suppression s'est bien passée, l'utilisateur retourne à la liste des QCM, sinon, un message d'erreur apparaît.
    */

    include_once("qcmDao.inc.php");
    $idQcm = $_GET['idQcm'];
    $deleteReturn = QcmDao::DeleteQcmWithEvaluationByIdQcm($idQcm);
    if($deleteReturn)
        header('Location: main.php');
    else
    {
        print_r($deleteReturn);
        exit();
    }
?>