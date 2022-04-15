<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 */
class Formation
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
     * @ORM\JoinColumn(name="id_equipe", referencedColumnName="id")
     * })
     */
    private $idEquipe;

    /**
     * @ORM\Column(type="integer")
     */
    private $st;

    /**
     * @ORM\Column(type="integer")
     */
    private $lw;

    /**
     * @ORM\Column(type="integer")
     */
    private $rw;

    /**
     * @ORM\Column(type="integer")
     */
    private $lm;

    /**
     * @ORM\Column(type="integer")
     */
    private $mc;

    /**
     * @ORM\Column(type="integer")
     */
    private $rm;

    /**
     * @ORM\Column(type="integer")
     */
    private $rcb;

    /**
     * @ORM\Column(type="integer")
     */
    private $lcb;

    /**
     * @ORM\Column(type="integer")
     */
    private $lb;

    /**
     * @ORM\Column(type="integer")
     */
    private $rb;

    /**
     * @ORM\Column(type="integer")
     */
    private $gk;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEquipe(): ?int
    {
        return $this->idEquipe;
    }

    public function setIdEquipe(?int $idEquipe): self
    {
        $this->idEquipe = $idEquipe;

        return $this;
    }

    public function getSt(): ?int
    {
        return $this->st;
    }

    public function setSt(int $st): self
    {
        $this->st = $st;

        return $this;
    }

    public function getLw(): ?int
    {
        return $this->lw;
    }

    public function setLw(int $lw): self
    {
        $this->lw = $lw;

        return $this;
    }

    public function getRw(): ?int
    {
        return $this->rw;
    }

    public function setRw(int $rw): self
    {
        $this->rw = $rw;

        return $this;
    }

    public function getLm(): ?int
    {
        return $this->lm;
    }

    public function setLm(int $lm): self
    {
        $this->lm = $lm;

        return $this;
    }

    public function getMc(): ?int
    {
        return $this->mc;
    }

    public function setMc(int $mc): self
    {
        $this->mc = $mc;

        return $this;
    }

    public function getRm(): ?int
    {
        return $this->rm;
    }

    public function setRm(int $rm): self
    {
        $this->rm = $rm;

        return $this;
    }

    public function getRcb(): ?int
    {
        return $this->rcb;
    }

    public function setRcb(int $rcb): self
    {
        $this->rcb = $rcb;

        return $this;
    }

    public function getLcb(): ?string
    {
        return $this->lcb;
    }

    public function setLcb(string $lcb): self
    {
        $this->lcb = $lcb;

        return $this;
    }

    public function getLb(): ?int
    {
        return $this->lb;
    }

    public function setLb(int $lb): self
    {
        $this->lb = $lb;

        return $this;
    }

    public function getRb(): ?int
    {
        return $this->rb;
    }

    public function setRb(int $rb): self
    {
        $this->rb = $rb;

        return $this;
    }

    public function getGk(): ?int
    {
        return $this->gk;
    }

    public function setGk(int $gk): self
    {
        $this->gk = $gk;

        return $this;
    }
}
