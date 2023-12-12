<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email(message:"Entrez un mail valide.")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:3, max:50, minMessage:"Entrez un nom de {{limit}} caractères minimum.", maxMessage:"Entrez un nom de {{limit}} caractères maximum.")]
    #[Assert\NotBlank(message:"Entrez un nom.")]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min:3, max:50, minMessage:"Entrez un prenom de {{limit}} caractères minimum.", maxMessage:"Entrez un nom de {{limit}} caractères maximum.")]
    #[Assert\NotBlank(message:"Entrez un prenom.")]
    private ?string $prenom = null;

    #[ORM\Column]
    #[Assert\IsTrue(message:"Cochez cette case.")]
    private ?bool $rgpd = null;

    #[ORM\Column(length: 255)]
    private ?string $imageName = "pfpUser.jpg";

    #[ORM\ManyToMany(targetEntity: Livre::class, inversedBy: 'utilisateurs')]
    private Collection $wishlist;

    // #[ORM\OneToOne(mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    // private ?Location $location = null;

    public function __construct()
    {
        $this->wishlist = new ArrayCollection();
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
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): static
    {
        $this->rgpd = $rgpd;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getWishlist(): Collection
    {
        return $this->wishlist;
    }

    public function addWishlist(Livre $wishlist): static
    {
        if (!$this->wishlist->contains($wishlist)) {
            $this->wishlist->add($wishlist);
        }

        return $this;
    }

    public function removeWishlist(Livre $wishlist): static
    {
        $this->wishlist->removeElement($wishlist);

        return $this;
    }

    // public function getLocation(): ?Location
    // {
    //     return $this->location;
    // }

    // public function setLocation(Location $location): static
    // {
    //     // set the owning side of the relation if necessary
    //     if ($location->getUtilisateur() !== $this) {
    //         $location->setUtilisateur($this);
    //     }

    //     $this->location = $location;

    //     return $this;
    // }
}
