<?php

// monsterform
// version: 1.1
// date: 16.01.2019
// author: WD250RXS98UH42JS
// license: MIT

// ##### MAIL FORM CONFIGURATION FILE #####

// Specify your custom names for form's fields
// For <input name="custom_field">Name</input>:
//$html_field_name = "custom_field";
$html_field_name = "username"; // default: "username"
$html_field_email = "email"; // default: "email"
$html_field_phone = "phone"; // default: "phone"
$html_field_mailbody = "userComment"; // default: "userComment"
$html_field_attachment = "attach"; // default: "attach"

// Parameters of your mail server
//Set the hostname of the mail server
$host = 'smtp.gmail.com';  // default: "smtp.gmail.com", but you can specify any hosting you want
//Set the SMTP port number
$port = 587; // default: "587"
//Set the encryption system to use - ssl (deprecated) or tls
$smtp_secure = 'tls'; // default: "tls"
//Whether to use SMTP authentication (true/false)
$smtp_auth = true; // default: "true"

// Allow attachments on form? 1 - True, 0 - False
$allow_attachments = 1;  // default: "1"
$max_attached_files_count = 3;  // default: "3"
// Max attaches size in MB
// This value indicates total size of files
$max_attached_files_size = 10;//MB, default: "10"

// If enable, user will receive mail with confirmation of request receiving
$allow_confirm_letter = 1; // default: "1"

// Allow captcha on form? 1 - True, 0 - False
$allow_captcha = 1; // default: "1"
// Secret captcha key
// For testing on localhost use this keys:
// Public key (located in html):
// 6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI
// Secret key (type it in $secret_captcha_key):
// 6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe
$secret_captcha_key = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";

// Sender credentials which shows in mail
$sender_from_name = "Site Admin";
$sender_from_email = "<some gmail account name>@<sitename>";        // YOU NEED TO CHANGE IT FIRSTLY!

// Login and password for mailbox which uses for mail sending
$sender_email = "<some account name>@<sitename>";                   // YOU NEED TO CHANGE IT FIRSTLY!
$sender_passwd = "<YOUR PASSWORD>";                                 // YOU NEED TO CHANGE IT FIRSTLY!

// Name of your site
// It can be used as plain text of HTML in mail body
$sitename = "<a href=\"http://sitename.domain\">sitename.domain</a>";

// Default values for mail subject and body
// They both encoding to UTF-8, so you can use cyrillic
// Also you can use PHP-allowable variables, like $_POST[*], $* etc
$customer_mail_subject = "Thank you for your request!";
$customer_mail_body = 
"
    <html>
    <body>
        <p>Hello, $_POST[$html_field_name]!<br>
        Your request which you leaved on $sitename, was successfully accepted.<br>
        Our manager will contact you using your phone number $_POST[$html_field_phone] as soon as possible.<br><br>
        Your reques details:<br>
        $_POST[$html_field_mailbody]
        </p>
    </body>
    </html>
";

$mail_subject = "Request from $_POST[$html_field_name] ($_POST[$html_field_email])";
$mail_body =
"
    <html>
    <body>
        <p>Client's name $_POST[$html_field_name]<br>
        Client's Email: $_POST[$html_field_email]<br>
        Client's phone number: $_POST[$html_field_phone]<br>
        Request details: $_POST[$html_field_mailbody]
        </p>
    </body>
    </html>
";

// Example of fully correct and working code:

// $customer_mail_subject = "Thank you for your request!";
// $customer_mail_body = 
// "
//     <html>
//     <body>
//         <p>Hello, $_POST[$html_field_name]!<br>
//         Your request which you leaved on $sitename, was successfully accepted.<br>
//         Our manager will contact you using your phone number $_POST[$html_field_phone] as soon as possible.<br><br>
//         Your reques details:<br>
//         $_POST[$html_field_mailbody]
//         </p>
//     </body>
//     </html>
// ";

// $mail_subject = "Request from $_POST[$html_field_name] ($_POST[$html_field_email])";
// $mail_body =
// "
//     <html>
//     <body>
//         <p>Client's name $_POST[$html_field_name]<br>
//         Client's Email: $_POST[$html_field_email]<br>
//         Client's phone number: $_POST[$html_field_phone]<br>
//         Request details: $_POST[$html_field_mailbody]
//         </p>
//     </body>
//     </html>
// ";


// ##### HTML PAGE SETTINGS (shows to user after message sending) #####

// This message will appear if all done without any issues
$confirm_page_ok_message = "Your request was sent.<br>Thank you for your appeal!";
// This message will apper if some issues present
$confirm_page_error_message = "Error while mail sending.<br>Please check data and try again.";

// CSS styles for HTML
$confirm_page_styles = 
"
<style>
    html, body
    {
        font-family: 'Exo 2', sans-serif;
        width: 100%;
        height: 100%;
    }

    .modalWindow_bg
    {
        display: flex;
        width: 100%;
        height: 100%;
        z-index: 1000;
        position: fixed;
        background-color: rgba(0, 0, 0, 0.3);
    }

        .modalWindow_wrapper
        {
            margin: auto;
            padding: 20px 40px;
            width: 75%;
            max-width: 600px;
            max-height: 90%;
            background-color: rgb(255, 255, 255);
            border-radius: 10px;
            box-shadow: 0px 10px 21px 0px rgba(0, 0, 0, 0.18);
            border-width: 3px;
            overflow: auto;
        }
        
            .modalWindow_body
            {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
            }

                .modalWindow_label
                {
                    font-size: 24px;
                    text-align: center;
                    margin: 30px;
                }

                .modalWindow_mainpage
                {
                    cursor: pointer;
                    font-size: 18px;
                    font-weight: medium;
                    color: rgb(255,255,255);
                    background: rgb(227,79,72);
                    border-radius: 20px;
                    border-style: none;
                    width: 200px;
                    height: 42px;
                }
</style>
";

// HTML page head
// This part of code contains all elements before user message variable
$confirm_page_html_head = 
"
<!DOCTYPE HTML>
<html>
<head>
	<meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0, user-scalable=no\">
	<link rel=\"icon\" href=\"../favicon.ico\" type=\"image/x-icon\">
	<link href=\"https://fonts.googleapis.com/css?family=Exo+2\" rel=\"stylesheet\">
	<link rel=\"stylesheet\" href=\"../styles/reset.css\">
	<meta charset=\"utf-8\">
</head>
<body>
$confirm_page_styles
<section class=\"modalWindow_bg\">
<div class=\"modalWindow_wrapper\">
    <div class=\"modalWindow_body\">
        <p class=\"modalWindow_label\">
";

// HTML page head
// This part of code contains all elements after user message variable
$confirm_page_html_tail = 
"</p>
        <a href=\"/index.html\"><input type=\"button\" class=\"modalWindow_mainpage\" value=\"To main page\"></a>
    </div>
</div>
</section>
</body>
</html>
";

?>