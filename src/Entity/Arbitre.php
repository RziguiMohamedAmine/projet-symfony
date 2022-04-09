<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Arbitre
 * @ORM\Table(name="arbitre", indexes={@ORM\Index(name="id_role", columns={"id_role"})})
 * @ORM\Entity(repositoryClass=App\Repository\ArbitreRepository::class)
 */
class Arbitre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=100, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=100, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=false)
     */
    private $image;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var \RoleArbitre
     *
     * @ORM\ManyToOne(targetEntity="RoleArbitre")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_role", referencedColumnName="id")
     * })
     */
    private $idRole;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getIdRole(): ?RoleArbitre
    {
        return $this->idRole;
    }

    public function setIdRole(?RoleArbitre $idRole): self
    {
        $this->idRole = $idRole;

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }


}
