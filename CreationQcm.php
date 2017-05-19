<!-- 
Author : Loick Pipolo, Ivan Trifunovic
Last modify on : 19.05.2017
Goal : Qcm creation interface, send the data to controleur.php in ajax
Status : Finished 
-->


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

        <!-- Custion CSS -->
        <link rel="stylesheet" href="TemplateQCM/css/style.css" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php include 'header.html'; ?>
        <section id="QCM">
            <div id="formulaireQcm" class="createQcm-qcm">
                <label>Nom QCM :</label>
                <input class="form-control" type="text" name="nameQcm" id="nameQcm"><br>
            </div>
            <div class="createQcm-qcm">
                <input class="btn btn-primary" type="submit" value="Ajouter une question" onclick="addQuestion()">
                <br>
                <input class="btn btn-primary" style="float: right;" type="submit" value="Créer le QCM" onclick="insert()">
            </div>
        </section>
        <?php include 'footer.html'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
                    $(document).ready(function () {
                        var hauteur_fenetre = $(window).height();
                        var hauteur_footer = $('footer').height();
                        var obj = document.getElementById('QCM');
                        obj.style.minHeight = hauteur_fenetre - hauteur_footer + "px";
                    });

                    var nbQuestion = 0;
                    function addQuestion() {
                        nbQuestion = nbQuestion + 1;
                        $("#formulaireQcm").append('<div id="formulaireReponse' + nbQuestion + '" class="createQcm-question"><label>Question ' + nbQuestion + ' :</label><input class="form-control" type="text" name="question" id="question' + nbQuestion + '"><input class="btn btn-default" type="submit" value="Ajouter une réponse" onclick="addAnswer(' + nbQuestion + ')"><br><div id="btnRemoveQuestion' + nbQuestion + '"><a onclick="removeQuestion(' + nbQuestion + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div></div>');
                        var numBtnHide = nbQuestion - 1;
                        $("#formulaireQcm").find(("#btnRemoveQuestion" + numBtnHide + "")).hide();
                    }

                    function removeQuestion(numQuestion) {
                        nbQuestion = nbQuestion - 1;
                        $("#formulaireQcm").find(("#formulaireReponse" + numQuestion + "")).remove();
                        var btnRemoveShow = numQuestion - 1;
                        $("#formulaireQcm").find(("#btnRemoveQuestion" + btnRemoveShow + "")).show();
                    }

                    function addAnswer(numQuestion) {
                        var nbAnswer = $("#formulaireReponse" + numQuestion + "").find($("label")).length;
                        $("#formulaireReponse" + numQuestion + "").append('<div id="answer' + nbAnswer + '" class="createQcm-answer"><label>Réponse ' + nbAnswer + ' :</label><input class="form-control" type="text" id="textAnswer' + numQuestion + '' + nbAnswer + '"><input type="radio" value="juste" name="rightAnswer' + numQuestion + '' + nbAnswer + '" id="rightAnswer' + numQuestion + '' + nbAnswer + '">Juste<br><input type="radio" value="faux" name="rightAnswer' + numQuestion + '' + nbAnswer + '" id="rightAnswer' + numQuestion + '' + nbAnswer + '" checked>Faux<div id="btnRemove' + nbAnswer + '"><a onclick="removeAnswer(' + nbAnswer + ', ' + numQuestion + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div></div>');
                        var btnRemoveHide = nbAnswer - 1;
                        $("#formulaireReponse" + numQuestion + "").find(("#btnRemove" + btnRemoveHide + "")).hide();
                    }

                    function removeAnswer(numAnswer, numFormRep) {
                        $("#formulaireReponse" + numFormRep + "").find(("#answer" + numAnswer + "")).remove();
                        var btnRemoveShow = numAnswer - 1;
                        $("#formulaireReponse" + numFormRep + "").find(("#btnRemove" + btnRemoveShow + "")).show();
                    }

                    function insert() {
                        var champsOk = true;
                        var nameQcm = $("#nameQcm").val();
                        var questions = [];
                        var answers = [];
                        for (i = 1; i <= nbQuestion; i++) {
                            var question = $("#question" + i + "").val()
                            questions.push(question);
                            if (question === "") {
                                champsOk = false;
                            }
                            var nbAnswerInQuestion = $("#formulaireReponse" + i + "").find($("label")).length - 1;
                            for (x = 1; x <= nbAnswerInQuestion; x++) {
                                var texteReponse = ($("#textAnswer" + i + "" + x + "").val());
                                if (texteReponse === "") {
                                    champsOk = false;
                                }
                                var RightAnswer = $("#rightAnswer" + i + "" + x + ":checked").val();
                                var RightAnswerBool = 0;
                                if (RightAnswer === "juste") {
                                    RightAnswerBool = 1;
                                }
                                var answer = {numQuestion: i, RightAnswerBool: RightAnswerBool, textAnswer: texteReponse};
                                answers.push(answer);
                            }
                        }
                        if (champsOk === true) {
                            $.ajax({
                                method: 'POST',
                                url: 'controleur.php',
                                data: {'nameQcm': nameQcm, 'questions': questions, 'answers': answers},
                                dataType: 'json',
                                success: function (data) {
                                    if (data.status === "success") {
                                        window.location.href = "CreationQcm.php";
                                    }
                                    if (data.status === "error") {
                                        error();
                                    }
                                },
                                error: function () {
                                    error();
                                }
                            });
                        } else {
                            error();
                        }
                    }

                    function error() {
                        alert("Veuillez renseigner tous les champs.");
                    }
        </script>
        </script>
    </body>
</html>
