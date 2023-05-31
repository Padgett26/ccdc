<?php
include "cgi-bin/config.php";

$category = filter_input ( INPUT_GET, 'q', FILTER_SANITIZE_STRING );
$loggedin = (filter_input ( INPUT_GET, 'l', FILTER_SANITIZE_STRING ) == "l") ? "1" : "0";
$stmt2 = $db->prepare ( "SELECT category FROM busiCategories WHERE id = ?" );
$stmt2->execute ( array (
		$category
) );
$row2 = $stmt2->fetch ();
$c = ($row2) ? $row2 ["category"] : "";
echo "<div style='text-decoration:none; font-size:2em; text-align:center; margin-bottom:20px;'>$c</div>\n";
$substmt = $db->prepare ( "SELECT * FROM business WHERE category=? ORDER BY RAND()" );
$substmt->execute ( array (
		$category
) );
while ( $row1 = $substmt->fetch () ) {
	$id = $row1 ['id'];
	$name = $row1 ['name'];
	$contact = $row1 ['contact'];
	$phone = $row1 ['phone'];
	$fax = $row1 ['fax'];
	$email = $row1 ['email'];
	$website = $row1 ['website'];
	$mailing = $row1 ['mailing'];
	$physical = $row1 ['physical'];
	$city = $row1 ['city'];
	$state = $row1 ['state'];
	$zipCode = $row1 ['zipCode'];
	$description = nl2br ( make_links_clickable ( html_entity_decode ( $row1 ['description'], ENT_QUOTES ) ) );
	$picture = $row1 ['picture'];
	$picExt = $row1 ['picExt'];
	echo "<div onclick='toggleview(\"bus$id\")' style='cursor:pointer; text-decoration:underline; font-size:1.5em; text-align:center; margin-bottom:10px;'>$name</div>\n";
	echo "<div id='bus$id' style='display:none; font-size:1.25em; text-align:center; margin:30px 10px;'>";
	if (file_exists ( "image/business/$picture.$picExt" )) {
		echo "<img src='image/business/$picture.$picExt' style='float:right; margin:0px 0px 10px 10px; padding:3px; border:1px solid #000000; max-width:400px; max-height:400px;' /><br /><br />";
	}
	if ($loggedin == "1") {
		echo "<form action='business.php' method='post'>Edit this business listing <input type='checkbox' name='editbusi' value='$id' /> <input type='submit' value='Go' /></form>";
	}
	if ($contact) {
		echo "Contact person: $contact<br />\n";
	}
	if ($phone) {
		echo "$phone - phone<br />\n";
	}
	if ($fax) {
		echo "$fax - fax<br />\n";
	}
	if ($email) {
		echo "<a href='mailto:$email' style='font-size:1.25em; text-align:center; text-decoration:underline;'>$email</a><br />\n";
	}
	if ($email) {
		echo "<a href='$website' style='font-size:1.25em; text-align:center; text-decoration:underline;' target='_blank'>$website</a><br />\n";
	}
	if ($mailing) {
		echo "$mailing<br />\n";
	}
	if ($physical) {
		echo "$physical<br />\n";
	}
	echo "$city, $state $zipCode<br /><br />\n";
	if (file_exists ( "image/business/$id.jpg" )) {
		echo "<div style='float:right; margin:5px 0px 5px 5px; border:1px solid black; padding:3px; background-color:#aa9f93;'><img src='images/business/$id.jpg' alt='' /></div>";
	}
	if ($description) {
		echo "<div style='text-align:justify; margin:0px 30px;'>$description</div>\n";
	}
	echo "</div>";
}