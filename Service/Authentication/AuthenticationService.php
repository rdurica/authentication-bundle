<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Authentication;

use DateTime;
use Doctrine\ORM\EntityManagerInterface as Em;
use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Event;
use Rd\AuthenticationBundle\Exception\AccountNotFoundException;
use Rd\AuthenticationBundle\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Ed;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class AuthenticationService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service\Authentication
 */
class AuthenticationService extends AbstractService implements AuthenticationInterface
{

    private UserPasswordEncoderInterface $passwordEncoder;


    /**
     * AuthenticationService constructor.
     *
     * @param Em                           $em
     * @param Ed                           $eventDispatcher
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(Em $em, Ed $eventDispatcher, UserPasswordEncoderInterface $passwordEncoder)
    {
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

        $this->eventDispatcher->dispatch($event, Event::REGISTRATION_SUCCEED);
    }


    /**
     * Confirm account after registration
     *
     * @param string $hash
     * @throws AccountNotFoundException
     */
    public function confirmAccount(string $hash): void
    {
        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->findOneBy([
            'confirmHash' => $hash,
            'active'      => true,
            'confirmed'   => false,
        ]);

        if (!$user) {
            throw  new AccountNotFoundException();
        }

        $user->setConfirmed(true);
        $user->setConfirmHash(null);

        $this->em->persist($user);
        $this->em->flush();

        $event = new GenericEvent($user);
        $this->eventDispatcher->dispatch($event, Event::ACCOUNT_VERIFIED);
    }


    /**
     * Create new password link & send email
     *
     * @param string $email
     * @throws AccountNotFoundException
     * @throws \Exception
     */
    public function regeneratePassword(string $email): void
    {

        /** @var User|null $user */
        $user = $this->em->getRepository(User::class)->findOneBy([
            'email'     => $email,
            'confirmed' => true,
            'active'    => true,
        ]);

        if (!$user) {
            throw new AccountNotFoundException();
        }

        $user->setConfirmHash($this->generateHash(69));
        $user->setResetPasswordCount($user->getResetPasswordCount() + 1);

        $this->em->persist($user);
        $this->em->flush();

        $event = new GenericEvent($user);
        $this->eventDispatcher->dispatch($event, Event::LOST_PASSWORD);
    }


    /**
     * Change password for logged user
     *
     * @param User   $user
     * @param string $newPassword
     */
    public function changePassword(User $user, string $newPassword): void
    {
        $password = $this->passwordEncoder->encodePassword($user, $newPassword);

        $user->setPassword($password);
        $user->setConfirmHash(null);

        $this->em->persist($user);
        $this->em->flush();

        $event = new GenericEvent($user);
        $this->eventDispatcher->dispatch($event, Event::PASSWORD_CHANGED);
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