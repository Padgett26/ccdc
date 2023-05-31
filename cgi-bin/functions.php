<?php
function send_email($to, $subject, $body) {
	if (! $to)
		$to = "cheyenne.ecodevo@ccdcks.com";
	if (! $subject)
		$subject = "An email from the website.";
	if (! $body)
		$body = "The body information wasnt sent.";
	mail ( $to, $subject, $body );
}
function destroySession() {
	$_SESSION = array ();

	if (ini_get ( "session.use_cookies" )) {
		$params = session_get_cookie_params ();
		setcookie ( session_name (), '', time () - 42000, $params ["path"], $params ["domain"], $params ["secure"], $params ["httponly"] );
	}

	session_destroy ();
}
function getPicType($imageType) {
	switch ($imageType) {
		case "image/gif" :
			$picExt = "gif";
			break;
		case "image/jpeg" :
			$picExt = "jpg";
			break;
		case "image/pjpeg" :
			$picExt = "jpg";
			break;
		case "image/png" :
			$picExt = "png";
			break;
		default :
			$picExt = "xxx";
			break;
	}
	return $picExt;
}
function processPic($f, $imageName, $imageWidth, $imageHeight, $tmpFile, $picExt) {
	$folder = "image/$f";

	$saveto = "$folder/$imageName.$picExt";

	$image = new Imagick ( $tmpFile );
	$image->thumbnailImage ( $imageWidth, $imageHeight, true );
	$image->writeImage ( $saveto );
}
function processThumbPic($f, $imageName, $imageWidth, $imageHeight, $tmpFile, $picExt) {
	$folder = "image/$f";

	$saveto = "$folder/thumb/$imageName.$picExt";

	$image = new Imagick ( $tmpFile );
	$image->thumbnailImage ( $imageWidth, $imageHeight, true );
	$image->writeImage ( $saveto );
}

$time = time ();
function make_links_clickable($text) {
	return preg_replace ( '!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', "<a href='$1' target='_blank'>$1</a>", $text );
}