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
            <div id="formulaireQuestion" class="createQcm-answer">
                <label>Nom QCM :</label>
                <input class="form-control" type="text" name="nameQcm"><br>
                <input class="btn btn-default" type="submit" value="Ajouter une question" onclick="addQuestion()">
                <br>
            </div>
            
<!--            <div id="formulaireReponse" class="createQcm-answer">
                <label>Question :</label>
                <input class="form-control" type="text" name="nameQcm"><br>
                <input class="btn btn-default" type="submit" value="Ajouter une réponse" onclick="addAnswer()">
                <br>
            </div>-->
        </section>
        <?php include 'footer.html'; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
                    function addQuestion(){
                        var nbQuestion = $("#QCM").find($("label")).length;
                        $("#QCM").append('<div id="formulaireReponse'+nbQuestion+'" class="createQcm-answer"><label>Question '+nbQuestion+' :</label><input class="form-control" type="text" name="nameQcm"><input class="btn btn-default" type="submit" value="Ajouter une réponse" onclick="addAnswer('+nbQuestion+')"><br></div>');
                    }
                    
                    function addAnswer(numFormRep) {
                        var nbAnswer = $("#formulaireReponse"+numFormRep+"").find($("input")).length-1;
                        $("#formulaireReponse"+numFormRep+"").append('<div id="answer' + nbAnswer + '"><label>Réponse ' + nbAnswer + ' :</label><input class="form-control" type="text" ><div id="btnRemove' + nbAnswer + '"><a onclick="removeAnswer(' + nbAnswer + ', '+numFormRep+')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div></div>');
                        var btnRemoveHide = nbAnswer-1;
                        $("#formulaireReponse"+numFormRep+"").find(("#btnRemove" + btnRemoveHide + "")).hide();
                    }
                    
                    function removeAnswer(numAnswer, numFormRep){
                       $("#formulaireReponse"+numFormRep+"").find(("#answer" + numAnswer + "")).remove();
                       //$("#answer" + numAnswer + "").remove();
                       var btnRemoveShow = numAnswer-1;
                       $("#formulaireReponse"+numFormRep+"").find(("#btnRemove" + btnRemoveShow + "")).show();
                    }
                    

        </script>
    </body>
</html>
