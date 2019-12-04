<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface as Em;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Ed;

/**
 * Class AbstractService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service
 */
abstract class AbstractService
{
    protected Em $em;

    protected Ed $eventDispatcher;


    /**
     * AbstractService constructor.
     *
     * @param Em $em
     * @param Ed $eventDispatcher
     */
    public function __construct(Em $em, Ed $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }
}