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

        <br><br>
<?php
$id = $_GET['id'];
                $query = "SELECT title FROM project WHERE project_id = $id;";
                $res1 = mysqli_query($conn, $query);
                $row = mysqli_fetch_row($res1);
                echo '<div class="form-group col-sm-3 mb-3">';
                echo '<label class = "form-label">Change information for project: <br><b>' . $id . '</b></label>';
                echo '<br>' . "Please note that you must only select researchers working on the projects organisation as supervisors";
            echo '<hr></div>';
        
            
            
        ?>
        <form class="form-horizontal" name="program-form" method="POST">
            <br><br>
            <div class="form-group col-sm-3 mb-3">
                <label class = "form-label">New Title</label>
                <input class = "form-control", name="title", placeholder="Title">
            </div>

            <br>

            <div class="form-group col-sm-3 mb-3">
                <label class = "form-label">New Summary</label>
                <input class = "form-control", name="summary", placeholder="Summary">
            </div>

            <br>

            <div class="form-group col-sm-3 mb-3">
                <label class = "form-label">New Funding Amount</label>
                <input class = "form-control", name="funding_amount", placeholder="Amount">
            </div>
            <br>

            <div class="form-group col-sm-3 mb-3">
                <label class = "form-label">New Starting Date</label>
                <input class = "form-control", name="start_date", placeholder="yyyy-mm-dd">
            </div>
            <br>

            <div class="form-group col-sm-3 mb-3">
                <label class = "form-label">New Ending Date</label>
                <input class = "form-control", name="end_date", placeholder="yyyy-mm-dd">
            </div>
            <br>

            <form method="post">
             New Executive: 
             <select name="executive">
               <option disabled selected>-- New Executive --</option>
                   <?php
                 $sql = "SELECT * FROM executive;";
                 $records = mysqli_query($conn, $sql);  

                while($row = mysqli_fetch_array($records)) {
                echo "<option value='". $row['executive_id'] ."'>" .$row['executive_name'] ."</option>"; 
                }	  
               ?>  
              </select>
              <br><br>

              <form method="post">
             New Program: 
             <select name="programm">
               <option disabled selected>-- New Program --</option>
                   <?php
                 $sql = "SELECT * FROM programm;";
                 $records = mysqli_query($conn, $sql);  

                while($row = mysqli_fetch_array($records)) {
                echo "<option value='". $row['programm_id'] ."'>" .$row['programm_name'] ."</option>"; 
                }	  
               ?>  
              </select>
              <br><br>

             <form method="post">
             New Organisation: 
             <select name="org">
               <option disabled selected>-- New Organisation --</option>
                   <?php
                 $sql = "SELECT * FROM organisation;";
                 $records = mysqli_query($conn, $sql);  

                while($row = mysqli_fetch_array($records)) {
                echo "<option value='". $row['organisation_id'] ."'>" .$row['org_name'] ."</option>"; 
                }	  
               ?>  
              </select>
              <br><br>

              <form method="post">
             New Supervisor: 
             <select name="supervisor">
               <option disabled selected>-- New Supervisor --</option>
                   <?php
                 $sql = "SELECT * FROM researcher;";
                 $records = mysqli_query($conn, $sql);  

                while($row = mysqli_fetch_array($records)) {
                echo "<option value='". $row['researcher_id'] ."'>" .$row['researcher_name'] ."</option>"; 
                }	  
               ?>  
              </select>
              <br><br>

              <form method="post">
             New Evaluator: 
             <select name="evaluator">
               <option disabled selected>-- New Evaluator --</option>
                   <?php
                 $sql = "SELECT * FROM researcher;";
                 $records = mysqli_query($conn, $sql);  

                while($row = mysqli_fetch_array($records)) {
                echo "<option value='". $row['researcher_id'] ."'>" .$row['researcher_name'] ."</option>"; 
                }	  
               ?>  
              </select>
    
             <br><br>

             <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">New Grade</label>
                    <input class = "form-control", name="grade", placeholder="e.g. B">
                </div>
                <br>

                <div class="form-group col-sm-3 mb-3">
                    <label class = "form-label">New Evaluation Date</label>
                    <input class = "form-control", name="eval_date", placeholder="yyyy-mm-dd">
                </div>
        
                 <br><br>

 <button class = "btn btn-primary btn-submit-custom" type = "submit" name="submit_upd">Submit</button>
 <button class = "btn btn-primary btn-submit-custom" formaction="crud.php">Back</button>

</form>
</div>
<div class="form-group col-sm-3 mb-3">

<?php
if(isset($_POST['submit_upd'])){
             
  $title = $_POST['title'];
  $summary = $_POST['summary'];
  $funding_amount = $_POST['funding_amount'];
  $start_date = $_POST['start_date'];
  $end_date = $_POST['end_date'];
  $executive = $_POST['executive'];
  $programm = $_POST['programm'];
  $org = $_POST['org'];
  $supervisor = $_POST['supervisor'];
  $evaluator = $_POST['evaluator'];
  $grade = $_POST['grade'];
  $eval_date = $_POST['eval_date'];

  $newsup1 = "INSERT INTO supervisor (project_id, researcher_id) 
              VALUES ($id, $supervisor);";
  mysqli_query($conn, $newsup1);
                     
  $sql1 = "SELECT supervisor_id FROM supervisor 
           WHERE researcher_id = $supervisor and project_id = $id;";

  $query2 = mysqli_query($conn, $sql1);
  $result1 = $query2->fetch_array();
  $query1 = intval($result1[0]);

  $neweval1 = "INSERT INTO evaluator (project_id, researcher_id, grade, evaluation_date) 
               VALUES ($id, $evaluator, '$grade', '$eval_date');";
  mysqli_query($conn, $neweval1);

  $sql2 = "SELECT evaluator_id FROM evaluator
           WHERE researcher_id = $evaluator and project_id = $id;";

  $query4 = mysqli_query($conn, $sql2);
  $result2 = $query4->fetch_array();
  $query2 = intval($result2[0]);

  
  $query = "UPDATE project
  SET title = '$title', summary = '$summary', funding_amount = '$funding_amount',
  start_date = '$start_date', end_date = '$end_date', executive_id = $executive,
  programm_id = $programm, organisation_id = $org, supervisor_id = $query1, 
  evaluator_id = $query2
  WHERE project_id = $id;";

  if (mysqli_query($conn, $query)) {                            
      echo "Record Updated Succsessfully! Please Click 'Back'";
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
        </div>
    </div>
                 </div>
    </div>
    </body>
</html>