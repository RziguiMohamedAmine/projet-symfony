<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups; 

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups ("comm")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=255)
     * @Groups ("comm")
     */
    private $descrp;
    
    /**
     * @ORM\Column(type="datetime")
     * @Groups("comm")
     */
    private $temps_comm;

    /**
     * @ORM\ManyToOne(targetEntity=Blog::class, inversedBy="commantaires")
     * @Groups ("blog")
     */
    private $blog;






    public function getTempsComm(): ?\DateTimeInterface
    {
        return $this->temps_comm;
    }

    public function setDescrp(string $descrp): self
    {
        $this->descrp = $descrp;

        return $this;
       
       

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($descrp) {
            // if 'updatedAt' is not defined in your entity, use another property
            $this->temps_comm = new \DateTime('now');
        }
        return $this;
    } 

    public function setTempsComm(\DateTimeInterface $temps_comm): self
    {
        $this->temps_comm= $temps_comm;

        return $this;
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescrp(): ?string
    {
        return $this->descrp;
    }

    public function getBlog(): ?Blog
    {
        return $this->blog;
    }

    public function setBlog(?Blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

   
}
