<?php
require_once 'autoloader.php';

use entities\FileStorage as FileStorage;
use entities\TelegraphText as TelegraphText;
use PHPMailer\PHPMailer\{PHPMailer, SMTP, Exception};
$defaultHTML = '';
function formHTML( string $resultSend = '') : string {
    return '
     <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>'
. $resultSend .
'<form class="form" method="POST" action="input_text.php">
    <input class="form__input" name="author" type="text" placeholder="Имя автора" />
    <input class="form__input" name="email" type="email" placeholder="email" />
    <textarea class="form__textarea" name="text-author"></textarea>
    <button class="form__btn" type="submit">
        Сохранить
    </button>
</form>
</body>
</html>
    ';
}


 if ( isset($_POST["author"]) && isset($_POST["text-author"]) ) {
     function funcHandler($exception) {
         global $defaultHTML;
         if($exception->getMessage() == '') {
             $defaultHTML = '<h3 class="success">Данные успешно отправлены</h3>';
         } else {
             $defaultHTML = '<h3 class="error">' . $exception->getMessage() . '</h3>';
         }
         echo formHTML( $defaultHTML );
     }
     set_exception_handler('funcHandler');

         $authorObject = new TelegraphText();
         $objectSave = new FileStorage($authorObject);
         $objectSave->create($authorObject);
         $authorObject->author = $_POST["author"];
         $authorObject->text = $_POST["text-author"];
         $objectSave->update($authorObject->slug, $authorObject);
//     set_exception_handler('functHandler');
//     throw new Exception('Ошибка отправки письма');

//    $urlText = $authorObject->slug;


    if ( isset($_POST["email"]) && !empty($_POST["email"]) ) {

        $mail = new PHPMailer(false);

        try {
            //Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'example@gmail.com';                     //SMTP username
            $mail->Password   = 'pass';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have
            // set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->charSet = 'UTF-8';

            //Recipients
            $mail->setFrom('example@gmail.com', 'Mailer');
            $mail->addAddress($_POST["email"], 'Mailer');     //Add a recipient             //Name is optional
            $mail->addReplyTo($_POST["email"], 'Mailer');
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = '=?UTF-8?B?' . base64_encode($_POST["author"]) . '?=';
            $mail->msgHTML($_POST["text-author"]);
            $mail->AltBody = $_POST["text-author"];

            $mail->send();
            $defaultHTML = '<h3 class="success">Данные успешно отправлены</h3>';
        } catch (Exception $e) {

            throw new Exception("Письмо не отправлено ошибка: {$mail->ErrorInfo}");
        }
    } else {
        throw new Exception("Не введен email");
    }
    throw new Exception('');
} else {
     echo formHTML( $defaultHTML);
 }

