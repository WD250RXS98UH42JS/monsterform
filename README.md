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
After that set your values in config.php, especially email credentials.

## Attention! 
Names of input fields can be identical in config.php and your HTML!

## Screenshots
This is form default view:

![main_form](https://user-images.githubusercontent.com/17432671/51320434-74340d00-1a68-11e9-9c43-ea80af25c167.png)

This is a message showed to user after mail sending:

![info_message](https://user-images.githubusercontent.com/17432671/51320500-bc532f80-1a68-11e9-8586-5dd963e035ff.png)

Mail received by user (is this feature was enabled in config.php):

![received_user](https://user-images.githubusercontent.com/17432671/51320603-03412500-1a69-11e9-9f4f-1c1338c6492a.png)

Mail received by site owner:

![received_owner](https://user-images.githubusercontent.com/17432671/51320634-24a21100-1a69-11e9-9357-be7244ba78f1.png)

All pages can be easily changed in config.php and index.html.
Also, you can customize a view of mails for users and site owner by using HTML and CSS.

## Dependencies:
autoload.php (part of Composer) - included;

PHPMailer library - included.

# 1.0:
 - release;

# 1.1:
 - added CSS for all show-to-user content;
 - some small fixes and improvements (especially for entered data validation);
