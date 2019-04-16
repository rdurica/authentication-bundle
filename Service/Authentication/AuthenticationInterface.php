<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Service\Authentication;

use Rd\AuthenticationBundle\Entity\User;

/**
 * Interface AuthenticationInterface
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Service
 */
interface AuthenticationInterface
{


    /**
     * Register new user
     *
     * @param User $user
     */
    public function register(User $user): void;


    /**
     * Confirm account after registration
     *
     * @param string $hash
     */
    public function confirmAccount(string $hash): void;


    /**
     * Create new password link & send email
     *
     * @param string $email
     */
    public function regeneratePassword(string $email): void;


    /**
     * Change password for logged user
     *
     * @param User   $user
     * @param string $newPassword
     */
    public function changePassword(User $user, string $newPassword): void;
}