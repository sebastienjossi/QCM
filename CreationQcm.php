<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>QCM</title>

        <!-- Bootstrap Core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Theme CSS -->
        <link href="css/freelancer.min.css" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

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
                <input class="btn btn-default" type="submit" value="Ajouter une question" onclick="addQuestion()">
                <br>
                <input class="btn btn-default" type="submit" value="Créer le QCM" onclick="insert()">
            </div>

        </section>
        <?php include 'footer.html'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
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
                        var nameQcm = $("#nameQcm").val();
                        var questions = [];                       
                        var answers = [];
                        for (i = 1; i <= nbQuestion; i++) {
                            questions.push($("#question" + i + "").val());
                            var nbAnswerInQuestion = $("#formulaireReponse" + i + "").find($("label")).length - 1;
                            for (x = 1; x <= nbAnswerInQuestion; x++) {
                                var texteReponse = ($("#textAnswer" + i + "" + x + "").val());
                                var RightAnswer = $("#rightAnswer" + i + "" + x + ":checked").val();
                                var answer = {numQuestion:i, rightAnswer:RightAnswer, textAnswer:texteReponse};
                                answers.push(answer);
                            }
                        }  
                        $.ajax({
                            method: 'POST',
                            url: 'controleur.php',
                            data: {'nameQcm': nameQcm, 'questions': questions, 'answers': answers},
                            dataType: 'json',
                            success: function (data) {
                                if (data.status === "success") {
                                    window.location.href = "http://stackoverflow.com";
                                }
                                if (data.status === "error") {
                                    window.location.href = "http://ok.com";
                                }
                            },
                            error: function (jqXHR) {
                                $('#userSection').html(jqXHR.toString());
                            }
                        });
                    }
        </script>
    </body>
</html>
