<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;

/**
 * Class ConditionRepository
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Repository
 */
class ConditionRepository extends EntityRepository
{

    /**
     * UserRepository constructor.
     *
     * @param                       $em
     * @param Mapping\ClassMetadata $class
     */
    public function __construct($em, Mapping\ClassMetadata $class)
    {
        parent::__construct($em, $class);
    }

}
