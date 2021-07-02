<?php

namespace App\Services;

use App\Services\Interfaces\OrderRegisterServiceInterface;
use Exception;

class SmsService implements SmsServiceInterface
{
    public function sendSms($phoneNumber)
    {
        $randCode = rand(1000, 9999);

        $smsru = new \SMSRU('F0F50464-285E-0F00-8D30-27240892DA9A'); // Ваш уникальный программный ключ, который можно получить на главной странице

        $data = new \stdClass();
        
        $data->to = $phoneNumber;
        $data->text = $randCode; // Текст сообщения
        session(['smsCode' => "$randCode"]);
        // $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
        // $data->time = time() + 7*60*60; // Отложить отправку на 7 часов
        // $data->translit = 1; // Перевести все русские символы в латиницу (позволяет сэкономить на длине СМС)
        // $data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
        // $data->partner_id = '1'; // Можно указать ваш ID партнера, если вы интегрируете код в чужую систему
        $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную

        if ($sms->status == "OK") { // Запрос выполнен успешно
            echo "Сообщение отправлено успешно. ";
            echo "ID сообщения: $sms->sms_id. ";
            //echo "Ваш новый баланс: $sms->balance";
        } else {
            echo "Сообщение не отправлено. ";
            echo "Код ошибки: $sms->status_code. ";
            echo "Текст ошибки: $sms->status_text.";
        }
    }
}