<style type="text/css">
* { font-family: helvetica;
    font-size: .9rem;}

  table {
  border:2px solid #999;
  width: 100%;
    }
td {
    border-bottom:1px solid #999;
    padding:3px;
}
th {
    text-align:center;
}
</style>

<?php

include('include/db.php');


  $sql = "SELECT link, title, content, translation_content FROM content_both_top_500 WHERE content='' OR translation_content=''";
  $result = $conn->query($sql);

  echo "<table>";
  echo "<tr><th>Page</th><th>English</th><th>French</th></tr>";

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td><a href=\"" . $row['link'] . "\" target=\"_blank\">" . $row['title'] . "</a></td>";
        if ($row['content'] != ""){
        echo "<td>Yes</td>";  
        }else{
            echo "<td>No</td>";
        }
        if ($row['translation_content'] != ""){
            echo "<td>Yes</td>";  
        }else{
            echo "<td>No</td>";
        }
        echo "</tr>";
        
      }
    } else {
      echo "0 results";
    }
    
    $conn->close();
    echo "</table>";
?> 
