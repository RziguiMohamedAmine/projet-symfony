<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Equipe
 * @ORM\Table(name="equipe")
 * @ORM\Entity(repositoryClass=App\Repository\EquipeRepository::class)
 */
class Equipe
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank
     **@Assert\Length(
     *      min = "3",
     *      minMessage = "Le nom de l'equipe doit faire au moins {{ limit }} caractères",
     * )
     * @ORM\Column(name="nomeq", type="string", length=100, nullable=false)
     */
    private $nomeq;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="logo", type="string", length=100, nullable=false)
     */
    private $logo;

    /**
     * @var string
     * @ORM\Column(name="nom_entreneur", type="string", length=100, nullable=false)
     */
    private $nomEntreneur;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="niveau", type="string", length=100, nullable=false)
     */
    private $niveau;

    /**
     * @var string
     * @Assert\NotBlank
     * @ORM\Column(name="stade", type="string", length=100, nullable=false)
     */
    private $stade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomeq(): ?string
    {
        return $this->nomeq;
    }

    public function setNomeq(string $nomeq): self
    {
        $this->nomeq = $nomeq;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNomEntreneur(): ?string
    {
        return $this->nomEntreneur;
    }

    public function setNomEntreneur(string $nomEntreneur): self
    {
        $this->nomEntreneur = $nomEntreneur;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getStade(): ?string
    {
        return $this->stade;
    }

    public function setStade(string $stade): self
    {
        $this->stade = $stade;

        return $this;
    }

    public function __toString() {
        return $this->nomeq;
    }


}
