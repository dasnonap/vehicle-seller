<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?AccessToken $access_token = null;

    /**
     * @var Collection<int, Vehicle>
     */
    #[ORM\OneToMany(targetEntity: Vehicle::class, mappedBy: 'user')]
    private Collection $vehicles;

    /**
     * @var Collection<int, UserVehicleLike>
     */
    #[ORM\OneToMany(targetEntity: UserVehicleLike::class, mappedBy: 'user')]
    private Collection $likedVehicles;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->likedVehicles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function eraseCredentials(): void {}

    public function getAccessToken(): ?AccessToken
    {
        return $this->access_token;
    }

    public function setAccessToken(AccessToken $access_token): static
    {
        // set the owning side of the relation if necessary
        if ($access_token->getUser() !== $this) {
            $access_token->setUser($this);
        }

        $this->access_token = $access_token;

        return $this;
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setUser($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            // set the owning side to null (unless already changed)
            if ($vehicle->getUser() === $this) {
                $vehicle->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserVehicleLike>
     */
    public function getLikedVehicles(): Collection
    {
        return $this->likedVehicles;
    }

    public function addLikedVehicle(UserVehicleLike $likedVehicle): static
    {
        if (!$this->likedVehicles->contains($likedVehicle)) {
            $this->likedVehicles->add($likedVehicle);
            $likedVehicle->setUser($this);
        }

        return $this;
    }

    public function removeLikedVehicle(UserVehicleLike $likedVehicle): static
    {
        if ($this->likedVehicles->removeElement($likedVehicle)) {
            // set the owning side to null (unless already changed)
            if ($likedVehicle->getUser() === $this) {
                $likedVehicle->setUser(null);
            }
        }

        return $this;
    }

    public function getUserData()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'roles' => $this->roles,
            'access_token' => $this->access_token->getToken()
        ];
    }
}
