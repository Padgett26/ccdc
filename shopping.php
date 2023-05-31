<?php
include "cgi-bin/config.php";
include "include/header.php";
echo "</div>";

if ($loggedin == "1") {
	if (filter_input ( INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT )) {
		$id = filter_input ( INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT );
		$stmt1 = $db->prepare ( "DELETE FROM shopping WHERE id=?" );
		$stmt1->execute ( array (
				$id
		) );
		echo "Post deleted...";
	}

	$picname1 = "0";
	$picname2 = "0";

	if (isset ( $_FILES ['image1'] ['tmp_name'] ) && ($_FILES ['image1'] ['size'] > 1000)) {
		$tmpFile = $_FILES ['image1'] ['tmp_name'];

		list ( $width, $height ) = (getimagesize ( $tmpFile ) != null) ? getimagesize ( $tmpFile ) : null;
		if ($width != null && $height != null) {
			$picname1 = filter_input ( INPUT_POST, 'picname1', FILTER_SANITIZE_NUMBER_INT );
			$imageType = getPicType ( $_FILES ["image1"] ["type"] );
			processPic ( "shopping", $picname1, "400", "400", $tmpFile, $imageType );
		}
	}

	if (isset ( $_FILES ['image2'] ['tmp_name'] ) && ($_FILES ['image2'] ['size'] > 1000)) {
		$tmpFile = $_FILES ['image2'] ['tmp_name'];

		list ( $width, $height ) = (getimagesize ( $tmpFile ) != null) ? getimagesize ( $tmpFile ) : null;
		if ($width != null && $height != null) {
			$picname2 = filter_input ( INPUT_POST, 'picname2', FILTER_SANITIZE_NUMBER_INT );
			$imageType = getPicType ( $_FILES ["image2"] ["type"] );
			processPic ( "shopping", $picname2, "400", "400", $tmpFile, $imageType );
		}
	}

	if (filter_input ( INPUT_POST, 'postnote', FILTER_SANITIZE_STRING )) {
		$id = filter_input ( INPUT_POST, 'postnote', FILTER_SANITIZE_STRING );
		$title = filter_input ( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
		$month = filter_input ( INPUT_POST, 'month', FILTER_SANITIZE_NUMBER_INT );
		$day = filter_input ( INPUT_POST, 'day', FILTER_SANITIZE_NUMBER_INT );
		$year = filter_input ( INPUT_POST, 'year', FILTER_SANITIZE_NUMBER_INT );
		$showDate = mktime ( 0, 0, 0, $month, $day, $year );
		$a2 = htmlEntities ( trim ( $_POST ['content'] ), ENT_QUOTES );
		$content = filter_var ( $a2, FILTER_SANITIZE_STRING );
		$picname1 = (isset ( $picname1 )) ? $picname1 : '0';
		$picname2 = (isset ( $picname2 )) ? $picname2 : '0';
		$delpic1 = (filter_input ( INPUT_POST, 'delpic1', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		$delpic2 = (filter_input ( INPUT_POST, 'delpic2', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		$delpost = (filter_input ( INPUT_POST, 'delpost', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		if ($id == "new") {
			$stmt2 = $db->prepare ( "INSERT INTO shopping VALUES" . "(NULL,?,?,NULL,?,?,?,'0','0')" );
			$stmt2->execute ( array (
					$title,
					$content,
					$showDate,
					$picname1,
					$picname2
			) );
			echo "Post added...";
		} else {
			if ($delpost == "1") {
				echo "Are you sure you want to delete this post? <form action='shopping.php' method='post'><input type='hidden' name='confdelpost' value='$id' /><input type='submit' value=' YES ' /></form> <form action='shopping.php' method='post'><input type='submit' value=' NO ' /></form>";
			} else {
				if ($delpic1 == '1') {
					$stmt3 = $db->prepare ( "SELECT pic1 FROM shopping WHERE id=?" );
					$stmt3->execute ( array (
							$id
					) );
					$row3 = $stmt3->fetch ();
					$delpicname1 = $row3 ['pic1'];
					if (file_exists ( "image/shopping/$delpicname1.jpg" )) {
						unlink ( "image/shopping/$delpicname1.jpg" );
					}
					$stmt4 = $db->prepare ( "UPDATE shopping SET pic1=? WHERE id=?" );
					$stmt4->execute ( array (
							'0',
							$id
					) );
				}
				if ($delpic2 == '1') {
					$stmt5 = $db->prepare ( "SELECT pic2 FROM shopping WHERE id=?" );
					$stmt5->execute ( array (
							$id
					) );
					$row5 = $stmt5->fetch ();
					$delpicname2 = $row5 ['pic2'];
					if (file_exists ( "image/shopping/$delpicname2.jpg" )) {
						unlink ( "image/shopping/$delpicname2.jpg" );
					}
					$stmt6 = $db->prepare ( "UPDATE shopping SET pic2=? WHERE id=?" );
					$stmt6->execute ( array (
							'0',
							$id
					) );
				}
				$stmt7 = $db->prepare ( "UPDATE shopping SET title=?,content=?,showDate=? WHERE id=?" );
				$stmt7->execute ( array (
						$title,
						$content,
						$showDate,
						$id
				) );
				if ($picname1 != '0') {
					$stmt8 = $db->prepare ( "UPDATE shopping SET pic1=? WHERE id=?" );
					$stmt8->execute ( array (
							$picname1,
							$id
					) );
				}
				if ($picname2 != '0') {
					$stmt9 = $db->prepare ( "UPDATE shopping SET pic2=? WHERE id=?" );
					$stmt9->execute ( array (
							$picname2,
							$id
					) );
				}
				echo "Post updated...<br />";
			}
		}
	}

	echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
	echo "<form action='shopping.php' method='post' enctype='multipart/form-data'>\n";
	echo "Insert a new post:<br />\n";
	echo "Title: <input type='text' name='title' maxlength='190' /><br />\n";
	echo "Month:<select name='month'>\n";
	for($m = 1; $m <= 12; ++ $m) {
		echo "<option value='$m'";
		if ($m == date ( "n" )) {
			echo " selected='selected'";
		}
		echo ">$m</option>\n";
	}
	echo "</select> Day:<select name='day'>\n";
	for($d = 1; $d <= 31; ++ $d) {
		echo "<option value='$d'";
		if ($d == date ( "j" )) {
			echo " selected='selected'";
		}
		echo ">$d</option>\n";
	}
	echo "</select> Year:<select name='year'>\n";
	$thisYear = date ( "Y" );
	$oldYear = ($thisYear - 2);
	for($y = $oldYear; $y <= $thisYear; $y ++) {
		echo "<option value='$y'";
		if ($y == date ( "Y" )) {
			echo " selected='selected'";
		}
		echo ">$y</option>\n";
	}
	echo "</select><br />\n";
	echo "Content:<br />\n";
	echo "<textarea name='content' cols='75' rows='15'></textarea><br /><br />\n";
	echo "Insert picture 1: <input type='file' name='image1' /><input type='hidden' name='picname1' value='" . $time . "1' /><br /><br />";
	echo "Insert picture 2: <input type='file' name='image2' /><input type='hidden' name='picname2' value='" . $time . "2' /><br /><br />";
	echo "<input type='hidden' name='postnote' value='new' />\n";
	echo "<input type='submit' value=' Upload ' /></form></div><br /><br />\n";
}
$tstart = mktime ( 0, 0, 0, 1, 1, $blogYear );
$tend = mktime ( 23, 59, 59, 12, 31, $blogYear );
$stmt10 = $db->prepare ( "SELECT * FROM shopping WHERE showDate BETWEEN $tstart AND $tend ORDER BY updated DESC" );
$stmt10->execute ();
while ( $row10 = $stmt10->fetch () ) {
	$id = $row10 ['id'];
	$title = $row10 ['title'];
	$tmonth = date ( "n", $row10 ['showDate'] );
	$month = $months [$tmonth];
	$day = date ( "j", $row10 ['showDate'] );
	$year = date ( "Y", $row10 ['showDate'] );
	$content = nl2br ( make_links_clickable ( html_entity_decode ( $row10 ['content'], ENT_QUOTES ) ) );
	$pic1 = $row10 ['pic1'];
	$pic2 = $row10 ['pic2'];
	$updated = $row10 ['updated'];
	if ($loggedin == "1") {
		echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
		echo "<form action='shopping.php' method='post' enctype='multipart/form-data'>\n";
		echo "<div class='showtitle'>Edit this post: <span style='text-decoration:underline;'>$title</span></div>\n";
		echo "<div class='showtext'>Title: <input type='text' name='title' maxlength='190' value='$title' /><br /><br />\n";
		echo "Month:<select name='month'>\n";
		for($m = 1; $m <= 12; ++ $m) {
			echo "<option value='$m'";
			if ($m == $tmonth) {
				echo " selected='selected'";
			}
			echo ">$m</option>\n";
		}
		echo "</select> Day:<select name='day'>\n";
		for($d = 1; $d <= 31; ++ $d) {
			echo "<option value='$d'";
			if ($d == $day) {
				echo " selected='selected'";
			}
			echo ">$d</option>\n";
		}
		echo "</select> Year:<select name='year'>\n";
		$thisYear = date ( "Y" );
		$substmt = $db->prepare ( "SELECT showDate FROM shopping ORDER BY showDate LIMIT 1" );
		$substmt->execute ();
		$subrow = $substmt->fetch ();
		$oldYear = date ( "Y", $subrow ['showDate'] );
		for($y = $oldYear; $y <= $thisYear; $y ++) {
			echo "<option value='$y'";
			if ($y == $year) {
				echo " selected='selected'";
			}
			echo ">$y</option>\n";
		}
		echo "</select><br /><br />\n";
		echo "Last updated: $updated<br /><br />\n";
		echo "Content:<br />\n";
		echo "<textarea name='content' cols='75' rows='15'>" . $row10 ['content'] . "</textarea><br /><br />\n";
		echo "Picture 1:<br />";
		if (file_exists ( "image/shopping/$pic1.jpg" )) {
			echo "<img src='image/shopping/$pic1.jpg' alt='' /><br /><input type='checkbox' name='delpic1' value='1' /> Delete this pic<br />";
		}
		echo "<input type='file' name='image1' /><input type='hidden' name='picname1' value='" . $time . "1' /><br /><br />";
		echo "Picture 2:<br />";
		if (file_exists ( "image/shopping/$pic2.jpg" )) {
			echo "<img src='image/shopping/$pic2.jpg' alt='' /><br /><input type='checkbox' name='delpic2' value='1' /> Delete this pic<br />";
		}
		echo "<input type='file' name='image2' /><input type='hidden' name='picname2' value='" . $time . "2' /><br /><br />";
		echo "Delete this post: <input type='checkbox' name='delpost' value='1' /><br /><br />\n";
		echo "<input type='hidden' name='postnote' value='$id' />\n";
		echo "<input type='submit' value=' Upload ' /></div></form></div><br /><hr /><br />\n";
	} else {
		echo "<div style='text-align:center; font-weight:bold; font-size:1.5em; padding:10px; font-family:sans-serif; text-decoration:underline;'>$title</div></div>\n";
		if (file_exists ( "image/shopping/$pic1.jpg" )) {
			echo "<img src='image/shopping/$pic1.jpg' alt='' style='float:right; margin:10px; max-width:300px;' />";
		}
		echo "<div style='text-align:justify; font-family:sans-serif; padding:10px;'>$content</div>";
		if (file_exists ( "image/shopping/$pic2.jpg" )) {
			echo "<img src='image/shopping/$pic2.jpg' alt='' style='margin:10px 0px;' />";
		}
		echo "<br /><hr /><br />\n";
	}
}

include "include/footer.php";