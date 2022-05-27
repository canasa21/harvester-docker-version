<?php

if (isset($_POST["upload"])) {

 
  include('include/db.php');

  
    
    print_r($_FILES);
  

      $handle = fopen( $_FILES[ 'file' ][ 'tmp_name' ], "r+" );
     
      while ( $data = fgetcsv( $handle ) ) {
        
        $item1 = mysqli_real_escape_string( $conn, $data[ 0 ] );
          

        $sql = "INSERT INTO externalPages (url)" . " VALUES ('$item1')";
   
        
        mysqli_query( $conn, $sql );

      }
      
    
      fclose( $handle );

      header("Location: index.php");

  
}

?>


<html>
<!-- Alex was here on October 18, 2021 -->
<!-- 1:15 PM -->
<style type="text/css">
* { font-family: helvetica;
    font-size: 1rem;}

  table {
  border:1px solid #999;
  width: 100%;
    }
td {
    border-bottom:1px solid #999;
}
th {
    text-align:left;
}

.pagination {
	margin-bottom: 100px;
}

.pagination li {
	padding: 5px 10px;
	/*border: 1px solid #ddd;*/
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

</style>
<body>




    <form method="post" name="upload_mysql" enctype="multipart/form-data">
            <input type="file" name="file" accept=".csv" id="file" class="buttonExport">
            <button type="submit" id="submit" name="upload" class="buttonExport" data-loading-text="Loading...">Upload URLs</button>
          </div>
        </form>
      

</body>
</html>