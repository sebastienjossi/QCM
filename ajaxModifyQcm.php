<?php
    /*
    Auteur : Ricardo
    Utilité : Modifie le QCM donné en le supprimant puis en le réécrivant.
    */

    require_once('qcmDao.inc.php');

    $qcmName = $_POST['nameQcm'];
    $questions = $_POST['questions'];
    $answers = $_POST['answers'];
    $idQcm = $_POST['idQcm'];
    print_r($_POST);

    if (isset($qcmName) && isset($answers) && isset($questions)) {
        $response_array['status'] = 'success';
        QcmDao::ModifyQcmName($idQcm, $qcmName);            // Modifie le nom du QCM (s'il a été changé.)
        print_r(QcmDao::DeleteQuestionsFromQCM($idQcm));    // Supprime les questions du QCM. (Ainsi que leur réponses)

        $questionNum = 0;
        foreach ($questions as $question) {
            $questionNum++;
            QcmDao::InsertQuestion($question, $idQcm);      // Ajoute une question
            $lastIDQuestion = QcmPdo::GetPdo()->lastInsertId();
            foreach ($answers as $answer){                  // Ajoute toutes les réponses en lien avec la dernière question ajoutée.
                if ($questionNum == $answer['questionNum']) {
                    QcmDao::InsertAnswer($answer['textAnswer'], $answer['rightAnswer'], $lastIDQuestion);
                }
            }
        }
    } else {
    $response_array['status'] = 'error';
    }
    echo json_encode($response_array);
?>