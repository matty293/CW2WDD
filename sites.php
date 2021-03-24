<?php

//include "dbConn.php";
include "pdo.php";
$selected_site_type = $_POST["category"];

echo "<html><body>";
echo "<form action='sites.php' method='post'>";
echo "<select name='category'>";

$result = $pdo->query("SELECT DISTINCT category FROM sites");

while ($row = $result->fetch()) {
  $type = $row["category"];
  if ($type == $selected_site_type) {
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
  echo "<tr><th align='left'>Site Name</th><th align='left'>City</th><th align='left'>Country</th><th align='left'>Visa Required</th></tr>";
     
  $stmt = $pdo->prepare("SELECT Sname, sites.city, Cname, visa FROM countries,cities,sites WHERE Cname = cities.country AND sites.city = cities.name AND category = ?");
  $stmt->execute([$selected_site_type]);

  while ($row = $stmt->fetch()) {
    echo "<tr><td>" . $row["Sname"] . "</td><td>" . $row["city"] . "</td><td>" . $row["Cname"] . "</td><td>" . $row["visa"] . "</td></tr>";
  }
  
}

echo "</table>";
echo "</body></html>";

?>