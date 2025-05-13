
<?php

require __DIR__.'/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendVerificationMail(
    $userEmail,
    $verificationCode
)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->isHTML(true);

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPmailer::ENCRYPTION_STARTTLS;;
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['GMAIL_MAIL'];
    $mail->Password = $_ENV['GMAIL_PASS'];

    $mail->setFrom($_ENV['APP_MAIL'], $_ENV['APP_NAME']);
    $mail->addAddress($userEmail);

    $mail->Subject = 'Verify your email';
    $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Verify Your Email</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(to right, #4CAF50, #45a049); padding: 20px; text-align: center;">
            <h1 style="color: white; margin: 0;">Verify Your Email</h1>
          </div>
          <div style="background-color: #f9f9f9; padding: 20px; border-radius: 0 0 5px 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <p>Hello,</p>
            <p>Thank you for signing up! Your verification code is:</p>
            <div style="text-align: center; margin: 30px 0;">
              <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4CAF50;">'. $verificationCode .'</span>
            </div>
            <p>Enter this code on the verification page to complete your registration.</p>
            <p>This code will expire in 15 minutes for security reasons.</p>
            <p>If you didnt create an account with us, please ignore this email.</p>
            <p>Best regards,<br>KeyNest</p>
          </div>
          <div style="text-align: center; margin-top: 20px; color: #888; font-size: 0.8em;">
            <p>This is an automated message, please do not reply to this email.</p>
          </div>
        </body>
        </html>
    ';

    //$mail->isHTML(true);
    $mail->send();

}

function sendOTPMail(
    $userEmail,
    $OTP,
    $username
)
{
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->isHTML(true);

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPmailer::ENCRYPTION_STARTTLS;;
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['GMAIL_MAIL'];
    $mail->Password = $_ENV['GMAIL_PASS'];

    $mail->setFrom($_ENV['APP_MAIL'], $_ENV['APP_NAME']);
    $mail->addAddress($userEmail);

    $mail->Subject = 'Your two-factor sign in code';
    $mail->Body = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Your two-factor sign in code</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
          <div style="background: linear-gradient(to right, #4CAF50, #45a049); padding: 20px; text-align: center;">
            <h1 style="color: white; margin: 0;">Your two-factor sign in code</h1>
          </div>
          <div style="background-color: #f9f9f9; padding: 20px; border-radius: 0 0 5px 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
            <div style="text-align: center; margin: 30px 0;">
              <span style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4CAF50;">'. $OTP .'</span>
            </div>
            <p>Hello '. $username .',</p>
            <p>You recently tried to log in from a new device, browser, or location. To complete your login, please use the above code.</p>
            <p>This code will expire in 1 minute for security reasons.</p>
            <p>If this wasn\'t you, please change your password</p>
            <p>Best regards,<br>KeyNest</p>
          </div>
          <div style="text-align: center; margin-top: 20px; color: #888; font-size: 0.8em;">
            <p>This is an automated message, please do not reply to this email.</p>
          </div>
        </body>
        </html>
    ';

    //$mail->isHTML(true);
    $mail->send();

}

?>
