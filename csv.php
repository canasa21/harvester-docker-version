<?php

//do a batch of files at once - 25 at a time


//function updateImgPath(){

//$drupalPath = "sites/default/files/";

//if (preg_match('%<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"%s', $subject, $regs)) {
  //$image = $regs[1];
//} else {
  //$image = "";
//}
//}

    include('simple_html_dom.php');
    $ID = $_POST['id'];

    $myURL = $_POST['url'];
    $html = file_get_html($myURL);
    //echo $html;
    $name = $ID;
    //$title = $html->find('title', 0)->plaintext;
    $title = strip_tags($html->find('h1[id="wb-cont"]',0));
    //$heading = $html->find('h1[id="wb-cont"]',0);

    $breadcrumbs = $html->find('div[id="gcwu-bc"]',0);
    //echo($breadcrumbs);
    $content = $html->find('div[id="wb-main"]',0);
    //echo($content);
    //if(is_null($content)){
      //$content = $html->find('div[class="span-6"]',0);
      //echo($content);
    //}

    //echo $content;
    $status = 1;
    $modified = $html->find('time',0)->plaintext;


    //modify $myURL into path
    $path = rtrim(str_replace('https://www.nuclearsafety.gc.ca','',$myURL), '.cfm');
    $translation_path = str_replace('/eng/','/fra/',$path);

    //get URL and switch to French
    $translation_myURL = str_replace('/eng/','/fra/',$myURL);
    $translation_html = file_get_html($translation_myURL);
    $translation_title = strip_tags($translation_html->find('h1[id="wb-cont"]',0));
    //$translation_heading = $translation_html->find('h1[id="wb-cont"]',0);
    $translation_breadcrumbs = $translation_html->find('div[id="gcwu-bc"]',0);
    $translation_content = $translation_html->find('div[id="wb-main"]',0);

    $content = str_replace('https://www.nuclearsafety.gc.ca/','/',$content);
    $translation_content = str_replace('https://www.nuclearsafety.gc.ca/','/',$translation_content);
    //modify myURL into language
    //if (strpos($myURL, '/eng/') !== false) {
    //  $language = 'en';
    //}

    //if (strpos($translation_myURL, '/fra/') !== false) {
    //  $$translation_language = 'fr';
    //}


    //$image = $content->find('img',0);

    //foreach($content->find('img') as $element){
      // echo $element->src . '<br>';
       //echo (basename($element));
       //if(isset($alttext->alt)){
        //echo $element->alt . '<br>';
      //}
    //}
    //echo $title;
    //echo $translation_title;
    //$title = str_replace('&nbsp;', ' ', $title);
    include('characters.php');
    $title = str_replace(array_keys($characters), $characters, $title);
    //echo "ENG: " . $title . PHP_EOL;


    $translation_title = str_replace(array_keys($characters), $characters,  $translation_title);
    //echo  "FRA: " . $translation_title . PHP_EOL;;
    //echo " ";
    //echo $modified;
    //echo $image; 

    
    //<a href="/eng/pdfs/Discussion-Papers/21-03/Discussion_Paper_DIS-21-03__Cyber_Security_and_the_Protection_of_Digital_Information.pdf
    //$content = preg_replace('#(\s.*?)=".*?/?([^/]+?(\.pdf|\.doc|\.xls|\.ppt|\.zip))"#s', '$1="sites/default/files/$2"', $content); 
    //$content = preg_replace('href="(.*?)(\.pdf|\.doc|\.xls|\.ppt|\.zip))"', 'href="sites/default/files/$2"', $content); 

     //   if (preg_match('#<a\s.*?href=".*?/?([^/]+?(\.pdf))"#s', '<a href="https://www.nuclearsafety.gc.ca/eng/pdfs/Discussion-Papers/21-03/Discussion_Paper_DIS-21-03__Cyber_Security_and_the_Protection_of_Digital_Information.pdf">DIS-21-03 | PDF, 40 pages, 1.10 MB</a>')){
       //     echo('Match!');
         //   $pdf = preg_replace('#<a\s.*?href=".*?/?([^/]+?(\.pdf))"#s', '<a href="sites/default/files/$1"', '<a href="https://www.nuclearsafety.gc.ca/eng/pdfs/Discussion-Papers/21-03/Discussion_Paper_DIS-21-03__Cyber_Security_and_the_Protection_of_Digital_Information.pdf">DIS-21-03 | PDF, 40 pages, 1.10 MB</a>');
           // echo $pdf;
          //}
        
   //$content = preg_replace('#<a\s.*?href=".*?/?([^/]+?(\.pdf))"#s', '<a href="sites/default/files/$1"', $content); 
    //echo $content;
    //<div id="wb-core">
	  //<div id="wb-core-in" class="equalize">
    //<div id="wb-main" role="main"><div id="wb-main-in">	
    //<h1 id="wb-cont">The CNSC's Regulatory Framework Plan</h1>
    //<div class="span-6">
    $content = str_replace('<div id="wb-core">', '', $content);
    //echo $content;


    $content = str_replace('<div id="wb-core-in" class="equalize">', '', $content);
    //echo $content;
    $content = str_replace('<div id="wb-main-in">', '', $content);
    $content = str_replace('<div id="wb-main" role="main">', '', $content);
    $content = str_replace('<div class="span-6">', '', $content);
    $content = str_replace('<div class="span-8">', '', $content);
    $content = preg_replace('#<h1 id="wb-cont">(.*?)<\/h1>#', '', $content);

    //clean breadcrumbs
    $breadcrumbs = str_replace('<div id="gcwu-bc">', '', $breadcrumbs);
    $breadcrumbs = str_replace('<h2>Breadcrumb trail</h2>', '', $breadcrumbs);
    $breadcrumbs = str_replace('<div id="gcwu-bc-in">', '', $breadcrumbs);
    $breadcrumbs = str_replace('<ol>', '', $breadcrumbs);
    $breadcrumbs = str_replace('</ol>', '', $breadcrumbs);
    $breadcrumbs = str_replace('</div>', '', $breadcrumbs);
    $breadcrumbs = str_replace('</div>', '', $breadcrumbs);
    $breadcrumbs = trim($breadcrumbs);
    //remove absolute paths


    //echo "img: ".$content; 
    $content = preg_replace('#<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '<img src="./images/$1"', $content);  
    //echo ("image on");
    //$content = preg_replace('%<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"%s', '<img src="sites/default/files/$1"', $content); 
    $content = preg_replace('#(\s.*?)poster=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '$1poster="./images/$2"', $content); 
    //echo ("poster on");
     
   //echo ("pdf on");
        //echo $content;
        //clean content
        //include('wet4.php');
        //var_dump(json_decode($json));
        //var_dump(json_decode($json, true));

    include('replacements.php');
    //$replacements = json_decode($json, true);
    //var_dump($replacements);
    $content = str_replace(array_keys($replacements), $replacements, $content);
    //echo ("<h1>".$i." WET replcaements</h1>");
    include('removals.php');
    $content = str_replace(($removals), '', $content);
    //remove share
    //<div class="wet-boew-share span-5 margin-bottom-none" data-wet-boew="{'sites': ['bit.ly', 'blogger', 'del.icio.us', 'digg', 'diigo', 'facebook', 'google', 'hotmail', 'linkedin', 'newsvine', 'reddit', 'stumbleupon', 'technorati', 'tumblr', 'twitter', 'yahoobuzz'],addAnalytics:true, analyticsName:'/share/{r}/{s}'}"></div>
    $content = preg_replace('#<div class="wet-boew-share(.*?)</div>#', '', $content);
    $content = preg_replace('#<dl id="gcwu-date-mod(.*?)</dl>#', '', $content);
    $content = str_replace('<div class="clearfix"></div>', '', $content);
    //$content = preg_replace('#</div>{3}#', '', $content);
    //$content = preg_replace('#</div></div>#', '', $content);
    $content = str_replace('</div> </div> </div>', '', $content);
    $content = str_replace('</div></div></div>', '', $content);
    $content = preg_replace('/\s\s+/', ' ', $content);
    $content = str_replace('<table class="width-100">', '<table class="table table-striped">', $content);
    $content = str_replace('<table>', '<table class="table table-striped">', $content);
    $content = trim($content);
    

    $content = preg_replace('#href="/eng/.*?/?([^/]+?(\.pdf))"#s', 'href="/sites/default/files/$1"', $content);
    
   //French
    $translation_content = str_replace('<div id="wb-core">', '', $translation_content);
    $translation_content = str_replace('<div id="wb-core-in" class="equalize">', '', $translation_content);
    $translation_content = str_replace('<div id="wb-main-in">', '', $translation_content);
    $translation_content = str_replace('<div id="wb-main" role="main">', '', $translation_content);
    $translation_content = str_replace('<div class="span-6">', '', $translation_content);
    $translation_content = str_replace('<div class="span-8">', '', $translation_content);
    $translation_content = preg_replace('#<h1 id="wb-cont">(.*?)<\/h1>#', '', $translation_content);
    //$translation_content = preg_replace('#<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '<img src="sites/default/files/$1"', $translation_content);   
    //$translation_content = preg_replace('#(\s.*?)poster=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '$1poster="sites/default/files/$2"', $translation_content); 
    //$translation_content = preg_replace('#<a\s.*?href=".*?/?([^/]+?(\.pdf))"#s', '<a href="sites/default/files/$1"', $translation_content);  
    $translation_content = preg_replace('#<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '<img src="./images/$1"', $translation_content);  
    //echo ("image on");
    //$content = preg_replace('%<img\s.*?src=".*?/?([^/]+?(\.gif|\.png|\.jpg))"%s', '<img src="sites/default/files/$1"', $content); 
    $translation_content = preg_replace('#(\s.*?)poster=".*?/?([^/]+?(\.gif|\.png|\.jpg))"#s', '$1poster="./images/$2"', $translation_content);    
    
    
    
        //echo $content;
        //clean content
        //include('wet4.php');
        //var_dump(json_decode($json));
        //var_dump(json_decode($json, true));

    include('replacements.php');
    //$replacements = json_decode($json, true);
    //var_dump($replacements);
    $translation_content = str_replace(array_keys($replacements), $replacements, $translation_content);
    //echo ("<h1>".$i." WET replcaements</h1>");
    include('removals.php');
    $translation_content = str_replace(($removals), '', $translation_content);


    //include('characters.php');
    //$translation_content = str_replace(($characters), '', $translation_content);



    //remove share
    //<div class="wet-boew-share span-5 margin-bottom-none" data-wet-boew="{'sites': ['bit.ly', 'blogger', 'del.icio.us', 'digg', 'diigo', 'facebook', 'google', 'hotmail', 'linkedin', 'newsvine', 'reddit', 'stumbleupon', 'technorati', 'tumblr', 'twitter', 'yahoobuzz'],addAnalytics:true, analyticsName:'/share/{r}/{s}'}"></div>
    $translation_content = preg_replace('#<div class="wet-boew-share(.*?)</div>#', '', $translation_content);
    $translation_content = preg_replace('#<dl id="gcwu-date-mod(.*?)</dl>#', '', $translation_content);
    $translation_content = str_replace('<div class="clearfix"></div>', '', $translation_content);
    //$content = preg_replace('#</div>{3}#', '', $content);
    //$content = preg_replace('#</div></div>#', '', $content);
    $translation_content = str_replace('</div> </div> </div>', '', $translation_content);
    $translation_content = str_replace('’', '', $translation_content);

    //$translation_content = addslashes($translation_content);


    $translation_content = preg_replace('/\s\s+/', ' ', $translation_content);
    $translation_content = trim($translation_content);

    $translation_content = preg_replace('#href="/fra/.*?/?([^/]+?(\.pdf))"#s', 'href="/sites/default/files/$1"', $translation_content);

    $translation_breadcrumbs = str_replace('<div id="gcwu-bc">', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('<h2>Fil d\'Ariane</h2>', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('<div id="gcwu-bc-in">', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('<ol>', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('</ol>', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('</div>', '', $translation_breadcrumbs);
    $translation_breadcrumbs = str_replace('</div>', '', $translation_breadcrumbs);
    $translation_breadcrumbs = trim($translation_breadcrumbs);

    //echo ("<h1>".$x." removal</h1>");
    //echo $image;
  
    include('include/db.php');


  
 

    $content = htmlspecialchars($content, ENT_QUOTES);
    $breadcrumbs = htmlspecialchars($breadcrumbs, ENT_QUOTES);
    $content = mysqli_real_escape_string($conn, $content);
    //$content = addslashes($content);
    $translation_content = htmlspecialchars($translation_content, ENT_QUOTES);
    $translation_breadcrumbs = htmlspecialchars($translation_breadcrumbs, ENT_QUOTES);
    $translation_content = mysqli_real_escape_string($conn, $translation_content );
    //$translation_content = addslashes($translation_content);
    //$content = htmlspecialchars($content);
    //$content = base64_encode($content);
    $sql = "INSERT INTO content_both (name, link, title, breadcrumb, translation_title, translation_breadcrumb, language, translation_language, content, translation_content, status, modified, path, translation_path)
    VALUES ('$name', '$myURL', '$title', ' $breadcrumbs', '$translation_title', '$translation_breadcrumbs', 'en', 'fr', '$content', '$translation_content', $status, '$modified', '$path', '$translation_path')";


    //update flag
    //$sql_flag = ""
    
    if ($conn->query($sql) === TRUE) {
      // deepcode ignore XSS: <please specify a reason of ignoring this>
      echo "\nNew record " . $ID . " created successfully";
    } else {
      // deepcode ignore XSS: <please specify a reason of ignoring this>
      echo " Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
?> 

