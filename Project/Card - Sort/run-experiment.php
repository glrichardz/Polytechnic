<!DOCTYPE html>
<?php include "connect/connect.inc.php"; ?>

<html> 
<head>
    <meta charset="utf-8">
    
    <title>Physical Card Sort - Run Experiment</title>
    
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
                            <li class="active"><a href="run-experiment.php">Run Experiment</a></li>                            
                            <li><a href="get-results.php">Get Results</a></li>
                            <li><a href="https://github.com/Boilrig/physicalcardsort">Github</a></li>
                        </ul> <!-- /.menu -->
                    </div> <!-- /.menu-wrapper -->

                </div> <!-- /.sidebar-menu -->
            </div> <!-- /.col-md-4 -->

            <div class="col-md-8 col-sm-12">
                        <div class="row">

                        <div style="text-align: center; padding: 40px; height:150px;" >
                        <img src="img/run_experiment.png"   style=" height:77px; width:90%" alt="Logo">

                        </div>
                       <div class="toggle-content text-center" >
                            <div class="col-md-12 col-sm-12">
                                    <h4>Run the experiment with the Experiment Number you have. Remember to have the picture crop perfectly. </h4>
                                                <?php
            function processForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                $age = $_POST["age"];
                $gender = $_POST["gender"];
                $experimentid = $_POST["experimentid"];

                $checkQuery = "SELECT * FROM card WHERE experimentID = '".$experimentid."'";
                $checkResult = mysqli_query($connection, $checkQuery);

                if(mysqli_num_rows($checkResult) > 0)
                {
                    $target_dir = "";
                    $target_file = $target_dir . basename($_FILES["image"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["image"]["tmp_name"]);
                        if($check !== false) {
                            echo "File is an image - " . $check["mime"] . ".";
                            $uploadOk = 1;
                        } else {
                            echo "File is not an image.";
                            $uploadOk = 0;
                        }
                    }
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        echo "Sorry, file already exists.";
                        $uploadOk = 0;
                    }
                    // Check file size
                    if ($_FILES["image"]["size"] > 500000000000000000000000000000) {
                        echo "Sorry, your file is too large.";
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        $uploadOk = 0;
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk == 0) {
                        echo "Sorry, your file was not uploaded.";
                    // if everything is ok, try to upload file
                    } else {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                        } else {
                            echo "Sorry, there was an error uploading your file.";
                        }
                    }

                    //Declare Image for Database Entry
                    $image = $target_file;

                    $insertQuery = "INSERT INTO subjectData (experimentID, subjectAge, subjectGender, subjectImage) VALUES ('$experimentid', '$age', '$gender', '$image')";
                    $insertResult = mysqli_query($connection, $insertQuery);
                    $insertCount = mysqli_insert_id($connection);

                    $subjectQuery = "SELECT subjectID FROM subjectData WHERE subjectID = '".$insertCount."'";
                    $subjectResult = mysqli_query($connection, $subjectQuery);
                    while ($row = $subjectResult->fetch_assoc()) {
                        echo $row['subjectID']."<br>";
                        $subjectID = $row['subjectID'];
                    }

                    //$subjectID = $subjectResult[0][0];

                    $countQuery = "SELECT cardStatement FROM card WHERE experimentID = '".$experimentid."'";
                    $countResult = mysqli_query($connection, $countQuery);



                    if($countResult)
                    {
                        $rowcount=mysqli_num_rows($countResult);

                        $pythonCommand = "python card.py " .$image ." ".$experimentid ." ".$subjectID." ".$rowcount;
                        $pid = popen( $pythonCommand,"r");

                        while( !feof( $pid ) )
                        {
                            echo fread($pid, 256);
                            flush();
                            ob_flush();
                            usleep(100000);
                        }
                        pclose($pid);
                    }  
                }
                else
                {
                    Echo("Error: Experiment ID is Invalid or Doesn't Exist");
                }

                $checkQuery = "SELECT * FROM subjectCard INNER JOIN card ON subjectCard.cardID=card.cardID WHERE card.experimentID = '$experimentid'";
                $checkResult = mysqli_query($connection, $checkQuery);

                echo("
                        <form method='POST' action='$self' enctype='multipart/form-data'>
                            <br>
                            <br>
                            <h3>Experiment Number</h3>  <input type='number' name='experimentid' required>
                            <br>
                            <br>
                            <h3>Age </h3> <input type='number' name='age' required>
                            <br>
                            <br>
                           <h3> Gender </h3> <select name='gender'>
                                <option value='male' selected>Male</option>
                                <option value='female'>Female</option>
                            </select>
                            <br>
                            <br>
                            <input type='file' required name='image' id='image' accept='image/*'>
                            <br>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' value='submit'>Submit</button>
                        </form>
                    ");
            }

            function showForm($connection)
            {
                $self = htmlentities($_SERVER['PHP_SELF']);

                echo("
                        <form method='POST' action='$self' enctype='multipart/form-data'>
                            <br>
                            <br>
                            <h3>Experiment Number</h3> <input type='number' name='experimentid' required>
                            <br>
                            <br>
                            <h3>Age </h3> <input type='number' name='age' required>
                            <br>
                            <br>
                            <h3> Gender </h3> <select name='gender'>
                                <option value='male' selected>Male</option>
                                <option value='female'>Female</option>
                            </select>
                            <br>
                            <br>
                            <input type='file'  required name='image' id='image' accept='image/*'>
                            <br>
                            <br>
                            <input type='hidden' name='verify' value='aaa'>
                            <button type='submit' value='submit' class='btn btn-success btn-add padd'>Submit</button>
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