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
     * @ORM\Column(type="float")
     */
    private $alt;

    /**
     * @ORM\Column(type="float")
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

    public function getAlt(): ?float
    {
        return $this->alt;
    }

    public function setAlt(float $alt): self
    {
        $this->alt = $alt;

        return $this;
    }

    public function getLng(): ?float
    {
        return $this->lng;
    }

    public function setLng(float $lng): self
    {
        $this->lng = $lng;

        return $this;
    }
}
