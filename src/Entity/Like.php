<?php

namespace App\Entity;

use App\Repository\LikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeRepository::class)
 * @ORM\Table(name="`like`")
 */
class Like
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeLike;

    /**
     * @ORM\ManyToOne(targetEntity=blog::class, inversedBy="likes")
     */
    private $blog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeLike(): ?string
    {
        return $this->typeLike;
    }

    public function setTypeLike(string $typeLike): self
    {
        $this->typeLike = $typeLike;

        return $this;
    }

    public function getBlog(): ?blog
    {
        return $this->blog;
    }

    public function setBlog(?blog $blog): self
    {
        $this->blog = $blog;

        return $this;
    }
}
