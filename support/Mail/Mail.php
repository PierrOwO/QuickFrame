<?php

namespace Support\Mail;

class Mail
{
    protected string $to;
    protected string $subject;
    protected string $body;
    protected array $attachments = []; // tu będą załączniki

    protected Mailer $mailer;
    protected ?string $error = null;

    public function __construct()
    {
        $this->mailer = new Mailer();
    }

    public static function to(string $address): self
    {
        $instance = new self();
        $instance->to = $address;
        return $instance;
    }

    public function subject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function body(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    public function attach(string $filePath, ?string $fileName = null): self
    {
        $this->attachments[] = ['path' => $filePath, 'name' => $fileName];
        return $this;
    }

    public function send(): bool
    {
        // Wywołujemy metodę send w Mailer, przekazując załączniki
        $result = $this->mailer->send($this->to, $this->subject, $this->body, $this->attachments);

        if (!$result) {
            $this->error = $this->mailer->getError();
        }

        return $result;
    }

    public function getError(): ?string
    {
        return $this->error;
    }
}