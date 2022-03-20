<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Matchs
 *
 * @ORM\Table(name="matchs", indexes={@ORM\Index(name="equipe_FK1", columns={"equipe1"}), @ORM\Index(name="arbitre_FK3", columns={"id_arbitre3"}), @ORM\Index(name="equipe_FK2", columns={"equipe2"}), @ORM\Index(name="arbitre_FK4", columns={"id_arbitre4"}), @ORM\Index(name="arbitre_FK1", columns={"id_arbitre1"}), @ORM\Index(name="arbitre_FK2", columns={"id_arbitre2"})})
 * @ORM\Entity(repositoryClass=App\Repository\MatchsRepository::class)
 */
class Matchs
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
     * @ORM\Column(name="nb_but1", type="integer", nullable=false)
     */
    private $nbBut1;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_but2", type="integer", nullable=false)
     */
    private $nbBut2;

    /**
     * @var string
     *
     * @ORM\Column(name="stade", type="string", length=100, nullable=false)
     */
    private $stade = '';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $date = 'CURRENT_TIMESTAMP';

    /**
     * @var int
     *
     * @ORM\Column(name="nb_spectateur", type="integer", nullable=false)
     */
    private $nbSpectateur;

    /**
     * @var string
     *
     * @ORM\Column(name="saison", type="string", length=8, nullable=false)
     */
    private $saison;

    /**
     * @var int
     *
     * @ORM\Column(name="round", type="integer", nullable=false)
     */
    private $round = '0';

    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre4", referencedColumnName="id")
     * })
     */
    private $idArbitre4;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe2", referencedColumnName="id")
     * })
     */
    private $equipe2;

    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre1", referencedColumnName="id")
     * })
     */
    private $idArbitre1;

    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre3", referencedColumnName="id")
     * })
     */
    private $idArbitre3;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe1", referencedColumnName="id")
     * })
     */
    private $equipe1;

    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre2", referencedColumnName="id")
     * })
     */
    private $idArbitre2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbBut1(): ?int
    {
        return $this->nbBut1;
    }

    public function setNbBut1(int $nbBut1): self
    {
        $this->nbBut1 = $nbBut1;

        return $this;
    }

    public function getNbBut2(): ?int
    {
        return $this->nbBut2;
    }

    public function setNbBut2(int $nbBut2): self
    {
        $this->nbBut2 = $nbBut2;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbSpectateur(): ?int
    {
        return $this->nbSpectateur;
    }

    public function setNbSpectateur(int $nbSpectateur): self
    {
        $this->nbSpectateur = $nbSpectateur;

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

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound(int $round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getIdArbitre4(): ?Arbitre
    {
        return $this->idArbitre4;
    }

    public function setIdArbitre4(?Arbitre $idArbitre4): self
    {
        $this->idArbitre4 = $idArbitre4;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2(?Equipe $equipe2): self
    {
        $this->equipe2 = $equipe2;

        return $this;
    }

    public function getIdArbitre1(): ?Arbitre
    {
        return $this->idArbitre1;
    }

    public function setIdArbitre1(?Arbitre $idArbitre1): self
    {
        $this->idArbitre1 = $idArbitre1;

        return $this;
    }

    public function getIdArbitre3(): ?Arbitre
    {
        return $this->idArbitre3;
    }

    public function setIdArbitre3(?Arbitre $idArbitre3): self
    {
        $this->idArbitre3 = $idArbitre3;

        return $this;
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1(?Equipe $equipe1): self
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getIdArbitre2(): ?Arbitre
    {
        return $this->idArbitre2;
    }

    public function setIdArbitre2(?Arbitre $idArbitre2): self
    {
        $this->idArbitre2 = $idArbitre2;

        return $this;
    }


}
