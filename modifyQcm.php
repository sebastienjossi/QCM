<!-- 
    Auteur : Ricardo
    Utilité : Permet de modifier un QCM donné.
    
    -->
<?php
    // Ajouté par Ricardo.
        include_once("qcmDao.inc.php");
    
        $qcm = QcmDao::GetQcmById($_GET['id']);
        $qcmQuestions = QcmDao::GetQuestionsByIdQcm($_GET['id']);
    
        //QcmDao::DeleteQcmByIdQcm(1);
    
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>QCM</title>
        <!-- Bootstrap Core CSS -->
        <link href="TemplateQCM/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Theme CSS -->
        <link href="TemplateQCM/css/freelancer.min.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="TemplateQCM/css/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            var nbQuestion = 0;
            // Reprit par Ricardo.
            function addQuestion(text) {
                if(text == undefined)
                    text = "";
            
                nbQuestion = nbQuestion + 1;
                $("#formulaireQcm").append('<div id="formulaireReponse' + nbQuestion + '" class="createQcm-question"><label>Question ' + nbQuestion + ' :</label><input class="form-control" type="text" name="question" id="question' + nbQuestion + '" value="' + text + '"><input class="btn btn-default" type="submit" value="Ajouter une réponse" onclick="addAnswer(' + nbQuestion + ')"><br><div id="btnRemoveQuestion' + nbQuestion + '"><a onclick="removeQuestion(' + nbQuestion + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div></div>');
                var numBtnHide = nbQuestion - 1;
                $("#formulaireQcm").find(("#btnRemoveQuestion" + numBtnHide + "")).hide();
            }
            
            // Reprit par Ricardo.
            function addAnswer(numQuestion, text, isCorrect) {
                if(text == undefined)
                    text = "";
            
                var nbAnswer = $("#formulaireReponse" + numQuestion + "").find($("label")).length;
                $("#formulaireReponse" + numQuestion + "").append('<div id="answer' + nbAnswer + '" class="createQcm-answer"><label>Réponse ' + nbAnswer + ' :</label><input class="form-control" type="text" id="textAnswer' + numQuestion + '' + nbAnswer + '" value="' + text + '"><input type="radio" value="juste" name="rightAnswer' + numQuestion + '' + nbAnswer + '" id="rightAnswer' + numQuestion + '' + nbAnswer + '"' + (isCorrect == 1 ? "checked" : "") + '>Juste<br><input type="radio" value="faux" name="rightAnswer' + numQuestion + '' + nbAnswer + '" id="rightAnswer' + numQuestion + '' + nbAnswer + '" ' + (isCorrect == 1 ? "" : "checked") + '>Faux<div id="btnRemove' + nbAnswer + '"><a onclick="removeAnswer(' + nbAnswer + ', ' + numQuestion + ')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div></div>');
                var btnRemoveHide = nbAnswer - 1;
                $("#formulaireReponse" + numQuestion + "").find(("#btnRemove" + btnRemoveHide + "")).hide();
            }
            
            function removeQuestion(numQuestion) {
                nbQuestion = nbQuestion - 1;
                $("#formulaireQcm").find(("#formulaireReponse" + numQuestion + "")).remove();
                var btnRemoveShow = numQuestion - 1;
                $("#formulaireQcm").find(("#btnRemoveQuestion" + btnRemoveShow + "")).show();
            }
            
            function removeAnswer(numAnswer, numFormRep) {
                $("#formulaireReponse" + numFormRep + "").find(("#answer" + numAnswer + "")).remove();
                var btnRemoveShow = numAnswer - 1;
                $("#formulaireReponse" + numFormRep + "").find(("#btnRemove" + btnRemoveShow + "")).show();
            }
            
            function findQcmId() {
               return location.search.split("=")[1];
            }
            
            function modify() {

                if(confirm("Voulez-vous vraiment modifer ce QCM ?\rLes évaluations seront désormais erronées.\rCette action est irréversible."))
                {
                    var nameQcm = $("#nameQcm").val();
                    var questions = [];                       
                    var answers = [];
                    for (i = 1; i <= nbQuestion; i++) {
                        if($("#question" + i + "").val() != '')
                        {
                            questions.push($("#question" + i + "").val());
                            var nbAnswerInQuestion = $("#formulaireReponse" + i + "").find($("label")).length - 1;
                            for (x = 1; x <= nbAnswerInQuestion; x++) {
                                var answerText = ($("#textAnswer" + i + "" + x + "").val());
                                var RightAnswer = document.getElementById("rightAnswer" + i + "" + x).checked
                                var answer = {questionNum:i, rightAnswer:RightAnswer ? 1 : 0, textAnswer:answerText};
                                answers.push(answer);
                            }
                        }
                    }  

                    if(questions.length == 0)
                        questions = null;
                    if(answers.length == 0)
                        answers = null;

                    $.ajax({
                        method: 'POST',
                        url: 'ajaxModifyQcm.php',
                        data: {'idQcm': findQcmId(), 'nameQcm': nameQcm, 'answers': answers, 'questions': questions},
                        dataType: 'html',
                        success: function (data) {
                            //alert(data);
                            document.location.href = "main.php";
                        },
                        error: function (jqXHR) {
                            alert(jqXHR.responseText);
                        }
                    });
                }
            }
        </script>
    </head>
    <body>
        <?php include 'header.html'; ?>
        <section id="QCM">
            <div id="formulaireQcm" class="createQcm-qcm">
                <label>Nom QCM :</label>
                <input class="form-control" type="text" name="nameQcm" id="nameQcm" value=<?php echo '"' . $qcm['name'] . '"'; ?>><br>
                <input class="btn btn-default" type="submit" value="Ajouter une question" onclick="addQuestion()">
                <br>
                <script>
                    // Ajouté par Ricardo.
                    var myJson = <?php echo json_encode($qcmQuestions); ?>;
                    //alert(findQcmId());
                    for(var i in myJson)
                    {
                        addQuestion(myJson[i]["question"]);
                        var answers = [];
                    
                        $.ajax(
                            {
                            method: 'POST',
                            dataType: 'json',
                            data: {'idQuestion': myJson[i]["id_question"]},
                            url: "ajaxAnswerByIdQuestion.php",
                            async: false,
                            success:function(data){
                                //alert("YES");
                                answers = data;
                            },
                            error: function (jqXHR) {
                                    alert(jqXHR.responseText);
                                }
                            });
                    
                        for(var j in answers)
                            addAnswer(nbQuestion, answers[j]["answer"], answers[j]["right_answer"]);
                    }
                </script>
                <input class="btn btn-default" type="submit" value="Modifier le QCM" onclick="modify()">
            </div>
        </section>
        <?php include 'footer.html'; ?>

        <!-- Create QCM button redirection -->
        <script>
            $("#creationButton").click(function(e){
                e.preventDefault();
                window.location = "/QCM/CreationQcm.php"; 
            });
        </script>
    </body>
</html>