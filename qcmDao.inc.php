<?php

require_once 'config.inc.php';

class QcmPdo{
    private static $dbPdo = NULL;

    public static function GetPdo(){
        try {
            if (!isset($dbPdo)) {
                $dbc = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME , DB_USER, DB_PWD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_PERSISTENT => true));
            }
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }
        return $dbc;
    }
}

class UserDao{
    public static function GetUsers(){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetUserById($idUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetUserByEmail($emailUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE email = :email";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':email', $emailUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertUser($idUser, $name, $firstName, $email, $password, $idRole){
        $req = "INSERT INTO user(id_user, name, first_name, email, password, id_role) VALUES (:id_user,:name,:first_name, :email,:password,:id_role)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_user', $idUser);   
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':firstName', $firstName);  
        $sql->bindParam(':email', $email);  
        $sql->bindParam(':password', $password);  
        $sql->bindParam(':idRole', $idRole);  
        $sql->execute();
    } 

    public static function GetRoles(){
        $req = "SELECT id_role, name FROM role";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetRoleById($idRole){
        $req = "SELECT id_role, name FROM role WHERE id_role = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idRole);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function GetQcmByIdUser($idUser){
        $req = "SELECT qcm.id_qcm, qcm.name, qcm.creation_date FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetAnswerById($idUser, $idQcm, $idQuestion){
        $req = "SELECT answer.id_answer, answer.answer, answer.right_answer, answer.id_question FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :idUser AND qcm.id_qcm = :idQcm AND question.id_question = :idQuestion";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idQcm', $idQcm);   
        $sql->bindParam(':idQuestion', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function UserHasAnswer($idUser, $idAnswer){
        $req = "INSERT INTO user_has_answer(id_user, id_answer) VALUES (:id_user, :id_answer)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idAnswer', $idAnswer);   
        $sql->execute();
    }
}

class QcmDao{
    public static function GetQcms(){
        $req = "SELECT id_qcm, name, creation_date FROM qcm";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetQcmById($idQcm){
        $req = "SELECT id_qcm, name, creation_date FROM qcm WHERE id_qcm = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetQcmByIdCreator($idUser){
        $req = "SELECT qcm.* FROM qcm JOIN evaluation ON evaluation.id_qcm = qcm.id_qcm JOIN user ON user.id_user = evaluation.id_creator WHERE user.id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function InsertQcm($idQcm, $name){
        $req = "INSERT INTO qcm(id_qcm, name, creation_date) VALUES (:id_qcm,:name, NOW())";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_qcm', $idQcm);   
        $sql->bindParam(':name', $name);
        $sql->execute();
    } 

    public static function GetQuestions(){
        $req = "SELECT id_question, question, id_qcm FROM question";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetQuestionById($idQuestion){
        $req = "SELECT id_question, question, id_qcm FROM question WHERE id_question = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idAnswer);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertQuestion($idQuestion, $question, $idQcm){
        $req = "INSERT INTO question(id_question, question, id_qcm) VALUES (:id_question, :question, :id_qcm)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_question', $idQuestion);   
        $sql->bindParam(':question', $question);  
        $sql->bindParam(':id_qcm', $idQcm); 
        $sql->execute();
    }

    public static function GetQuestionsByIdQcm($idQcm){
        $req = "SELECT id_question, question, id_qcm FROM question JOIN qcm WHERE id_Qcm = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetAnswers(){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetAnswerById($idAnswer){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHERE id_answer = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idAnswer);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertAnswer($idAnswer, $answer, $right_answer, $idQuestion){
        $req = "INSERT INTO answer(id_answer, answer, right_answer, id_question) VALUES (:id_answer,:answer,:right_answer,:id_question)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_answer', $idAnswer);   
        $sql->bindParam(':answer', $answer);  
        $sql->bindParam(':right_answer', $right_answer);  
        $sql->bindParam(':id_question', $idQuestion);  
        $sql->execute();
    } 

    public static function GetAnswersByIdQuestion($idQuestion){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHEREid_question = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

class EvaluationDao{
    public static function GetEvaluations(){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetEvaluationById($idEvaluation){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE id_evaluation = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetEvaluationByAccessCode($accessCode){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE access_code = :code";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':code', $accessCode);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function GetQcmByEvaluation($idEvaluation){
        $req = "SELECT qcm.id_qcm, qcm.name, qcm.creation_date FROM evaluation JOIN qcm ON qcm.id_qcm = evaluation.id_qcm WHERE evaluation.id_evaluation = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertEvaluation($idEvaluation, $name, $accessCode, $idQcm, $idCreator){
        $req = "INSERT INTO evaluation(id_evaluation, name, access_code, id_qcm, id_creator) VALUES (:id_evaluation,:name,:access_code,:id_qcm,:id_creator)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_evaluation', $idEvaluation);   
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':access_code', $accessCode);  
        $sql->bindParam(':id_qcm', $idQcm);  
        $sql->bindParam(':id_creator', $idCreator);  
        $sql->execute();
    } 

    public static function AddUserInEvalutionByCode($idUser, $code){
        $req = 'INSERT INTO evaluation_has_user(id_user, id_evaluation) VALUES (1, (SELECT IdEvaluation FROM evaluation WHERE access_code = :code))';
    }

    public static function EvaluationHasUser($idEvaluation, $idUser){
        $req = "INSERT INTO user_has_answer(id_user, id_answer) VALUES (:id_evaluation, :id_user)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idEvaluation', $idEvaluation);  
        $sql->bindParam(':idUser', $idUser);    
        $sql->execute();
    }
}

