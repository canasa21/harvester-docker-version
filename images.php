<?php 

include('simple_html_dom.php');

include('include/db.php');

$sql = "select id, url from externalPages WHERE id IN(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20)";

    $result = $conn->query($sql);

    while($row = $result->fetch_array())
    {

        $myURL = $row['url'];

$html = file_get_html($myURL);

$images = array();
    foreach($html->find('img') as $img){
        $images[] = $img->src.PHP_EOL;
    }

    //print_r($images);

    file_put_contents('images.txt',$images,FILE_APPEND);

    }
    $conn->close();

    ?>