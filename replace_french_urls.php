<?php

//update links in filename
//use full path to file, get file, then rename file
//use variable for old name
//use variable for new name
//reanme a directory and a file - renames a file or directory
//<?php
//rename("images","pictures");
//rename("/test/file1.txt","/home/docs/my_file.txt");
//
// https://www.php.net/manual/en/function.rename.php
// rename(string $from, string $to, ?resource $context = null): bool
// may require changes using chmod() or chown()



//update links in content

//array can be generated from excel spreadsheet or table in word



echo getcwd();
rename("wwwroot/fra/a/page-one.html", "wwwroot/fra/a/page-une.html");
rename("wwwroot/fra/b/page-two.html", "wwwroot/fra/bb/page-deux.htm");
rename("wwwroot/fra/c/page-three.js", "wwwroot/fra/cc/page-trois.js");
rename("wwwroot/fra/d/page-four", "wwwroot/fra/dd/page-quattre");

// same array can be used to handle both and run separately

$repalcement_links = [
    "/fra/a/page-one" => "/aa/page-une",
    "/fra/b/page-two" => "/bb/page-deux",
    "/fra/c/page-three" => "/cc/page-trois",
    "/fra/d/page-four" => "/dd/page-quattre",
    "/fra/e/page-five" => "/ee/page-cinq",
    "/fra/f/page-six" => "/ff/page-six"
];

$content = '<div class="col-md-12 margin-left-none"><p>Un examen de la protection de l&rsquo;environnement est une &eacute;valuation technique &agrave; caract&egrave;re scientifique effectu&eacute;e par le personnel de la CCSN, conform&eacute;ment &agrave; la Loi sur la s&ucirc;ret&eacute; et la r&eacute;glementation nucl&eacute;aires. Ces <a href="/fra/d/page-four">examens permettent de d&eacute;terminer si un demandeur ou un titulaire de permis</a> prendra les mesures appropri&eacute;es pour prot&eacute;ger l&rsquo;environnement ainsi que la sant&eacute; et la s&eacute;curit&eacute; du public.</p>
<p><a href="/fra/c/page-three">Ces examens s&rsquo;appuient sur les &eacute;l&eacute;ments suivants</a>&nbsp;:</p>
<ul>
  <li>les renseignements que le demandeur ou le titulaire de permis soumet &agrave; la CCSN, comme les demandes de permis et les documents &agrave; l&rsquo;appui qui d&eacute;crivent les mesures de protection de l&rsquo;environnement</li>
  <li>les activit&eacute;s de v&eacute;rification de la conformit&eacute; et d&rsquo;&eacute;valuation technique r&eacute;alis&eacute;es par le personnel de la CCSN, comme l&rsquo;examen des donn&eacute;es de surveillance environnementale et les &eacute;valuations des risques environnementaux</li>
  <li>les activit&eacute;s de v&eacute;rification ind&eacute;pendantes, notamment dans le cadre du <a href="/fra/b/page-two">Programme ind&eacute;pendant de surveillance environnementale (PISE)</a> de la CCSN, les &eacute;tudes r&eacute;gionales pertinentes sur la sant&eacute;, les programmes de surveillance et les &eacute;tudes sur le savoir autochtone</li>
</ul>
<p>Les rapports d&rsquo;examen de la protection de l&rsquo;environnement sont examin&eacute;s par la Commission ind&eacute;pendante dans le cadre de son processus de d&eacute;cision visant les autorisations, et ils sont mis &agrave; la disposition du public sous forme de <a href="/fra/a/page-one">documents d&rsquo;audience</a>.</p>
<p>&Agrave; partir de 2021, la CCSN adoptera une nouvelle approche pour la publication des rapports d&rsquo;examen de la protection de l&rsquo;environnement. Ces rapports seront publi&eacute;s selon un cycle r&eacute;gulier, s&eacute;par&eacute;ment des d&eacute;cisions d&rsquo;autorisation particuli&egrave;res. Des r&eacute;sum&eacute;s seront affich&eacute;s sur ce site Web, et les rapports complets appara&icirc;tront sur le <a href="/fra/e/page-five">Portail du gouvernement ouvert du Canada</a>. Le rapport sur la raffinerie de Blind River est le premier &agrave; &ecirc;tre publi&eacute; dans ce format actualis&eacute; et est disponible ci-dessous.</p>
<p><a href="/fra/f/page-six">Vous avez des questions</a> ou vous avez besoin d&rsquo;aide? Contactez-nous &agrave; <a href="mailto:ea-ee@cnsc-ccsn.gc.ca">ea-ee@cnsc-ccsn.gc.ca</a>.</p>
</div>';


$result = str_replace(array_keys($repalcement_links), $repalcement_links, $content);

echo $result;


?>

