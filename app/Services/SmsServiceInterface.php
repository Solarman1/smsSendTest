<?php

namespace App\Services;

interface SmsServiceInterface
{
    public function sendSms($phoneNumber);
}