<?php

namespace App\Contracts;

interface CanSendEmail
{

    public function sendEmail($request);

}
