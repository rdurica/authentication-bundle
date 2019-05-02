<?php declare(strict_types=1);

namespace Rd\AuthenticationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Condition
 *
 * @author  Robert Durica <r.durica@gmail.com>
 * @package Rd\AuthenticationBundle\Entity
 * @ORM\Table("rd_authentication_condition")
 * @ORM\Entity(repositoryClass="Rd\AuthenticationBundle\Repository\ConditionRepository")
 */
class Condition
{

    /**
     * @var integer
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $text;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }


    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }


}
