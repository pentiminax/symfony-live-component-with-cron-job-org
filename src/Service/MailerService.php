<?php

namespace App\Service;

use App\Entity\Event;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{

    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    public function createEmailForEvent(Event $event): Email
    {
        $email = new TemplatedEmail();

        $email
            ->from('tanguy.lemarie6@gmail.com')
            ->to('tanguy.lemarie6@gmail.com')
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