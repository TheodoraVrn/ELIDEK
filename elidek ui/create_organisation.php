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
echo "Please enter all required info: " . "<br>";       
            ?>
            <form class="form-horizontal" name="program-form" method="POST">
                <br>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Name</label>
                    <input class = "form-control", name="name", placeholder="Name">
                </div>

                <br>

                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Abbreviation</label>
                    <input class = "form-control", name="abbreviation", placeholder="Abbr.">
                </div>
                
                <br>

                <form method="post">
                    Organisation Type:  
                    <select name="type">  
                    <option disabled selected>-- Organisation Type --</option>  
                    <option value="Company">Company</option>  
                    <option value="University">University</option> 
                    <option value="Research Centre">Research Centre</option>  
                </select> 

                 <br><br>

                 <?php echo 'Address: '; ?>

                 <br><br>
                 <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">City</label>
                    <input class = "form-control", name="city", placeholder="City">
                </div>
                <br>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Postal Code</label>
                    <input class = "form-control", name="postal", placeholder="Postal Code">
                </div>
                <br>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Street Name</label>
                    <input class = "form-control", name="street", placeholder="Street Name">
                </div>
                <br>
                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">Street Number</label>
                    <input class = "form-control", name="num", placeholder="Street Number">
                </div>
                <br>

                <button class = "btn btn-primary btn-submit-custom" type = "submit" name="submit_upd">Submit</button>
                <button class = "btn btn-primary btn-submit-custom" formaction="crud.php">Back</button>

            </form>
        <div class="form-group col-sm-3 mb-3">
            <?php
            
                if(isset($_POST['submit_upd'])){
                            
                    $name = $_POST['name'];
                    $abbreviation = $_POST['abbreviation'];
                    $type = $_POST['type'];
                    $city = $_POST['city'];
                    $postal = $_POST['postal'];
                    $street = $_POST['street'];
                    $num = $_POST['num'];

                        $query = "INSERT INTO organisation (org_name, abbreviation, org_type, 
                                city, postal_code, street, street_number) values
                                ('$name', '$abbreviation', '$type',
                                '$city', '$postal', '$street', '$num');";

                        if (mysqli_query($conn, $query)) {
                            echo "Record added successfully. Please go back to starting page 
                            and add additional info regarding the organisation type.";
                        }
                        else{
                            echo "Error while updating record: <br>" . mysqli_error($conn) . "<br>";
                        }
                    }
                
            ?>

        </div>
            </form>
        </div>
    </div>
             </div>
    </div>
    </body>
</html>