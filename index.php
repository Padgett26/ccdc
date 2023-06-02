<?php
include "cgi-bin/config.php";
include "include/header.php";

if ($loggedin == "1") {
    if (filter_input(INPUT_POST, 'homeText', FILTER_SANITIZE_STRING)) {
        $a2 = htmlEntities(trim($_POST['homeText']), ENT_QUOTES);
        $text = filter_var($a2, FILTER_SANITIZE_STRING);
        $stmt1 = $db->prepare("UPDATE pages SET content=? WHERE page=?");
        $stmt1->execute(array(
                $text,
                'home'
        ));
    }
}

$stmt2 = $db->prepare("SELECT content FROM pages WHERE page='home'");
$stmt2->execute();
$row2 = $stmt2->fetch();
$homeText = nl2br(
        make_links_clickable(
                html_entity_decode($row2['content'], ENT_QUOTES)));

if ($loggedin == "1") {
    echo "<div><form action='index.php' method='post'><textarea name='homeText' rows='7' cols='42'>" .
            $row2['content'] .
            "</textarea><div style='text-align:right'><input type='submit' value=' Upload ' /></div></form></div>";
} else {
    echo "<div style='margin:40px auto; width:70%; text-align:justify; font-weight:bold; font-family:Sans-serif; line-height:200%;'>$homeText</div>";
}

