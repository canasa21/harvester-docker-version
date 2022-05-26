<html>

<style type="text/css">
* { font-family: helvetica;
    font-size: 1rem;}

  table {
  border:1px solid #999;
  width: 100%;
    }
td {
    border-bottom:1px solid #999;
    line-height: 3rem;
}
th {
    text-align:left;
}

.pagination {
	margin-bottom: 100px;
}

.pagination li {
	padding: 5px 10px;
	display: inline-block;
	float: left;
	background: #fff;
	color: #888;
	margin-right: 1px;
	-webkit-box-shadow:  0px 1px 1px 0px rgba(180, 180, 180, 0.1);
	box-shadow:  0px 1px 1px 0px rgba(180, 180, 180, 0.1);
	-webkit-transition: all 0.1s ease-in-out;
	-moz-transition: all 0.1s ease-in-out;
	-o-transition: all 0.1s ease-in-out;
	-ms-transition: all 0.1s ease-in-out;
	transition: all 0.1s ease-in-out;
}

.ie7 .pagination li {margin-right: 5px;}

li.current {
	background: #72b626;
	border: 1px solid #72b626;
	color: #fff;
}

.button {
  text-decoration: none;
  background-color: #EEEEEE;
  color: #000;
  padding: 8px;
  border: 1px solid #CCCCCC;
  border-radius: 5px;
 
}


.buttonAction {
  text-decoration: none;
  background-color: #666;
  color: #fff;
  padding: 8px;
  border: 1px solid #000;
  border-radius: 5px;
  cursor: pointer;
}

.buttonAction:hover {
  color: #000;
  background-color: #ddd;
  cursor: pointer;
}

.buttonExport {
  text-decoration: none;
  background-color: #336699;
  color: #fff;
  padding: 18px;
  border: 1px solid #000;
  border-radius: 5px;
  font-size: 1.2rem;
  cursor: pointer;
  
}

.buttonExport:hover {
  color: #000;
  background-color: #ddd;
  cursor: pointer;
}

select {
  text-decoration: none;
  background-color: #ddd;
  color: #000;
  padding: 18px;
  border: 1px solid #000;
  border-radius: 5px;
  font-size: 1.2rem;
  
}
a:hover {
  color: #000;
  background-color: #ddd;
}
.trigger, .result, .log {
  display: inline;
}

</style>
<body>

    <p style="padding-top:30px;padding-bottom:30px;"><a class="buttonExport" href="top500.php">Main</a> <a class="buttonExport" href="upload.php">Upload URLs</a> <a class="buttonExport" href="export-js.php">Export English Pages</a> <a class="buttonExport" href="export-js-f.php">Export French Pages</a><p><a class="buttonExport" href="export-html.php">Export HTML English Pages</a> <a class="buttonExport" href="export-html-f.php">Export HTML French Pages</a></p>
    <form id="batch" action="start.php" style="margin-top: 30px;">

    <?php
    echo "<select name=\"threshold\" id=\"threshold\">";
for ($i = 1; $i <= 2410; $i += 50)
{
    $j = $i + 49;
    echo "<option value=\" $i AND $j \">$i to $j</option>";
}
echo "</select>";
?>
  <input class="buttonExport" id="batch" value="Batch Process" type="submit"></form></p>
 </p>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>


      $(document).ready(function() {


            $("form[name=singlePage]").submit(function(event) {

     
            event.preventDefault();
            var idData = $(this).closest('form').find('input[name=id]').val();
            var urlData = $(this).closest('form').find('input[name=addy]').val();
            //urlData = urlData.replace('addy=','');
            console.log("url data: " + urlData);
            //alert(urlData.toString());

          $.ajax({

           type: 'POST',
            url: 'force-csv.php',
            data: {
                'url': urlData,
                'id' : idData
            },
            success: function (data) {
                returnedvalue = data;
                console.log(data);

               
                    location.reload();
                 

                  }
          });
          return false;
        });   
     
});




    </script>



<?php




  if ( isset( $_GET[ 'pageno' ] ) ) {
    $pageno = $_GET[ 'pageno' ];
  } else {
    $pageno = 1;
  }
  $no_of_records_per_page = 200;
  $offset = ( $pageno - 1 ) * $no_of_records_per_page;

  include('include/db.php');


  $total_pages_sql = "SELECT COUNT(*) FROM externalPages";
  $resultCount = mysqli_query( $conn, $total_pages_sql );
  $total_rows = mysqli_fetch_array( $resultCount )[ 0 ];
  $total_pages = ceil( $total_rows / $no_of_records_per_page );


  $sql = "select id, url from externalPages LIMIT $offset, $no_of_records_per_page";
    $result = $conn->query($sql);

  echo "<p><b>Total number of records: </b>" . $total_rows . "</p>";

  $sql_ids = "select name from content_both_top_500";
  $dataset = $conn->query($sql_ids);
  $page_ids = array();
  while($row = $dataset->fetch_assoc()){
    $page_ids[] = $row['name'];
  }
  

  ?>

<ul class="pagination">
    <li><a class="button" href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>"> <a class="button" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=" .($pageno - 1); } ?>">Prev</a> </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"> <a class="button" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=" .($pageno + 1); } ?>">Next</a> </li>
    <li><a class="button" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
  </ul>

<?php

    
    echo "<table>";

    if ($result->num_rows > 0) {
   
      while($row = $result->fetch_assoc()) {

        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td><a href=\"" . $row['url'] . "\" target=\"_blank\">" . $row['url'] . "</a></td>";


        if (isset($row['id']) && in_array($row['id'],$page_ids)){
          echo "<td style=\"background-color: #336699;padding:4px;color:#fff;text-align:center;\">Complete</td>";
        }else{
          echo "<td style=\"background-color: #dd0000;padding:4px;color:#fff;text-align:center;\">No data</td>";
        }
       
       echo "</tr>";
        
      }
    } else {
      echo "0 results";
    }
    
    $conn->close();
?> 
</table>

<ul class="pagination">
    <li><a class="button" href="?pageno=1">First</a></li>
    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>"> <a class="button" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=" .($pageno - 1); } ?>">Prev</a> </li>
    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>"> <a class="button" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=" .($pageno + 1); } ?>">Next</a> </li>
    <li><a class="button" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
  </ul>
  <script>
$('.js-selectall').on('change', function() {
  var isChecked = $(this).prop("checked");
  var selector = $(this).data('target');
  $(selector).prop("checked", isChecked);
});



</script>
</body>
</html>