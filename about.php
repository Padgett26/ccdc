<?php
include "cgi-bin/config.php";
include "include/header.php";
echo "</div>";

if ($loggedin == "1") {
	if (filter_input ( INPUT_POST, 'rowid', FILTER_SANITIZE_STRING )) {
		$name = filter_input ( INPUT_POST, 'name', FILTER_SANITIZE_STRING );
		$delmem = (filter_input ( INPUT_POST, 'delmem', FILTER_SANITIZE_NUMBER_INT ) == "1") ? "1" : "0";
		$rowid = filter_input ( INPUT_POST, 'rowid', FILTER_SANITIZE_STRING );
		if ($delmem == "1") {
			$stmt1 = $db->prepare ( "DELETE FROM members WHERE id=?" );
			$stmt1->execute ( array (
					$rowid
			) );
			echo "<span style=''>Person deleted...</span><br />";
		} else {
			if ($rowid == "new") {
				$stmt2 = $db->prepare ( "INSERT INTO members VALUES" . "(NULL,?,'Member','0','0')" );
				$stmt2->execute ( array (
						$name
				) );
				echo "<span style=''>Person added...</span><br />";
			} else {
				$stmt3 = $db->prepare ( "UPDATE members SET name=? WHERE id=?" );
				$stmt3->execute ( array (
						$name,
						$rowid
				) );
				echo "<span style=''>Person updated...</span><br />";
			}
		}
	}

	if (filter_input ( INPUT_POST, 'content', FILTER_SANITIZE_STRING )) {
		$a2 = htmlEntities ( trim ( $_POST ['content'] ), ENT_QUOTES );
		$content = filter_var ( $a2, FILTER_SANITIZE_STRING );
		$stmt4 = $db->prepare ( "UPDATE pages SET content=? WHERE page='about'" );
		$stmt4->execute ( array (
				$content
		) );
	}
}
echo "<table cellpadding='5px'><tr>";
echo "<td colspan='2' style='text-align:center; font-size:2em;'>Our board members:</td></tr>";
$stmt5 = $db->prepare ( "SELECT * FROM members ORDER BY id" );
$stmt5->execute ();
while ( $row5 = $stmt5->fetch () ) {
	if ($loggedin == "1") {
		echo "<tr><td><form action='about.php' method='post'><input type='text' name='name' value='" . $row5 ['name'] . "' /></td><td style=''>" . $row5 ['title'];
		if ($row5 ['title'] == "Member") {
			echo " / Delete this member? <input type='checkbox' name='delmem' value='1' />";
		}
		echo " <input type='hidden' name='rowid' value='" . $row5 ['id'] . "' /><input type='submit' value='Update' /></form></td></tr>";
	} else {
		echo ($row5 ['title'] == "Member") ? "<tr><td colspan='2' style='text-align:center;'>" : "<tr><td style='text-align:right; width:300px;'>";
		echo "<span style='font-size:1.25em;'>" . $row5 ['name'] . "</span>";
		echo ($row5 ['title'] == "Member") ? "</td></tr>" : "</td><td style='text-align:left; width:300px;'>- " . $row5 ['title'] . "</td></tr>";
	}
}
if ($loggedin == "1") {
	echo "<tr><td><form action='about.php' method='post'><input type='text' name='name' title='Add new member' /></td><td style=''>Member <input type='hidden' name='rowid' value='new' /><input type='submit' value='Update' /></form></td></tr>";
}
echo "</table><br /><br />";

$stmt6 = $db->prepare ( "SELECT content FROM pages WHERE page='about'" );
$stmt6->execute ();
$row6 = $stmt6->fetch ();
$content = nl2br ( make_links_clickable ( html_entity_decode ( $row6 ['content'], ENT_QUOTES ) ) );
if ($loggedin == "1") {
	echo "<div style='content-align:justify; margin:0px 0px; font-size:1.25em;'>";
	echo "<form action='about.php' method='post'><textarea name='content' rows='20' cols='80' maxlength='9900'>" . $row6 ['content'] . "</textarea><br />";
	echo "<input type='submit' value=' Update ' /></form>";
	echo "</div>";
} else {
	echo "<div style='text-align:justify; margin:0px 30px; font-size:1.25em;'>$content</div>";
}

include "include/footer.php";