?>
<div style="text-align:center;"><img src="image/exploreButton.png" alt="" style="border:40px 0px;"></div>
<?php
if ($loggedin == "1") {
    if (filter_input(INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT)) {
        $id = filter_input(INPUT_POST, 'confdelpost', FILTER_SANITIZE_NUMBER_INT);
        $stmt1 = $db->prepare("DELETE FROM explore WHERE id=?");
        $stmt1->execute(array(
                $id
        ));
        echo "Post deleted...";
    }

    $picname1 = "0";
    $picname2 = "0";

    if (isset($_FILES['image1']['tmp_name']) &&
            ($_FILES['image1']['size'] > 1000)) {
        $tmpFile = $_FILES['image1']['tmp_name'];

        list ($width, $height) = (getimagesize($tmpFile) != null) ? getimagesize(
                $tmpFile) : null;
        if ($width != null && $height != null) {
            $picname1 = filter_input(INPUT_POST, 'picname1',
                    FILTER_SANITIZE_NUMBER_INT);
            $imageType = getPicType($_FILES["image1"]["type"]);
            processPic("explore", $picname1, "400", "400", $tmpFile, $imageType);
            processPic("image/explore", $picname1 . "." . $imageType,
                    $tmpFile, 400, 150);
        }
    }

    if (isset($_FILES['image2']['tmp_name']) &&
            ($_FILES['image2']['size'] > 1000)) {
        $tmpFile = $_FILES['image2']['tmp_name'];

        list ($width, $height) = (getimagesize($tmpFile) != null) ? getimagesize(
                $tmpFile) : null;
        if ($width != null && $height != null) {
            $picname2 = filter_input(INPUT_POST, 'picname2',
                    FILTER_SANITIZE_NUMBER_INT);
            $imageType = getPicType($_FILES["image2"]["type"]);
            processPic("image/explore", $picname2 . "." . $imageType,
                    $tmpFile, 400, 150);
        }
    }

    if (filter_input(INPUT_POST, 'postnote', FILTER_SANITIZE_STRING)) {
        $id = filter_input(INPUT_POST, 'postnote', FILTER_SANITIZE_STRING);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
        $a2 = htmlEntities(trim($_POST['content']), ENT_QUOTES);
        $content = filter_var($a2, FILTER_SANITIZE_STRING);
        $picname1 = (isset($picname1)) ? $picname1 : '0';
        $picname2 = (isset($picname2)) ? $picname2 : '0';
        $delpic1 = (filter_input(INPUT_POST, 'delpic1',
                FILTER_SANITIZE_NUMBER_INT) == '1') ? '1' : '0';
        $delpic2 = (filter_input(INPUT_POST, 'delpic2',
                FILTER_SANITIZE_NUMBER_INT) == '1') ? '1' : '0';
        $delpost = (filter_input(INPUT_POST, 'delpost',
                FILTER_SANITIZE_NUMBER_INT) == '1') ? '1' : '0';
        if ($id == "new") {
            $stmt2 = $db->prepare(
                    "INSERT INTO explore VALUES" . "(NULL,?,?,NULL,?,?,'0','0')");
            $stmt2->execute(array(
                    $title,
                    $content,
                    $picname1,
                    $picname2
            ));
            echo "Post added...";
        } else {
            if ($delpost == "1") {
                echo "Are you sure you want to delete this post? <form action='explore.php' method='post'><input type='hidden' name='confdelpost' value='$id' /><input type='submit' value=' YES ' /></form> <form action='explore.php' method='post'><input type='submit' value=' NO ' /></form>";
            } else {
                if ($delpic1 == '1') {
                    $stmt3 = $db->prepare("SELECT pic1 FROM explore WHERE id=?");
                    $stmt3->execute(array(
                            $id
                    ));
                    $row3 = $stmt3->fetch();
                    $delpicname1 = $row3['pic1'];
                    if (file_exists("image/explore/$delpicname1.jpg")) {
                        unlink("image/explore/$delpicname1.jpg");
                    }
                    $stmt4 = $db->prepare(
                            "UPDATE explore SET pic1=? WHERE id=?");
                    $stmt4->execute(array(
                            '0',
                            $id
                    ));
                }
                if ($delpic2 == '1') {
                    $stmt5 = $db->prepare("SELECT pic2 FROM explore WHERE id=?");
                    $stmt5->execute(array(
                            $id
                    ));
                    $row5 = $stmt5->fetch();
                    $delpicname2 = $row5['pic2'];
                    if (file_exists("image/explore/$delpicname2.jpg")) {
                        unlink("image/explore/$delpicname2.jpg");
                    }
                    $stmt6 = $db->prepare(
                            "UPDATE explore SET pic2=? WHERE id=?");
                    $stmt6->execute(array(
                            '0',
                            $id
                    ));
                }
                $stmt7 = $db->prepare(
                        "UPDATE explore SET title=?,content=? WHERE id=?");
                $stmt7->execute(array(
                        $title,
                        $content,
                        $id
                ));
                if ($picname1 != '0') {
                    $stmt8 = $db->prepare(
                            "UPDATE explore SET pic1=? WHERE id=?");
                    $stmt8->execute(array(
                            $picname1,
                            $id
                    ));
                }
                if ($picname2 != '0') {
                    $stmt9 = $db->prepare(
                            "UPDATE explore SET pic2=? WHERE id=?");
                    $stmt9->execute(array(
                            $picname2,
                            $id
                    ));
                }
                echo "Post updated...<br />";
            }
        }
    }

    echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
    echo "<form action='index.php' method='post' enctype='multipart/form-data'>\n";
    echo "Insert a new post:<br />\n";
    echo "Title: <input type='text' name='title' maxlength='190' /><br />\n";
    echo "Content:<br />\n";
    echo "<textarea name='content' cols='75' rows='15'></textarea><br /><br />\n";
    echo "Insert picture 1: <input type='file' name='image1' /><input type='hidden' name='picname1' value='" .
            (time() + 1) . "' /><br /><br />";
    echo "Insert picture 2: <input type='file' name='image2' /><input type='hidden' name='picname2' value='" .
            (time() + 2) . "' /><br /><br />";
    echo "<input type='hidden' name='postnote' value='new' />\n";
    echo "<input type='submit' value=' Upload ' /></form></div><br /><br />\n";
}
$stmt10 = $db->prepare("SELECT * FROM explore ORDER BY RAND()");
$stmt10->execute();
while ($row10 = $stmt10->fetch()) {
    $id = $row10['id'];
    $title = $row10['title'];
    $content = make_links_clickable(
            html_entity_decode($row10['content'], ENT_QUOTES));
    $c1 = str_replace("\n", '<br>', $content);
    $c = explode("<br>", $c1);
    $pic1 = $row10['pic1'];
    $pic2 = $row10['pic2'];
    $updated = $row10['updated'];
    if ($loggedin == "1") {
        echo "<hr><br>\n";
        echo "<div style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>\n";
        echo "<form action='index.php' method='post' enctype='multipart/form-data'>\n";
        echo "<div style='cursor:pointer;' onclick='toggleview(\"L$id\")'>Edit this post: <span style='text-decoration:underline;'>$title</span></div><br />\n";
        echo "<div id='L$id' style='display:none; margin-top:10px;'>Title: <input type='text' name='title' maxlength='190' value='$title' /><br /><br />\n";
        echo "Last updated: $updated<br /><br />\n";
        echo "Content:<br />\n";
        echo "<textarea name='content' cols='75' rows='15'>" . $row10['content'] .
                "</textarea><br /><br />\n";
        echo "Picture 1:<br />";
        if (file_exists("image/explore/$pic1.jpg")) {
            echo "<img src='image/explore/$pic1.jpg' alt='' /><br /><input type='checkbox' name='delpic1' value='1' /> Delete this pic<br />";
        }
        echo "<input type='file' name='image1' /><input type='hidden' name='picname1' value='" .
                $time . "1' /><br /><br />";
        echo "Picture 2:<br />";
        if (file_exists("image/explore/$pic2.jpg")) {
            echo "<img src='image/explore/$pic2.jpg' alt='' /><br /><input type='checkbox' name='delpic2' value='1' /> Delete this pic<br />";
        }
        echo "<input type='file' name='image2' /><input type='hidden' name='picname2' value='" .
                $time . "2' /><br /><br />";
        echo "Delete this post: <input type='checkbox' name='delpost' value='1' /><br /><br />\n";
        echo "<input type='hidden' name='postnote' value='$id' />\n";
        echo "<input type='submit' value=' Upload ' /></div></form></div><br /><hr /><br />\n";
    } else {
        echo "<hr><br>\n";
        echo "<div class='clearfix' style=''><div style='text-align:center; padding:10px; font-weight:bold; font-size:1.25em;'>$title</div>";
        if (file_exists("image/explore/$pic1.jpg")) {
            echo "<img src='image/explore/$pic1.jpg' alt='' style='float:right; margin:10px; max-width:150px; max-height:150px;' />";
        }
        echo "<div style='text-align:justify; font-family:sans-serif; padding:10px;'>" .
                $c[0] . "<br><br>";
        echo "<a href='exploreDetail.php?show=$id' style='text-decoration:none;'>...View detail page...</a></div>";
        echo "</div>\n";
    }
}

echo "<hr><br>\n";
echo "<div style='text-align:center; font-weight:bold; font-size:1.25em; padding:10px;'>River Walk and Keller Pond Flyover</div>\n";
echo "<div style='margin:10px;'>Drone footage of the River Walk and Keller Pond</div>";
echo "<div style='margin-left: 40px;'><iframe width='560' height='315' src='https://www.youtube.com/embed/LwP4p_7Ck_A' frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe></div>";
?>
</div>
<?php
include "include/footer.php";