<?php

$target_directory = "./wwwroot";

include('include/db.php');


$sql = "select link, path, translation_title, translation_content, modified, translation_language, translation_path from content_both_top_500";
    $result = $conn->query($sql);


if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $incoming_path = $target_directory . $row['translation_path'];
        $page_name = $row['link'];
        echo "Basename: " . (basename($page_name, ".cfm"));
        echo "<br>";
        $page_name = (basename($page_name, ".cfm"));
        $page_name = "/" . $page_name;

      
        $incoming_path = pathinfo($incoming_path, PATHINFO_DIRNAME);
        echo "Path: " . $incoming_path;
        createDirectoryStructure($incoming_path);

        $title = $row['translation_title'];
        $content = $row['translation_content'];
        $language = $row['translation_language'];
        $modified = $row['modified'];
        $translation_path = $row['path'];
       
        $title = htmlspecialchars_decode($row["translation_title"], ENT_QUOTES);
        $content = htmlspecialchars_decode($row["translation_content"], ENT_QUOTES);

        include('gatsby.php');
        $content = str_replace(array_keys($gatsby), $gatsby, $content);

        
        $content = preg_replace('/className="\s*?"/','',$content);
        $content = preg_replace('/<!--(.|\s)*?-->/', '', $content);
        //add breaks
        $content = preg_replace('#\s{4,}#', PHP_EOL, $content);
        $content = preg_replace('#((<\/div>)\s*){3}$#','',$content);
       
  
        $HTML=$incoming_path . $page_name.'.js';
        $languageToggle = $incoming_path . $page_name;
        $languageToggle = str_replace('./wwwroot/fra','/eng',$languageToggle);
        $languageToggle = str_replace('/index','/',$languageToggle);
       
        $handlehtml=fopen($HTML, 'w');
        $loadhtml='import React from "react"
        import Layout from "/src/components/Layout"

        export default function pageName({ pageContext }) {

            pageContext.layout = {

                language: "' . $language . '",
                pageTitle: "' . $title . '", 
                dateModified: "' . $modified . '",
                langToggleUrl: "'. $languageToggle .'"
        
            };


            return (
                <>
                    <Layout pageContext={pageContext}>
                    {/*MAIN CONTENT START*/}
                    ' . $content . '
                    {/*MAIN CONTENT END*/}
                    </Layout>
                </>
            )
        }';


  
     
        
        fwrite($handlehtml, $loadhtml);


    }
}

$conn->close();


function createDirectoryStructure($path_to_directory) {
if (!file_exists($path_to_directory)) {
    // deepcode ignore PT: <please specify a reason of ignoring this>
    mkdir($path_to_directory, 0777, true);
    //add page    
    }
}

echo "<script>";
echo 'setTimeout("location.href = \'index.php\';",1500);';
echo "</script>";

?>