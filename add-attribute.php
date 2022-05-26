<style>
.img-responsive {
    height: 100px;
    width: 100px;
    border:5px solid #000;
}
</style>

<?php

$string_no_attribute ='<img src="https://www.nuclearsafety.gc.ca/images/75th-anniversary/720px_milestones_1946_55.jpg" alt="Marking the decade 1946 to 1955. Shot from above in a large meeting room, a meeting is set up in a hollow-square format with several rows of seating on all 4 sides. Every seat is occupied." class="img-responsive" />
<p class="test" alt="">In December, the organization co-hosted its first virtual  conference. This 5-day international, multi-sector workshop focused on how to  safely regulate innovative and disruptive technologies. Coincidentally,  December also marked nine months of disruption caused by the pandemic and  having to adapt to remote work, virtual Commission proceedings and virtual  conferences. The CNSC has adjusted to a new normal and is now making it a priority  to prepare for the next normal. This year has tested the CNSC, requiring both  quick thinking and flexibility in order to innovate and adopt new ways of  working. This agility has enabled the organization to successfully carry out  its mandate undeterred. It is clear that working remotely has not impacted the  CNSC&rsquo;s role as the regulator.</p>
<img src="https://www.nuclearsafety.gc.ca/images/about-us/mission-vision/w_ethics-720.png" class="mrgn-tp-md" alt="This is an imageadd-"/> 
<img src="https://www.nuclearsafety.gc.ca/images/75th-anniversary/720px_milestones_1946_55.jpg" alt="Marking the decade 1946 to 1955. Shot from above in a large meeting room, a meeting is set up in a hollow-square format with several rows of seating on all 4 sides. Every seat is occupied." class="test" />
<img class="mrgn-tp-md" src="https://www.nuclearsafety.gc.ca/images/about-us/mission-vision/w_ethics-720.png" alt="" />';

//$regex = "#img(.*?)(class=\")([^']*?\")#";
$regex = "#img(.*?)(class=\")([^']*?)(\".?)(/>)#";

$string_plus_attribute = preg_replace($regex, 'img$1$2img-responsive $3$4$5', $string_no_attribute);
//$xhtml = '#(<img[^>]+)(?<!\/)>#';
//$string_plus_attribute_strict = preg_replace($xhtml, '$1/>', $string_plus_attribute); 
echo $string_plus_attribute;
?>