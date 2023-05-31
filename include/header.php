<!DOCTYPE HTML>
<html>
    <head>
        <title>Cheyenne Community Development Corporation</title>
<meta name="keywords" content="kansas, cheyenne co, cheyenne county, development, business, ccdc, northwest kansas, nw kansas, travel cheyenne county ks, travel cheyenne co ks" />
<meta name="description" content="For a day or a lifetime, come to Cheyenne County! Old fashioned values combined with 21st Century technology make Cheyenne County a destination for all ages. Wide-open spaces and friendly faces where business is still done on a hand shake. Award winning schools. Special events. Excellent healthcare. Vibrant entrepreneurship. The life you've dreamed of. Come home to Cheyenne County." />
<style type="text/css">
    @font-face
    {
        font-family: impact;
        src: url('impact.ttf')
    }

    a {
        color: #000000;
        text-decoration:underline;
    }

    a:hover {
        color: #cccccc;
    }

</style>
<script src="jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="usableforms.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1" />
  <link rel="stylesheet" href="css/lightbox.min.css">
    <script type="text/javascript">
        function showCategory(str, l)
        {
            if (str === "")
            {
                document.getElementById("listCategory").innerHTML = "";
                return;
            }
            if (window.XMLHttpRequest)
            {// code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else
            {// code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function ()
            {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200)
                {
                    document.getElementById("listCategory").innerHTML = xmlhttp.responseText;
                }
            };
            xmlhttp.open("GET", "businessesajax.php?q=" + str + "&l=" + l, true);
            xmlhttp.send();
        }

    function toggleview(itm) {
        var itmx = document.getElementById(itm);
        if (itmx.style.display === "none") {
            itmx.style.display = "block";
        } else {
            itmx.style.display = "none";
        }
    }
</script>
<style>
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
</style>
    </head>
    <body style="font-family:sans-serif; width:100%; position:relative; top:0px; left:0px; color:#000000;">
    <div style="width:90%; margin:40px auto; background-color:#ffffff;">
    <img src="image/headPic.png" style="position:relative; top:0px; left:-10px; width:100%;" alt="">
    <div style="width:90%; margin:0px auto; background-color:#ffffff;">
    <table style="width:100%;">
    <tr>
    <td style="padding:10px; text-align:center; font-weight:bold; font-size:1.5em;" colspan="3">Cheyenne Community Development Corporation</td>
	</tr>
	<tr>
    <td style="width:33%; padding:10px; text-align:left; font-weight:bold; cursor:pointer;" onclick="toggleview('showContact')">Contact Us</td>
    <td style="width:33%; padding:10px; text-align:center; font-weight:bold;">785-332-3508</td>
    <td style="width:33%; padding:10px; text-align:right; font-weight:bold; cursor:pointer;" onclick="toggleview('showMenu')">Menu</td>
	</tr>
	</table>
	<div id="showContact" style="width:100%; margin:0px auto; display:none;">
	<div style="text-align:right; padding:10px; font-weight:bold; cursor:pointer;" onclick="toggleview('showContact')">Close</div>
	<div style="text-align:center; text-size:1.25em; margin-bottom:20px; font-weight:bold;">Contact Us</div>
	<div style="text-align:justify;"><br /><br />Questions about Cheyenne County Development? Please contact us. Our phone number is 785-332-3508 or use the form below. Thank you!<br /><br /></div>
    <form method="post" action="index.php">
        <table cellspacing="0px" border="0px">
            <tr>
                <td style="padding:10px 0px;">First name:</td>
                <td style="padding:10px 0px;"><input type="text" name="fname" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Last name:</td>
                <td style="padding:10px 0px;"><input type="text" name="lname" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Address street 1:</td>
                <td style="padding:10px 0px;"><input type="text" name="addy1" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Address street 2:</td>
                <td style="padding:10px 0px;"><input type="text" name="addy2" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">City:</td>
                <td style="padding:10px 0px;"><input type="text" name="city" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Zip:</td>
                <td style="padding:10px 0px;"><input type="text" name="zip" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">State:</td>
                <td style="padding:10px 0px;"><select name="state" size="1">
                    <option value="AL">AL</option>
                    <option value="AK">AK</option>
                    <option value="AZ">AZ</option>
                    <option value="AR">AR</option>
                    <option value="CA">CA</option>
                    <option value="CO">CO</option>
                    <option value="CT">CT</option>
                    <option value="DE">DE</option>
                    <option value="DC">DC</option>
                    <option value="FL">FL</option>
                    <option value="GA">GA</option>
                    <option value="HI">HI</option>
                    <option value="ID">ID</option>
                    <option value="IL">IL</option>
                    <option value="IN">IN</option>
                    <option value="IA">IA</option>
                    <option value="KS">KS</option>
                    <option value="KY">KY</option>
                    <option value="LA">LA</option>
                    <option value="ME">ME</option>
                    <option value="MD">MD</option>
                    <option value="MA">MA</option>
                    <option value="MI">MI</option>
                    <option value="MN">MN</option>
                    <option value="MS">MS</option>
                    <option value="MO">MO</option>
                    <option value="MT">MT</option>
                    <option value="NE">NE</option>
                    <option value="NV">NV</option>
                    <option value="NH">NH</option>
                    <option value="NJ">NJ</option>
                    <option value="NM">NM</option>
                    <option value="NY">NY</option>
                    <option value="NC">NC</option>
                    <option value="ND">ND</option>
                    <option value="OH">OH</option>
                    <option value="OK">OK</option>
                    <option value="OR">OR</option>
                    <option value="PA">PA</option>
                    <option value="RI">RI</option>
                    <option value="SC">SC</option>
                    <option value="SD">SD</option>
                    <option value="TN">TN</option>
                    <option value="TX">TX</option>
                    <option value="UT">UT</option>
                    <option value="VT">VT</option>
                    <option value="VA">VA</option>
                    <option value="WA">WA</option>
                    <option value="WV">WV</option>
                    <option value="WI">WI</option>
                    <option value="WY">WY</option>
                    </select></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Daytime phone:</td>
                <td style="padding:10px 0px;"><input type="text" name="dphone" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Evening phone:</td>
                <td style="padding:10px 0px;"><input type="text" name="ephone" value=""></td>
            </tr>
            <tr>
                <td style="padding:10px 0px;">Email:</td>
                <td style="padding:10px 0px;"><input type="text" name="email" value=""></td>
            </tr>
            <tr>
                <td colspan="2" style="padding:10px 0px;">
                    This message is for: <select name="for" size="1">
                        <option value="director">CCDC Director - <?php
																								$stmt = $db->prepare ( "SELECT name FROM members WHERE title='director'" );
																								$stmt->execute ();
																								$row = $stmt->fetch ();
																								$director = $row ['name'];
																								echo $director;
																								?></option>
                        <option value="support">Website Support - Jason Padgett</option>
                    </select>
            <tr>
                <td colspan="2" style="padding:10px 0px;">Comments:<br>
                <textarea name="comments" cols="42" rows="12"></textarea></td>
            </tr>
            <tr>
                <td colspan="2" style="padding:10px 0px;"><input type="hidden" name="submitemail" value="1"><input type="submit" value=" SEND "></td>
            </tr>
        </table>
    </form>
	</div>
	<div id="showMenu" style="width:70%; margin:0px auto; display:none; text-align:center; border:1px solid black;">
	<div style="text-align:right; padding:10px; font-weight:bold; cursor:pointer;" onclick="toggleview('showMenu')">Close</div>
	<div style="margin-top:9px; cursor:pointer;">
    <a href='index.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Home</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='blog.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>News</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='calendar.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Event Calendar</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='index.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Explore Cheyenne Co</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
<a href='dining.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Dining</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='lodging.php?page=lodging' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Lodging</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='business.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Businesses</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='commercial.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Commercial Properties</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='jobs.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Job Opportunites</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='cheyenneopoly.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Cheyenneopoly Game</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='https://www.ncta.com/connectingruralamerica' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;' target="_blank">NCTA Connecting Rural America</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='links.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Links</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
    <a href='about.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>About Us</a>
</div>
<div style="margin-top:9px; cursor:pointer;">
<?php
if ($loggedin == '1') {
	?>
    <a href='index.php?logout=yep' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Log Out</a>
    <?php
} else {
	?>
    <a href='login.php' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Log In</a>
    <?php
}
?>
</div>
<?php
if ($loggedin == "1") {
	echo "<div style='margin-top:30px; cursor:pointer;'>";
	echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Edit users:</div>";
	echo "<form action='users.php' method='post'><select name='user' size='1'><option value='new'>New user</option>\n";
	$stmt = $db->prepare ( "SELECT id,userid FROM users" );
	$stmt->execute ();
	while ( $row = $stmt->fetch () ) {
		$id = $row ['id'];
		$userid = $row ['userid'];
		echo "<option value='$id'>$userid</option>\n";
	}
	echo "</select><input type='submit' value='Go' /></form>";
	echo "</div>";

	if (filter_input ( INPUT_POST, 'delPDF', FILTER_SANITIZE_NUMBER_INT )) {
		$delPDF = filter_input ( INPUT_POST, 'delPDF', FILTER_SANITIZE_NUMBER_INT );
		$stmt1 = $db->prepare ( "SELECT flyerName FROM flyers WHERE id=?" );
		$stmt1->execute ( array (
				$delPDF
		) );
		$row1 = $stmt1->fetch ();
		$flyerName = $row1 ['flyerName'];
		$stmt2 = $db->prepare ( "DELETE FROM flyers WHERE id=?" );
		$stmt2->execute ( array (
				$delPDF
		) );
		if (file_exists ( "pdf/$flyerName.pdf" )) {
			unlink ( "pdf/$flyerName.pdf" );
		}
	}
	if (filter_input ( INPUT_POST, 'upPDF', FILTER_SANITIZE_STRING ) == 'new') {
		$pdfName = $time;
		$flyerDesc = filter_input ( INPUT_POST, 'flyerDesc', FILTER_SANITIZE_STRING );
		$flyerOrder = filter_input ( INPUT_POST, 'flyerOrder', FILTER_SANITIZE_NUMBER_INT );
		$t = 1;
		$pdfO = $db->prepare ( "SELECT id, flyerOrder FROM flyers ORDER BY flyerOrder" );
		$pdfO->execute ();
		while ( $pdfR = $pdfO->fetch () ) {
			$pdfO2 = $db->prepare ( "UPDATE flyers SET flyerOrder = ? WHERE id = ?" );
			$pdfO2->execute ( array (
					$t,
					$pdfR ['id']
			) );
			$t ++;
		}
		$pdfO3 = $db->prepare ( "SELECT id, flyerOrder FROM flyers" );
		$pdfO3->execute ();
		while ( $pdfR3 = $pdfO3->fetch () ) {
			if ($pdfR3 ['flyerOrder'] >= $flyerOrder) {
				$pdfO4 = $db->prepare ( "UPDATE flyers SET flyerOrder = flyerOrder + 1 WHERE id = ?" );
				$pdfO4->execute ( array (
						$pdfR3 ['id']
				) );
			}
		}
		$saveto = "pdf/$pdfName.pdf";
		move_uploaded_file ( $_FILES ['getPDF'] ['tmp_name'], $saveto );
		if (file_exists ( "pdf/$pdfName.pdf" )) {
			$pdfstmt = $db->prepare ( "INSERT INTO flyers VALUES(NULL,?,?,?,'0','0')" );
			$pdfstmt->execute ( array (
					$pdfName,
					$flyerDesc,
					$flyerOrder
			) );
		}
	}
}
?>
<div style='margin-top:30px; cursor:pointer;'><span style='font-weight:bold; font-size:1em; text-decoration:underline; font-family:sans-serif; cursor:pointer;'>Informational Flyers</span></div>
<div style='margin-top:9px; cursor:pointer;'><a href='HTTP://ONLINE.PUBLICATIONPRINTERS.COM/LAUNCH.ASPX?EID=A61AF0A3-CF47-44F9-A242-451C31D0DA06' target='_blank' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>Land & Sky Scenic Byway</a></div>
<?php
$stmt = $db->prepare ( "SELECT * FROM flyers ORDER BY flyerOrder" );
$stmt->execute ();
while ( $row = $stmt->fetch () ) {
	echo "<div style='margin-top:9px; cursor:pointer;'>";
	if ($loggedin == "1") {
		echo "<form action='index.php' method='post'><input type='hidden' name='delPDF' value='" . $row ['id'] . "' /><input type='submit' value=' Delete ' /><span style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>" . $row ['flyerDesc'] . "</span></form>";
	} else {
		echo "<a href='pdf/" . $row ['flyerName'] . ".pdf' target='_blank' style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif; cursor:pointer;'>" . $row ['flyerDesc'] . "</a>";
	}
	echo "</div>\n";
}
if ($loggedin == "1") {
	echo "<form action='index.php' method='post' enctype='multipart/form-data' style=''>Upload a new PDF flyer:<br /><br /><input type='file' name='getPDF' /><br /><br />Displayed Name: <input type='text' name='flyerDesc' value='' /><br /><br />Placement in list:<select name='flyerOrder' size='1'>";
	$stmtC = $db->prepare ( "SELECT COUNT(*) FROM flyers" );
	$stmtC->execute ();
	$rowC = $stmtC->fetch ();
	$fCount = $rowC [0] + 1;
	for($i = 1; $i <= $fCount; $i ++) {
		echo "<option value='$i'";
		if ($i == $fCount) {
			echo " selected";
		}
		echo ">$i</option>\n";
	}
	echo "</select><br /><br /><input type='hidden' name='upPDF' value='new' /><input type='submit' value=' Upload PDF ' /></form>";
}
?>
<div style='margin-top:9px; cursor:pointer;'>
<a href='NWGuide.php'><img src='image/NWGuideCover.png' style='max-width:100%;' /></a>
</div>
    </div>
    <div style="width:100%; height:20px;">&nbsp;</div>