<?php

namespace App\Service;

use App\Entity\Event;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{

    public function __construct(
        private readonly MailerInterface $mailer,
        #[Autowire('%admin_email%')] private string $adminEmail
    ) {
    }

    public function createEmailForEvent(Event $event): Email
    {
        $email = new TemplatedEmail();

        $email
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->subject(sprintf('Votre évènement %s commence bientôt', $event->getName()))
            ->htmlTemplate('emails/event.html.twig')
            ->context([
                'event' => $event
            ])
        ;


        return $email;
    }

    public function sendEmail(Email $email): void
    {
        $this->mailer->send($email);
    }
}