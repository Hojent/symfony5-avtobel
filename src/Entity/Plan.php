<?php

namespace App\Entity;

use App\Repository\PlanRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlanRepository::class)
 * @ORM\Table(name="plans")
 * @ORM\HasLifecycleCallbacks()
 */
class Plan
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $originalFilename;

    /**
     *@ORM\Column(type="boolean")
     */
    private $diagonal;

    /**
     * @ORM\ManyToOne(targetEntity="Body", inversedBy="plans")
     * @ORM\JoinColumn(name="body_id", referencedColumnName="id")
     */
    private $body;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(?string $originalFilename): self
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDiagonal()
    {
        return $this->diagonal;
    }

    /**
     * @param mixed $diagonal
     */
    public function setDiagonal($diagonal): void
    {
        $this->diagonal = $diagonal;
    }

    public function getBody(): ?Body
    {
        return $this->body;
    }

    public function setBody(?Body $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
