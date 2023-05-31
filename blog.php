<?php
include "cgi-bin/config.php";
include "include/header.php";

echo "<div style='margin-top:9px; cursor:pointer;'><span style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>View news from:</span></div>\n";
$stmt = $db->prepare ( "SELECT showDate FROM news ORDER BY showDate DESC" );
$stmt->execute ();
$menuYear = array ();
while ( $row = $stmt->fetch () ) {
	$menuYear [] = date ( "Y", $row ['showDate'] );
}
$years = array_unique ( $menuYear );
foreach ( $years as $year ) {
	echo "<div style='margin-top:9px; cursor:pointer;'>";
	echo "<a href='blog.php?blogYear=$year' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>$year</a>";
	echo "</div>\n";
}

echo "</div>";

if ($loggedin == "1") {
	if (filter_input ( INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT )) {
		$id = filter_input ( INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT );
		$stmt1 = $db->prepare ( "DELETE FROM news WHERE id=?" );
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
			processPic ( "dirnotes", $picname1, "400", "400", $tmpFile, $imageType );
		}
	}

	if (isset ( $_FILES ['image2'] ['tmp_name'] ) && ($_FILES ['image2'] ['size'] > 1000)) {
		$tmpFile = $_FILES ['image2'] ['tmp_name'];

		list ( $width, $height ) = (getimagesize ( $tmpFile ) != null) ? getimagesize ( $tmpFile ) : null;
		if ($width != null && $height != null) {
			$picname2 = filter_input ( INPUT_POST, 'picname2', FILTER_SANITIZE_NUMBER_INT );
			$imageType = getPicType ( $_FILES ["image2"] ["type"] );
			processPic ( "dirnotes", $picname2, "400", "400", $tmpFile, $imageType );
		}
	}

	if (filter_input ( INPUT_POST, 'postnote', FILTER_SANITIZE_STRING )) {
		$id = filter_input ( INPUT_POST, 'postnote', FILTER_SANITIZE_STRING );
		$title = filter_input ( INPUT_POST, 'title', FILTER_SANITIZE_STRING );
		$a2 = htmlEntities ( trim ( $_POST ['content'] ), ENT_QUOTES );
		$content = filter_var ( $a2, FILTER_SANITIZE_STRING );
		$picname1 = (isset ( $picname1 )) ? $picname1 : '0';
		$picname2 = (isset ( $picname2 )) ? $picname2 : '0';
		$delpic1 = (filter_input ( INPUT_POST, 'delpic1', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		$delpic2 = (filter_input ( INPUT_POST, 'delpic2', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		$delpost = (filter_input ( INPUT_POST, 'delpost', FILTER_SANITIZE_NUMBER_INT ) == '1') ? '1' : '0';
		if ($id == "new") {
			$stmt2 = $db->prepare ( "INSERT INTO news VALUES" . "(NULL,?,?,?,?,?,'0')" );
			$stmt2->execute ( array (
					$title,
					$content,
					$picname1,
					$picname2,
					$time
			) );
			echo "Post added...";
		} else {
			if ($delpost == "1") {
				echo "Are you sure you want to delete this post? <form action='blog.php' method='post'><input type='hidden' name='confdelpost' value='$id' /><input type='submit' value=' YES ' /></form> <form action='blog.php' method='post'><input type='submit' value=' NO ' /></form>";
			} else {
				if ($delpic1 == '1') {
					$stmt3 = $db->prepare ( "SELECT pic1 FROM news WHERE id=?" );
					$stmt3->execute ( array (
							$id
					) );
					$row3 = $stmt3->fetch ();
					$delpicname1 = $row3 ['pic1'];
					if (file_exists ( "image/dirnotes/$delpicname1.jpg" )) {
						unlink ( "image/dirnotes/$delpicname1.jpg" );
					}
					$stmt4 = $db->prepare ( "UPDATE news SET pic1=? WHERE id=?" );
					$stmt4->execute ( array (
							'0',
							$id
					) );
				}
				if ($delpic2 == '1') {
					$stmt5 = $db->prepare ( "SELECT pic2 FROM news WHERE id=?" );
					$stmt5->execute ( array (
							$id
					) );
					$row5 = $stmt5->fetch ();
					$delpicname2 = $row5 ['pic2'];
					if (file_exists ( "image/dirnotes/$delpicname2.jpg" )) {
						unlink ( "image/dirnotes/$delpicname2.jpg" );
					}
					$stmt6 = $db->prepare ( "UPDATE news SET pic2=? WHERE id=?" );
					$stmt6->execute ( array (
							'0',
							$id
					) );
				}
				$stmt7 = $db->prepare ( "UPDATE news SET title=?,content=?,showDate=? WHERE id=?" );
				$stmt7->execute ( array (
						$title,
						$content,
						$time,
						$id
				) );
				if ($picname1 != '0') {
					$stmt8 = $db->prepare ( "UPDATE news SET pic1=? WHERE id=?" );
					$stmt8->execute ( array (
							$picname1,
							$id
					) );
				}
				if ($picname2 != '0') {
					$stmt9 = $db->prepare ( "UPDATE news SET pic2=? WHERE id=?" );
					$stmt9->execute ( array (
							$picname2,
							$id
					) );
				}
				echo "Post updated...<br>";
			}
		}
	}

	echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
	echo "<form action='blog.php' method='post' enctype='multipart/form-data'>\n";
	echo "Insert a new post:<br>\n";
	echo "Title: <input type='text' name='title' maxlength='190' /><br>\n";
	echo "Content:<br>\n";
	echo "<textarea name='content' cols='75' rows='15'></textarea><br><br>\n";
	echo "Insert picture 1: <input type='file' name='image1' /><input type='hidden' name='picname1' value='" . ($time + 1) . "' /><br><br>";
	echo "Insert picture 2: <input type='file' name='image2' /><input type='hidden' name='picname2' value='" . ($time + 2) . "' /><br><br>";
	echo "<input type='hidden' name='postnote' value='new' />\n";
	echo "<input type='submit' value=' Upload ' /></form></div><br><br>\n";
}

$start = ($blogYear == date ( "Y" )) ? ($time - 31536000) : mktime ( 0, 0, 0, 1, 1, $blogYear );
$end = ($blogYear == date ( "Y" )) ? $time : mktime ( 23, 59, 59, 12, 31, $blogYear );
$stmt10 = $db->prepare ( "SELECT * FROM news WHERE showDate >= ? && showDate <= ? ORDER BY showDate DESC" );
$stmt10->execute ( array (
		$start,
		$end
) );
while ( $row10 = $stmt10->fetch () ) {
	$id = $row10 ['id'];
	$title = $row10 ['title'];
	$content = nl2br ( make_links_clickable ( html_entity_decode ( $row10 ['content'], ENT_QUOTES ) ) );
	$pic1 = $row10 ['pic1'];
	$pic2 = $row10 ['pic2'];
	$updated = date ( 'l jS \of F Y', $row10 ['showDate'] );
	if ($loggedin == "1") {
		echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
		echo "<form action='blog.php' method='post' enctype='multipart/form-data'>\n";
		echo "<div style='cursor:pointer;' onclick='toggleview(\"L$id\")'>Edit this post: <span style='text-decoration:underline;'>$title</span></div><br>\n";
		echo "<div id='L$id' style='display:none; margin-top:10px;'>Title: <input type='text' name='title' maxlength='190' value='$title' /><br><br>\n";
		echo "Last updated: $updated<br><br>\n";
		echo "Content:<br>\n";
		echo "<textarea name='content' cols='75' rows='15'>" . $row10 ['content'] . "</textarea><br><br>\n";
		echo "Picture 1:<br>";
		if (file_exists ( "image/dirnotes/$pic1.jpg" )) {
			echo "<img src='image/dirnotes/$pic1.jpg' alt='' /><br><input type='checkbox' name='delpic1' value='1' /> Delete this pic<br>";
		}
		echo "<input type='file' name='image1' /><input type='hidden' name='picname1' value='" . $time . "1' /><br><br>";
		echo "Picture 2:<br>";
		if (file_exists ( "image/dirnotes/$pic2.jpg" )) {
			echo "<img src='image/dirnotes/$pic2.jpg' alt='' /><br><input type='checkbox' name='delpic2' value='1' /> Delete this pic<br>";
		}
		echo "<input type='file' name='image2' /><input type='hidden' name='picname2' value='" . $time . "2' /><br><br>";
		echo "Delete this post: <input type='checkbox' name='delpost' value='1' /><br><br>\n";
		echo "<input type='hidden' name='postnote' value='$id' />\n";
		echo "<input type='submit' value=' Upload ' /></div></form></div><br><hr /><br>\n";
	} else {
		echo "<div style='";
		echo (file_exists ( "image/dirnotes/$pic1.jpg" )) ? "min-height:350px;" : "";
		echo "'><div style='text-align:center; font-weight:bold; font-size:1.5em; padding:10px; font-family:sans-serif; text-decoration:underline;'>$title</div>\n";
		if (file_exists ( "image/dirnotes/$pic1.jpg" )) {
			echo "<img src='image/dirnotes/$pic1.jpg' alt='' style='float:right; margin:10px; max-width:300px; max-height:300px;' />";
		}
		echo "<div style='text-align:justify; font-family:sans-serif; padding:10px;'>$content</div>";
		if (file_exists ( "image/dirnotes/$pic2.jpg" )) {
			echo "<div style='margin:auto; width:300px;'><img src='image/dirnotes/$pic2.jpg' alt='' style='width:300px;' /></div>";
		}
		echo "</div><hr /><br>\n";
	}
}
include "include/footer.php";
?>