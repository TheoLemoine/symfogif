<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\EntityTrait;
use Doctrine\ORM\Mapping\JoinColumn;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 */
class User implements UserInterface
{

    use EntityTrait;
    use TimestampableEntity;

    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var string
     * @ORM\Column()
     */
    private $username;

    /**
     * @var string
     * @ORM\Column()
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gif", mappedBy="author")
     */
    private $gifs;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Gif", inversedBy="fans")
     */
    private $favoriteGifs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Album", mappedBy="author")
     */
    private $albums;

    public function __construct()
    {
        $this->gifs = new ArrayCollection();
        $this->favoriteGifs = new ArrayCollection();
    }

    /**
     * Returns the roles granted to the security.
     *
     *     public function getRoles()
     *     {
     *         return ['ROLE_USER'];
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the security object
     * is created.
     *
     * @return string[] The security roles
     */
    public function getRoles()
    {
        return [
            self::ROLE_USER,
            self::ROLE_ADMIN,
        ];
    }

    /**
     * Removes sensitive data from the security.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // nothing to do here :)
    }

    /**
     * Returns the password used to authenticate the security.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The encoded password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the security.
     *
     * @return string|null The username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return self
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return Collection|Gif[]
     */
    public function getGifs(): Collection
    {
        return $this->gifs;
    }

    /**
     * @return Collection|Gif[]
     */
    public function getFavoriteGifs(): Collection
    {
        return $this->favoriteGifs;
    }

    /**
     * @param Gif $gif
     * @return self
     */
    public function addFavorite(Gif $gif): self
    {
        $this->favoriteGifs->add($gif);
        return $this;
    }

    /**
     * @param Gif $gif
     * @return self
     */
    public function removeFavorite(Gif $gif): self
    {
        $this->favoriteGifs->removeElement($gif);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAlbums()
    {
        return $this->albums;
    }

    /**
     * @param mixed $albums
     * @return self
     */
    public function setAlbums($albums): self
    {
        $this->albums = $albums;
        return $this;
    }

}