<pre>
<?php

$siteURL = array (
    "https://www.nuclearsafety.gc.ca/includes/mega-menu-eng.cfm"
);

// $siteURL = array(
//     "https://www.nuclearsafety.gc.ca/eng/reactors/index.cfm",
//     "https://www.nuclearsafety.gc.ca/eng/reactors/power-plants/new-reactor-facilities/index.cfm",
//     "https://www.nuclearsafety.gc.ca/eng/reactors/power-plants/index.cfm",
//     "https://www.nuclearsafety.gc.ca/eng/reactors/research-reactors/other-reactor-facilities/small-modular-reactors.cfm",
//     "https://www.nuclearsafety.gc.ca/eng/reactors/research-reactors/index.cfm",
//     "https://www.nuclearsafety.gc.ca/eng/reactors/research-reactors/other-reactor-facilities/index.cfm"
// );

include ('simple_html_dom.php');

foreach ($siteURL as $url) {

    $html = file_get_html($url);

    //$content = $html->find('div[class="wb-sec-def"]',0);
    $content = $html->find('html[lang="en"]',0);
    //$content = $html->find('div[id="wb-main-in"]',0);
    //$title = strip_tags($html->find('h1[id="wb-cont"]',0));
    $links = array();
    foreach($content->find('a') as $a){
        $links[] = $a->href;
    }

    //echo($title);
    echo('<br>');
    foreach ($links as $val) {

        if (strpos($val, '.cfm') !== false){
            print_r($val);
            echo('<br>');
        }
    }
}
?>
</pre>