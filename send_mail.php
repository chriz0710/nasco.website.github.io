<?php
/*
This first bit sets the email address that you want the form to be submitted to.
You will need to change this value to a valid email address that you can access.
*/
$webmaster_email = "info@trogo.me";

/*
This bit sets the URLs of the supporting pages.
If you change the names of any of the pages, you will need to change the values here.
*/
$feedback_page = "index.html";
$error_page = "index.html?r=error";
$thankyou_page = "index.html?r=success";

/*
This next bit loads the form field data into variables.
If you add a form field, you will need to add it here.
*/
$email = $_REQUEST['email'] ;
$textarea = $_REQUEST['textarea'] ;
$full_name = $_REQUEST['full_name'] ;
$mobile = $_REQUEST['mobile'] ;
$linkedin = $_REQUEST['linkedin'] ;
$facebook = $_REQUEST['facebook'] ;
$instagram = $_REQUEST['instagram'] ;
$msg = 
"Full Name: " . $full_name . "\r\n" . 
"Email: " . $email . "\r\n" . 
"Mobile: " . $mobile . "\r\n" . 
"Linkedin: " . $linkedin . "\r\n" . 
"Instagram: " . $instagram . "\r\n" . 
"Facebook: " . $facebook . "\r\n" . 
"Describe Yourself: " . $textarea ;

/*
The following function checks for email injection.
Specifically, it checks for carriage returns - typically used by spammers to inject a CC list.
*/
function isInjected($str) {
	$injections = array('(\n+)',
	'(\r+)',
	'(\t+)',
	'(%0A+)',
	'(%0D+)',
	'(%08+)',
	'(%09+)'
	);
	$inject = join('|', $injections);
	$inject = "/$inject/i";
	if(preg_match($inject,$str)) {
		return true;
	}
	else {
		return false;
	}
}

// If the user tries to access this script directly, redirect them to the feedback form,
if (!isset($_REQUEST['email'])) {
header( "Location: $error_page" );
}

// If the form fields are empty, redirect to the error page.
elseif (empty($full_name) || empty($email) || empty($mobile)|| empty($linkedin) || empty($instagram) || empty($facebook) || empty($textarea)) {
header( "Location: $error_page" );
}

/* 
If email injection is detected, redirect to the error page.
If you add a form field, you should add it here.
*/
elseif ( isInjected($email) || isInjected($full_name)  || isInjected($textarea) ) {
header( "Location: $error_page" );
}

// If we passed all previous tests, send the email then redirect to the thank you page.
else {
    $header = "FROM: The Circle Editions - Jimmy <Jimmy@thecircleeditions.com>\r\n";

	mail( "$webmaster_email", "Online Form Results", $msg );

	header( "Location: $thankyou_page" );
}
?>