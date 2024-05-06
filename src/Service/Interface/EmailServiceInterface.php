<?php
namespace App\Service\Interface;

interface EmailServiceInterface
{
    public function sendWelcomeEmail(string $email): void;
}