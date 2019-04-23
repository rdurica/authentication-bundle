<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle;

/**
 * Class Event
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle
 */
final class Event
{
    /**
     * @Event(Symfony\Component\EventDispatcher\GenericEvent")
     * @var string
     */
    public const REGISTRATION_SUCCEED = 'rd.authentication.registrationSucceed';


    /**
     * @Event(Symfony\Component\EventDispatcher\GenericEvent")
     * @var string
     */
    public const LOST_PASSWORD = 'rd.authentication.lostPassword';

    /**
     * @Event(Symfony\Component\EventDispatcher\GenericEvent")
     * @var string
     */
    public const PASSWORD_CHANGED = 'rd.authentication.passwordChanged';


    /**
     * @Event(Symfony\Component\EventDispatcher\GenericEvent")
     * @var string
     */
    public const ACCOUNT_VERIFIED = 'rd.authentication.accountVerified';
}