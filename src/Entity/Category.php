<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 * @ORM\Table(name="categories")
 */
class Category
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $alias;

    // ...
    /**
     * One Category has Many Categories.
     * @ORM\OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * Many Categories have One Category.
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * One Category has Many Posts.
     * @ORM\OneToMany(targetEntity="Post", mappedBy="category")
     */
    private $posts;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

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

    public function getParent()
    {
        return $this->parent;
    }

    public function setParent(Category $parent = null): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChildren()
    {
        return $this->children;
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

    public function __toString()
    {
        return $this->title;
    }
}
