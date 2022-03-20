<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Billet
 *
 * @ORM\Table(name="billet", indexes={@ORM\Index(name="user_fk", columns={"id_user"}), @ORM\Index(name="forien_key", columns={"id_match"})})
 * @ORM\Entity(repositoryClass=App\Repository\BilletRepository::class)
 */
class Billet
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
     * @ORM\Column(name="bloc", type="string", length=500, nullable=false)
     */
    private $bloc;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var \Matchs
     *
     * @ORM\ManyToOne(targetEntity="Matchs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     * })
     */
    private $idMatch;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBloc(): ?string
    {
        return $this->bloc;
    }

    public function setBloc(string $bloc): self
    {
        $this->bloc = $bloc;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getIdMatch(): ?Matchs
    {
        return $this->idMatch;
    }

    public function setIdMatch(?Matchs $idMatch): self
    {
        $this->idMatch = $idMatch;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
