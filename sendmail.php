<?php
    // Подключение библиотеки
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';
    require 'phpmailer/Exception.php';

    // Получение данных
    $json = file_get_contents('php://input'); // Получение json строки
    $data = json_decode($json, true); // Преобразование json

    // Данные
    $name = $_POST['name'];
    
    $tel = $_POST['telephone'];
    $msg = $_POST['comments'];    

    // Контент письма
    $title = 'Заявка с сайта'; // Название письма
    $body = '<p>Имя: <strong>'.$_POST['name'].'</strong></p>'.
            '<p>Компания: <strong>'.$_POST['company'].'</strong></p>'.
            '<p>E-mail: <strong>'.$_POST['email'].'</strong></p>'.
            '<p>Телефон: <strong>'.$_POST['telephone'].'</strong></p>'.
            '<p>Город: <strong>'.$_POST['city'].'</strong></p>'.
            '<p>Сообщение: <strong>'.$_POST['comments'].'</strong></p>';

    // Настройки PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();

    try {
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth   = true;
    $mail->setLanguage('ru', 'PHPMailer/language');

    // Настройки почты отправителя
    $mail->Host       = 'smtp.yandex.com'; // SMTP сервера вашей почты
    $mail->Username   = 'promplast-ekb@yandex.ru'; // Логин на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom('promplast-ekb@yandex.ru', 'Заявка с сайта'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('promplast-ekb@yandex.ru');

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;

    $mail->send('d');

    // Сообщение об успешной отправке
    if (!$mail->send()) {
        $message = 'Ошибка';
    } else {
        $message = 'Данные отправлены';
    }

    } catch (Exception $e) {
    header('HTTP/1.1 400 Bad Request');
    echo('Сообщение не было отправлено! Причина ошибки: {$mail->ErrorInfo}');
    }
    
    $response = ['message' => $message];

    header('Content-type: application/json');
    echo json_encode($response);
?>
