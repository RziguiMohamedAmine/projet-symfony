<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Mapping\Entity ;
use Symfony\Component\HttpFoundation\File\File;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert ;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("blog")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *@Assert\Length(min=6, max=255, minMessage="Votre titre est court")
     * @Groups ("blog")
     */
    private $titre;

    /**
    * @ORM\Column(type="string", length=255)
     * @Groups ("blog")
     */
    private $image;


    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min=10)
     * @Groups ("blog")
     */
    private $contenu;

    
    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(length=128, unique=true ,nullable=true)
     */
    private $slug;
    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="blog" , cascade={"remove"})
     */
    private $commantaires;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="blog")
     */
    private $likes;

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommantaires(): Collection
    {
        return $this->commantaires;
    }

    public function addCommantaire(Commentaire $commantaire): self
    {
        if (!$this->commantaires->contains($commantaire)) {
            $this->commantaires[] = $commantaire;
            $commantaire->setBlog($this);
        }

        return $this;
    }

    public function removeCommantaire(Commentaire $commantaire): self
    {
        if ($this->commantaires->removeElement($commantaire)) {
            // set the owning side to null (unless already changed)
            if ($commantaire->getBlog() === $this) {
                $commantaire->setBlog(null);
            }
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }








    public function __construct()
    {
        $this->commantaires = new ArrayCollection();
        $this->likes = new ArrayCollection();
    }



    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }



    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setBlog($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getBlog() === $this) {
                $like->setBlog(null);
            }
        }

        return $this;
    }




   




}
