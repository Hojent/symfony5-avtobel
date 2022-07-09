<?php

namespace App\Entity;

use App\Repository\BodyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=BodyRepository::class)
 * @ORM\Table(name="bodies")
 * @UniqueEntity(fields = {"slug"},
 *     message = "The Slug already exists")
 * @ORM\HasLifecycleCallbacks()
 */
class Body
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
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank
     */
    private $slug;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $published;

    /**
     * Many Bodies have One BodyCategory.
     * @ORM\ManyToOne(targetEntity="BodyCategory", inversedBy="bodies")
     * @ORM\JoinColumn(name="body_category_id", referencedColumnName="id")
     */
    private $bodycategory;

    /**
     * @ORM\Column(name="created", type="date", nullable=true,
     *      )
     *
     */
    //@Assert\Type("\Date")
    private $created;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $images;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ordering;

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
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $featured;

    /**
     * @ORM\OneToMany(targetEntity=Plan::class, mappedBy="body")
     */
    private $plans;

    public function __construct()
    {
        $this->plans = new ArrayCollection();
    }

    public function getBodyCategory(): ?BodyCategory
    {
        return $this->bodycategory;
    }

    public function setBodyCategory(?BodyCategory $bodycategory): self
    {
        $this->bodycategory = $bodycategory;

        return $this;
    }

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

    public function getSlug(): ?string
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

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getImages(): ?string
    {
        return $this->images;
    }

    public function setImages(?string $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getOrdering(): ?int
    {
        return $this->ordering;
    }

    public function setOrdering(?int $ordering): self
    {
        $this->ordering = $ordering;

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

    public function getMetakey(): ?string
    {
        return $this->metakey;
    }

    public function setMetakey(string $metakey): self
    {
        $this->metakey = $metakey;

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

    public function getPlan(): ?Plan
    {
        return $this->plan;
    }

    public function setPlan(?Plan $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @return Collection<int, Plan>
     */
    public function getPlans(): Collection
    {
        return $this->plans;
    }

    public function addPlan(Plan $plan): self
    {
        if (!$this->plans->contains($plan)) {
            $this->plans[] = $plan;
            $plan->setBody($this);
        }

        return $this;
    }

    public function removePlan(Plan $plan): self
    {
        if ($this->plans->removeElement($plan)) {
            // set the owning side to null (unless already changed)
            if ($plan->getBody() === $this) {
                $plan->setBody(null);
            }
        }

        return $this;
    }

}
