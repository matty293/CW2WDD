<?php

include "pdo.php";


echo "<html><body>";
echo "<form action='sites.php' method='post'>";
echo "<select name='site_type'>";

$result = $pdo->query("SELECT Name FROM Users ORDER BY Name");

while ($row = $result->fetch()) {
    $name = $row["Name"];
    if ($name == $selected_site_type) {
      $option = "<option selected>";
    } else {
      $option = "<option>";
    }
    echo $option . $type . "</option>";
  }

echo "</select>";
echo "<input type='submit' value='Submit'>";
echo "</form>";
  
if ($selected_site_type) {
    echo "<table border = 1>";                                            
    echo "<tr><th align='left'>Site Name</th>";
       
    $stmt = $pdo->prepare("SELECT Name,Sites_Name,Rating FROM User,UserVisits,Sites WHERE Users.Email_Address = UserVisits.Email_Address AND Sites.Site_ID = UserVisits.Site_ID Name = ? ORDER BY Rating");
    $stmt->execute([$selected_site_type]);
  
    while ($row = $stmt->fetch()) {
      echo "<tr><td>" . $row["Name"] . "</td><tr><td>" . $row["Site_Name"] . "</td><tr><td>" . $row["Rating"] . "</td>";
    }
  }
  
  echo "</table>";
  echo "</body></html>";
?>