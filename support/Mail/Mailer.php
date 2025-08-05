<?php

namespace Support\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected PHPMailer $mail;
    protected ?string $error = null;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();
        $this->mail->Host = config('mail.host');
        $this->mail->SMTPAuth = true;
        $this->mail->Username = config('mail.username');
        $this->mail->Password = config('mail.password');
        $this->mail->SMTPSecure = config('mail.encryption', 'tls');
        $this->mail->Port = config('mail.port', 587);
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom(
            config('mail.from.address'),
            config('mail.from.name')
        );
    }

    public function send(string $to, string $subject, string $body, array $attachments = []): bool
    {
        try {
            $this->mail->clearAddresses();
            $this->mail->clearAttachments();

            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $body;

            // Dodajemy załączniki jeśli są
            foreach ($attachments as $attachment) {
                if (isset($attachment['name'])) {
                    $this->mail->addAttachment($attachment['path'], $attachment['name']);
                } else {
                    $this->mail->addAttachment($attachment['path']);
                }
            }

            return $this->mail->send();
        } catch (Exception $e) {
            $this->error = $this->mail->ErrorInfo;
            error_log('Mailer Error: ' . $this->error);
            return false;
        }
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}