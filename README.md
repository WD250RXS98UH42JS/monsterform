# monsterform
monsterform - a very customizable PHP feedback mail form based on PHPMailer

# Features:
1. Very customizable settings for:
   * SMTP - you can send messages from any server with SMTP support;
   * appearance (HTML+CSS) - set appearance of your form and mails as you like;
   * attachments - all filetypes and count (can be edited in config);
   * protection - validation of entered data and user actions.
2. Email sending without local mail server;
3. Using your own email address for sending;
4. Detailed logs;
5. Pretty show-to-user messages and forms;
6. Easy integration in your site;
7. ReCAPTCHA v2 integrated;
8. Multiple attachments.

# Installation
Just put the files in place you want, and modify your HTML page.
You can find the code examples in index.html and config.php.

## Attention! 
Names of input fields can be identical in config.php and your HTML!

## Dependencies:
autoload.php (part of Composer) - included;

PHPMailer library - included.

# 1.0:
 - release;

# 1.1:
 - added CSS for all show-to-user content;
 - some small fixes and improvements (especially for entered data validation);
