<?php

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;

class EventService
{
    public function __construct(
        private readonly EventRepository $eventRepository,
        private readonly MailerService $mailerService
    ) {
    }

    public function addEvent(Event $event): Event
    {
        return $this->eventRepository->addEvent($event);
    }

    /**
     * @return Event[]
     */
    public function findAllFutureEvents(): array
    {
        return $this->eventRepository->findAllFutureEvents();
    }

    public function checkFutureEvents(): void
    {
        $futureEvents = $this->findAllFutureEvents();

        foreach ($futureEvents as $event) {
            $this->mailerService->sendEmail(
                $this->mailerService->createEmailForEvent($event)
            );
        }
    }
}