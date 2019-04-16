<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Mail;

use Doctrine\ORM\EntityManagerInterface;
use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Service\AbstractService;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;

/**
 * Class MailService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service\Mail
 */
class MailService extends AbstractService implements MailInterface
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $twig;


    /**
     * MailService constructor.
     *
     * @param EntityManagerInterface   $em
     * @param EventDispatcherInterface $eventDispatcher
     * @param Swift_Mailer             $mailer
     * @param Environment              $twig
     */
    public function __construct(
        EntityManagerInterface $em,
        EventDispatcherInterface $eventDispatcher,
        Swift_Mailer $mailer,
        Environment $twig
    ) {
        parent::__construct($em, $eventDispatcher);
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    /**
     * Send email about new registration + confirm hash
     *
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function registrationSuccessful(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Registration successful')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/registration_successful.html.twig', [
                    'user' => $user,
                ]));

        $this->mailer->send($message);
    }


    /**
     * Send email with reset password link
     *
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function resetPassword(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Reset password')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/reset_password.html.twig', [
                    'user' => $user,
                ]));

        $this->mailer->send($message);
    }


    /**
     * Generate new email with link to restore password
     *
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function forgottenPassword(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Forgotten password')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/forgotten_password.html.twig', [
                    'user' => $user,
                ]));

        $this->mailer->send($message);
    }


    /**
     * Send email if user change password
     *
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function passwordChanged(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Password changed')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/password_changed.html.twig', [
                    'user' => $user,
                ]));

        $this->mailer->send($message);
    }


    /**
     * Send email if confirmation has was confirmed
     *
     * @param User $user
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function accountVerified(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Account verified')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/account_verified.html.twig', [
                    'user' => $user,
                ]));

        $this->mailer->send($message);
    }
}