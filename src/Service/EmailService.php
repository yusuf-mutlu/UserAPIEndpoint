<?php
namespace App\Service;

use App\Service\Interface\EmailServiceInterface;

class EmailService implements EmailServiceInterface
{
    public function sendWelcomeEmail(string $email): void
    {
        //echo "Sending welcome email to $email";
    }
}