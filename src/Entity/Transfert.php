<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Transfert
 *
 * @ORM\Table(name="transfert", indexes={@ORM\Index(name="id_nouveaueq", columns={"id_nouveaueq"}), @ORM\Index(name="id_joueur", columns={"id_joueur"}), @ORM\Index(name="id_ancieneq", columns={"id_ancieneq"})})
 * @ORM\Entity(repositoryClass=App\Repository\TransfertRepository::class)
 */
class Transfert
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
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ancieneq", referencedColumnName="id")
     * })
     */
    private $idAncieneq;

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
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_nouveaueq", referencedColumnName="id")
     * })
     */
    private $idNouveaueq;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdAncieneq(): ?Equipe
    {
        return $this->idAncieneq;
    }

    public function setIdAncieneq(?Equipe $idAncieneq): self
    {
        $this->idAncieneq = $idAncieneq;

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

    public function getIdNouveaueq(): ?Equipe
    {
        return $this->idNouveaueq;
    }

    public function setIdNouveaueq(?Equipe $idNouveaueq): self
    {
        $this->idNouveaueq = $idNouveaueq;

        return $this;
    }


}
