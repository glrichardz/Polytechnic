<!DOCTYPE html>
<?php include "connect/connect.inc.php"; ?>
<html > 
<head>
    <meta charset="utf-8">
    <title>BadgerPi - Get Cards</title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/BadgerPistyle.css">
        <link rel="stylesheet" href="css/card.css">
    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
    <style type="text/css">
@media print
{

.noprint {display:none;}
}
    </style>
</head>
<body>

<div style="width:70%; text-align:center; margin-right: auto; margin-left: auto;">
  <div class="noprint"><div class="bg-overlay"></div></div>
    <div class="container-fluid">
        <div class="row">
        <div class="noprint">
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
                            <li ><a href="index.php">Home</a></li>                            
                            <li><a href="instructions.php">Instructions</a></li>
                            <li><a href="create-experiment.php">Create Experiment</a></li>
							<li class="active"><a href="get-cards.php">Get Cards</a></li>
                            <li><a href="run-experiment.php">Run Experiment</a></li>                            
                            <li><a href="get-results.php">Get Results</a></li>
                            <li><a href="https://github.com/Boilrig/physicalcardsort">Github</a></li>
                        </ul> <!-- /.menu -->
                    </div> <!-- /.menu-wrapper -->
</div>
                </div> <!-- /.sidebar-menu -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12">
                        <div class="row">
                          <div class="noprint">
                        <div style="text-align: center; padding: 40px; height:150px;" >
                        <img src="img/get_cards.png"   style=" height53px;  width:53%" alt="Logo">                        
                        </div>
                        </div>
                    <div class="toggle-content text-center" >
                            <div class="col-md-12 col-sm-12">
                            <div class="noprint">
                                    <h4>Please enter the number that was provided to you on the create experiment page.</h4>
                                   </div>    
                                  <div style="width:100%;"> 
                                                             
                <?php
            function processForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                $number = $_POST["cardNum"];

                $printQuery = "SELECT * FROM experiment INNER JOIN card ON experiment.experimentID=card.experimentID WHERE experiment.experimentID='".$number."'";
                $printResult = mysqli_query($connection, $printQuery);

                if($printResult)
                {
                    $rows = array();
                    while($row = mysqli_fetch_array($printResult))
                        $rows[] = $row;
                    foreach($rows as $row)
                    {
                        $statement = stripslashes($row['cardStatement']);
                        $qrpicture = stripslashes($row['cardQR']);

                        while(strchr($statement,'\\'))
                        {
                            $statement = stripslashes($statement);
                        }

                        echo('<div class="one outline shadow rounded"><div class="top">' . $statement . '</div> <div class="bottom"><img src = "img/qr_codes/' . $qrpicture . '.png" alt="QRCode">'.'</div></div>');
                    }
                }
                else
                {
                    echo("No ExperimentID with that Number. Please Try Again.");
                    echo("
                        <form method='POST' action='$self'>
                            <div class='input_fields_wrap'>
                            <br>
                            <h3>Experiment Number</h3> <input type='number' name='cardNum' required>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' class='btn btn-success btn-add pad' value='submit'>Submit</button>
                        </form>
                    ");
                }
            }

            function showForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                echo("
                        <form method='POST' action='$self'>
                            <div class='input_fields_wrap'>
                            <br>
                            <h3>Experiment Number</h3> <input type='number' name='cardNum' required>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' class='btn btn-success btn-add pad' value='submit'>Submit</button>
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
        ?>
        </div>
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
        <script type="text/javascript">
            
            jQuery(function ($) {

                $.supersized({

                    // Functionality
                    slide_interval: 3000, // Length between transitions
                    transition: 1, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed: 700, // Speed of transition

                    // Components                           
                    slide_links: 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    slides: [ // Slideshow Images
                        {
                            image: 'images/templatemo-slide-1.jpg'
                        }, {
                            image: 'images/templatemo-slide-2.jpg'
                        }, {
                            image: 'images/templatemo-slide-3.jpg'
                        }, {
                            image: 'images/templatemo-slide-4.jpg'
                        }
                    ]

                });
            });
            
    </script>
<div>
</body>
</html>