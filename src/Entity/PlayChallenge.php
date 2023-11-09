<?php

namespace App\Entity;

use App\Repository\PlayChallengeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayChallengeRepository::class)]
class PlayChallenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $completed = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $playDate = null;

    #[ORM\ManyToOne(inversedBy: 'challengesPlayed')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Challenge $challenge = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $completionTime = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $comment = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlayDate(): ?\DateTimeInterface
    {
        return $this->playDate;
    }

    public function setPlayDate(\DateTimeInterface $playDate): static
    {
        $this->playDate = $playDate;

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

    public function __toString()
    {
        $r = "";
        $r .= "User : " . $this->user . " ";
        $r .= "Last challenge run : " . $this->playDate->format('d-m-Y h:i:s') . " ";
        $r .= "Completed : " . ($this->completed === true ? "Yes" : "No") . " ";
        $r .= $this->completed === true ? "Completion Time : " . $this->completionTime->format('h:i:s') : "" . " ";

        return $r;

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

    public function getCompletionTime(): ?\DateTimeInterface
    {
        return $this->completionTime;
    }

    public function setCompletionTime(?\DateTimeInterface $completionTime): static
    {
        $this->completionTime = $completionTime;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
