<?php
include "cgi-bin/config.php";
include "include/header.php";

if (filter_input(INPUT_POST, 'addlink', FILTER_SANITIZE_STRING)) {
    $addlink = filter_input(INPUT_POST, 'addlink', FILTER_SANITIZE_STRING);
    $linktitle = filter_input(INPUT_POST, 'linktitle', FILTER_SANITIZE_STRING);
    $linktext = filter_input(INPUT_POST, 'linktext', FILTER_SANITIZE_STRING);
    $linkaddress = filter_input(INPUT_POST, 'linkaddress', FILTER_SANITIZE_URL);
    $linkemail = filter_input(INPUT_POST, 'linkemail', FILTER_SANITIZE_EMAIL);
    $linkphone = filter_input(INPUT_POST, 'linkphone', FILTER_SANITIZE_STRING);
    $linkaddr1 = filter_input(INPUT_POST, 'linkaddr1', FILTER_SANITIZE_STRING);
    $linkaddr2 = filter_input(INPUT_POST, 'linkaddr2', FILTER_SANITIZE_STRING);
    $linkaddr3 = filter_input(INPUT_POST, 'linkaddr3', FILTER_SANITIZE_STRING);
    if ($addlink == "new") {
        $stmt = $db->prepare("INSERT INTO links VALUES" . "(NULL, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $linktitle,
            $linktext,
            $linkaddress,
            $linkemail,
            $linkphone,
            $linkaddr1,
            $linkaddr2,
            $linkaddr3
        ));
        echo "Link Added...<br />";
    } else {
        $stmt = $db->prepare("UPDATE links SET title=?,description=?,website=?,email=?,phone=?,address1=?,address2=?,address3=? WHERE id=?");
        $stmt->execute(array(
            $linktitle,
            $linktext,
            $linkaddress,
            $linkemail,
            $linkphone,
            $linkaddr1,
            $linkaddr2,
            $linkaddr3,
            $addlink
        ));
    }
}

$editlink = "";
if (filter_input(INPUT_GET, 'editlink', FILTER_SANITIZE_STRING)) {
    $editlink = filter_input(INPUT_GET, 'editlink', FILTER_SANITIZE_STRING);
}

if ($editlink == "new") {
    echo "<div style=''>Add a new link...<br /><form method='post' action='links.php'>";
    echo "Title...<br /><input type='text' name='linktitle' value='' size='60' maxlength='60' /><br />";
    echo "Description...<br /><textarea name='linktext' cols='60' rows='6' maxlength='500' /></textarea><br />";
    echo "Website address...<br /><input type='text' name='linkaddress' value='http://' size='60' maxlength='60' /><br />";
    echo "Email Address...<br /><input type='text' name='linkemail' value='' size='60' maxlength='60' /><br />";
    echo "Phone Number...<br /><input type='text' name='linkphone' value='' size='60' maxlength='13' /><br />";
    echo "Physical Address Line 1...<br /><input type='text' name='linkaddr1' value='' size='60' maxlength='60' /><br />";
    echo "Physical Address Line 2...<br /><input type='text' name='linkaddr2' value='' size='60' maxlength='60' /><br />";
    echo "Physical Address Line 3...<br /><input type='text' name='linkaddr3' value='' size='60' maxlength='60' /><br />";
    echo "<input type='hidden' name='addlink' value='new' /><input type='submit' value=' -Add Link- ' style='border-radius:8px; -moz-border-radius:8px;' /></form></div>";
} elseif ($loggedin == "1") {
    echo "<div style='text-align:center;'><a href='links.php?editlink=new' style='font-size:1.5em;'>...Add a new link...</a></div><br />";
}

$stmt = $db->prepare("SELECT * FROM links");
$stmt->execute();
while ($row = $stmt->fetch()) {
    $idlink = $row[0];
    $titlelink = $row[1];
    $text = $row[2];
    $textlink = nl2br($text);
    $weblink = $row[3];
    $emaillink = $row[4];
    $phonelink = $row[5];
    $addr1link = $row[6];
    $addr2link = $row[7];
    $addr3link = $row[8];
    if ($editlink == $idlink) {
        echo "<div style=''><a name='idlink' style='text-decoration:none;'>Edit this link...</a><br /><form method='post' action='links.php'>";
        echo "Title...<br /><input type='text' name='linktitle' value='$titlelink' size='60' maxlength='60' /><br />";
        echo "Description...<br /><textarea name='linktext' cols='60' rows='6' maxlength='500' />$text</textarea><br />";
        echo "Website address...<br /><input type='text' name='linkaddress' value='$weblink' size='60' maxlength='60' /><br />";
        echo "Email Address...<br /><input type='text' name='linkemail' value='$emaillink' size='60' maxlength='60' /><br />";
        echo "Phone Number...<br /><input type='text' name='linkphone' value='$phonelink' size='60' maxlength='13' /><br />";
        echo "Physical Address Line 1...<br /><input type='text' name='linkaddr1' value='$addr1link' size='60' maxlength='60' /><br />";
        echo "Physical Address Line 2...<br /><input type='text' name='linkaddr2' value='$addr2link' size='60' maxlength='60' /><br />";
        echo "Physical Address Line 3...<br /><input type='text' name='linkaddr3' value='$addr3link' size='60' maxlength='60' /><br />";
        echo "<input type='hidden' name='addlink' value='$idlink' /><input type='submit' value=' -Edit Link- ' style='border-radius:8px; -moz-border-radius:8px;' /></form></div>";
    } else {
        if ($titlelink) {
            echo "<div style='text-align:center; font-size:1.5em;'>$titlelink</div>";
        }
        if ($weblink) {
            echo "<div style='text-align:center; font-size:1em;'><a href='$weblink' target='_blank' style=''>$weblink</a></div>";
        }
        if ($emaillink) {
            echo "<div style='text-align:center; font-size:1em;'><a href='mailto:$emaillink' style=''>$emaillink</a></div>";
        }
        if ($phonelink) {
            echo "<div style='text-align:center; font-size:1em;'>$phonelink</div>";
        }
        if ($addr1link) {
            echo "<div style='text-align:center; font-size:1em;'>$addr1link</div>";
        }
        if ($addr2link) {
            echo "<div style='text-align:center; font-size:1em;'>$addr2link</div>";
        }
        if ($addr3link) {
            echo "<div style='text-align:center; font-size:1em;'>$addr3link</div>";
        }
        if ($textlink) {
            echo "<div style='text-align:center; font-size:1em; margin:10px 40px;'>$textlink</div>";
        }
        if ($loggedin == "1") {
            echo "<br /><div style='text-align:center; font-size:1em;'><a href='links.php?editlink=$idlink#idlink' style=''>...Edit this link...</a></div>";
        }
        echo "<hr style='width:50%; background-color:#aa9f93;'>";
    }
}

include "include/footer.php";