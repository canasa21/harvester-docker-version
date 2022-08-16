<?php 

$threshold = htmlspecialchars($_GET['threshold']);
include('simple_html_dom.php');
include('include/db.php');
$sql = "select id, url from allPages WHERE id BETWEEN $threshold";
    $result = $conn->query($sql);
    while($row = $result->fetch_array())
    {
        $myURL = $row['url'];

        //check if url is good
        $page_headers = @get_headers($myURL);
        if(!$page_headers || $page_headers[0] == 'HTTP/1.1 500 Internal Server Error'){
            $bad = $myURL.PHP_EOL;
            file_put_contents('bad.txt','500 ' . $bad,FILE_APPEND);
        }
        elseif(!$page_headers || $page_headers[0] == 'HTTP/1.1 400 Bad Request'){
            $bad = $myURL.PHP_EOL;
            file_put_contents('bad.txt','400 ' . $bad,FILE_APPEND);
        }
        elseif(!$page_headers || $page_headers[0] == 'HTTP/1.1 404 Not Found'){
            $bad = $myURL.PHP_EOL;
            file_put_contents('bad.txt','404 ' . $bad,FILE_APPEND);
        }
        else{
            $html = file_get_html($myURL);
            $images = array();
            foreach($html->find('img') as $img){
                $images[] = $img->src.PHP_EOL;
            }
        $name = 'images' . $threshold . 'txt';
        file_put_contents($name,$myURL.PHP_EOL,FILE_APPEND);    
        file_put_contents($name,$images,FILE_APPEND);
        }
    }
    $conn->close();

    echo ("<script>");
      echo ('setTimeout("location.href = \'index.php\';",1500);');
      echo ("</script>");
?>