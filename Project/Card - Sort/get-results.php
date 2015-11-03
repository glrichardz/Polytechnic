
<?php

            function processForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                $experimentid = $_POST["experimentid"];

                $checkQuery = "SELECT subjectID, cardStatement, position FROM subjectCard INNER JOIN card ON subjectCard.cardID=card.cardID WHERE card.experimentID = '$experimentid'";
                $checkResult = mysqli_query($connection, $checkQuery);
                ob_end_clean();
                if($checkResult)
                {
                    if (!$checkResult) die('Couldn\'t fetch records');
                    $headers = $checkResult->fetch_fields();
                    foreach($headers as $header) {
                        $head[] = $header->name;
                    }
                    $fp = fopen('php://output', 'w');

                    if ($fp && $checkResult) {
                        header('Content-Type: text/csv');
                        header('Content-Disposition: attachment; filename="export.csv"');
                        header('Pragma: no-cache');
                        header('Expires: 0');
                        fputcsv($fp, array_values($head)); 
                        while ($row = $checkResult->fetch_array(MYSQLI_NUM)) {
                            fputcsv($fp, array_values($row));
                        }
                        die;
                    }

                    echo("Downloading Now");
                }
                else
                {
                    echo("Invalid Experiment Indentification Number OR No Experiments Run on this experiment.");
                    echo("
                        <form method='POST' action='$self' enctype='multipart/form-data'>
                            <br>
                            <br>
                            <h4>Experiment Number</h4> <input type='number' name='experimentid' required>
                            <br>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' class='btn btn-success btn-add padd' value='submit'>Submit</button>
                        </form>
                    ");
                }
            }
            ?>
<!DOCTYPE html>
<?php include "connect/connect.inc.php"; ?>

<html > 
<head>
    <meta charset="utf-8">
    <title>Physical Card Sort - Experiment Creation</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/BadgerPistyle.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
</head>
<body>
<div style="width:70%; text-align:center; margin-right: auto; margin-left: auto;">
  <div class="bg-overlay"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="sidebar-menu">
                    <div class="logo-wrapper">
                        <h1 class="logo">
                            <a href="index.php"><img src="img/BadgerPiLogoSmall.png" alt="Logo">
                            <span>BadgerPi - Card Sort</span></a>
                        </h1>
                    </div> <!-- /.logo-wrapper -->
                    
                    <div class="menu-wrapper">
                        <ul class="menu">
                            <li><a href="index.php">Home</a></li>                            
                            <li><a href="instructions.php">Instructions</a></li>
                            <li><a href="create-experiment.php">Create Experiment</a></li>
                            <li><a href="get-cards.php">Get Cards</a></li>
                            <li><a href="run-experiment.php">Run Experiment</a></li>                            
                            <li class="active"><a href="get-results.php">Get Results</a></li>
                            <li><a href="https://github.com/Boilrig/physicalcardsort">Github</a></li>
                        </ul> <!-- /.menu -->
                    </div> <!-- /.menu-wrapper -->

                </div> <!-- /.sidebar-menu -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12">
                        <div class="row">
                        <div style="text-align: center; padding: 40px; height:150px;" >
                            <img src="img/get-results.png"   style=" height:66px; width:70%" alt="Logo">   
                        </div>
                       <div class="toggle-content text-center" >
                            <div class="col-md-12 col-sm-12">
                                    <h4>Put your Experiment Number here to download a spreadsheet of all the results.</h4>

    <?php

            function showForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                echo("
                        <form method='POST' action='$self' enctype='multipart/form-data'>
                            <br>
                            <br>
                            <h4>Experiment Number</h4> <input type='number' name='experimentid' required>
                            <br>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' class='btn btn-success btn-add padd' value='submit'>Submit</button>
                        </form>
                    ");
            }

            if(isset($_POST['verify']))
            {
                    processForm($connection);
            }
            else
            {
                    showForm($connection);
            }
        ?>      </div>
                             </div>
                             </div>
                            </div>
                        </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.services -->
                </div> <!-- /#menu-container -->
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
    <div class="noprint">
    <div class="container-fluid">   
        <div class="row">
            <div class="col-md-12 footer">
                <p id="footer-text"><center>
                
                    Copyright &copy; 2015 BadgerPi
                    
                    | Design & Developed by BadgerPi
                 </center>
                 </p>
            </div><!-- /.footer --> 
        </div>
    </div> <!-- /.container-fluid -->
    </div>
<div class="noprint">
    <script src="js/jquery.easing-1.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</div>
</body>
</html>