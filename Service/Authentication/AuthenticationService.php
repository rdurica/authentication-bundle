<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Authentication;

use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Event\UserEvent;
use Rd\AuthenticationBundle\Helper\BundleHelper;
use Rd\AuthenticationBundle\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AuthenticationService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service
 */
class AuthenticationService extends AbstractService implements AuthenticationInterface
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    /**
     * AuthenticationService constructor.
     *
     * @param EntityManagerInterface       $em
     * @param EventDispatcherInterface     $eventDispatcher
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        parent::__construct($em, $eventDispatcher);
        $this->passwordEncoder = $passwordEncoder;
    }


    /**
     * Register new user
     *
     * @param User $user
     * @throws \Exception
     */
    public function register(User $user): void
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setConfirmHash($this->generateHash());

        $event = new GenericEvent($user);
        $this->em->persist($user);

        $this->em->flush();

        $this->eventDispatcher->dispatch(BundleHelper::EVENT_REGISTRATION_SUCCEED, $event);
    }


    /**
     * Confirm account after registration
     *
     * @param string $hash
     */
    public function confirmAccount(string $hash): void
    {

    }


    /**
     * Create new password link & send email
     *
     * @param string $email
     */
    public function regeneratePassword(string $email): void
    {

    }


    /**
     * Change password for logged user
     *
     * @param User   $user
     * @param string $newPassword
     */
    public function changePassword(User $user, string $newPassword): void
    {

    }


    /**
     * Create hash which will be send to user
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    private function generateHash(int $length = 70): string
    {
        $dateTime = new DateTime();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString . $dateTime->format('his');
    }
}