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
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif; background: WhiteSmoke}
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
<style>
td {
  text-align: center;
}
</style>

    <div class="w3-row-padding w3-padding-64 w3-container">
     <body>
    <form method="post">
    <br> Scientific Field: 
    <select name="name_sci_field">
      <option disabled selected>-- Select Field --</option>
      <?php
          $sql = "SELECT * FROM scientific_field;";
          $records = mysqli_query($conn, $sql);  
  
          while($row = mysqli_fetch_array($records))
          {
              echo "<option value='". $row['name_sci_field'] ."'>" .$row['name_sci_field'] ."</option>";  // displaying data in option menu
          }	  
      ?> 
    </select>
    <input type="submit">
    </form>

<?php
if (isset($_POST['name_sci_field'])) {
    $selected = $_POST['name_sci_field'];
    
    if(!$selected) {
        echo '<h1 style="margin-top: 5rem;"Please Select a Field!</h1>';
    }
    else {
    echo "<br>" . "<b>You have selected </b>" . "$selected" . "<br>";
    echo "<br><br>" . "<em>Active Projects concerning this field:</em>" . "<br>";
    echo "<br>";

    $query = "SELECT project.title, project.project_id, project.end_date, scientific_field.name_sci_field 
    FROM project, scientific_field, project_scientific_field
    WHERE scientific_field.name_sci_field='$selected' 
    AND project.project_id = project_scientific_field.project_id 
    AND scientific_field.field_id = project_scientific_field.field_id 
    AND datediff(project.end_date, curdate()) > 0 
    order by scientific_field.name_sci_field;";
    $result = mysqli_query($conn, $query);
                        
    if(mysqli_num_rows($result) == 0){
        echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
    }
    else{
        echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto; float:left;">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th style="width:60%">Projects</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
        $counter = 0;
        while($row = mysqli_fetch_row($result)) {
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
             echo '</tr>';    
            $counter++;
    }
            echo '</tbody>';
        echo '</table>';
        echo '</div>';
}
        while ($counter > 0){
            echo "<br>";
            $counter--;
        }
    echo "<br><br><br><br>" . "<em>Researchers currently working on this field:</em>" . "<br>";
    echo "<br>";

    $query = "SELECT DISTINCT researcher.researcher_name, project.project_id, project.end_date, scientific_field.name_sci_field 
    FROM researcher, project, scientific_field, project_scientific_field, researcher_in_project
    WHERE scientific_field.name_sci_field='$selected' 
    AND project.project_id = project_scientific_field.project_id 
    AND project.project_id = researcher_in_project.project_id
    AND researcher.researcher_id = researcher_in_project.researcher_id
    AND scientific_field.field_id = project_scientific_field.field_id 
    AND datediff(project.end_date, curdate()) > 0 
    order by scientific_field.name_sci_field;";
    $result = mysqli_query($conn, $query);
                        
    if(mysqli_num_rows($result) == 0){
        echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
    }
    else{
        echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto; float:left;">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th style="width:60%">Researchers</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
        while($row = mysqli_fetch_row($result)) {
            echo '<tr>';
            echo '<td>' . $row[0] . '</td>';
             echo '</tr>';        
                        
    }
               echo '</tbody>';
    echo '</table>';
}
    }
}
    ?>
</body>
    </div>