<!-- 
 Nom : Pierrick et Christophe
 Date : 17.03.2017
 Descritpion : Affichage d'un QCM passé par un utilisateur avec les réponses justes ou fausses
 -->
<?php
include_once("qcmDao.inc.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Freelancer - Start Bootstrap Theme</title>
        
        <!-- Bootstrap Core CSS -->
        <link href="Template QCM/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="Template QCM/css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="Template QCM/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="Template QCM/css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include 'header.html'; ?>
        <section>
            <?php foreach (QcmDao::GetQuestionsByIdQcm($_GET['id']) as $question) { ?>

                <div id="div">

                    <label>Question : <?php echo $question['question']; ?></label>
                    <?php
                    foreach (QcmDao::GetAnswersByIdQuestion($question['id_question']) as $answer) {

                        foreach (QcmDao::GetRightAnswerByIdQuestion($question['id_question']) as $rightAnswer) {

                            $ansUser = UserDao::GetAnswerFromUserById(2, $_GET['id'], $question['id_question']);

                            if (empty($ansUser)) {

                                if ($answer['id_answer'] != $rightAnswer['id_answer']) {
                                    ?>
                                    <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"><br>  
                                    <?php
                                } else {
                                    ?>
                                    <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"style="background-color: #33cc33; color: white;"><br>
                                    <?php
                                }
                            }

                            foreach (UserDao::GetAnswerFromUserById(2, $_GET['id'], $question['id_question']) as $answerUser) {

                                if ($rightAnswer['id_answer'] != $answer['id_answer']) {

                                    if ($answer['id_answer'] != $answerUser['id_answer']) {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"><br>  
                                        <?php
                                    }
                                } else {
                                    if ($rightAnswer['id_answer'] != $answerUser['id_answer']) {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"style="background-color: #33cc33; color: white;"><br>

                                        <?php
                                    }
                                    if ($rightAnswer['id_answer'] == $answerUser['id_answer']) {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answerUser['answer']; ?>" style="background-color: #8cff66;"><br>  
                                        <?php
                                    } else {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answerUser['answer']; ?>" style="background-color: #e60000; color: white;"><br>  
                                        <?php
                                    }
                                }
                            }
                        }
                    }
                    ?>
                    <br>
                </div>
            <?php } ?>
        </section>
        <?php include 'footer.html'; ?>
    </body>
</html>
