<?php

//define root folder

$target_directory = "./wwwroothtml";

include('include/db.php');


$sql = "select link, path, title, content, modified, language, translation_path from content_both_top_500";
    $result = $conn->query($sql);

//select paths

//loop through records
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $incoming_path = $target_directory . $row['path'];
        $page_name = $row['link'];
        echo "Basename: " . (basename($page_name, ".cfm"));
        echo "<br>";
        $page_name = (basename($page_name, ".cfm"));
        $page_name = "/" . $page_name;

        //remove filename from incoming path
        $incoming_path = pathinfo($incoming_path, PATHINFO_DIRNAME);
        echo "Path: " . $incoming_path;
        createDirectoryStructure($page_name,$incoming_path);

        $title = $row['title'];
        $content = $row['content'];
        $language = $row['language'];
        $modified = $row['modified'];
        $translation_path = $row['translation_path'];

        $title = htmlspecialchars_decode($row["title"], ENT_QUOTES);
        $content = htmlspecialchars_decode($row["content"], ENT_QUOTES);

        include('gatsby.php');
        $content = str_replace(array_keys($gatsby), $gatsby, $content);
        
        //$content = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $content);
        $content = preg_replace('/className="\s*?"/','',$content);
        $content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
        //add breaks
        $content = preg_replace('#\s{4,}#', PHP_EOL, $content);
        $content = preg_replace('#((<\/div>)\s*){3}$#','',$content);
        //remove inline styles
        //$content = preg_replace('#style="[^\"]*"#','',$content);
     
        $HTML=$incoming_path . $page_name.'.html';
        $languageToggle = $incoming_path . $page_name;
        $languageToggle = str_replace('./wwwroot/eng','/fra',$languageToggle);
        $languageToggle = str_replace('/index','/',$languageToggle);
        //$HTML=$path_to_directory . '.html';
        // deepcode ignore PT: <please specify a reason of ignoring this>
        $handlehtml=fopen($HTML, 'w');
        $loadhtml='
                <!doctype html>
                <html lang="'.$language.'">
                <head>
                <title>'.$title.'</title>
                </head>
                <body>
                <li id="gcwu-gcnb-lang"><a href="'.$languageToggle.'" lang="fr">Fran&ccedil;ais</a></li>
                <h1>'.$title.'</h1>
                <main>'
                .$content.
                '</main><dl id="gcwu-date-mod">
	            <dt>Date modified:</dt>
	            <dd><span><time>'.$modified.'</time></span></dd>
	            </dl>
                </body>
                </html>';

  
     
        
        fwrite($handlehtml, $loadhtml);


    }
}

$conn->close();


function createDirectoryStructure($page_name,$path_to_directory) {
if (!file_exists($path_to_directory)) {
    // deepcode ignore PT: <please specify a reason of ignoring this>
    mkdir($path_to_directory, 0777, true);
    //add page    
    }
}


echo ("<script>");
echo ('setTimeout("location.href = \'index.php\';",1500);');
echo ("</script>");


?>