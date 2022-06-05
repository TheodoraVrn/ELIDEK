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
<style>
td {
  text-align: center;
}
</style>

<div class="w3-row-padding w3-padding-64 w3-container">
<body>
    <br>
    <?php 
    echo 'First, choose the filters you wish to apply: ' . '<br>'; ?>
    <form class="form-horizontal" name="parameters" method="POST">
            <br><br> Please Select Project Duration :   
            <select name="duration">  
            <option value=0 selected>---</option> 
            <option value=1>1</option>  
            <option value=2>2</option>   
            <option value=3>3</option> 
            <option value=4>4</option> 
            </select> 
            

            <form method="post">
            <br><br> Please Select a Starting Date: 
            <select name="start_date">
            <option value="none" selected>---</option>
            <?php
            $sql = "SELECT DISTINCT start_date FROM project ORDER BY start_date DESC;";
            $records = mysqli_query($conn, $sql);  
  
             while($row = mysqli_fetch_array($records)) {
              echo "<option value='". $row['start_date'] ."'>" .$row['start_date'] ."</option>";  
              }	  
              ?>  
            </select>
            

            <form method="post">
            <br><br> Please Select an Executive: 
            <select name="executive">
            <option value="none" selected>---</option>
            <?php
            $sql = "SELECT * FROM executive;";
            $records = mysqli_query($conn, $sql);  
  
             while($row = mysqli_fetch_array($records)) {
              echo "<option value='". $row['executive_id'] ."'>" .$row['executive_name'] ."</option>";  
              }	  
              ?>  
            </select>
            <br><br>

            <button class = "btn btn-primary btn-submit-custom" type = "submit" name="submit_param">See Projects</button>
            </form>
            <br>
    <?php

    

    if(isset($_POST['submit_param'])) {
       $duration = $_POST['duration'];
       $start_date = $_POST['start_date'];
       $executive = $_POST['executive'];

    if ($duration != 0 and $start_date != 'none' and $executive != 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.start_date = '$start_date' 
        and p.duration = $duration 
        and p.executive_id = $executive
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th><th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration==0 and $start_date=='none' and $executive=='none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration == 0 and $start_date != 'none' and $executive != 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.start_date = '$start_date' 
        and p.executive_id = $executive
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration != 0 and $start_date = 'none' and $executive != 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.duration = $duration 
        and p.executive_id = $executive
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration != 0 and $start_date != 'none' and $executive = 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.start_date = '$start_date' 
        and p.duration = $duration
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration != 0 and $start_date = 'none' and $executive = 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.duration = $duration
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration == 0 and $start_date != 'none' and $executive = 'none') {
        $query = "SELECT  p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        WHERE p.start_date = '$start_date' 
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($duration == 0 and $start_date = 'none' and $executive != 'none') {
        $query = "SELECT p.project_id, p.title, p.start_date, p.duration, e.executive_name 
        FROM project AS p 
        INNER JOIN executive AS e ON e.executive_id = p.executive_id
        and p.executive_id = $executive
        ORDER BY p.title;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
        echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th>ID</th>';
                    echo '<th style="width:20%">Title</th>';
                    echo '<th style="width:20%">Start Date</th>';
                    echo '<th style="width:10%">Duration</th>';
                    echo '<th style="width:20%">Executive</th>';
                    echo '<th></th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_researchers.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'View Researchers';
            echo '</a>';
        echo '</td>';
                echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    }
?>
        </form>
    </form>
            </body>
    </div>
    </body>
</html>
