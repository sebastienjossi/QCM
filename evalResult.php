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
        <link href="TemplateQCM/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="TemplateQCM/css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="Template QCM/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="TemplateQCM/css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php 
            session_start();
            include 'header.html'; 
        ?>
        <section>
            <?php foreach (QcmDao::GetQuestionsByIdQcm($_GET['idQcm']) as $question) { ?>
            
                <div class="container" >
                    <div id="div" class="col-xs-6 col-sm-6 col-md-8">
                        <label>Question : <?php echo $question['question']; ?></label>
                        <?php
                        foreach (QcmDao::GetAnswersByIdQuestion($question['id_question']) as $answer) {

                            if(isset($_GET['idUser']))
                                $ansU = UserDao::GetAnswerFromUserById($_GET['idUser'], $_GET['idQcm'], $question['id_question']);
                            else
                                $ansU = UserDao::GetAnswerFromUserById($_SESSION['IdUser'], $_GET['idQcm'], $question['id_question']);

                            // Si l'utilisateur n'a pas répondu
                            if (empty($ansU)) {
                                //Est-ce que cette réponse est juste
                                if ($answer['right_answer'] == true) {
                                    ?>
                                    <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"style="background-color: #8cff66; border: solid 3px red;"><br>
                                    <?php
                                } else {
                                    ?>
                                    <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"><br>  
                                    <?php
                                }
                            }
                            foreach ($ansU as $answerUser) {

                                //Est-ce que l'utilisateur a mis cette réponse ?
                                if ($answer['id_answer'] == $answerUser['id_answer']) {

                                    //Est-ce que cette réponse est juste
                                    if ($answer['right_answer'] == true) {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>" style="background-color: #8cff66;"><br>  
                                        <?php
                                    } else {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>" style="background-color: #e60000; color: white;"><br>  
                                        <?php
                                    }
                                } else {
                                    //Est-ce que cette réponse est juste
                                    if ($answer['right_answer'] == true) {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"style="border: solid 3px #8cff66;"><br>
                                        <?php
                                    } else {
                                        ?>
                                        <input id="answerQCM" class="form-control" type="text" name="nameQcm" readonly value="<?php echo $answer['answer']; ?>"><br>  
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                        <br>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-4">
                        <div class="intro-text">
                            <div id="piechart" style="width: 150%; height: 150%;"></div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages': ['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {
                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Nombre'],
                            ['Juste', 11],
                            ['Fausse', 7]
                        ]);

                        var options = {
                            title: 'Pourcentage questions'
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                </script>
            <?php } ?>
        </section>
        <?php include 'footer.html'; ?>
    </body>
</html>