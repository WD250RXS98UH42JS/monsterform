<?php

// monsterform
// version: 1.0
// date: 11.01.2019
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

?>