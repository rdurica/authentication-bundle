<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
 * @ORM\Entity(repositoryClass="Robbyte\AuthenticationBundle\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, \Serializable, EquatableInterface
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;


    /**
     * @ORM\Column(type="string", length=100, nullable=true, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $isActive;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isConfirmed;

    /**
     * @ORM\Column(type="string", options={"default": "ROLE_USER"})
     */
    private $roles;

    /**
     * @ORM\Column(type="string", nullable=true, unique=false, length=255, options={"default" :null})
     */
    private $confirmHash;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->roles = 'ROLE_USER';
        $this->isConfirmed = false;
    }


    public function getId()
    {
        return $this->id;
    }


    public function getUsername(): ?string
    {
        return $this->username;
    }


    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }


    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }


    public function getPassword(): ?string
    {
        return $this->password;
    }


    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }


    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }


    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }


    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }


    /**
     * @return mixed
     */
    public function getIsConfirmed()
    {
        return $this->isConfirmed;
    }


    /**
     * @param mixed $isConfirmed
     */
    public function setIsConfirmed($isConfirmed): void
    {
        $this->isConfirmed = $isConfirmed;
    }


    /**
     * @return mixed
     */
    public function getConfirmHash()
    {
        return $this->confirmHash;
    }


    /**
     * @param mixed $confirmHash
     */
    public function setConfirmHash($confirmHash): void
    {
        $this->confirmHash = $confirmHash;
    }


    public function serialize()
    {
        return serialize([
            $this->id,
            $this->email,
            $this->password,
        ]);
    }


    public function unserialize($serialized)
    {
        list ($this->id, $this->email, $this->password,) = unserialize($serialized, ['allowed_classes' => false]);
    }


    public function getRoles()
    {
        return [$this->roles];
    }


    public function setRoles(string $role)
    {
        $this->roles = $role;
    }


    public function getSalt()
    {
        return 'T4suXsYv0UZwQSQvXx6N';
    }


    public function eraseCredentials()
    {

    }


    /**
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     * Also implementation should consider that $user instance may implement
     * the extended user interface `AdvancedUserInterface`.
     *
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
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
}
