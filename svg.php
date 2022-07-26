<?php

ini_set('max_execution_time', '300');

//$threshold = htmlspecialchars($_GET['threshold']);


include('simple_html_dom.php');


    //for batch pages
    //$sql = "select id, url from externalPages WHERE ID BETWEEN $threshold";
    //$sql = "select id, url from externalPages WHERE ID IN(695,698,1136,1452)";

    //$result = $conn->query($sql);

    //ADD URL
    $url = "reactors/research-reactors/other-reactor-facilities/nuclear-power-demonstration.cfm";
          //$ID = $row['id'];

      $myURL = "https://www.nuclearsafety.gc.ca/eng/".$url;
      $html = file_get_html($myURL);
      //$name = $ID;

      //use title of page if this is blank - only for inforgraphics
      /* if ($html->find('title[id="title"]',0)){
      strip_tags($html->find('h1[id="wb-cont"]',0));
      } */ 

      if ($html->find('h1[id="wb-cont"]',0)){
        $title = strip_tags($html->find('h1[id="wb-cont"]',0));
        }

      
      //if it doesn't exist do not use - only for infographics
      /* if ($html->find('desc[id="desc"]',0)){
      $description = strip_tags($html->find('desc[id="desc"]',0));
      } */
      $content = $html->find('div[id="wb-main-in"]',0);
      //echo "SVG:" . $content;

    //$status = 1;

    if ($html->find('time',0)){
    $modified = $html->find('time',0)->plaintext;
    }

    //modify $myURL into path
    $path = rtrim(str_replace('https://www.nuclearsafety.gc.ca','',$myURL), '.cfm');
    $translation_path = str_replace('/eng/','/fra/',$path);

    //get URL and switch to French
    $translation_myURL = str_replace('/eng/','/fra/',$myURL);
    //echo $translation_myURL;
    $translation_html = file_get_html($translation_myURL);
    //$translation_title = strip_tags($translation_html->find('h1[id="wb-cont"]',0));

    if ($translation_html->find('h1[id="wb-cont"]',0)){
        $translation_title = strip_tags($translation_html->find('h1[id="wb-cont"]',0));
        }


    //echo $translation_title;
    //$translation_description = strip_tags($translation_html->find('desc[id="desc"]',0));
    //echo $translation_description;
    //$translation_content = $translation_html->find('div[class="svgConteiner"]',0);
    $translation_content = $translation_html->find('div[id="wb-main-in"]',0);
    
    //$content = str_replace('https://www.nuclearsafety.gc.ca/','/',$content);
    //$translation_content = str_replace('https://www.nuclearsafety.gc.ca/','/',$translation_content);
    //$title = str_replace(array_keys($characters), $characters, $title);
    //$translation_title = str_replace(array_keys($characters), $characters,  $translation_title);
   
    //$content = trim($content);
 
    $translation_content = trim($translation_content);

    $target_directory = "./wwwroot";

    $incoming_path = $target_directory . $path;
    $page_name = $url;
    echo "Basename: " . (basename($page_name, ".cfm"));
    //echo "<br>";
    $page_name = (basename($page_name, ".cfm"));
    $page_name = "/" . $page_name;

    //remove filename from incoming path
    $incoming_path = pathinfo($incoming_path, PATHINFO_DIRNAME);
    echo "<br>Path: " . $incoming_path;
    createDirectoryStructure($page_name,$incoming_path);


    $HTML=$incoming_path . $page_name.'.html';
    $languageToggle = $incoming_path . $page_name;
    $languageToggle = str_replace('./wwwroot/eng','/fra',$languageToggle);
    $languageToggle = str_replace('/index','/',$languageToggle);

    //$language = "en";
   
    
    $handlehtml=fopen($HTML, 'w');
    $loadhtml='
            <!doctype html>
            <html lang="en">
            <head>
            <title>'.$title.'</title>
            </head>
            <body>

            <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
            <h2 class="wb-inv">Language selection</h2>
            <ul class="list-inline mrgn-bttm-0">
                         <li>
                                       <a lang="fr" hreflang="fr" href="'.$languageToggle.'">
                                                     <span class="hidden-xs">Français</span>
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
            <dt>Date modified:</dt>
            <dd><time property="dateModified">'.$modified.'</time></dd>
            </dl>
            </div>
            </main>
            </body>
            </html>';


 
    
    fwrite($handlehtml, $loadhtml);
    //echo $loadhtml;

    //echo "FRENCH START";
    //french page
        $HTML=$incoming_path . $page_name.'.html';
        
        $HTML = str_replace('/eng/','/fra/',$HTML);
         echo "<br>" . $HTML;
        $languageToggle = $HTML;
        $languageToggle = str_replace('./wwwroot/fra','/eng',$languageToggle);
        $languageToggle = str_replace('/index','/',$languageToggle);


    $handlehtml=fopen($HTML, 'w');
        $loadhtml='
                <!doctype html>
                <html lang="fr">
                <head>
                <title>'.$translation_title.'</title>
                </head>
                <body>

                <section id="wb-lng" class="col-xs-3 col-sm-12 pull-right text-right">
                <h2 class="wb-inv">Language selection</h2>
                <ul class="list-inline mrgn-bttm-0">
                             <li>
                                           <a lang="en" hreflang="en" href="'.$languageToggle.'">
                                                         <span class="hidden-xs">English</span>
                                                         <abbr title="English" class="visible-xs h3 mrgn-tp-sm mrgn-bttm-0 text-uppercase">en</abbr>

                                           </a>
                             </li>
                </ul>
                </section>
  
                
                <main class="container" property="mainContentOfPage" resource="#wb-main" typeof="WebPageElement">
                <h1 id="wb-cont" property="name">'.$translation_title.'</h1>'
                .$translation_content.
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
       


function createDirectoryStructure($page_name,$path_to_directory) {
if (!file_exists($path_to_directory)) {
// deepcode ignore PT: <please specify a reason of ignoring this>
mkdir($path_to_directory, 0777, true);
//add page    
}
}

?>