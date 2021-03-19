<?php

include "pdo.php";

$selected_site_type = $_POST["site_type"];

echo "<html><body>";
echo "<form action='sites.php' method='post'>";
echo "<select name='site_type'>";

$result = $pdo->query("SELECT DISTINCT type FROM Site ORDER BY type");

while ($row = $result->fetch()) {
  $type = $row["type"];
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
  echo "<table border = 1>";                                               //added code underneath
  echo "<tr><th align='left'>Site Name</th><th align='left'>City</th></tr><th align='left'>Country</th></tr><th align='left'>Visa Required</th></tr>";
      //updated the query below
  $stmt = $pdo->prepare("SELECT Site_Name, City_Name, Country_Name, Visa FROM Countries,Cities,Sites WHERE Countries.Country_Name = Cities.Country_Name AND Sites.City_Name = Cities.City_Name AND type = ?");
  $stmt->execute([$selected_site_type]);

  while ($row = $stmt->fetch()) {
    echo "<tr><td>" . $row["Site_Name"] . "</td><td>" . $row["City_Name"] . "</td><td>" . $row["Country_Name"] . "</td><td>" . $row["Visa"] . "</td></tr>";
  }
}

echo "</table>";
echo "</body></html>";

?>