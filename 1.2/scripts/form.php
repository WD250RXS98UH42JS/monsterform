<?php

// monsterform
// version: 1.2
// date: 19.02.2019
// author: WD250RXS98UH42JS
// license: MIT

// importing libs and classes used in this script
use PHPMailer\PHPMailer\PHPMailer;
require './vendor/autoload.php';
require_once "recaptchalib.php";

// path to config file
// can be changed but very carefully!
require '../config.php';

$log_msg = "Log started. <br>";

function log_msg($text)
{
    global $log_msg;

    $log_msg .= $text . "<br>";
}

function info_message($message)
{
    // This function uses for show error or information messages to user/developer
    // Text messages and page structure can be customizable in config file

    global $confirm_page_ok_message, $confirm_page_error_message, $confirm_page_styles, $confirm_page_html_head, $confirm_page_html_tail, $debug, $log_msg;

    // if debug mode enabled in config, messages will show on html page
    if (!$debug)
    {
        // if flag is OK, show success message template
        if ($message == 'OK')
        {
            $message = $confirm_page_ok_message;
        }
    
        // if flag is ERROR, show error message template
        else 
            if ($message == 'ERROR')
            {
                $message = $confirm_page_error_message;
            }
    
        echo $confirm_page_html_head . $message . $confirm_page_html_tail;
    }
    // if debug mode disabled, messages will show as plain text, but log will contain more info
    else
    {
        echo $log_msg . "<br>";
    }
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
            // to log
            log_msg("CAPTCHA OK");
        }
        else
        {
            // to log
            log_msg("CAPTCHA FAIL");
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
        $mail->SMTPDebug = 0;
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
            log_msg("You're trying to upload too much files! Max files count: $max_attached_files_count");
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
                log_msg("Files array bigger than $max_attached_files_size MB ($file_array_size bytes)");
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
                        log_msg("Failed to move file to $uploadfile");
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
        $send_status = mail_send($body_status, $attach_status);

        // if mail was sent successfully, call function info_message with OK flag
        if ($send_status)
        {
            info_message("OK");
        }
        // if mail was not sent, call function info_message with ERROR flag
        else
        {
            info_message("ERROR");
        }
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
        log_msg("Something went wrong, please try again");
    }
    
    if (!$mail->send()) 
    {
        // if mail was not sended - turn message to log and stop
        log_msg("Mailer Error: $mail->ErrorInfo");
        return FALSE;

    }
    else
    {
        // to log
        log_msg("Message sent!");
        return TRUE;
    }
}

function write_data_to_file($allow_writing_data_to_file)
{
    global $file_name, $data_header, $data_body;

    if ($allow_writing_data_to_file)
    {
        $date = date_create();
        // append data to text file
        $f = fopen($file_name, "a");
        $file_data = $data_header . "\r\nDate stamp: " . date_format($date, 'YmdHis.u') . "\r\n" . $data_body;
        if (fwrite($f, $file_data))
        {
            // to log
            log_msg("Data was added to file successfully!");
        }
        else
        {
            // to log
            log_msg("Error while adding data to file!");
        };
        fclose($f);
    }
}

// main calls
$mail = new PHPMailer;
$captcha_status = check_captcha($allow_captcha);
$config_status = mailer_config($captcha_status);
$content_status = mail_content($config_status, $allow_confirm_letter);
write_data_to_file($allow_writing_data_to_file);
?>