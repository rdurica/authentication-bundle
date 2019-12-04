<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Mail;

use Doctrine\ORM\EntityManagerInterface as Em;
use Rd\AuthenticationBundle\Entity\User;
use Rd\AuthenticationBundle\Service\AbstractService;
use Swift_Mailer;
use Swift_Message;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as Ed;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class MailService
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service\Mail
 */
class MailService extends AbstractService implements MailInterface
{

    private Swift_Mailer $mailer;

    private Environment $twig;


    /**
     * MailService constructor.
     *
     * @param Em           $em
     * @param Ed           $eventDispatcher
     * @param Swift_Mailer $mailer
     * @param Environment  $twig
     */
    public function __construct(Em $em, Ed $eventDispatcher, Swift_Mailer $mailer, Environment $twig)
    {
        parent::__construct($em, $eventDispatcher);
        $this->mailer = $mailer;
        $this->twig = $twig;
    }


    /**
     * Send email about new registration + confirm hash
     *
     * @param User $user
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function registrationSuccessful(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Registration successful')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/registration_successful.html.twig', [
                    'user' => $user,
                ]), 'text/html');

        $this->mailer->send($message);
    }


    /**
     * Send email with reset password link
     *
     * @param User $user
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function resetPassword(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Reset password')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/reset_password.html.twig', [
                    'user' => $user,
                ]), 'text/html');

        $this->mailer->send($message);
    }


    /**
     * Send email if user change password
     *
     * @param User $user
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function passwordChanged(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Password changed')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/password_changed.html.twig', [
                    'user' => $user,
                ]), 'text/html');

        $this->mailer->send($message);
    }


    /**
     * Send email if confirmation has was confirmed
     *
     * @param User $user
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function accountVerified(User $user): void
    {
        $message = new Swift_Message();
        $message->setSubject('Account verified')
                ->setFrom('test@test.net')
                ->setTo($user->getEmail())
                ->setBody($this->twig->render('@RdAuthentication/mail/account_verified.html.twig', [
                    'user' => $user,
                ]), 'text/html');

        $this->mailer->send($message);
    }
}