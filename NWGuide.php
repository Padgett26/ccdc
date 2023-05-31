<?php
include "cgi-bin/config.php";
include "include/header.php";
?>
<div style="text-align:center; font-size:2em; font-weight:bold;">The Ultimate Guide to NorthWest Kansas</div>
<div style="text-align:left; font-size:0.75em; margin:10px 7px;">Click on a page for a larger picture. Then use the 'previous' and 'next' buttons to flip pages.</div>
<?php
for($i = 1; $i <= 44; $i ++) {
	echo "<a class='image-link' href='NWGuide/NWGuide$i.png' data-lightbox='page-set' data-title='The Ultimate Guide to NorthWest Kansas'><img style='margin:7px;' src='NWGuide/thumb/NWGuide$i.png' alt=''/></a>";
}
?>
<script src="js/lightbox-plus-jquery.min.js"></script>
<?php
include "include/footer.php";