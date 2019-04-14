<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\NonUniqueResultException;
use Rd\AuthenticationBundle\Entity\User;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
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


    /**
     * Loads the user for the given username.
     * This method must return null if the user is not found.
     *
     * @param string $username The username
     * @return UserInterface|null
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
                    ->where('u.email = :email')
                    ->andWhere('u.isActive = :isActive')
                    ->andWhere('u.isConfirmed = :isConfirmed')
                    ->setParameter('email', $username)
                    ->setParameter('isActive', true)
                    ->setParameter('isConfirmed', true)
                    ->getQuery()
                    ->getOneOrNullResult();
    }

}