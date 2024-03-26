<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';

    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail->setLanguage('ru', 'phpmailer/language/');
    $mail->IsHTML(true);

    //От кого письмо
    $mail->setForm('info@promplast.ru', 'ПромПласт');
    //Кому отправить
    $mail->addAddress('zemlemerova.as@gmail.com');
    //Тема письма
    $mail->Subject = 'Заявка с сайта';

    //Тело письма
    $body = '<h1>Заявка с сайта</h1>';

    if(trim(!empty($_POST['name']))){
        $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
    }
    if(trim(!empty($_POST['company']))){
        $body.='<p><strong>Компания:</strong> '.$_POST['company'].'</p>';
    }
    if(trim(!empty($_POST['email']))){
        $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
    }
    if(trim(!empty($_POST['telephone']))){
        $body.='<p><strong>Телефон:</strong> '.$_POST['telephone'].'</p>';
    }
    if(trim(!empty($_POST['city']))){
        $body.='<p><strong>Город:</strong> '.$_POST['city'].'</p>';
    }
    if(trim(!empty($_POST['comments']))){
        $body.='<p><strong>Город:</strong> '.$_POST['comments'].'</p>';
    }

    //Отправляем
    if (!$mail->send()) {
        $message = 'Ошибка';
    } else {
        $message = 'Данные отправлены';
    }

    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>