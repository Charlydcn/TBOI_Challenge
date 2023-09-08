<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChallengeRepository::class)]
class Challenge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $character = null;

    #[ORM\Column(length: 25)]
    private ?string $boss = null;

    #[ORM\Column(nullable: true)]
    private ?int $streak = null;

    #[ORM\OneToMany(mappedBy: 'challenge', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'challenge', targetEntity: Like::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\ManyToOne(inversedBy: 'challengesCreated')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $creator = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'challengesPlayed')]
    private Collection $players;

    #[ORM\OneToMany(mappedBy: 'challenge', targetEntity: Versus::class, orphanRemoval: true)]
    private Collection $versuses;

    #[ORM\ManyToMany(targetEntity: Restriction::class, mappedBy: 'challenges')]
    private Collection $restrictions;

    #[ORM\ManyToMany(targetEntity: Boss::class, inversedBy: 'challenges')]
    private Collection $bosses;

    #[ORM\ManyToMany(targetEntity: character::class, inversedBy: 'challenges')]
    private Collection $characters;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->players = new ArrayCollection();
        $this->versuses = new ArrayCollection();
        $this->bosses = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->restrictions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCharacter(): ?string
    {
        return $this->character;
    }

    public function setCharacter(string $character): static
    {
        $this->character = $character;

        return $this;
    }

    public function getBoss(): ?string
    {
        return $this->boss;
    }

    public function setBoss(string $boss): static
    {
        $this->boss = $boss;

        return $this;
    }

    public function getStreak(): ?int
    {
        return $this->streak;
    }

    public function setStreak(?int $streak): static
    {
        $this->streak = $streak;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setChallenge($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getChallenge() === $this) {
                $comment->setChallenge(null);
            }
        }

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
     * @return Collection<int, User>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(User $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
        }

        return $this;
    }

    public function removePlayer(User $player): static
    {
        $this->players->removeElement($player);

        return $this;
    }

    /**
     * @return Collection<int, Versus>
     */
    public function getVersuses(): Collection
    {
        return $this->versuses;
    }

    public function addVersus(Versus $versus): static
    {
        if (!$this->versuses->contains($versus)) {
            $this->versuses->add($versus);
            $versus->setChallenge($this);
        }

        return $this;
    }

    public function removeVersus(Versus $versus): static
    {
        if ($this->versuses->removeElement($versus)) {
            // set the owning side to null (unless already changed)
            if ($versus->getChallenge() === $this) {
                $versus->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Like>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): static
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->setChallenge($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getChallenge() === $this) {
                $like->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Restriction>
     */
    public function getRestrictions(): Collection
    {
        return $this->restrictions;
    }

    public function addRestriction(Restriction $restriction): static
    {
        if (!$this->restrictions->contains($restriction)) {
            $this->restrictions->add($restriction);
            $restriction->addChallenge($this);
        }

        return $this;
    }

    public function removeRestriction(Restriction $restriction): static
    {
        if ($this->restrictions->removeElement($restriction)) {
            $restriction->removeChallenge($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Boss>
     */
    public function getBosses(): Collection
    {
        return $this->bosses;
    }

    public function addBoss(Boss $boss): static
    {
        if (!$this->bosses->contains($boss)) {
            $this->bosses->add($boss);
        }

        return $this;
    }

    public function removeBoss(Boss $boss): static
    {
        $this->bosses->removeElement($boss);

        return $this;
    }

    /**
     * @return Collection<int, character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(character $character): static
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
        }

        return $this;
    }

    public function removeCharacter(character $character): static
    {
        $this->characters->removeElement($character);

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function __toString()
    {
        $r = "";

        foreach($this->characters as $character) {
            $r += " " + $character;
        }

        foreach($this->bosses as $boss) {
            $r += " " + $boss;
        }

        foreach($this->restrictions as $restriction) {
            $r += " " + $restriction;
        }

        return $r;
    }
}
