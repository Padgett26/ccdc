<?php
session_start();

include "../globalFunctions.php";

$db = db_ccdc();

include "cgi-bin/functions.php";

$domain = "ccdcks.com";

$salt1 = "mk&*";
$salt2 = "^&gh";

if (filter_input(INPUT_POST, 'submitemail', FILTER_SANITIZE_NUMBER_INT)) {
    $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
    $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
    $addy1 = filter_input(INPUT_POST, 'addy1', FILTER_SANITIZE_STRING);
    $addy2 = filter_input(INPUT_POST, 'addy2', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_STRING);
    $state = filter_input(INPUT_POST, 'state', FILTER_SANITIZE_STRING);
    $dphone = filter_input(INPUT_POST, 'dphone', FILTER_SANITIZE_STRING);
    $ephone = filter_input(INPUT_POST, 'ephone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $for = filter_input(INPUT_POST, 'for', FILTER_SANITIZE_STRING);
    $comments = filter_input(INPUT_POST, 'comments', FILTER_SANITIZE_STRING);
    $to = ($for == "support") ? "jcs@padgett-online.com" : "cheyenne.ecodevo@ccdcks.com";
    if (filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)) {
        echo "<div style='color:#ffffff; font-weight:bold;'>The email you entered seems to be invalid. Please enter another.</div>";
    } else {
        $message = "
        <html><head></head><body>
        A message posted on the ccdcks.com website:<br /><br />
        From: $fname $lname<br />
        $addy1<br />
        $addy2<br />
        $city, $state $zip<br /><br />
        Daytime phone: $dphone<br />
        Evening phone: $ephone<br />
        Email: $email<br /><br />
        Comments:<br />
        $comments<br />
        </body></html>";
        // In case any of our lines are larger than 70 characters, we should use
        // wordwrap()
        $message = wordwrap($message, 70);
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers .= "From: $fname $lname <$email>" . "\r\n";
        // Send
        mail($to, 'Question or comment from ccdcks.com', $message, $headers);
        $showForm = "0";
    }
}

if (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_NUMBER_INT)) {
    $user = filter_input(INPUT_POST, 'userid', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
    $hidepwd = md5("$salt1$pass$salt2");
    if ($user == "" || $pass == "") {
        echo "<div class='error' style='color:white; font-weight:bold;'>Both the user name and password fields are required. Please fill in these fields when completing the form.</div>";
    } else {
        $stmt = $db->prepare("SELECT id FROM users WHERE userid=? AND pwd=?");
        $stmt->execute(array(
                $user,
                $hidepwd
        ));
        $row = $stmt->fetch();
        if ($row) {
            $id = $row['id'];
            $_SESSION['user'] = $id;
        } else {
            echo "<div class='error' style='color:white; font-weight:bold;'>Your log on information is incorrect.</div>";
        }
    }
}

$loggedin = (isset($_SESSION['user']) && $_SESSION['user'] >= 1) ? "1" : "0";

$page = (filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING)) ? filter_input(
        INPUT_GET, 'page', FILTER_SANITIZE_STRING) : "home";

$blogYear = (filter_input(INPUT_GET, 'blogYear', FILTER_SANITIZE_NUMBER_INT)) ? filter_input(
        INPUT_GET, 'blogYear', FILTER_SANITIZE_NUMBER_INT) : date("Y");

$months = array(
        "0",
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec"
);

$linksCSS = "margin-top:9px; cursor:pointer;";

if (filter_input(INPUT_GET, 'logout', FILTER_SANITIZE_STRING) == 'yep') {
    $_SESSION['user'] = 0;
    $loggedin = 0;
}