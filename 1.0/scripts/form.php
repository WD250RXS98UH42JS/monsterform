<?php

// monsterform
// version: 1.0
// date: 11.01.2019
// author: WD250RXS98UH42JS
// license: MIT

// importing libs and classes used in this script
use PHPMailer\PHPMailer\PHPMailer;
require './vendor/autoload.php';
require_once "recaptchalib.php";

// path to config file
// can be changed but very carefully!
require '../config.php';

function info_message($message)
{
    // This function uses for show error or information messages to user/developer
    // Can be customizable
    echo $message;
}

function check_captcha($allow_captcha)
{
    // This function adds RECAPTCHA to form
    // DO NOT RECOMMENDED to make any changes here

    global $secret_captcha_key;

    // if captcha was enable in config
    if ($allow_captcha)
    {
        $secret = $secret_captcha_key;
        $response = null;
        $reCaptcha = new ReCaptcha($secret);
        if ($_POST["g-recaptcha-response"]) 
        {
            $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]);
        }
        // if captcha was passed successfully
        if ($response != null && $response->success) 
        {
            info_message("CAPTCHA OK");
        }
        else
        {
            info_message("CAPTCHA FAIL");
            return FALSE;
        }
    }
    return TRUE;
}

function mailer_config($captcha_status)
{
    // This function sets up some specific mail parameters, like server credentials, user login/password etc
    // This parameters is very important for mail sending, so
    // DO NOT RECOMMEND TO CHANGE ANYTHING HERE
    // all changes you can do in config file

    global $mail, $host, $port, $smtp_secure, $smtp_auth, $sender_email, $sender_passwd;

    // if captcha sucessfully passed
    if ($captcha_status)
    {
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->isSMTP();
        $mail->IsHTML();
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 2;
        // use
        // $mail->Host = gethostbyname($host);
        // if your network does not support SMTP over IPv6
        $mail->Host = $host;
        $mail->Port = $port;
        $mail->SMTPSecure = $smtp_secure;
        $mail->SMTPAuth = $smtp_auth;
        $mail->Username = $sender_email;
        $mail->Password = $sender_passwd;
    }
    else
    {
        return FALSE;
    }
    return TRUE;
}

function mail_attachment()
{
    // This function adds attachments to form
    // For using this functionality, you can add this code to your form in HTML:
    // <input name="attach[]" type="file" multiple accept="*">
    // Strictly recommended do not make anu changes here
    // all settings you can make in config file

    // Features:
    // - multiple attachments (restricts can be changed);
    // - multiple filetypes (can be changed by HTML tag "accept");
    // - limit for files count;
    // - limit for total files size;
    // - information messages for user.

    global $mail, $html_field_attachment, $max_attached_files_count, $max_attached_files_size;

    // if files was uploaded by user to form
    if (array_key_exists($html_field_attachment, $_FILES)) 
    {
        // if amount of files more than allowed in config file
        if (count($_FILES[$html_field_attachment]['tmp_name']) > $max_attached_files_count)
        {
            // send error message to user and stop
            info_message("You're trying to upload too much files! Max files count: $max_attached_files_count");
            return FALSE;
        }
        else
        {
            $file_array_size = 0;
            // definition of MB
            define('MB', 1048576);

            // this code accounts the value of files total size
            foreach ($_FILES[$html_field_attachment]['size'] as $value)
            {
                $file_array_size = $file_array_size + $value;
            }

            // if total files size more than allowed
            if ($file_array_size > $max_attached_files_size*MB)
            {
                // send error message to user and stop
                info_message("Files array bigger than $max_attached_files_size MB ($file_array_size bytes)");
                return FALSE;
            }
            else
            {
                // for each item in files array do upload to attachments
                for ($ct = 0; $ct < count($_FILES[$html_field_attachment]['tmp_name']); $ct++) 
                {
                    $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES[$html_field_attachment]['name'][$ct]));
                    $filename = $_FILES[$html_field_attachment]['name'][$ct];
                    if (move_uploaded_file($_FILES[$html_field_attachment]['tmp_name'][$ct], $uploadfile)) 
                    {
                        $mail->addAttachment($uploadfile, $filename);
                    } 
                    else 
                    {
                        // send error message to user and stop
                        info_message("Failed to move file to $uploadfile");
                        return FALSE;
                    }
                }
                return TRUE;
            }
        }
    }
}

function mail_content($config_status, $allow_confirm_letter)
{
    // This function adds mail fields such as subject, body, sender, recipient, attachments and calls sending function if everything went fine
    // DO NOT RECOMMENDED TO CHANGE ANYTHING HERE

    global $mail, $sender_from_email, $sender_from_name, $sender_email, $html_field_email, $html_field_name, $html_field_attachment,$customer_mail_subject, $customer_mail_body, $mail_subject, $mail_body, $allow_attachments;

    // if previous function ends successfully
    if ($config_status)
    {
        // if confirmation letter for user allowed in config file
        if ($allow_confirm_letter)
        {
            //this code creates confirmation letter for user
                                                    
            $mail->setFrom(htmlspecialchars($sender_from_email), htmlspecialchars($sender_from_name));
            $mail->addAddress(htmlspecialchars($_POST[$html_field_email]), htmlspecialchars($_POST[$html_field_name]));
            $mail->Subject = $customer_mail_subject;
            $mail->Body = $customer_mail_body;
            
            // if everything fine, check flag
            $body_status = TRUE;

            // if attachments allowed in config file, call attachments function
            if ($allow_attachments)
            {
                $attach_status = mail_attachment();
            }

            // call sending function
            mail_send($body_status, $attach_status);
        }
        
        //this code creates information letter for site owner

        $mail->setFrom(htmlspecialchars($_POST[$html_field_email]), htmlspecialchars($_POST[$html_field_name]));
        $mail->ClearAddresses();
        $mail->addAddress(htmlspecialchars($sender_email), htmlspecialchars($sender_from_name));
        $mail->Subject = $mail_subject;
        $mail->Body = $mail_body;

        // if everything fine, check flag
        $body_status = TRUE;

        // if attachments allowed in config file, call attachments function
        if ($allow_attachments)
        {
            $attach_status = mail_attachment();
        }

        // call sending function
        mail_send($body_status, $attach_status);
    }
}

function mail_send($body_status, $attach_status)
{
    global $mail;

    // if checking flags checked
    if ($body_status == TRUE && $attach_status == TRUE)
    {
        // send mail
        $mail->send();
    }
    else
    {
        // if flags not checked - show message and stop
        info_message("Something went wrong, please try again");
    }
    
    if (!$mail->send()) 
    {
        // if mail was not sended - show message and stop
        info_message("Mailer Error: $mail->ErrorInfo");
    }
    else
    {
        info_message("Message sent!");
    }
}

$mail = new PHPMailer;
$captcha_status = check_captcha($allow_captcha);
$config_status = mailer_config($captcha_status);
$content_status = mail_content($config_status, $allow_confirm_letter);

?>