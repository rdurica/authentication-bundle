<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Serializable;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class User
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Entity
 * @ORM\Table("rd_authentication_user")
 * @ORM\Entity(repositoryClass="Rd\AuthenticationBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, Serializable, EquatableInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id = 0;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private string $username = '';

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private string $email = '';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $password = '';

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $active = true;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private bool $confirmed = false;

    /**
     * @ORM\Column(type="string", options={"default": "ROLE_USER"})
     */
    private string $roles = 'ROLE_USER';

    /**
     * @ORM\Column(type="string", nullable=true, unique=false, length=255, options={"default" :null})
     */
    private ?string $confirmHash = null;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private ?string $plainPassword = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTime $registrationDate;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private int $resetPasswordCount = 0;


    /**
     * User constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->registrationDate = new DateTime();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }


    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }


    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }


    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }


    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }


    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->active;
    }


    /**
     * @param bool $active
     * @return User
     */
    public function setActive(bool $active): User
    {
        $this->active = $active;

        return $this;
    }


    /**
     * @return array
     */
    public function getRoles(): array
    {
        return [$this->roles];
    }


    /**
     * @param string $roles
     * @return User
     */
    public function setRoles(string $roles): User
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @return string|null
     */
    public function getConfirmHash(): ?string
    {
        return $this->confirmHash;
    }


    /**
     * @param string $confirmHash
     * @return User
     */
    public function setConfirmHash(?string $confirmHash): User
    {
        $this->confirmHash = $confirmHash;

        return $this;
    }


    /**
     * @return string
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }


    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword(string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }


    /**
     * @return DateTime
     */
    public function getRegistrationDate(): DateTime
    {
        return $this->registrationDate;
    }


    /**
     * @param DateTime $registrationDate
     * @return User
     */
    public function setRegistrationDate(DateTime $registrationDate): User
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }


    /**
     * @return int
     */
    public function getResetPasswordCount(): int
    {
        return $this->resetPasswordCount;
    }


    /**
     * @param int $resetPasswordCount
     * @return User
     */
    public function setResetPasswordCount(int $resetPasswordCount): User
    {
        $this->resetPasswordCount = $resetPasswordCount;

        return $this;
    }


    /**
     * @return bool
     */
    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }


    /**
     * @param bool $confirmed
     * @return User
     */
    public function setConfirmed(bool $confirmed): User
    {
        $this->confirmed = $confirmed;

        return $this;
    }


    /**
     * String representation of object
     *
     * @link  https://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize(): string
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
        ]);
    }


    /**
     * Constructs the object
     *
     * @link  https://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     *                           The string representation of the object.
     *                           </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized): void
    {
        [$this->id, $this->email, $this->password,] = unserialize($serialized, ['allowed_classes' => false]);
    }


    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user): bool
    {
        if ($this->password !== $user->getPassword()) {
            return false;
        }
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }
        if ($this->email !== $user->getEmail()) {
            return false;
        }

        return true;
    }


    /**
     * Returns the salt that was originally used to encode the password.
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return null;
    }


    /**
     * Removes sensitive data from the user.
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
        $this->plainPassword = null;
    }
}
