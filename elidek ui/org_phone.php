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
<style>
td {
  text-align: center;
}
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

<body>

<?php
 $id = $_GET['id'];

 echo 'Available phone numbers for Organisation no. ' . $id . ' : ';
 echo "<br><br>";

    
    $query = "SELECT phone FROM phone WHERE organisation_id = $id;";
    $result = mysqli_query($conn, $query);
                        
    if(mysqli_num_rows($result) == 0){
        echo '<h1 style="margin-top: 5rem;">No Organizations found!</h1>';
    }
    else {
      echo '<div class="table-responsive">';
      echo '<table class="table" style="border:1px solid black;margin-left:auto;margin-right:auto;">';
          echo '<thead>';
              echo '<tr>';
                  echo '<th style="width:40%">Phone Number</th>';
                  echo '<th style="width:20%"></th>';
                  echo '<th style="width:20%"></th>';
              echo '</tr>';
          echo '</thead>';
          echo '<tbody>';

      while($row = mysqli_fetch_row($result)) {
          echo '<tr>';
          echo '<td>' . $row[0] . '</td>';
          echo '<td>';
          echo '<a type="button" href="./update_phone.php?id=' . $row[0]. '">';
          echo '<i class="fa fa-edit"></i>' . 'Edit';
      echo '</a>';
  echo '</td>';
  echo '<td>';
          echo '<a type="button" href="./delete_phone.php?id=' . $row[0]. '">';
          echo '<i class = "fa fa-trash"></i>' . 'Delete';
      echo '</a>';
  echo '</td>';
      echo '</tr>';                
  }
  echo '</tbody>';
  echo '</table>';
echo '</div>';
                
                        
    }

    ?>

</body>

    </div>
    </body>
</html>