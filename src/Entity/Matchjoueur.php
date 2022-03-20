<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Matchjoueur
 *
 * @ORM\Table(name="matchjoueur", indexes={@ORM\Index(name="id_match", columns={"id_match"}), @ORM\Index(name="id_joueur", columns={"id_joueur"})})
 * @ORM\Entity(repositoryClass=App\Repository\MatchjoueurRepository::class)
 */
class Matchjoueur
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
     * @var int
     *
     * @ORM\Column(name="carton_jaune", type="integer", nullable=false)
     */
    private $cartonJaune;

    /**
     * @var int
     *
     * @ORM\Column(name="carton_rouge", type="integer", nullable=false)
     */
    private $cartonRouge;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_but", type="integer", nullable=false)
     */
    private $nbBut;

    /**
     * @var \Joueur
     *
     * @ORM\ManyToOne(targetEntity="Joueur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_joueur", referencedColumnName="id")
     * })
     */
    private $idJoueur;

    /**
     * @var \Matchs
     *
     * @ORM\ManyToOne(targetEntity="Matchs")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_match", referencedColumnName="id")
     * })
     */
    private $idMatch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCartonJaune(): ?int
    {
        return $this->cartonJaune;
    }

    public function setCartonJaune(int $cartonJaune): self
    {
        $this->cartonJaune = $cartonJaune;

        return $this;
    }

    public function getCartonRouge(): ?int
    {
        return $this->cartonRouge;
    }

    public function setCartonRouge(int $cartonRouge): self
    {
        $this->cartonRouge = $cartonRouge;

        return $this;
    }

    public function getNbBut(): ?int
    {
        return $this->nbBut;
    }

    public function setNbBut(int $nbBut): self
    {
        $this->nbBut = $nbBut;

        return $this;
    }

    public function getIdJoueur(): ?Joueur
    {
        return $this->idJoueur;
    }

    public function setIdJoueur(?Joueur $idJoueur): self
    {
        $this->idJoueur = $idJoueur;

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


}
