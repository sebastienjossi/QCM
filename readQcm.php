<!-- 

Auteur : Ricardo
Utilité : Fait le listing des QCM.

-->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>QCM</title>

        <!-- Bootstrap Core CSS -->
        <link href="TemplateQCM/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

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
    </head>
    <body>
        <?php include 'TemplateQCM/header.html'; ?>
        <section>
            <!-- START : ADDED BY RICARDO -->
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <table class="table table-hover">
                        <thead><th>Nom QCM</th><th>Date de création</th><th>Modifer</th><th>Supprimer</th></thead>

                        <?php
                            include_once("qcmDao.inc.php");

                            foreach(QcmDao::GetQcmByIdCreator(2) as $qcm)
                            {
                                echo '<tr><td>' . $qcm['name'] . '</td><td>' . $qcm['creation_date'] . '</td><td><a href="modifyQcm.php?id=' . $qcm['id_qcm'] . '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td><td><a onclick="return myDelete(' . $qcm['id_qcm'] . ')" href=""><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>';
                            }
                        ?>
                    </table>
                </div>
            </div>
            <script>
            
                function myDelete(idQcm)
                {
                    if(confirm("Voulez-vous vraiment supprimer ce QCM ?\rToutes les évaluations vont également être supprimées.\rCette action est irréversible."))
                    {
                        window.location.href = "deleteQcm.php?idQcm=" + idQcm;
                        return false;
                    }
                }

            </script>
            <!-- END : ADDED BY RICARDO -->
        </section>
        <?php include 'TemplateQCM/footer.html'; ?>
    </body>
</html>
