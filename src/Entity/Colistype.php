<?php

namespace App\Entity;

use App\Repository\ColistypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ColistypeRepository::class)
 */
class Colistype
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
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "The type must be at least {{ limit }} characters long",
     *      maxMessage = "The type cannot be longer than {{ limit }} characters"
     * )
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=Colis::class, mappedBy="colistype")
     */
    private $colis;

    public function __construct()
    {
        $this->colis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Colis[]
     */
    public function getColis(): Collection
    {
        return $this->colis;
    }

    public function addColis(Colis $colis): self
    {
        if (!$this->colis->contains($colis)) {
            $this->colis[] = $colis;
            $colis->setColistype($this);
        }

        return $this;
    }

    public function removeColis(Colis $colis): self
    {
        if ($this->colis->removeElement($colis)) {
            // set the owning side to null (unless already changed)
            if ($colis->getColistype() === $this) {
                $colis->setColistype(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getType();
    }
}