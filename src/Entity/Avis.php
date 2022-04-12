<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * Avis
 *
 * @ORM\Table(name="avis", indexes={@ORM\Index(name="fk_user", columns={"id_user"}), @ORM\Index(name="fk_avis", columns={"id_produit"})})
 * @ORM\Entity(repositoryClass=App\Repository\AvisRepository::class)
 */
class Avis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_avis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAvis;

    /**
     * @var float
     *
     * @ORM\Column(name="avis", type="float", precision=10, scale=0, nullable=false)
     */
    private $avis;

    /**
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_produit", referencedColumnName="id")
     * })
     */
    private $idProduit;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    public function getIdAvis(): ?int
    {
        return $this->idAvis;
    }

    public function getAvis(): ?float
    {
        return $this->avis;
    }

    public function setAvis(float $avis): self
    {
        $this->avis = $avis;

        return $this;
    }

    public function getIdProduit(): ?Produit
    {
        return $this->idProduit;
    }

    public function setIdProduit(?Produit $idProduit): self
    {
        $this->idProduit = $idProduit;

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
