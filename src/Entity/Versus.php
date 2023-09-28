<?php

namespace App\Entity;

use App\Repository\VersusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersusRepository::class)]
class Versus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'versus')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Challenge $challenge = null;

    #[ORM\ManyToOne(inversedBy: 'versusCreated')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\OneToMany(mappedBy: 'versus', targetEntity: PlayVersus::class, orphanRemoval: true)]
    private Collection $players;

    #[ORM\Column]
    private ?bool $public = null;

    #[ORM\Column]
    private ?bool $closed = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeLimit = null;

    #[ORM\ManyToOne(inversedBy: 'versusWon')]
    private ?User $winner = null;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): static
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): static
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * @return Collection<int, PlayVersus>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(PlayVersus $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setVersus($this);
        }

        return $this;
    }

    public function removePlayer(PlayVersus $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getVersus() === $this) {
                $player->setVersus(null);
            }
        }

        return $this;
    }

    public function isPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): static
    {
        $this->public = $public;

        return $this;
    }

    public function isClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): static
    {
        $this->closed = $closed;

        return $this;
    }

    public function getTimeLimit(): ?\DateTimeInterface
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(?\DateTimeInterface $timeLimit): static
    {
        $this->timeLimit = $timeLimit;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getWinner(): ?User
    {
        return $this->winner;
    }

    public function setWinner(?User $winner): static
    {
        $this->winner = $winner;

        return $this;
    }
}
