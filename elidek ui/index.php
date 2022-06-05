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
body,h1,h2,h3,h4,h5,h6 {font-family: "Lato", sans-serif}
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

<!-- Header -->
<header class="w3-container w3-siena w3-center" style="padding:128px 16px">
  <h1 class="w3-margin w3-jumbo">Welcome to ELIDEK</h1>
    <style>
body {font-family: "Lato", sans-serif; background-color: thistle}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
</header>

<!-- Grid -->
<div class="w3-row-padding w3-light-grey w3-padding-64 w3-container">
  <div class="w3-content">
    <div class="w3-third w3-center">
     
    </div>

    <div class="w3-twothird">
      <h1>Queries</h1>
      <br> 
        <h4 class="card-title">Projects</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_1.php">Click here to see all projects with selected filters</a></h5>
        <h4 class="card-title">Projects per Researchers</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_2a.php">Click here to see each researchers' projects</a>
        <h4 class="card-title">Projects' Grades</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_2b.php">Click here to view each projects' grade </a>
        <h4 class="card-title">Scientific Fields</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_3.php">Click here to choose a scientific field </a>
        <h4 class="card-title">Organisations with same number of Projects in Two Consecutive Years</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_4.php">Click here to see each the organizations with most projects at consecutive years</a>
        <h4 class="card-title">Top-3 Field Combos</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_5.php">Click here to see the Top-3 Field Combos</a>
        <h4 class="card-title">Young Researchers</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_6.php">Click here to see the young researchers</a>
        <h4 class="card-title">Top-5 Executives</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_7.php">Click here to see the top 5 executives</a>      
        <h4 class="card-title">Reasearchers in Projects with no Deliverables</h4>
        <a class="btn btn-primary" id="show-btn" href="/elidek ui/3_8.php">Click here to see the reasearchers who work on projects with no deliverables</a>
    </div>
      
  </div>
    
</div>
    

<script>
// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

</body>

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity">  
 <p>Ⓒ2022 Vernardaki Theodora / Zachou Aliki</p>
<style>
footer {font-family: "Lato", sans-serif;background: DarkSeaGreen}
.w3-bar,h1,button {font-family: "Montserrat", sans-serif}
.fa-anchor,.fa-coffee {font-size:200px}
</style>
</footer>
</html>

</html>