<?php

include "pdo.php";
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//if(isset($selected_user)){
  $selected_user = $_POST["email_address"];
//}
echo "<html><body>";
echo "<form action='users.php' method='post'>";
echo "<select name='email_address'>";

$result = $pdo->query("SELECT email_address FROM users");

while ($row = $result->fetch()) {
    $name = $row["email_address"];
    if ($name == $selected_user) {
      $option = "<option selected>";
    } else {
      $option = "<option>";
    }
    echo $option . $name . "</option>";
  }

echo "</select>";
echo "<input type='submit' value='Submit'>";
echo "</form>";

if ($selected_user) {
    echo "<table border = 1>";                                            
    echo "<tr><th align='left'>Name</th><th align='left'>Site Name</th><th align='left'>Rating</th></tr>";
       
    $stmt = $pdo->prepare("SELECT users.name,Sname,user_visits.rating FROM users,user_visits,sites WHERE users.email_address = user_visits.email_address AND sites.siteid = user_visits.siteid AND users.email_address = '$selected_user' ORDER BY rating");
    $stmt->execute();
  
    while ($row = $stmt->fetch()) {
      echo "<tr><td>" . $row["name"] . "</td><td>" . $row["Sname"] . "</td><td>" . $row["rating"] . "</td>";
    }
  }
  
  echo "</table>";
  echo "</body></html>";
?>