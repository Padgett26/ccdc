<?php

function send_email ($to, $subject, $body)
{
    if (! $to)
        $to = "cheyenne.ecodevo@ccdcks.com";
    if (! $subject)
        $subject = "An email from the website.";
    if (! $body)
        $body = "The body information wasnt sent.";
    mail($to, $subject, $body);
}

$time = time();