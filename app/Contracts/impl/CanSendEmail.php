<?php

namespace App\Contracts\impl;


use App\Notifications\CreateUser;
use Illuminate\Support\Facades\Log;

trait CanSendEmail
{
    public function sendEmail($request): void
    {
        Log::info("sendEmail");
        $this->notify(new CreateUser($request));
    }
}
