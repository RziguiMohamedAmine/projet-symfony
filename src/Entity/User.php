<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * User
 *
 * @ORM\Table(name="user", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"}), @ORM\UniqueConstraint(name="t_unique", columns={"tel"})})
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 */
class User
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pass", type="string", length=100, nullable=false)
     */
    private $pass;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer", nullable=false)
     */
    private $tel;

    /**
     * @var bool
     *
     * @ORM\Column(name="ban", type="boolean", nullable=false)
     */
    private $ban = '0';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="block", type="date", nullable=true)
     */
    private $block;

    /**
     * @var string|null
     *
     * @ORM\Column(name="forgetpassCode", type="string", length=50, nullable=true)
     */
    private $forgetpasscode;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50, nullable=false, options={"default"="user"})
     */
    private $role = 'user';

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPass(): ?string
    {
        return $this->pass;
    }

    public function setPass(string $pass): self
    {
        $this->pass = $pass;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getBan(): ?bool
    {
        return $this->ban;
    }

    public function setBan(bool $ban): self
    {
        $this->ban = $ban;

        return $this;
    }

    public function getBlock(): ?\DateTimeInterface
    {
        return $this->block;
    }

    public function setBlock(?\DateTimeInterface $block): self
    {
        $this->block = $block;

        return $this;
    }

    public function getForgetpasscode(): ?string
    {
        return $this->forgetpasscode;
    }

    public function setForgetpasscode(?string $forgetpasscode): self
    {
        $this->forgetpasscode = $forgetpasscode;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }


}
