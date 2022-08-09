<?php

namespace App\Entity;

use App\Repository\BodyCategoryRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\Body;

/**
 * @ORM\Entity(repositoryClass=BodyCategoryRepository::class)
 * @ORM\Table(name="body_categories")
 * @UniqueEntity(fields = {"slug"},
 *     message = "The Slug already exists")
 * @ORM\HasLifecycleCallbacks()
 */
class BodyCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * One Category has Many Bodies.
     * @ORM\OneToMany(targetEntity="Body", mappedBy="bodycategory")
     */
    private $bodies;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $metatitle;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $metadesc;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $metakey;

    /**
     * @ORM\Column(name="created_time", type="datetime", nullable=false)
     * date('Y-m-d H:i:s')
     * @Assert\Type("\DateTime")
     */
    protected $created_time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getMetatitle(): ?string
    {
        return $this->metatitle;
    }

    public function setMetatitle(?string $metatitle): self
    {
        $this->metatitle = $metatitle;

        return $this;
    }

    public function getMetadesc(): ?string
    {
        return $this->metadesc;
    }

    public function setMetadesc(?string $metadesc): self
    {
        $this->metadesc = $metadesc;

        return $this;
    }

    public function getMetakey(): ?string
    {
        return $this->metakey;
    }

    public function setMetakey(?string $metakey): self
    {
        $this->metakey = $metakey;

        return $this;
    }

    public function getCreatedTime(): ?\DateTimeInterface
    {
        return $this->created_time;
    }

    public function setCreatedTime(\DateTimeInterface $created_time): self
    {
        $this->created_time = $created_time;

        return $this;
    }

    public function getBodies()
    {
        return $this->bodies;
    }

    public function __toString()
    {
        return $this->title;
    }
}
