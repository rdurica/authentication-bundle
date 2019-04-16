<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\EventSubscriber;

use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Event;
use Rd\AuthenticationBundle\Service\Mail\MailInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * Class AuthenticationSubscriber
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\EventSubscriber
 */
class AuthenticationSubscriber implements EventSubscriberInterface
{


    /**
     * @var MailInterface
     */
    private $mail;


    /**
     * AuthenticationSubscriber constructor.
     *
     * @param MailInterface $mail
     */
    public function __construct(MailInterface $mail)
    {
        $this->mail = $mail;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            Event::REGISTRATION_SUCCEED => 'registrationSucceed',
        ];
    }


    /**
     * @param GenericEvent $event
     */
    public function registrationSucceed(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mail->registrationSuccessful($user);
    }
}