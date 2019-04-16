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
}