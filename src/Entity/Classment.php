<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Classment
 *
 * @ORM\Table(name="classment", indexes={@ORM\Index(name="equipe_classment", columns={"id_equipe"})})
 * @ORM\Entity(repositoryClass=App\Repository\ClassementRepository::class)
 */
class Classment
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_classment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClassment;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_totale_but", type="integer", nullable=false)
     */
    private $nbTotaleBut = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nb_totale_but_recu", type="integer", nullable=false)
     */
    private $nbTotaleButRecu = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nb_point", type="integer", nullable=false)
     */
    private $nbPoint = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="saison", type="string", length=8, nullable=false)
     */
    private $saison;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_win", type="integer", nullable=false)
     */
    private $nbWin = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nb_draw", type="integer", nullable=false)
     */
    private $nbDraw = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="nb_lose", type="integer", nullable=false)
     */
    private $nbLose = '0';

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe", referencedColumnName="id")
     * })
     */
    private $idEquipe;

    public function getIdClassment(): ?int
    {
        return $this->idClassment;
    }

    public function getNbTotaleBut(): ?int
    {
        return $this->nbTotaleBut;
    }

    public function setNbTotaleBut(int $nbTotaleBut): self
    {
        $this->nbTotaleBut = $nbTotaleBut;

        return $this;
    }

    public function getNbTotaleButRecu(): ?int
    {
        return $this->nbTotaleButRecu;
    }

    public function setNbTotaleButRecu(int $nbTotaleButRecu): self
    {
        $this->nbTotaleButRecu = $nbTotaleButRecu;

        return $this;
    }

    public function getNbPoint(): ?int
    {
        return $this->nbPoint;
    }

    public function setNbPoint(int $nbPoint): self
    {
        $this->nbPoint = $nbPoint;

        return $this;
    }

    public function getSaison(): ?string
    {
        return $this->saison;
    }

    public function setSaison(string $saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getNbWin(): ?int
    {
        return $this->nbWin;
    }

    public function setNbWin(int $nbWin): self
    {
        $this->nbWin = $nbWin;

        return $this;
    }

    public function getNbDraw(): ?int
    {
        return $this->nbDraw;
    }

    public function setNbDraw(int $nbDraw): self
    {
        $this->nbDraw = $nbDraw;

        return $this;
    }

    public function getNbLose(): ?int
    {
        return $this->nbLose;
    }

    public function setNbLose(int $nbLose): self
    {
        $this->nbLose = $nbLose;

        return $this;
    }

    public function getIdEquipe(): ?Equipe
    {
        return $this->idEquipe;
    }

    public function setIdEquipe(?Equipe $idEquipe): self
    {
        $this->idEquipe = $idEquipe;

        return $this;
    }


}
