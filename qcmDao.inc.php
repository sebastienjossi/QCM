<?php

require_once 'config.inc.php';

class QcmPdo{
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_pwd;

    public function Construct($db_host, $db_name, $db_user, $db_pwd){
        $this->db_host = $db_host;
        $this->db_name = $db_name;
        $this->db_user = $db_user;
        $this->db_pwd = $db_pwd;
    }

    public function GetPdo(){
        $dbc = NULL;
        try {
            if ($dbc == NULL) {
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
    public static function GetUsers($qcmDao){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetUserById($qcmDao, $idUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE id_user = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetUserByEmail($qcmDao, $emailUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE email = :email";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':email', $emailUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertUser($qcmDao, $idUser, $name, $firstName, $email, $password, $idRole){
        $req = "INSERT INTO user(id_user, name, first_name, email, password, id_role) VALUES (:id_user,:name,:first_name, :email,:password,:id_role)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id_user', $idUser);   
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':firstName', $firstName);  
        $sql->bindParam(':email', $email);  
        $sql->bindParam(':password', $password);  
        $sql->bindParam(':idRole', $idRole);  
        $sql->execute();
    } 

    public static function GetRoles($qcmDao){
        $req = "SELECT id_role, name FROM role";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetRoleById($qcmDao, $idRole){
        $req = "SELECT id_role, name FROM role WHERE id_role = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idRole);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function GetQcmByIdUser($qcmDao, $idUser){
        $req = "SELECT qcm.id_qcm, qcm.name, qcm.creation_date FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetAnswerById($qcmDao, $idUser, $idQcm, $idQuestion){
        $req = "SELECT answer.id_answer, answer.answer, answer.right_answer, answer.id_question FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :idUser AND qcm.id_qcm = :idQcm AND question.id_question = :idQuestion";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idQcm', $idQcm);   
        $sql->bindParam(':idQuestion', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function UserHasAnswer($idUser, $idAnswer){
        $req = "INSERT INTO user_has_answer(id_user, id_answer) VALUES (:id_user, :id_answer)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idAnswer', $idAnswer);   
        $sql->execute();
    }
}

class QcmDao{
    public static function GetQcms($qcmDao){
        $req = "SELECT id_qcm, name, creation_date FROM qcm";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

    public static function GetQcmById($qcmDao, $idQcm){
        $req = "SELECT id_qcm, name, creation_date FROM qcm WHERE id_qcm = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertQcm($qcmDao, $idQcm, $name, $creationDate){
        $req = "INSERT INTO qcm(id_qcm, name, creation_date) VALUES (:id_qcm,:name,:creation_date)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id_qcm', $idQcm);   
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':creation_date', $creationDate);  
        $sql->execute();
    } 

    public static function GetQuestions($qcmDao){
        $req = "SELECT id_question, question, id_qcm FROM question";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetQuestionById($qcmDao, $idQuestion){
        $req = "SELECT id_question, question, id_qcm FROM question WHERE id_question = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idAnswer);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertQuestion($qcmDao, $idQuestion, $question, $idQcm){
        $req = "INSERT INTO question(id_question, question, id_qcm) VALUES (:id_question, :question, :id_qcm)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id_question', $idQuestion);   
        $sql->bindParam(':question', $question);  
        $sql->bindParam(':id_qcm', $idQcm); 
        $sql->execute();
    }

    public static function GetQuestionsByIdQcm($qcmDao, $idQcm){
        $req = "SELECT id_question, question, id_qcm FROM question JOIN qcm WHERE id_Qcm = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcmr);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function GetAnswers($qcmDao){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetAnswerById($qcmDao, $idAnswer){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHERE id_answer = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idAnswer);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertAnswer($qcmDao, $idAnswer, $answer, $right_answer, $idQuestion){
        $req = "INSERT INTO answer(id_answer, answer, right_answer, id_question) VALUES (:id_answer,:answer,:right_answer,:id_question)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id_answer', $idAnswer);   
        $sql->bindParam(':answer', $answer);  
        $sql->bindParam(':right_answer', $right_answer);  
        $sql->bindParam(':id_question', $idQuestion);  
        $sql->execute();
    } 

    public static function GetAnswersByIdQuestion($qcmDao, $idQuestion){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHEREid_question = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

class EvaluationDao{
    public static function GetEvaluations($qcmDao){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation";
        $sql = $qcmDao->GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

    public static function GetEvaluationById($qcmDao, $idEvaluation){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE id_evaluation = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function GetEvaluationByAccessCode($qcmDao, $accessCode){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE access_code = :code";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':code', $accessCode);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

    public static function GetQcmByEvaluation($qcmDao, $idEvaluation){
        $req = "SELECT qcm.id_qcm, qcm.name, qcm.creation_date FROM evaluation JOIN qcm ON qcm.id_qcm = evaluation.id_qcm WHERE evaluation.id_evaluation = :id";
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

    public static function InsertEvaluation($qcmDao, $idEvaluation, $name, $accessCode, $idQcm, $idCreator){
        $req = "INSERT INTO evaluation(id_evaluation, name, access_code, id_qcm, id_creator) VALUES (:id_evaluation,:name,:access_code,:id_qcm,:id_creator)";
        $sql = $qcmDao->GetPdo()->prepare($req); 
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
        $sql = $qcmDao->GetPdo()->prepare($req); 
        $sql->bindParam(':idEvaluation', $idEvaluation);  
        $sql->bindParam(':idUser', $idUser);    
        $sql->execute();
    }
}

