<?php
/*
Auteurs: Sven Wikberg et Seb Mata
3 objets PHP et ensembles des fonctions pour intéragire avec la base de données
*/
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
	//READ la table user  (retourne toutes les données de tout les utilisateurs)
    public static function GetUsers(){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

	//READ la table user pour un utilisateur à partir de son id (retourne toutes les données de cet utilisateur)
    public static function GetUserById($idUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

	//READ la table user pour un utilisateur en fonction d'un email donné (retourne toutes les données de cet utilisateur)
    public static function GetUserByEmail($emailUser){
        $req = "SELECT id_user, name, first_name, email, password, id_role FROM user WHERE email = :email";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':email', $emailUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  
	//INSERT un utilisateur dans la table user (avec un nom, un prénom, un email, un mot de passe, et un id de role)
    public static function InsertUser($name, $firstName, $email, $password, $idRole){
        $req = "INSERT INTO user(name, first_name, email, password, id_role) VALUES (:name,:first_name, :email,:password,:id_role)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':firstName', $firstName);  
        $sql->bindParam(':email', $email);  
        $sql->bindParam(':password', $password);  
        $sql->bindParam(':idRole', $idRole);  
        $sql->execute();
    } 
	//READ de la table Role (retourne tout les roles)
    public static function GetRoles(){
        $req = "SELECT id_role, name FROM role";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    
	//READ de la table role en fonction d'un id donné (retourne le nom du role)
    public static function GetRoleById($idRole){
        $req = "SELECT id_role, name FROM role WHERE id_role = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idRole);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 
	//READ de la table qcm en fonction d'un utilisateur (retourne les données de la table qcm)
    public static function GetQcmByIdUser($idUser){
        $req = "SELECT DISTINCT qcm.id_qcm, qcm.name, qcm.creation_date FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  
	//READ de la table answer en fonction en fonction d'un id d'utilisateur, d'un id de qcm et d'un id de question (retourne la réponse d'un utilisateur à une question d'un qcm)
    public static function GetAnswerFromUserById($idUser, $idQcm, $idQuestion){
        $req = "SELECT answer.id_answer, answer.answer, answer.right_answer, answer.id_question FROM user JOIN user_has_answer ON user_has_answer.id_user = user.id_user JOIN answer ON answer.id_answer = user_has_answer.id_answer JOIN question ON question.id_question = answer.id_question JOIN qcm ON qcm.id_qcm = question.id_qcm WHERE user.id_user = :idUser AND qcm.id_qcm = :idQcm AND question.id_question = :idQuestion";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idQcm', $idQcm);   
        $sql->bindParam(':idQuestion', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

	//INSERT une liaison dans la table user_has_answer
    public static function UserHasAnswer($idUser, $idAnswer){
        $req = "INSERT INTO user_has_answer(id_user, id_answer) VALUES (:id_user, :id_answer)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->bindParam(':idAnswer', $idAnswer);   
        $sql->execute();
    }
}

class QcmDao{
	//READ de la table qcm (retourne l'id, le nom, et la date de création)
    public static function GetQcms(){
        $req = "SELECT id_qcm, name, creation_date FROM qcm";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }    

	//Read de la table qcm en fonction de l'id d'un qcm (retourne l'id le nom et la date de création d'un qcm)
    public static function GetQcmById($idQcm){
        $req = "SELECT id_qcm, name, creation_date FROM qcm WHERE id_qcm = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC)[0];
    }  

	//Read de la table qcm en fonction de l'id du créateur (retourne tout les qcms créés par un même utilisateur)
    public static function GetQcmByIdCreator($idUser){
        $req = "SELECT qcm.* FROM qcm JOIN evaluation ON evaluation.id_qcm = qcm.id_qcm JOIN user ON user.id_user = evaluation.id_creator WHERE user.id_user = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idUser);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
	
	//Supprime le qcm correspondant à l'id donné (gère également la suppression des questions du qcm et des réponses des questions)
    public static function DeleteQcmByIdQcm($idQcm){
        QcmPdo::GetPdo()->beginTransaction();
        $req = "DELETE user_has_answer FROM qcm JOIN question ON qcm.id_qcm = question.id_qcm JOIN answer ON question.id_question = answer.id_question JOIN user_has_answer ON answer.id_answer = user_has_answer.id_answer WHERE qcm.id_qcm = :id";
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        $req = "DELETE answer FROM qcm JOIN question ON qcm.id_qcm = question.id_qcm JOIN answer ON question.id_question = answer.id_question WHERE qcm.id_qcm = :id";
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        $req = "DELETE question FROM qcm JOIN question ON qcm.id_qcm = question.id_qcm WHERE qcm.id_qcm = :id";
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();
        
        QcmPdo::GetPdo()->commit();
    }

	//Insert un qcm qui a un nom dans la table qcm
    public static function InsertQcm($idQcm, $name){
        $req = "INSERT INTO qcm(id_qcm, name, creation_date) VALUES (:id_qcm,:name, NOW())";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id_qcm', $idQcm);   
        $sql->bindParam(':name', $name);
        $sql->execute();
    } 

	//Read de la table question (retourne l'id, la question et l'id du qcm contenant la question)
    public static function GetQuestions(){
        $req = "SELECT id_question, question, id_qcm FROM question";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

	//Read de la table question en fonction d'un id de question (retourne la question correspondant à l'id donné)
    public static function GetQuestionById($idQuestion){
        $req = "SELECT id_question, question, id_qcm FROM question WHERE id_question = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

	//Insert d'une question avec la question et le qcm la contenant
    public static function InsertQuestion($question, $idQcm){
        $req = "INSERT INTO question(question, id_qcm) VALUES (:question, :id_qcm)";
        $sql = QcmPdo::GetPdo()->prepare($req);  
        $sql->bindParam(':question', $question);  
        $sql->bindParam(':id_qcm', $idQcm); 
        $sql->execute();
    }

	//Read de question en fonction de l'id du qcm la contenant (retourne l'id , la question, l'id du qcm
    public static function GetQuestionsByIdQcm($idQcm){
        $req = "SELECT question.id_question, question.question, question.id_qcm FROM question WHERE question.id_qcm = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

	//Read de la table answers (retourne l'id, la réponse, le booléen indiquant si la réponse est juste ou fausse, l'id de la question correspondante)
    public static function GetAnswers(){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

	//Read de la table réponse en fonction d'un Id (retourne l'id, la réponse, le booéen indiquant si la réponse est juste ou fausse et l'id de la question correspondante)
    public static function GetAnswerById($idAnswer){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHERE id_answer = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idAnswer);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

	//Insert une réponse
    public static function InsertAnswer($answer, $right_answer, $idQuestion){
        $req = "INSERT INTO answer(answer, right_answer, id_question) VALUES (:answer,:right_answer,:id_question)";
        $sql = QcmPdo::GetPdo()->prepare($req);   
        $sql->bindParam(':answer', $answer);  
        $sql->bindParam(':right_answer', $right_answer);  
        $sql->bindParam(':id_question', $idQuestion);  
        $sql->execute();
    } 

	//Read une réponse en fonction de l'id de la question correspondante (retourne l'id, la réponse, le booléen et l'id de la question)
    public static function GetAnswersByIdQuestion($idQuestion){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHERE id_question = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
	
	//Read la bonne réponse en fonction de l'id de la question correspondante (retourne l'id, la réponse, le booléen et l'id de la question)
	 public static function GetRightAnswerByIdQuestion($idQuestion){
        $req = "SELECT id_answer, answer, right_answer, id_question FROM answer WHERE id_question = :id AND right_answer = 1";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQuestion);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }
}

class EvaluationDao{
	//Read de la table evaluation (retourne l'id, le nom, le code d'accès, l'id du qcm correspondant et l'id du créateur (de chaque évaluation)
    public static function GetEvaluations(){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation";
        $sql = QcmPdo::GetPdo()->prepare($req);
        $sql -> execute();

        return $sql->fetchALL(PDO::FETCH_ASSOC);
    }

	//Read de la table evaluation en fonction d'un id (retourne toutes les données d'une évaluation correspondant à l'id)
    public static function GetEvaluationById($idEvaluation){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE id_evaluation = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  
	
	//Read de la table evaluation en fonction d'un id de qcm (retourne toutes les données d'une évaluation correspondant à l'id du qcm)
    public static function GetEvaluationByIdQcm($idQcm){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE id_qcm = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idQcm);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

	//Read de la table evaluation en fonction du code d'accès (retourne toutes les données de l'évaluation correspondant au code d'accès)
    public static function GetEvaluationByAccessCode($accessCode){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation WHERE access_code = :code";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':code', $accessCode);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 
	
	//Read de la table evaluation en fonction de l'id d'un utilisateur (retourne toutes les données de l'évaluation correspondant à l'id utilisateur)
	public static function GetEvaluationByIduser($idUser){
        $req = "SELECT id_evaluation, name, access_code, id_qcm, id_creator FROM evaluation JOIN evaluation_has_user USING(id_evaluation) WHERE id_user = :idUser";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idUser', $idUser);   
        $sql->execute();
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    } 

	//Read de la table qcm en fonction d'une evaluation (retourne le qcm correspondant à l'évaluation)
    public static function GetQcmByEvaluation($idEvaluation){
        $req = "SELECT qcm.id_qcm, qcm.name, qcm.creation_date FROM evaluation JOIN qcm ON qcm.id_qcm = evaluation.id_qcm WHERE evaluation.id_evaluation = :id";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':id', $idEvaluation);   
        $sql->execute();

        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }  

	//Insert d'une evaluation avec un nom, un code d'accès, un id de qcm et un id de créateur
    public static function InsertEvaluation($name, $accessCode, $idQcm, $idCreator){
        $req = "INSERT INTO evaluation(name, access_code, id_qcm, id_creator) VALUES (:name,:access_code,:id_qcm,:id_creator)";
        $sql = QcmPdo::GetPdo()->prepare($req);  
        $sql->bindParam(':name', $name);  
        $sql->bindParam(':access_code', $accessCode);  
        $sql->bindParam(':id_qcm', $idQcm);  
        $sql->bindParam(':id_creator', $idCreator);  
        $sql->execute();
    } 

	//Insert un utilisateur dans une evaluation via son code d'accès !!! A VERIFIER !!!
    public static function AddUserInEvalutionByCode($idUser, $code){
        $req = 'INSERT INTO evaluation_has_user(id_user, id_evaluation) VALUES (:idUser, (SELECT IdEvaluation FROM evaluation WHERE access_code = :code))';
		$sql->bindParam(':idUser', $idUser);
		$sql->bindParam(':code', $code);  		 
    }

	//Insert dans la table de liaison entre les évaluations et les utilisateurs
    public static function evaluationHasUser($idEvaluation, $idUser){
        $req = "INSERT INTO evaluation_has_user(id_user, id_evaluation) VALUES (:id_user, :id_evaluation¨)";
        $sql = QcmPdo::GetPdo()->prepare($req); 
        $sql->bindParam(':idEvaluation', $idEvaluation);  
        $sql->bindParam(':idUser', $idUser);    
        $sql->execute();
    }
}

