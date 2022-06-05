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
    <form method="post">
    <br> Please Select the Table you want to view :   
  <select name="table">  
  <option value="Select">Select</option>
  <option value="program">Programs</option>   
  <option value="project">Projects</option>
  <option value="executive">Executives</option>
  <option value="organisation">Organisations</option>
  <option value="researcher">Researchers</option>
  <option value="field">Scientific Fields</option>

</select> 
<input type="submit" name="Submit" value="Select" />  
</form>
<style>
td {
  text-align: center;
}
</style>
    
<?php
if(isset($_POST['table'])) {
    $selected = $_POST['table'];
    echo "<br>";

    if(!$selected) {
        echo '<h1 style="margin-top: 5rem;">Please Select a Table!</h1>';
    }
else{
    if($selected=='organisation') {
        ?>
        <style>
td {
  text-align: center;
}
</style>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_organisation.php">Add New Organisation</a>
                    </div>
                    <br>

                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_phone.php">Add a New Phone Number to an Organisation</a>
                    </div>
                    <br>

                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_company.php">Add Additional Info about a Company</a>
                    </div>
                    <br>

                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_university.php">Add Additional Info about a University</a>
                    </div>
                    <br>
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_research_centre.php">Add Additional Info about a Research Centre</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT * from organisation;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Organisations found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Name</th>';
                        echo '<th>Abbreviation</th>';
                        echo '<th>Type</th>';
                        echo '<th>Address</th>';
                        echo '<th style="width:10%"></th>';
                        echo '<th style="width:10%"></th>';
                        echo '<th style="width:10%"></th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[6] . " " . $row[7] . ", " .  $row[5] . ", " . $row[4] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./org_phone.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Contact Info';
                echo '</a>';
                echo '</td>';
                echo '<td>';
                echo '<a type="button" href="./update_organisation.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_organisation.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
            echo '</a>';
        echo '</td>';
            echo '</tr>';                
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($selected=='researcher') {
        ?>
            <style> 
                td {
                    text-align: center;
                }
            </style>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_researcher.php">Add New Researcher</a>
                    </div>
                    <br>
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_researcher_in_project.php">Add a Researcher to a Project</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT r.researcher_id, r.researcher_name, r.sex, r.birthdate, org.org_name, 
        r.org_starting_date
        from researcher as r, organisation as org
        where org.organisation_id=r.organisation_id;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Researchers found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Name</th>';
                        echo '<th style="width:10%">Gender</th>';
                        echo '<th>Birthdate</th>';
                        echo '<th>Organization</th>';
                        echo '<th>Organization Start Date</th>';
                        echo '<th style="width:10%"></th>';
                        echo '<th style="width:10%"></th>';
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
                echo '<td>' . $row[5] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./update_researcher.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_researcher.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
            echo '</a>';
        echo '</td>';
            echo '</tr>';                
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($selected=='program') {
        ?>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_programm.php">Add New Programm</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT * from programm;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Programs found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Name</th>';
                        echo '<th>ELIDEK Unit</th>';
                        echo '<th style="width:20%"></th>';
                        echo '<th style="width:20%"></th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>' . $row[2] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./update_programm.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_programm.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
            echo '</a>';
        echo '</td>';
            echo '</tr>';                
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($selected=='executive') {
        ?>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_exec.php">Add New Executive</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT * from executive;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Executives found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th style="width:10%">ID</th>';
                        echo '<th style="width:20%">Name</th>';
                        echo '<th style="width:10%"></th>';
                        echo '<th style="width:10%"></th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>'; 
                echo '<td>';
                echo '<a type="button" href="./update_exec.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_exec.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
            echo '</a>';
        echo '</td>';
            echo '</tr>';                
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($selected=='project') {
        ?>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_project.php">Add New Project</a>
                    </div>
                    <br>
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_deliverable.php">Add a Deliverable for a Project</a>
                    </div>
                    <br>
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_project_scientific_field.php">Add a Project to a Scientific Field</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT p.project_id, p.title, p.funding_amount, p.start_date, p.end_date, 
        duration, e.executive_name, 
        pr.programm_name, o.org_name, s.researcher_name, ev.researcher_name
        FROM project as p, executive as e, programm as pr, organisation as o, 
        researcher as s, researcher as ev, supervisor, evaluator 
        WHERE e.executive_id = p.executive_id
        AND pr.programm_id = p.programm_id
        AND o.organisation_id = p.organisation_id
        AND p.supervisor_id = supervisor.supervisor_id AND supervisor.researcher_id = s.researcher_id
        AND p.evaluator_id = evaluator.evaluator_id AND evaluator.researcher_id = ev.researcher_id;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Projects found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th style="width:8%">ID</th>';
                        echo '<th>Title</th>';
                        echo '<th style="width:8%">View Summary</th>';
                        echo '<th>Funding Amount</th>';
                        echo '<th>Start Date</th>';
                        echo '<th>End Date</th>';
                        echo '<th>Duration</th>';
                        echo '<th>Executive</th>';
                        echo '<th>Programm</th>';
                        echo '<th>Organization</th>';
                        echo '<th>Scientific Supervisor</th>';
                        echo '<th>Evaluator</th>';
                        echo '<th style="width:5%"></th>';
                        echo '<th style="width:5%"></th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./view_summary.php?id=' . $row[0]. '">';
                echo '<i class=""></i>' . 'Summary';
                echo '</a>';
                echo '</td>';
                echo '<td>' . $row[2] . " €" . '</td>';
                echo '<td>' . $row[3] . '</td>';
                echo '<td>' . $row[4] . '</td>';
                echo '<td>' . $row[5] . '</td>';
                echo '<td>' . $row[6] . '</td>';
                echo '<td>' . $row[7] . '</td>';
                echo '<td>' . $row[8] . '</td>';
                echo '<td>' . $row[9] . '</td>';
                echo '<td>' . $row[10] . '</td>';
                echo '<td>';
                echo '<a type="button" href="./update_project.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_project.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
            echo '</a>';
        echo '</td>';
            echo '</tr>';              
        }
        echo '</tbody>';
        echo '</table>';
    echo '</div>';
        }
    }
    else if ($selected=='field') {
        ?>
        <div class="container" id="row-container">
        <div class="row" id="row">
            <div class="col-md-4">
                <div class="card" id="card-container-layout">
                    <div class="card-body" id="card">
                        <a class="btn btn-primary" id="show-btn" href="/elidek ui/create_field.php">Add New Scientific Field</a>
                    </div>
                </div>
            </div>
            <br><br>
            <?php
        $query = "SELECT * from Scientific_field;";
        $result = mysqli_query($conn, $query);
                            
        if(mysqli_num_rows($result) == 0){
            echo '<h1 style="margin-top: 5rem;">No Scientific Fields found!</h1>';
        }
        else{
            echo '<div class="table-responsive">';
            echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
                echo '<thead>';
                    echo '<tr>';
                        echo '<th style="width:10%">ID</th>';
                        echo '<th style="width:20%">Name</th>';
                        echo '<th style="width:10%"></th>';
                        echo '<th style="width:10%"></th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while($row = mysqli_fetch_row($result)) {
                echo '<tr>';
                echo '<td>' . $row[0] . '</td>';
                echo '<td>' . $row[1] . '</td>'; 
                echo '<td>';
                echo '<a type="button" href="./update_field.php?id=' . $row[0]. '">';
                echo '<i class="fa fa-edit"></i>' . 'Edit';
            echo '</a>';
        echo '</td>';
        echo '<td>';
                echo '<a type="button" href="./delete_field.php?id=' . $row[0]. '">';
                echo '<i class = "fa fa-trash"></i>' . 'Delete';
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
}
        ?>
            </div>