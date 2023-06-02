<?php
include "cgi-bin/config.php";
include "include/header.php";

$l = ($loggedin == "1") ? "l" : "x";
echo "<div style='margin-top:9px;'><span style='font-weight:bold; font-size:1.25em; text-decoration:none; font-family:sans-serif;'>Categories:</span></div>\n";
$stmt2 = $db->prepare(
        "SELECT id,category FROM busiCategories ORDER BY category");
$stmt2->execute();
while ($row2 = $stmt2->fetch()) {
    $cId = $row2['id'];
    $cCategory = $row2['category'];
    $stmt = $db->prepare("SELECT COUNT(*) FROM business WHERE category=?");
    $stmt->execute(array(
            $cId
    ));
    $row = $stmt->fetch();
    if ($row[0] >= 1) {
        echo "<div style='padding:10px; cursor:pointer; float:left;' onclick='showCategory(\"$cId\", \"$l\")'><span style='font-weight:bold; font-size:1em; text-decoration:none; font-family:sans-serif;'>$cCategory</span></div>\n";
    }
}
echo "<div style='clear:both; width:100%; height:30px;'>&nbsp;</div>";

if ($loggedin == "1") {
    if (filter_input(INPUT_POST, 'confdelbusi', FILTER_SANITIZE_NUMBER_INT)) {
        $did = filter_input(INPUT_POST, 'confdelbusi',
                FILTER_SANITIZE_NUMBER_INT);
        $stmtPic = $db->prepare(
                "SELECT picture, picExt FROM business WHERE id=?");
        $stmtPic->execute(array(
                $did
        ));
        $sprow = $stmtPic->fetch();
        $sp = $sprow['picture'];
        $spExt = $sprow['picExt'];
        if (file_exists("image/business/$sp.$spExt")) {
            unlink("image/business/$sp.$spExt");
        }
        $stmt1 = $db->prepare("DELETE FROM business WHERE id=?");
        $stmt1->execute(array(
                $did
        ));
        echo "<div style=' clear:both;'>Business Deleted....</div>";
    }

    if (filter_input(INPUT_POST, 'businessup', FILTER_SANITIZE_STRING)) {
        $id = filter_input(INPUT_POST, 'businessup', FILTER_SANITIZE_STRING);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $contact = filter_input(INPUT_POST, 'contact', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $fax = filter_input(INPUT_POST, 'fax', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $website = filter_input(INPUT_POST, 'website', FILTER_SANITIZE_URL);
        $mailing = filter_input(INPUT_POST, 'mailing', FILTER_SANITIZE_STRING);
        $physical = filter_input(INPUT_POST, 'physical', FILTER_SANITIZE_STRING);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
        $zipCode = filter_input(INPUT_POST, 'zipCode', FILTER_SANITIZE_STRING);
        $a2 = htmlEntities(trim($_POST['description']), ENT_QUOTES);
        $description = filter_var($a2, FILTER_SANITIZE_STRING);
        $delbusi = (filter_input(INPUT_POST, 'delbusi',
                FILTER_SANITIZE_NUMBER_INT) == "1") ? "1" : "0";
        $delPic = (filter_input(INPUT_POST, 'delPic', FILTER_SANITIZE_NUMBER_INT) ==
                "1") ? "1" : "0";
        if ($delbusi == "1") {
            echo "<div style='text-align:center; clear:both;'>Are you sure you want to delete this listing?<form action='business.php' method='post'><input type='hidden' name='confdelbusi' value='$id' /><input type='submit' value=' YES ' /></form><form action='business.php' method='post'><input type='submit' value=' NO ' /></form></div>";
        } else {
            if ($id == "new") {
                $stmt3 = $db->prepare(
                        "INSERT INTO business VALUES" .
                        "(NULL,?,?,?,?,?,?,?,?,?,?,?,?,?,'0','0','0')");
                $stmt3->execute(
                        array(
                                $category,
                                $name,
                                $contact,
                                $phone,
                                $fax,
                                $email,
                                $website,
                                $mailing,
                                $physical,
                                $city,
                                $state,
                                $zipCode,
                                $description
                        ));
                $stmt2 = $db->prepare(
                        "SELECT id FROM business WHERE category=? && name=? ORDER BY id DESC LIMIT 1");
                $stmt2->execute(array(
                        $category,
                        $name
                ));
                $niRow = $stmt2->fetch();
                $newId = $niRow['id'];

                if (isset($_FILES['image']['tmp_name']) &&
                        $_FILES['image']['size'] > 1000) {
                    $tmpFile = $_FILES["image"]["tmp_name"];
                    list ($width, $height) = (getimagesize($tmpFile) != null) ? getimagesize(
                            $tmpFile) : null;
                    if ($width != null && $height != null) {
                        $imageType = getPicType($_FILES["image"]["type"]);
                        processPic("image/business",
                                $time . "." . $imageType, $tmpFile, 800, 150);
                        $pstmt1 = $db->prepare(
                                "UPDATE business SET picture=?, picExt=? WHERE id=?");
                        $pstmt1->execute(array(
                                $time,
                                $imageType,
                                $newId
                        ));
                    }
                }
                echo "<div style=' clear:both;'>Business Added....</div>";
            } else {
                $stmt = $db->prepare(
                        "UPDATE business SET category=?,name=?,contact=?,phone=?,fax=?,email=?,website=?,mailing=?,physical=?,city=?,state=?,zipCode=?,description=? WHERE id=?");
                $stmt->execute(
                        array(
                                $category,
                                $name,
                                $contact,
                                $phone,
                                $fax,
                                $email,
                                $website,
                                $mailing,
                                $physical,
                                $city,
                                $state,
                                $zipCode,
                                $description,
                                $id
                        ));

                if (isset($_FILES['image']['tmp_name']) &&
                        $_FILES['image']['size'] > 1000) {
                    $tmpFile = $_FILES["image"]["tmp_name"];
                    list ($width, $height) = (getimagesize($tmpFile) != null) ? getimagesize(
                            $tmpFile) : null;
                    if ($width != null && $height != null) {
                        $imageType = getPicType($_FILES["image"]["type"]);
                        processPic("image/business",
                                $time . "." . $imageType, $tmpFile, 800, 150);
                        $pstmt2 = $db->prepare(
                                "UPDATE business SET picture=?, picExt=? WHERE id=?");
                        $pstmt2->execute(array(
                                $time,
                                $imageType,
                                $id
                        ));
                    }
                }
                echo "<div style=' clear:both;'>Business Updated....</div>";
            }
        }
        if ($delPic == "1") {
            $stmtPic = $db->prepare(
                    "SELECT picture, picExt FROM business WHERE id=?");
            $stmtPic->execute(array(
                    $id
            ));
            $sprow = $stmtPic->fetch();
            $sp = $sprow['picture'];
            $spExt = $sprow['picExt'];
            if (file_exists("image/business/$sp.$spExt")) {
                unlink("image/business/$sp.$spExt");
            }
            $stmt4 = $db->prepare(
                    "UPDATE business SET picture=?, picExt=? WHERE id=?");
            $stmt4->execute(array(
                    '0',
                    'xxx',
                    $id
            ));
        }
    }

    if (filter_input(INPUT_POST, 'editbusi', FILTER_SANITIZE_NUMBER_INT)) {
        $formtitle = "Edit the business listing";
        $fid = filter_input(INPUT_POST, 'editbusi', FILTER_SANITIZE_NUMBER_INT);
        $stmt5 = $db->prepare("SELECT * FROM business WHERE id=?");
        $stmt5->execute(array(
                $fid
        ));
        $row5 = $stmt5->fetch();
        $fcategory = $row5['category'];
        $fname = $row5['name'];
        $fcontact = $row5['contact'];
        $fphone = $row5['phone'];
        $ffax = $row5['fax'];
        $femail = $row5['email'];
        $fwebsite = $row5['website'];
        $fmailing = $row5['mailing'];
        $fphysical = $row5['physical'];
        $fcity = $row5['city'];
        $fstate = $row5['state'];
        $fzipCode = $row5['zipCode'];
        $fdescription = $row5['description'];
        $fpicture = $row5['picture'];
        $fpicExt = $row5['picExt'];
    } else {
        $formtitle = "Add a new business listing";
        $fid = "new";
        $fcategory = "0";
        $fname = "";
        $fcontact = "";
        $fphone = "";
        $ffax = "";
        $femail = "";
        $fwebsite = "";
        $fmailing = "";
        $fphysical = "";
        $fcity = "";
        $fstate = "";
        $fzipCode = "";
        $fdescription = "";
        $fpicture = "xxx";
        $fpicExt = "xxx";
    }

    if (filter_input(INPUT_POST, 'categories', FILTER_SANITIZE_NUMBER_INT) == "1") {
        foreach ($_POST as $key => $val) {
            if (preg_match("/^category([1-9][0-9]*)$/", $key, $match)) {
                $cId = $match[1];
                if ($val == '1') {
                    $stmt6 = $db->prepare("DELETE FROM busiCategories id=?");
                    $stmt6->execute(array(
                            $cId
                    ));
                }
            }
            if (preg_match("/^categoryNew$/", $key, $match)) {
                if ($val != "" && $val != " ") {
                    $stmt7 = $db->prepare(
                            "INSERT INTO busiCategories VALUES(NULL,?)");
                    $stmt7->execute(array(
                            $val
                    ));
                }
            }
        }
    }

    if (filter_input(INPUT_POST, 'categorize', FILTER_SANITIZE_NUMBER_INT) == "1") {
        foreach ($_POST as $key => $val) {
            if (preg_match("/^category([1-9][0-9]*)$/", $key, $match)) {
                $cId = $match[1];
                $stmt8 = $db->prepare(
                        "UPDATE business SET category=? WHERE id=?");
                $stmt8->execute(array(
                        $val,
                        $cId
                ));
            }
        }
    }
    ?>

    <div style='text-decoration:underline; font-size:2em; text-align:center; clear:both;'><?php

    echo $formtitle;
    ?></div>
    <div style='font-size:1.25em; text-align:center;'>
        <form action='business.php' method='post' enctype="multipart/form-data">
            <table>
                <tr>
                    <td>Category <select name="category">
                            <?php
    $stmt9 = $db->prepare(
            "SELECT id,category FROM busiCategories ORDER BY category");
    $stmt9->execute();
    while ($row9 = $stmt9->fetch()) {
        $cateId = $row9['id'];
        $cate = $row9['category'];
        echo "<option value='$cateId'";
        echo ($cateId == $fcategory) ? " selected='selected'" : "";
        echo ">$cate</option>\n";
    }
    ?>
                        </select>
                    </td>
                    <td>
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="name" value="<?php

    echo $fname;
    ?>" maxlength="35" />
                    </td>
                    <td>Business Name
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="contact" value="<?php

    echo $fcontact;
    ?>" maxlength="35" />
                    </td>
                    <td>Contact person
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="phone" value="<?php

    echo $fphone;
    ?>" maxlength="15" />
                    </td>
                    <td>Phone number
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="fax" value="<?php

    echo $ffax;
    ?>" maxlength="15" />
                    </td>
                    <td>Fax number
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="email" value="<?php

    echo $femail;
    ?>" maxlength="50" />
                    </td>
                    <td>Email address
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="website" value="<?php

    echo $fwebsite;
    ?>" maxlength="50" />
                    </td>
                    <td>Website address
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="mailing" value="<?php

    echo $fmailing;
    ?>" maxlength="50" />
                    </td>
                    <td>Mailing Address
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="physical" value="<?php

    echo $fphysical;
    ?>" maxlength="50" />
                    </td>
                    <td>Physical Address
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="city" value="<?php

    echo $fcity;
    ?>" maxlength="50" />
                    </td>
                    <td>City
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="state" value="<?php

    echo $fstate;
    ?>" maxlength="50" />
                    </td>
                    <td>State
                    </td>
                </tr>
                <tr>
                    <td><input type="text" name="zipCode" value="<?php

    echo $fzipCode;
    ?>" maxlength="50" />
                    </td>
                    <td>Zip Code
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php
    if (file_exists("image/business/$fpicture.$fpicExt")) {
        echo "<img src='image/business/$fpicture.$fpicExt' style='margin:10px; max-width:300px; max-height:300px;' /><br /><br />";
        echo "Delete this pic? <input type='checkbox' name='delPic' value='1' /><br /><br />";
    }
    ?>
                        Upload new picture:<br /><input type="file" name="image" /><br /><br />
                    </td>
                    <td>Picture
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Description:<br /><textarea name="description" cols="70" rows="15" maxlength="4900"><?php

    echo $fdescription;
    ?></textarea>
                    </td>
                </tr>
                <?php

    if ($fid != "new") {
        ?>
                    <tr>
                        <td colspan="2" align="center">Delete this business listing: <input type="checkbox" name="delbusi" value="1" />
                        </td>
                    </tr>
                <?php
    }
    ?>
                <tr>
                    <td colspan="2" align="center"><input type="hidden" name="businessup" value="<?php

    echo $fid;
    ?>" /><input type="submit" value=" Upload " />
                    </td>
                </tr>
            </table>
        </form>
    </div><hr style='width:60%;' /><br /><br />
    <?php
    echo "<form action='business.php' method='post'><table cellspacing='2'>\n";
    $stmt10 = $db->prepare(
            "SELECT id,category FROM busiCategories ORDER BY category");
    $stmt10->execute();
    while ($row10 = $stmt10->fetch()) {
        $catId = $row10['id'];
        $cate = $row10['category'];
        echo "<tr><td style='border:1px solid #000000; padding:5px;'><table style='width:100%;'><tr><td style='width:50%; text-align:left;'>$cate</td><td style='width:50%; text-align:right;'><input type='checkbox' name='category$catId' value='1' /> - Delete?</td></tr></table></td></tr>\n";
    }
    echo "<tr><td style='border:1px solid #000000; padding:5px;'>Add new? <input type='text' name='categoryNew' value='' /></td></tr>\n";
    echo "<tr><td style='border:1px solid #000000; padding:5px;'><input type='hidden' name='categories' value='1' /><input type='submit' value=' Go ' /></td></tr></table></form><br /><br />\n";

    $stmt11 = $db->prepare("SELECT COUNT(*) FROM business WHERE category='0'");
    $stmt11->execute();
    $row11 = $stmt11->fetch();
    if ($row11[0] >= 1) {
        echo "<span style='font-weight:bold; color:white;'>There are businesses which are not categorized:</span><br />\n";
        echo "<form action='index.php?page=business' method='post'><table cellspacing='2'>\n";
        $stmt12 = $db->prepare(
                "SELECT id,name FROM business WHERE category='0'");
        $stmt12->execute();
        while ($row12 = $stmt12->fetch()) {
            $id = $row12['id'];
            $name = $row12['name'];
            echo "<tr><td style='border:1px solid #000000; padding:5px;'>$name</td><td><select name='category$id'>";
            echo "<option value='0'></option>\n";
            $stmt13 = $db->prepare(
                    "SELECT id,category FROM busiCategories ORDER BY category");
            $stmt13->execute();
            while ($row13 = $stmt13->fetch()) {
                $cId = $row13['id'];
                $cate = $row13['category'];
                echo "<option value='$cId'>$cate</option>\n";
            }
            echo "</select></td></tr>\n";
        }
        echo "<tr><td colspan='2' style='border:1px solid #000000; padding:5px;'><input type='hidden' name='categorize' value='1' /><input type='submit' value=' Go ' /></td></tr></table></form>\n";
    }
}
?>
<div id="listCategory" style="clear:both; margin-top:30px;">
    <?php
    $stmt14 = $db->prepare(
            "SELECT category FROM business ORDER BY RAND() LIMIT 1");
    $stmt14->execute();
    $row14 = $stmt14->fetch();
    $category = $row14['category'];
    $stmt15 = $db->prepare("SELECT category FROM busiCategories WHERE id = ?");
    $stmt15->execute(array(
            $category
    ));
    $row15 = $stmt15->fetch();
    if ($row15) {
        $c = $row15["category"];
        echo "<div style='text-decoration:none; font-size:2em; text-align:center; margin-bottom:20px;'>$c</div>\n";
        $substmt = $db->prepare(
                "SELECT * FROM business WHERE category=? ORDER BY RAND()");
        $substmt->execute(array(
                $category
        ));
        while ($row16 = $substmt->fetch()) {
            $id = $row16['id'];
            $name = $row16['name'];
            $contact = $row16['contact'];
            $phone = $row16['phone'];
            $fax = $row16['fax'];
            $email = $row16['email'];
            $website = $row16['website'];
            $mailing = $row16['mailing'];
            $physical = $row16['physical'];
            $city = $row16['city'];
            $state = $row16['state'];
            $zipCode = $row16['zipCode'];
            $description = nl2br(
                    make_links_clickable(
                            html_entity_decode($row16['description'], ENT_QUOTES)));
            $picture = $row16['picture'];
            $picExt = $row16['picExt'];
            echo "<div onclick='toggleview(\"bus$id\")' style='cursor:pointer; text-decoration:underline; font-size:1.5em; text-align:center; margin-bottom:10px;'>$name</div>\n";
            echo "<div id='bus$id' style='display:none; font-size:1.25em; text-align:center; margin:30px 10px;'>";
            if (file_exists("image/business/$picture.$picExt")) {
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
            if (file_exists("image/business/$id.jpg")) {
                echo "<div style='float:right; margin:5px 0px 5px 5px; border:1px solid black; padding:3px; background-color:#aa9f93;'><img src='image/business/$id.jpg' alt='' /></div>";
            }
            if ($description) {
                echo "<div style='text-align:center; margin:0px 30px;'>$description</div>\n";
            }
            echo "</div>";
        }
    }
    ?>
</div>

<?php
include "include/footer.php";
?>