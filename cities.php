<?php

include "pdo.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//if(isset($selected_user)){
  $selected_city = $_POST["name"];
//}
echo "<html><body>";
echo "<form action='cities.php' method='post'>";
echo "<select name='name'>";

$result = $pdo->query("SELECT name FROM cities");

while ($row = $result->fetch()) {
    $name = $row["name"];
    if ($name == $selected_city) {
      $option = "<option selected>";
    } else {
      $option = "<option>";
    }
    echo $option . $name . "</option>";
  }

echo "</select>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if ($selected_city) {
    echo "<table border = 1>";                                            
    echo "<tr><th align='left'>Site Name</th><th align='left'>Average Rating</th></tr>";
       
    $stmt = $pdo->prepare("SELECT Sname, 
                            (SELECT avg(rating) AS avRating from user_visits,sites,cities where sites.city = cities.name AND sites.siteid = user_visits.siteid) AS avRating
                            FROM sites,user_visits,cities
                            WHERE cities.name = sites.city AND cities.name = ?
                            GROUP BY Sname");
    $stmt->execute([$selected_city]);
  
    while ($row = $stmt->fetch()) {
      echo "<tr><td>" . $row["Sname"] . "</td><td>" . $row["avRating"] . "</td>";
    }
  }
  
  echo "</table>";
  echo "</body></html>";
?>