<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    // ----------------------------------------------------------------------------
    // ----- normal attributes ----------------------------------------------------

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;
    
    #[ORM\Column(length: 20)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $icon = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $banner = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    // ----------------------------------------------------------------------------
    // ----- relationnals attributes ----------------------------------------------

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Like::class, orphanRemoval: true)]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Challenge::class, orphanRemoval: true)]
    private Collection $challengesCreated;

    #[ORM\ManyToMany(targetEntity: Challenge::class, mappedBy: 'players')]
    private Collection $challengesPlayed;

    #[ORM\ManyToMany(targetEntity: Versus::class, mappedBy: 'players')]
    private Collection $versusesPlayed;

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Versus::class, orphanRemoval: true)]
    private Collection $versusesCreated;

    // ----------------------------------------------------------------------------
    // ----------------------------------------------------------------------------

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->challengesCreated = new ArrayCollection();
        $this->challengesPlayed = new ArrayCollection();
        $this->versusesPlayed = new ArrayCollection();
        $this->versusesCreated = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->password = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): static
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getBanner(): ?string
    {
        return $this->banner;
    }

    public function setBanner(?string $banner): static
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallengesCreated(): Collection
    {
        return $this->challengesCreated;
    }

    public function addChallengesCreated(Challenge $challengesCreated): static
    {
        if (!$this->challengesCreated->contains($challengesCreated)) {
            $this->challengesCreated->add($challengesCreated);
            $challengesCreated->setCreator($this);
        }

        return $this;
    }

    public function removeChallengesCreated(Challenge $challengesCreated): static
    {
        if ($this->challengesCreated->removeElement($challengesCreated)) {
            // set the owning side to null (unless already changed)
            if ($challengesCreated->getCreator() === $this) {
                $challengesCreated->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Challenge>
     */
    public function getChallengesPlayed(): Collection
    {
        return $this->challengesPlayed;
    }

    public function addChallengesPlayed(Challenge $challengesPlayed): static
    {
        if (!$this->challengesPlayed->contains($challengesPlayed)) {
            $this->challengesPlayed->add($challengesPlayed);
            $challengesPlayed->addPlayer($this);
        }

        return $this;
    }

    public function removeChallengesPlayed(Challenge $challengesPlayed): static
    {
        if ($this->challengesPlayed->removeElement($challengesPlayed)) {
            $challengesPlayed->removePlayer($this);
        }

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
            $comment->setCreator($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getCreator() === $this) {
                $comment->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Versus>
     */
    public function getVersusesPlayed(): Collection
    {
        return $this->versusesPlayed;
    }

    public function addVersusesPlayed(Versus $versusesPlayed): static
    {
        if (!$this->versusesPlayed->contains($versusesPlayed)) {
            $this->versusesPlayed->add($versusesPlayed);
            $versusesPlayed->addPlayer($this);
        }

        return $this;
    }

    public function removeVersusesPlayed(Versus $versusesPlayed): static
    {
        if ($this->versusesPlayed->removeElement($versusesPlayed)) {
            $versusesPlayed->removePlayer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Versus>
     */
    public function getVersusesCreated(): Collection
    {
        return $this->versusesCreated;
    }

    public function addVersusesCreated(Versus $versusesCreated): static
    {
        if (!$this->versusesCreated->contains($versusesCreated)) {
            $this->versusesCreated->add($versusesCreated);
            $versusesCreated->setCreator($this);
        }

        return $this;
    }

    public function removeVersusesCreated(Versus $versusesCreated): static
    {
        if ($this->versusesCreated->removeElement($versusesCreated)) {
            // set the owning side to null (unless already changed)
            if ($versusesCreated->getCreator() === $this) {
                $versusesCreated->setCreator(null);
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
            $like->setCreator($this);
        }

        return $this;
    }

    public function removeLike(Like $like): static
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getCreator() === $this) {
                $like->setCreator(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

    
}
