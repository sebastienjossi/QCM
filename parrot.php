<!--
        Florent Jaquerod
        IFA-P3C
        2017
       Verification des données reçue par le formulaire 
-->
<?php
    session_start();
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd2 = filter_input(INPUT_POST, 'pwd2', FILTER_SANITIZE_SPECIAL_CHARS);

    $passwordH = password_hash($pwd, PASSWORD_DEFAULT);
    $erreur = array();
    
    // Gère les erreurs
    if (filter_has_var(INPUT_POST, "submit")) {
        if (empty($email)) 
            $erreur['email'] = "L'email ne peut pas être vide";

        if (empty($name)) 
            $erreur['name'] = "Le nom ne peut pas être vide";

        if (empty($fname)) 
            $erreur['fname'] = "Le prenom ne peut pas être vide";

        if (empty($pwd)) 
            $erreur['pwd'] = "Le mot de passe est vide ";
        elseif ($pwd != $pwd2) 
            $erreur['pwd'] = "Les mots de passe ne sont pas les même ";

        // Si il n'y a pas d'erreur le formulaire envoie les données à la base
        if (empty($erreur)) {
            require_once("qcmDao.inc.php");
            UserDao::InsertUser($name, $fname, $email, $passwordH);
            header("location: index.php");
        }
    }
        
        
        
        
      
       
        
 
