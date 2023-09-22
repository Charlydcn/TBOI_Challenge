<?php

namespace App\Entity;

use App\Repository\VersusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VersusRepository::class)]
class Versus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $timeLimit = null;

    #[ORM\ManyToOne(inversedBy: 'versuses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Challenge $challenge = null;

    #[ORM\ManyToOne(inversedBy: 'versusesCreated')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\OneToMany(mappedBy: 'versus', targetEntity: VersusPlayer::class, orphanRemoval: true)]
    private Collection $players;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeLimit(): ?int
    {
        return $this->timeLimit;
    }

    public function setTimeLimit(?int $timeLimit): static
    {
        $this->timeLimit = $timeLimit;

        return $this;
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

    public function __toString()
    {
        $r = $this->challenge;

        foreach($this->players as $player) {
            $r += " " + $player;
        }

        return $r;
    }

    /**
     * @return Collection<int, VersusPlayer>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(VersusPlayer $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setVersus($this);
        }

        return $this;
    }

    public function removePlayer(VersusPlayer $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getVersus() === $this) {
                $player->setVersus(null);
            }
        }

        return $this;
    }
}
