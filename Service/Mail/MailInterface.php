<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Mail;

use Rd\AuthenticationBundle\Entity\User;

/**
 * Interface MailInterface
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service\Mail
 */
interface MailInterface
{


    /**
     * Send email about new registration + confirm hash
     *
     * @param User $user
     */
    public function registrationSuccessful(User $user): void;


    /**
     * Send email with reset password link
     *
     * @param User $user
     */
    public function resetPassword(User $user): void;


    /**
     * Send email if user change password
     *
     * @param User $user
     */
    public function passwordChanged(User $user): void;


    /**
     * Send email if confirmation has was confirmed
     *
     * @param User $user
     */
    public function accountVerified(User $user): void;

}