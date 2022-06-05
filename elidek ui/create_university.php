<?php
include_once 'db-connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>ELIDEK</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif;background: WhiteSmoke}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
</head>
<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card w3-left-align w3-large">
    <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-red" href="javascript:void(0);" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="/elidek ui/" class="w3-bar-item w3-button w3-padding-large w3-white">Home</a>
    <a href= "/elidek ui/crud.php" class="w3-bar-item w3-button w3-hide-small w3-padding-large w3-hover-white">Manage Elidek Data</a>
  </div>
</div>

       <div class="w3-row-padding w3-padding-64 w3-container">  
<div class="container">
    <div class="row" id="row">
        <div class="col-md-12">
            <br>

<?php

                echo '<div class="form-group col-sm-3 mb-3">';
                echo "Please add all the required info: " . "<br>";
                echo "<br>";
                echo '<hr></div>';
            
                
                
            ?>
            <form class="form-horizontal" name="program-form" method="POST">
                <form method="post">
                 University: 
                 <select name="org">
                   <option disabled selected>-- Organisation --</option>
                       <?php
                     $sql = "SELECT * FROM organisation WHERE org_type = 'University';";
                     $records = mysqli_query($conn, $sql);  
  
                    while($row = mysqli_fetch_array($records)) {
                    echo "<option value='". $row['organisation_id'] ."'>" .$row['org_name'] ."</option>"; 
                    }	  
                   ?>  
                  </select>
                  <br><br>
                  
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Budget from Ministry of Education:</label>
                    <input class = "form-control", name="budget", placeholder="Budget">

                </div>
                <br>

                <button class = "btn btn-primary btn-submit-custom" type = "submit" name="submit_upd">Submit</button>
                <button class = "btn btn-primary btn-submit-custom" formaction="crud.php">Back</button>

            </form>
        </div>
        <div class="form-group col-sm-3 mb-3">
            <?php
            
                if(isset($_POST['submit_upd'])){
                            
                    $org = $_POST['org'];
                    $assets = $_POST['budget'];
                    
                    $query = "INSERT INTO university (organisation_id, org_type, budget_from_ed_ministry) VALUES
                    ($org, 'University', $budget);";

                    if (mysqli_query($conn, $query)) {                            
                        echo "Record Added Succsessfully! Please Click 'Back'";
                        exit();
                        }
                        
                        else{
                            echo "<br>" . "Error while updating record: <br>" . mysqli_error($conn) . "<br>";
                        }
                    }
                
            ?>

        </div>
                      </form>
                    </form>
                </form>
            </form>
        </div>
    </div>
           </div>
    </div>
    </body>
</html>
