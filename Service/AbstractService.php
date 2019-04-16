<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AbstractService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service
 */
abstract class AbstractService
{


    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;


    /**
     * AbstractService constructor.
     *
     * @param EntityManagerInterface   $em
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }
}