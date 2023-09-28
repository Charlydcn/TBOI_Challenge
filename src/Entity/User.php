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

    // ----------------------------------------------------------------------------
    // ----- challenge related attributes -----------------------------------------

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Challenge::class, orphanRemoval: true)]
    private Collection $challengesCreated;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PlayChallenge::class, orphanRemoval: true)]
    private Collection $challengesPlayed;

    // ----------------------------------------------------------------------------
    // ----- versus related attributes --------------------------------------------

    #[ORM\OneToMany(mappedBy: 'creator', targetEntity: Versus::class, orphanRemoval: true)]
    private Collection $versusCreated;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PlayVersus::class, orphanRemoval: true)]
    private Collection $versusPlayed;
    
    #[ORM\OneToMany(mappedBy: 'winner', targetEntity: Versus::class)]
    private Collection $versusWon;

    // ----------------------------------------------------------------------------
    // ----- other ----------------------------------------------------------------

    #[ORM\OneToMany(mappedBy: 'user1', targetEntity: Friendship::class, orphanRemoval: true)]
    private Collection $friendships;


    // ----------------------------------------------------------------------------
    // ----------------------------------------------------------------------------

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->challengesCreated = new ArrayCollection();
        $this->versusCreated = new ArrayCollection();
        $this->friendships = new ArrayCollection();
        $this->challengesPlayed = new ArrayCollection();
        $this->versusPlayed = new ArrayCollection();
        $this->versusWon = new ArrayCollection();
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
    public function getVersusCreated(): Collection
    {
        return $this->versusCreated;
    }

    public function addVersusCreated(Versus $versusCreated): static
    {
        if (!$this->versusCreated->contains($versusCreated)) {
            $this->versusCreated->add($versusCreated);
            $versusCreated->setCreator($this);
        }

        return $this;
    }

    public function removeVersusCreated(Versus $versusCreated): static
    {
        if ($this->versusCreated->removeElement($versusCreated)) {
            // set the owning side to null (unless already changed)
            if ($versusCreated->getCreator() === $this) {
                $versusCreated->setCreator(null);
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

    /**
     * @return Collection<int, Friendship>
     */
    public function getFriendships(): Collection
    {
        return $this->friendships;
    }

    public function addFriendship(Friendship $friendship): static
    {
        if (!$this->friendships->contains($friendship)) {
            $this->friendships->add($friendship);
            $friendship->setUser1($this);
        }

        return $this;
    }

    public function removeFriendship(Friendship $friendship): static
    {
        if ($this->friendships->removeElement($friendship)) {
            // set the owning side to null (unless already changed)
            if ($friendship->getUser1() === $this) {
                $friendship->setUser1(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlayChallenge>
     */
    public function getChallengesPlayed(): Collection
    {
        return $this->challengesPlayed;
    }

    public function addChallengesPlayed(PlayChallenge $challengesPlayed): static
    {
        if (!$this->challengesPlayed->contains($challengesPlayed)) {
            $this->challengesPlayed->add($challengesPlayed);
            $challengesPlayed->setUser($this);
        }

        return $this;
    }

    public function removeChallengesPlayed(PlayChallenge $challengesPlayed): static
    {
        if ($this->challengesPlayed->removeElement($challengesPlayed)) {
            // set the owning side to null (unless already changed)
            if ($challengesPlayed->getUser() === $this) {
                $challengesPlayed->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PlayVersus>
     */
    public function getVersusPlayed(): Collection
    {
        return $this->versusPlayed;
    }

    public function addVersusPlayed(PlayVersus $versusPlayed): static
    {
        if (!$this->versusPlayed->contains($versusPlayed)) {
            $this->versusPlayed->add($versusPlayed);
            $versusPlayed->setUser($this);
        }

        return $this;
    }

    public function removeVersusPlayed(PlayVersus $versusPlayed): static
    {
        if ($this->versusPlayed->removeElement($versusPlayed)) {
            // set the owning side to null (unless already changed)
            if ($versusPlayed->getUser() === $this) {
                $versusPlayed->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Versus>
     */
    public function getVersusWon(): Collection
    {
        return $this->versusWon;
    }

    public function addVersusWon(Versus $versusWon): static
    {
        if (!$this->versusWon->contains($versusWon)) {
            $this->versusWon->add($versusWon);
            $versusWon->setWinner($this);
        }

        return $this;
    }

    public function removeVersusWon(Versus $versusWon): static
    {
        if ($this->versusWon->removeElement($versusWon)) {
            // set the owning side to null (unless already changed)
            if ($versusWon->getWinner() === $this) {
                $versusWon->setWinner(null);
            }
        }

        return $this;
    }

    
}
