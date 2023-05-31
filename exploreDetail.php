<?php
include "cgi-bin/config.php";
include "include/header.php";
$show = (filter_input ( INPUT_GET, 'show', FILTER_SANITIZE_NUMBER_INT ) >= 1) ? filter_input ( INPUT_GET, 'show', FILTER_SANITIZE_NUMBER_INT ) : 0;
if ($show == 0) {
	echo "<div style='text-align:center; font-weight:bold; font-size:1.25em; padding:10px; font-family:sans-serif; text-decoration:underline;'>River Walk and Keller Pond Flyover</div>\n";
	echo "<div style='margin:10px;'>Drone footage of the River Walk and Keller Pond</div>";
	echo "<div style='margin-left: 40px;'><iframe width='560' height='315' src='https://www.youtube.com/embed/LwP4p_7Ck_A' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
	?>
</div>
<?php
} else {
	$stmt10 = $db->prepare ( "SELECT * FROM explore WHERE id = ?" );
	$stmt10->execute ( array (
			$show
	) );
	$row10 = $stmt10->fetch ();
	if ($row10) {
		$title = $row10 ['title'];
		$content = nl2br ( make_links_clickable ( html_entity_decode ( $row10 ['content'], ENT_QUOTES ) ) );
		$pic1 = $row10 ['pic1'];
		$pic2 = $row10 ['pic2'];
		echo "<div class='clearfix' style=''><div style='text-align:center; padding:10px; font-family:sans-serif; text-decoration:underline; font-weight:bold; font-size:1.25em;'>$title</div>";
		if (file_exists ( "image/explore/$pic1.jpg" )) {
			echo "<img src='image/explore/$pic1.jpg' alt='' style='float:right; margin:10px; max-width:300px; max-height:300px;' />";
		}
		echo "<div style='text-align:justify; font-family:sans-serif; padding:10px;'>" . $content . "</div>";
		if (file_exists ( "image/explore/$pic2.jpg" )) {
			echo "<img src='image/explore/$pic2.jpg' alt='' style='text-align:center; margin:10px auto; max-width:300px; max-height:300px;' />";
		}
		echo "</div>\n";
	}
}
include "include/footer.php";