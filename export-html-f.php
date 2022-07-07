<?php

//define root folder

$target_directory = "./wwwroot";

include('include/db.php');


$sql = "select link, path, translation_title, translation_content, modified, translation_language, translation_path from content_both_top_500";
    $result = $conn->query($sql);

//select paths

//loop through records
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $incoming_path = $target_directory . $row['translation_path'];
        $page_name = $row['link'];
        echo "Basename: " . (basename($page_name, ".cfm"));
        echo "<br>";
        $page_name = (basename($page_name, ".cfm"));
        $page_name = "/" . $page_name;

        //remove filename from incoming path
        $incoming_path = pathinfo($incoming_path, PATHINFO_DIRNAME);
        echo "Path: " . $incoming_path;
        createDirectoryStructure($page_name,$incoming_path);

        $title = $row['translation_title'];
        $content = $row['translation_content'];
        $language = $row['translation_language'];
        $modified = $row['modified'];
        $translation_path = $row['path'];
       
        $title = htmlspecialchars_decode($row["translation_title"], ENT_QUOTES);
        $content = htmlspecialchars_decode($row["translation_content"], ENT_QUOTES);

        include('gatsby.php');
        $content = str_replace(array_keys($gatsby), $gatsby, $content);

        $content = preg_replace('/(<[^>]*) style=("[^"]+"|\'[^\']+\')([^>]*>)/i', '$1$3', $content);
        $content = preg_replace('/className="\s*?"/','',$content);
        $content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
        //add breaks
        $content = preg_replace('#\s{4,}#', PHP_EOL, $content);
        $content = preg_replace('#((<\/div>)\s*){3}$#','',$content);
        //remove inline styles
        //$content = preg_replace('#style="[^\"]*"#','',$content);
  
        $HTML=$incoming_path . $page_name.'.html';
        $languageToggle = $incoming_path . $page_name;
        $languageToggle = str_replace('./wwwroot/fra','/eng',$languageToggle);
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

                <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
                <h2 class="wb-inv">Language selection</h2>
                <ul class="list-inline mrgn-bttm-0">
                             <li>
                                           <a lang="en" hreflang="en" href="'.$languageToggle.'">
                                                         <span class="hidden-xs">English</span>
                                                         <abbr title="Français" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">fr</abbr>
                                           </a>
                             </li>
                </ul>
                </section>
  
                
                <main class="container" property="mainContentOfPage" resource="#wb-main" typeof="WebPageElement">
                <h1 id="wb-cont" property="name">'.$title.'</h1>'
                .$content.
                '<div class="wet-boew-share"></div>
                <div class="pagedetails">
                <dl id="wb-dtmd">
	            <dt>Derni&egrave;re mise &agrave; jour :</dt>
	            <dd><time property="dateModified">'.$modified.'</time></dd>
	            </dl>
                </div>
                </main>
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