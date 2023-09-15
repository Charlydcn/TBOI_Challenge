<?php

namespace App\Entity;

use App\Repository\BossRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BossRepository::class)]
class Boss
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $img = null;

    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'bosses')]
    private Collection $challenges;

    #[ORM\Column]
    private ?bool $timed = null;

    public function __construct()
    {
        $this->challenges = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(string $img): static
    {
        $this->img = $img;

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): static
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges->add($challenge);
            $challenge->addBoss($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): static
    {
        if ($this->challenges->removeElement($challenge)) {
            $challenge->removeBoss($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function isTimed(): ?bool
    {
        return $this->timed;
    }

    public function setTimed(bool $timed): static
    {
        $this->timed = $timed;

        return $this;
    }
}
