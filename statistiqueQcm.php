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
        <link href="TemplateQCM/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
          
//SELECT DISTINCT * FROM `user_has_answer`, `answer`, `question` WHERE id_user = 2 AND id_qcm = 1 AND question.id_question = answer.id_question ANd answer.id_answer = `user_has_answer`.id_answer

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Nombre'],
          ['Juste',     11],
          ['Fausse',    7]
        ]);

        var options = {
          title: 'Questions juste ou fausse'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
    </head>
    <body id="page-top" class="index">

        <?php include 'header.html'; ?>
<!--            SQL pour l'instant
            SELECT Count(answer), Count(`right_answer`) FROM `answer`, user_has_answer, question Where id_user = 2 AND answer.id_answer = user_has_answer.id_answer AND question.id_question = answer.id_question and id_qcm = 1-->

        <!-- Header -->
        <header>
            <div id="contenu" class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="intro-text">
                            <div id="piechart" style="width: 900px; height: 500px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <?php include 'footer.html'; ?>

        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
        <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
            <a class="btn btn-primary" href="#page-top">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>

        <!-- Portfolio Modals -->
        <div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-lg-offset-2">
                            <div class="modal-body">
                                <h2 class="login-h2">Login</h2>
                                <hr class="star-primary">
                                <div class="login-form">
                                    <form>
                                        <input type="text" placeholder="Username" />
                                        <br /><br />
                                        <input type="password" placeholder="Passowrd" />
                                        <br /><br />
                                        <input title="login" type="submit" value="Login" />
                                        <br /><br />
                                        <a title="sign up">Sign up</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="portfolio-modal modal fade" id="portfolioModal2" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-content">
                <div class="close-modal" data-dismiss="modal">
                    <div class="lr">
                        <div class="rl">
                        </div>
                    </div>
                </div>
            </div>
        </div>
       

        <!-- jQuery -->
        <script src="vendor/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

        <!-- Plugin JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

        <!-- Contact Form JavaScript -->
        <script src="js/jqBootstrapValidation.js"></script>
        <script src="js/contact_me.js"></script>

        <!-- Theme JavaScript -->
        <script src="js/freelancer.min.js"></script>
        
        <script>
            $(document).ready(function () {
                var hauteur_fenetre = $(window).height();
                var hauteur_footer = $('footer').height();
                var obj = document.getElementById('contenu');
                obj.style.minHeight = hauteur_fenetre - hauteur_footer + "px";
            });
        </script>

    </body>
</html>
