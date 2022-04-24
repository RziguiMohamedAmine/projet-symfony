<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator as AcmeAssert;


/**
 * Matchs
 *
 * @ORM\Table(name="matchs", indexes={@ORM\Index(name="equipe_FK1", columns={"equipe1"}), @ORM\Index(name="arbitre_FK3", columns={"id_arbitre3"}), @ORM\Index(name="equipe_FK2", columns={"equipe2"}), @ORM\Index(name="arbitre_FK4", columns={"id_arbitre4"}), @ORM\Index(name="arbitre_FK1", columns={"id_arbitre1"}), @ORM\Index(name="arbitre_FK2", columns={"id_arbitre2"})})
 * @ORM\Entity(repositoryClass=App\Repository\MatchsRepository::class)
 */
class Matchs
{
    public $nbBillet = 0;
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
    private $nbBut1 = -1;
    /**
     * @var int
     *
     * @ORM\Column(name="nb_but2", type="integer", nullable=false)
     */
    private $nbBut2 = -1;
    /**
     * @var string
     *
     * @ORM\Column(name="stade", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="cette champ est obligatoire")
     * @Assert\Length(
     *     min=3,
     *     max=100,
     *     minMessage="le nom de stade doit etre sperieur à 3",
     *     maxMessage = "le nom de stade doit etre inferieur à 100"
     * )
     */
    private $stade;
    /**
     * @var int
     *
     * @ORM\Column(name="date", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     * @Assert\NotBlank (message="ce champ est obligatoire");
     *
     */
    private $date;
    /**
     * @var int
     *
     * @ORM\Column(name="nb_spectateur", type="integer", nullable=false)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Positive(message="ce champ doit etre positive")
     */
    private $nbSpectateur;
    /**
     * @var string
     *
     * @ORM\Column(name="saison", type="string", length=8, nullable=false)
     * @Assert\NotBlank(message = "saison est obligtoire")
     * @Assert\Regex(
     *     pattern = "/^[0-9]{4}\/[0-9]{4}$/",
     *     message="saion doit etre de cette format 2020/2021"
     * )
     * @AcmeAssert\SaisonFormat()
     */
    private $saison;
    /**
     * @var int
     *
     * @ORM\Column(name="round", type="integer", nullable=false)
     * @Assert\NotBlank(message="round est obligatoire")
     * @Assert\Positive(message="round doit etre >0")
     */
    private $round;
    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe1", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */
    private $equipe1;
    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipe2", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */

    private $equipe2;
    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre1", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */

    private $idArbitre1;
    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre2", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */
    private $idArbitre2;
    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre3", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */
    private $idArbitre3;
    /**
     * @var \Arbitre
     *
     * @ORM\ManyToOne(targetEntity="Arbitre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_arbitre4", referencedColumnName="id")
     * })
     * @Assert\NotBlank(message="ce champ est obligtoire")
     */
    private $idArbitre4;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNbBut1(): ?int
    {
        return $this->nbBut1;
    }

    public function setNbBut1($nbBut1): self
    {
        $this->nbBut1 = -1;

        return $this;
    }

    public function getNbBut2(): ?int
    {
        return $this->nbBut2;
    }

    public function setNbBut2($nbBut2): self
    {
        $this->nbBut2 = -1;

        return $this;
    }

    public function getStade(): ?string
    {
        return $this->stade;
    }

    public function setStade($stade): self
    {
        $this->stade = $stade;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate($date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNbSpectateur(): ?int
    {
        return $this->nbSpectateur;
    }

    public function setNbSpectateur($nbSpectateur): self
    {
        $this->nbSpectateur = $nbSpectateur;

        return $this;
    }

    public function getSaison(): ?string
    {
        return $this->saison;
    }

    public function setSaison($saison): self
    {
        $this->saison = $saison;

        return $this;
    }

    public function getRound(): ?int
    {
        return $this->round;
    }

    public function setRound($round): self
    {
        $this->round = $round;

        return $this;
    }

    public function getIdArbitre4(): ?Arbitre
    {
        return $this->idArbitre4;
    }

    public function setIdArbitre4($idArbitre4): self
    {
        $this->idArbitre4 = $idArbitre4;

        return $this;
    }

    public function getIdArbitre1(): ?Arbitre
    {
        return $this->idArbitre1;
    }

    public function setIdArbitre1($idArbitre1): self
    {
        $this->idArbitre1 = $idArbitre1;

        return $this;
    }

    public function getIdArbitre3(): ?Arbitre
    {
        return $this->idArbitre3;
    }

    public function setIdArbitre3($idArbitre3): self
    {
        $this->idArbitre3 = $idArbitre3;

        return $this;
    }

    public function getIdArbitre2(): ?Arbitre
    {
        return $this->idArbitre2;
    }

    public function setIdArbitre2($idArbitre2): self
    {
        $this->idArbitre2 = $idArbitre2;

        return $this;
    }

    public function __toString()
    {
        return $this->getEquipe1()->getNomeq() . " - " . $this->getEquipe2()->getNomeq();
    }

    public function getEquipe1(): ?Equipe
    {
        return $this->equipe1;
    }

    public function setEquipe1($equipe1): self
    {
        $this->equipe1 = $equipe1;

        return $this;
    }

    public function getEquipe2(): ?Equipe
    {
        return $this->equipe2;
    }

    public function setEquipe2($equipe2): self
    {
        $this->equipe2 = $equipe2;

        return $this;
    }


}
