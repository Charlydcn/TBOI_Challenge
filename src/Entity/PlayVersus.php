<?php

namespace App\Entity;

use App\Repository\PlayVersusRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayVersusRepository::class)]
class PlayVersus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completionTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $playDate = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Versus $versus = null;

    #[ORM\ManyToOne(inversedBy: 'versusPlayed')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?bool $completed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompletionTime(): ?\DateTimeInterface
    {
        return $this->completionTime;
    }

    public function setCompletionTime(\DateTimeInterface $completionTime): static
    {
        $this->completionTime = $completionTime;

        return $this;
    }

    public function getPlayDate(): ?\DateTimeInterface
    {
        return $this->playDate;
    }

    public function setPlayDate(\DateTimeInterface $playDate): static
    {
        $this->playDate = $playDate;

        return $this;
    }

    public function getVersus(): ?Versus
    {
        return $this->versus;
    }

    public function setVersus(?Versus $versus): static
    {
        $this->versus = $versus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isCompleted(): ?bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): static
    {
        $this->completed = $completed;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
