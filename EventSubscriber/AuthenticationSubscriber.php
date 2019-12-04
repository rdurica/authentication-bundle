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

    private MailInterface $mail;


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
            Event::ACCOUNT_VERIFIED     => 'accountVerified',
            Event::PASSWORD_CHANGED     => 'passwordChanged',
            Event::LOST_PASSWORD        => 'lostPassword',
        ];
    }


    /**
     * @param GenericEvent $event
     */
    public function lostPassword(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mail->resetPassword($user);
    }


    /**
     * @param GenericEvent $event
     */
    public function passwordChanged(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mail->passwordChanged($user);
    }


    /**
     * @param GenericEvent $event
     */
    public function accountVerified(GenericEvent $event): void
    {
        /** @var User $user */
        $user = $event->getSubject();
        $this->mail->accountVerified($user);
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