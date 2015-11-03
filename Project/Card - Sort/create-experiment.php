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
      <script>
        $(document).ready(function() 
        {
            var max_fields      = 50; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID
                    
            var x = 1; //initlal text box count
            $(add_button).click(function(e)
            { //on add input button click
                e.preventDefault();
                if(x < max_fields)
                { //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div><br /><input type="text" name="statement[]" input pattern=".{3,}" required title="3 Characters Minimum"/><a href="#" class="remove_field btn btn-remove btn-danger"><span class="glyphicon glyphicon-minus"></span></a></div>'); 
                    }
                });
                $(wrapper).on("click",".remove_field", function(e)
                { //user click on remove text
                    e.preventDefault(); $(this).parent('div').remove(); x--;
                })
        });
        </script>

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
                            <li class="active" ><a href="create-experiment.php">Create Experiment</a></li>
                            <li><a href="get-cards.php">Get Cards</a></li>
                            <li><a href="run-experiment.php">Run Experiment</a></li>                            
                            <li><a href="get-results.php">Get Results</a></li>
                            <li><a href="https://github.com/Boilrig/physicalcardsort">Github</a></li>
                        </ul> <!-- /.menu -->
                    </div> <!-- /.menu-wrapper -->

                </div> <!-- /.sidebar-menu -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12">
                        <div class="row">
                        <div style="text-align: center; padding: 40px; height:150px;" >

                        <img src="img/create_experiment.png"   style=" height:78px; width:90%" alt="Logo">
                        
                        </div>
                       <div class="toggle-content text-center" >
                            <div class="col-md-12 col-sm-12">
                                    <h4>Create your experiment here. Remember to write down the Experiment Number.</h4>
<?php
            function processForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                $name = $_POST["experimentName"];
                $method = $_POST["experimentMethod"];

                foreach ($_POST["statement"] as $key => $value)
                {
                    $_POST["statement"] = array_map('mysql_escape_string', $_POST["statement"]);
                }

                if($_POST["experimentMethod"] == "pairs")
                {
                    $evencount = 0;

                    foreach($_POST["statement"] as $key => $text_field)
                    {
                        $evencount = $evencount + 1;
                    }

                    if ($evencount % 2 == 0)
                    {
                        $insertQuery = "INSERT INTO experiment (experimentName, experimentMethod) VALUES ('$name', '$method');";
                        $insertResult = mysqli_query($connection, $insertQuery);
                        $insertCount = mysqli_insert_id($connection);
                        $qr = 1;

                        foreach($_POST["statement"] as $key => $text_field)
                        {
                            $insertQuery = "INSERT INTO card (cardStatement, experimentID, cardQR) VALUES ('$text_field', '$insertCount', '$qr');";
                            $insertResult = mysqli_query($connection, $insertQuery);
                            $qr = $qr + 1;
                        }

                        echo("Your Experiment Number is <b>" . $insertCount . "</b>.");
                        echo("<br> <p>It is vital you keep this Experiment Number with you to allow printing of the cards but also running the experiment.</p>");
                    }
                    else
                    {
                        print("You choose Pairs, but you don't have an even number of cards! Please Try Again! ");
                    }
                }
                else
                {
                    $insertQuery = "INSERT INTO experiment (experimentName, experimentMethod) VALUES ('$name', '$method');";
                    $insertResult = mysqli_query($connection, $insertQuery);
                    $insertCount = mysqli_insert_id($connection);
                    $qr = 1;

                    foreach($_POST["statement"] as $key => $text_field)
                    {
                        $insertQuery = "INSERT INTO card (cardStatement, experimentID, cardQR) VALUES ('$text_field', '$insertCount', '$qr');";
                        $insertResult = mysqli_query($connection, $insertQuery);
                        $qr = $qr + 1;
                    }

                    echo("Your Experiment Number is <b>" . $insertCount . "</b>.");
                    echo("<br> <p>It is vital you keep this Experiment Number with you to allow printing of the cards but also running the experiment.</p>");
                }
            }


            function showForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                echo("
                        <form method='POST' action='$self'>
                            <div class='input_fields_wrap'>
                            <br>
                            <h3>Experiment Name</h3>
                            <input type='text' maxlength='40' input pattern='.{3,}' name='experimentName' required>
                            <br>
                            <br>
                            <b>Method:</b> <select name='experimentMethod'>
                                <option value='ranking' selected>Ranking</option>
                                <option value='pairs'>Pairs</option>
                               
                            </select>
                            <br>
                            <br>
                                
                                <h3>Card Description</h3>
                               <div> <input type='text' name='statement[]' maxlength='182'input pattern='.{3,}' required title='3 characters minimum'> <button class='add_field_button btn btn-success btn-add' type='button'>
                                <span class='glyphicon glyphicon-plus'></span>
                            </button></div>
                                
                            </div>
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

                            
                            </div> <!-- /.col-md-12 -->
                        </div> <!-- /.row -->
                    </div> <!-- /.services -->
                </div> <!-- /#menu-container -->
            </div> <!-- /.col-md-8 -->
        </div> <!-- /.row -->
    </div> <!-- /.container-fluid -->
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

    <script src="js/jquery.easing-1.3.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>

</body>
</html>
