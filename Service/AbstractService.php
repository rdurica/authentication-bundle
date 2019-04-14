<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service;

use Doctrine\ORM\EntityManagerInterface;

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
     * AbstractService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
}