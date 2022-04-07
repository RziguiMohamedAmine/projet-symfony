<?php

namespace App\Entity;

use App\Repository\StadeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StadeRepository::class)
 */
class Stade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Stade;

    /**
     * @ORM\Column(type="integer")
     */
    private $alt;

    /**
     * @ORM\Column(type="integer")
     */
    private $lng;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStade(): ?string
    {
        return $this->Stade;
    }

    public function setStade(string $Stade): self
    {
        $this->Stade = $Stade;

        return $this;
    }

    public function getAlt(): ?int
    {
        return $this->alt;
    }

    public function setAlt(int $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getLng(): ?int
    {
        return $this->lng;
    }

    public function setLng(int $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
